<?php

function replaceTag($content, $tag, $replacement) {
	$l = mb_strlen($tag, 'UTF-8') + 6;

	$i = mb_strpos($content, '/* <' . $tag . '> */', 0, 'UTF-8');
	if (false === $i) {
		break;
	}

	$i += $l + 2;

	$n = mb_strpos($content, '/* </' . $tag . '> */', 0, 'UTF-8');
	if (false === $n) {
		echo 'Final tag not found\n';
		die();
	}

	$n -= $l;

	$replacement = "\n" . $replacement . "\n";

	$content = mb_substr($content, 0, $i) . $replacement . mb_substr($content, $n + $l, mb_strlen($content) - $n - $l);

	return $content;
}
