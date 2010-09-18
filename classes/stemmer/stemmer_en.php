<?php

class Stemmer_EN {

	public function stem( $word )
	{
		if ( empty($word) ) {
			return false;
		}

		$result = '';

		// Strip punctuation, etc. Keep ' and . for URLs and contractions.
		if ( substr($word, -2) == "'s" ) {
			$word = substr($word, 0, -2);
		}
		$word = preg_replace("/[^a-z0-9'.-]/u", '', $word);

		$first = '';
		if ( strpos($word, '-') !== false ) {
			$first = substr($word, 0, strrpos($word, '-') + 1); // Grabs hyphen too
			$word = substr($word, strrpos($word, '-') + 1);
		}

    $word = $this->_step_1($word);
    $word = $this->_step_2($word);
    $word = $this->_step_3($word);
    $word = $this->_step_4($word);
    $word = $this->_step_5($word);

		$result = $first . $word;

		return $result;
	}

	private function _step_1( $word ) {
		if ( substr($word, -1) == 's' ) {
			if ( substr($word, -4) == 'sses' ) {
				$word = substr($word, 0, -2);
			} elseif ( substr($word, -3) == 'ies' ) {
				$word = substr($word, 0, -2);
			} elseif ( substr($word, -2, 1) != 's' ) {
				$word = substr($word, 0, -1);
			}
		}

		if ( substr($word, -3) == 'eed' ) {
			if ($this->count_vc(substr($word, 0, -3)) > 0 ) {
				$word = substr($word, 0, -1);
			}
		} else {
			if ( preg_match('/([aeiou]|[^aeiou]y).*(ed|ing)$/', $word) ) {
				if ( substr($word, -2) == 'ed' ) {
					$word = substr($word, 0, -2);
				} else {
					$word = substr($word, 0, -3);
				}

				if ( 
					substr($word, -2) == 'at' 
					|| substr($word, -2) == 'bl' 
					|| substr($word, -2) == 'iz' 
				) {
					$word .= 'e';
				} else {
					$last_char = substr($word, -1, 1);
					$next_to_last = substr($word, -2, 1);

					if ( 
						$this->is_consonant($word, -1) 
						&& $last_char == $next_to_last 
						&& $last_char != 'l' 
						&& $last_char != 's' 
						&& $last_char != 'z' 
					) {
						$word = substr($word, 0, -1);
					} else {
						if ( $this->count_vc($word) == 1 && $this->_o($word) ) {
							$word .= 'e';
						}
					}
				}
			}
		}

		if ( preg_match('/([aeiou]|[^aeiou]y).*y$/', $word) ) { 
			$word = substr($word, 0, -1) . 'i';
		}

		return $word;
	}

	function _step_2( $word ) {
		switch ( substr($word, -2, 1) ) {
			case 'a':
				if ( 
					$this->_replace($word, 'ational', 'ate', 0) 
					|| $this->_replace($word, 'tional', 'tion', 0) 
				) {
					return $word;
				}

				break;

			case 'c':
				if ( 
					$this->_replace($word, 'enci', 'ence', 0) 
					|| $this->_replace($word, 'anci', 'ance', 0) 
				) {
					return $word;
				}
				
				break;

			case 'e':
				if ( $this->_replace($word, 'izer', 'ize', 0) ) {
					return $word;
				}
				
				break;

			case 'l':
				if ( 
					$this->_replace($word, 'bli', 'ble', 0) 
					|| $this->_replace($word, 'alli', 'al', 0) 
					|| $this->_replace($word, 'entli', 'ent', 0) 
					|| $this->_replace($word, 'eli', 'e', 0) 
					|| $this->_replace($word, 'ousli', 'ous', 0) 
				) {
					return $word;
				}

				break;

			case 'o':
				if ( 
					$this->_replace($word, 'ization', 'ize', 0) 
					|| $this->_replace($word, 'isation', 'ize', 0) 
					|| $this->_replace($word, 'ation', 'ate', 0) 
					|| $this->_replace($word, 'ator', 'ate', 0) 
				) {
					return $word;
				}

				break;

			case 's':
				if ( 
					$this->_replace($word, 'alism', 'al', 0) 
					|| $this->_replace($word, 'iveness', 'ive', 0) 
					|| $this->_replace($word, 'fulness', 'ful', 0) 
					|| $this->_replace($word, 'ousness', 'ous', 0) 
				) {
					return $word;
				}

				break;

			case 't':
				if ( 
					$this->_replace($word, 'aliti', 'al', 0) 
					|| $this->_replace($word, 'iviti', 'ive', 0) 
					|| $this->_replace($word, 'biliti', 'ble', 0) 
				) {
					return $word;
				}

				break;

			case 'g':
				if ( $this->_replace($word, 'logi', 'log', 0) ) { 
					return $word;
				}

				break;
		}

		return $word;
	}

