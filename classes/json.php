<?php
    // Кодирование и декодирование формата JSON
    // Евгений Степанищев (BOLK) 2006 год

    class JSON
    {
        // Основная функция, она и вызывается
        // $str - строка, которую надо декодировать
        // $array - выдавать результат в виде массива или в виде объекта
        static function decode($str, $array = false)
        {
            if ($str == '{}') return $array ?  array() : new stdClass();
            
            // всегда должно начинаться с {
            if ($str[0] <> '{') return null;

            $i = 1;
            return self::odecode($str, $array, 0, $i);
        }
        
        // рекурсивная функция декодирования
        // параметр assoc означает:
        // 0 - проходим массив [ .. ]
        // 1 - проходим объект { .. }
        static private function odecode($str, $array, $assoc, &$i)
        {
            $out = $array || !$assoc ? array() : new stdClass();

            $idx = -1;
            
            for ($len = strlen($str); $i<$len; )
            {                
                if (!$assoc)
                {
                    // теперь идёт пара - name:value, ищем двоеточие
                    $next = strpos($str, ':', $i);
    
                    // если двоеточие не найдено, то неверный формат
                    if ($next === false)
                    return null;
    
                    $idx = trim(substr($str, $i, $next - $i));
    
                    // проверка на строку
                    if ($idx[0] <> '"' || substr($idx, -1) <> '"')
                    return null;
                        
                    // если строка верная, преобразование символов \r и т.п
                    $idx = self::convert(substr($idx, 1, -1));
                    
    
                    // дальше нужно найти значение - это может быть массив или скаляр
                    $i = $next + 1;
    
                    if ($i + 1 >= $len) return null;
                }
                else
                {
                    $idx++;
                }

                // нужно пропустить пробелы (FIXME: переделать на strcspn)
                for (; $i < $len && $str[$i] == ' '; $i++);
                
                if ($i >= $len) return null;
                
                // это объект
                if ($str[$i] == '{')
                {
                    $i++;
                    
                    if ($array)
                    $out[$idx] = self::odecode($str, $array, 0, $i); else
                    $out->$idx = self::odecode($str, $array, 0, $i);
                }
                else
                // это массив
                if ($str[$i] == '[')
                {
                    $i++;
                    
                    if ($array)
                    $out[$idx] = self::odecode($str, $array, 1, $i); else
                    $out->$idx = self::odecode($str, $array, 1, $i);
                }
                else
                {
                    if ($array)
                    $out[$idx] = self::scalar(substr($str, $i), $l); else
                    $out->$idx = self::scalar(substr($str, $i), $l);

                    if ($l === null)
                    return null;
                    
                    $i += $l;
                }

                // тут должна быть запятая или theend
                if (!$assoc && $str[$i] == '}' || $assoc && $str[$i] == ']')
                {
                    $i++;
                    return $out;
                }

                // нужно пропустить пробелы до запятой (FIXME: переделать на strcspn)
                for (; $i < $len && $str[$i] == ' '; $i++);

                // проверяем - элементы у нас разделены запятой
                if ($i >= $len || $str[$i] <> ',')
                return null;

                // нужно пропустить пробелы после запятой (FIXME: переделать на strcspn)
                for ($i++; $i < $len && $str[$i] == ' '; $i++);
            }
            
            return $out;            
        }
        
        // функция декодирует скаляры - смотрит начинается ли строка
        // со скаляра и возвращает его длину
        static private function scalar($str, &$len)
        {
            $scalar =
            '/
                ^(
                    true  |
                    false |
                    null  |
                    "(?:\\\\.|[^"])*" |
                    -?\d+(?:\.\d+)?(?:[Ee][+-]?\d+)*                    
                )/x';

            if (preg_match($scalar, $str, $m) && $m[1] <> '')
            {
                $len = strlen($m[1]);
                
                switch ($m[1][0])
                {
                    case 't':
                        return true;
                    case 'f':
                        return false;
                    case 'n':
                        return null;
                    case '"':
                        return self::convert(substr($m[1], 1, -1));
                    default:
                        return preg_match('/^-?[0-9]+$/', $m[1]) ? (int) $m[1] : (float) $m[1];
                }
            }
            
            return $len = null;
        }
        
        // конвертирование \t, \r, \uXXXX и прочих вхождений
        static private function convert($str)
        {
            // преобразуем комбинацию \u1234 из UCS-2BE в UTF-8
            $str = preg_replace
            (
                '/u([0-9a-f]{2})([0-9a-f]{2})/ie',
                "mb_convert_encoding(chr(0x$1).chr(0x$2), 'UTF-8', 'UCS-2BE')",
                $str
            );
            
            return stripcslashes($str);
        }

        // Основная функция кодирования в формат JSON
        // $mix - массив или объект для кодирования
        static public function encode($mix)
        {
            if (is_scalar($mix) || is_null($mix))
            {
                return '{}';
            }
            
            return self::oencode($mix, true);
        }
        
        static private function oencode($mix, $force_hash = false)
        {
            if (is_scalar($mix) || is_null($mix)) return self::encodeScalar($mix);
            
            // если это массив, но не хеш
            if (!$force_hash && self::encodeCheckArray($mix))
            {
                foreach ($mix as &$val)
                {
                    $val = self::oencode($val);
                    
                    // убираем ссылку на элемент массива
                    // чтобы элемент перестал быть ссылкой
                    unset($val);
                }
                
                return '['.implode(',', $mix).']';
            }

            $out = array();
            // это хеш или объект
            foreach ($mix as $key => $val)
            $out[] = self::encodeString($key).':'.self::oencode($val);

            if (defined('DEBUG')) {
                return "{\n\t" . implode(",\n\t", $out) . "\n}";
            } else {
                return '{'.implode(',', $out).'}';
            }
        }
        
        // функция, которая проверяет является ли переменная
        // массивом и, если да, является ли она не хеш массивом
        static private function encodeCheckArray($mix)
        {
            if (!is_array($mix)) return false;

            // массив не содержит элементов,
            // считаем что это не хеш
            $cnt = sizeof($mix);
            if (!$cnt) return true;

            // обычно сюда передаются очень небольшие массивы,
            // поэтому проверять будем на сравнение с эталоном,
            // это проще всего
            $model = range(0, $cnt - 1);
            return $model == array_keys($mix);            
        }
        
        // кодирование скаляров - number, string, boolean, NULL
        static private function encodeScalar($mix)
        {
            switch (true)
            {
                case is_numeric($mix):
                    return $mix;
                    
                case is_bool($mix):
                    return $mix ? 'true' : 'false';
                    
                case is_null($mix):
                    return 'null';
                    
                default:
                    return self::encodeString($mix);
            }
        }
        
        // кодирование строки
        static private function encodeString($str)
        {
            // замена в строках: нужно заэкранировать ", / и \,
            // заменить \n, \r, \t, \b, \f
            return '"'.addcslashes($str, "\"\n\r\t\x08\x0C/").'"';            
        }
    }
