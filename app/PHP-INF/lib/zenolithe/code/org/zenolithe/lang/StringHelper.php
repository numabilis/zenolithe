<?php
namespace org\zenolithe\lang;

class StringHelper {
	static public function toUrl($str) {
		$url = $str;
		
		$accent = utf8_decode('ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŠÙÚÛÜÝÞŸŽàáâãäåçèéêëìíîïðñòóôõöøšßùúûýþÿž°/\' –');
		$noAccent = 'aaaaaaceeeeiiiidnoooooosuuuuybyzaaaaaaceeeeiiiidnoooooossuuuybyz-----';
		$url = str_replace('Æ', 'AE', $url);
		$url = str_replace('Œ', 'OE', $url);
		$url = str_replace('æ', 'ae', $url);
		$url = str_replace('œ', 'oe', $url);
		$url = strtolower(strtr(utf8_decode($url), $accent, $noAccent));
		$url = preg_replace('/(-)+.(-)+/', '-', $url);
		$url = preg_replace('/^-(-)+/', '', $url);
		
		return $url;
	}
	
	static public function toAnsi($str) {
		$ansi = $str;
		
		$accent = utf8_decode('ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŠÙÚÛÜÝÞŸŽàáâãäåçèéêëìíîïðñòóôõöøšßùúûýþÿž–');
		$noAccent = 'AAAAAACEEEEIIIIDNOOOOOOSUUUUYBYZaaaaaaceeeeiiiidnoooooossuuuybyz-';
		$ansi = str_replace('Æ', 'AE', $ansi);
		$ansi = str_replace('Œ', 'OE', $ansi);
		$ansi = str_replace('æ', 'ae', $ansi);
		$ansi = str_replace('œ', 'oe', $ansi);
		$ansi = strtr(utf8_decode($ansi), $accent, $noAccent);
			
		return $ansi;
	}
	
	static public function ansiRand($size=8) {
		$chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$str = '';
	
		for($i=0;$i<$size;$i++) {
			$str .= $chars[rand(0,strlen($chars)-1)];
		}
	
		return $str;
	}
}
?>