	function _step_3( $word )	{
		switch ( substr($word, -1) ) {
			case 'e':
				if ( 
					$this->_replace($word, 'icate', 'ic', 0) 
					|| $this->_replace($word, 'ative', '', 0) 
					|| $this->_replace($word, 'alize', 'al', 0) 
				) {
					return $word;
				}

				break;

			case 'i':
				if ( $this->_replace($word, 'iciti', 'ic', 0) ) {
					return $word;
				}
	
				break;

			case 'l':
				if ( 
					$this->_replace($word, 'ical', 'ic', 0) 
					|| $this->_replace($word, 'ful', '', 0) 
				) {
					return $word;
				}

				break;

			case 's':
				if ( $this->_replace($word, 'ness', '', 0) ) {
					return $word;
				}
	
				break;
		}

		return $word;
	}

	function _step_4( $word )	{
		switch ( substr($word, -2, 1) ) {
			case 'a':
				if ( $this->_replace($word, 'al', '', 1) ) {
					return $word;
				}
		
				break;
			case 'c':
				if ( 
					$this->_replace($word, 'ance', '', 1) 
					|| $this->_replace($word, 'ence', '', 1) 
				) {
					return $word;
				}

				break;
			case 'e':
				if ( $this->_replace($word, 'er', '', 1) ) {
					return $word;
				}

				break;
			case 'i':
				if ( $this->_replace($word, 'ic', '', 1) ) {
					return $word;
				}
		
				break;
			case 'l':
				if ( 
					$this->_replace($word, 'able', '', 1) 
					|| $this->_replace($word, 'ible', '', 1) 
				) {
					return $word;
				}
	
				break;
			case 'n':
				if ( 
					$this->_replace($word, 'ant', '', 1) 
					|| $this->_replace($word, 'ement', '', 1) 
					|| $this->_replace($word, 'ment', '', 1) 
					|| $this->_replace($word, 'ent', '', 1) 
				) {
					return $word;
				}
		
				break;
			case 'o':
				if ( substr($word, -4) == 'sion' || substr($word, -4) == 'tion' ) {
					if ( $this->_replace($word, 'ion', '', 1) ) {
						return $word;
					}
				}
	
				if ( $this->_replace($word, 'ou', '', 1) ) {
					return $word;
				}
		
				break;
			case 's':
				if ( $this->_replace($word, 'ism', '', 1) ) {
					return $word;
				}
				break;
			case 't':
				if ( 
					$this->_replace($word, 'ate', '', 1)
					|| $this->_replace($word, 'iti', '', 1) 
				) {
					return $word;
				}
				break;
			case 'u':
				if ( $this->_replace($word, 'ous', '', 1) ) {
					return $word;
				}
				break;
			case 'v':
				if ( $this->_replace($word, 'ive', '', 1) ) {
					return $word;
				}
				break;
			case 'z':
				if ( $this->_replace($word, 'ize', '', 1) ) {
					return $word;
				}
				break;
		}

		return $word;
	}

	function _step_5( $word )
	{
		if ( substr($word, -1) == 'e' ) {
			$short = substr($word, 0, -1);

			if ( $this->count_vc($short) > 1 ) {
				$word = $short;
			} elseif ( $this->count_vc($short) == 1 && !$this->_o($short) ) {
				$word = $short;
			}
		}
	
		if ( substr($word, -2) == 'll' ) {
			if ( $this->count_vc($word) > 1 ) {
				$word = substr($word, 0, -1);
			}
		}
	
		return $word;
	}

	function is_consonant( $word, $pos ) {
		if ( abs($pos) > strlen($word) ) {
			if ( $pos < 0 ) {
				$pos = 0;
			} else {
				$pos = -1;
			}
		}
		
		$char = substr($word, $pos, 1);
		switch ( $char ) {
			case 'a':
			case 'e':
			case 'i':
			case 'o':
			case 'u':
				return false;
			case 'y':
				if ( $pos == 0 || strlen($word) == -$pos ) {
					if ( substr($word, 1, 1) == 'y' ) {
					  return true;
					}
				
					return !($this->is_consonant($word, 1));
				} else {
					return !($this->is_consonant($word, $pos - 1));
				}
			default:
				return true;
		}
	}

	function count_vc( $word ) {
		$m = 0;
		$length = strlen($word);
		$prev_c = false;
	
		for ( $i = 0; $i < $length; $i++ ) {
			$is_c = $this->is_consonant($word, $i);
	
			if ( $is_c ) {
				if ( $m > 0 && !$prev_c ) {
					$m += 0.5;
				}
			} else {
				if ( $prev_c || $m == 0 ) {
					$m += 0.5;
				}
			}

			$prev_c = $is_c;
		}

		$m = floor($m);
	
		return $m;
	}

	function _o( $word ) {
		if ( strlen($word) >= 3 ) {
			if ( 
				$this->is_consonant($word, -1) 
				&& !$this->is_consonant($word, -2) 
				&& $this->is_consonant($word, -3) 
			) {
				$last_char = substr($word, -1);
		
				if ( $last_char == 'w' || $last_char == 'x' || $last_char == 'y' ) {
					return false;
				}

				return true;
			}
		}
	
		return false;
	}

	function _replace( &$word, $suffix, $replace, $m = 0 ) {
		$sl = strlen($suffix);
	
		if ( substr($word, -$sl) == $suffix ) {
			$short = substr_replace($word, '', -$sl);

			if ( $this->count_vc($short) > $m ) {
				$word = $short . $replace;
			}

			return true;
		}

		return false;
	}

}
