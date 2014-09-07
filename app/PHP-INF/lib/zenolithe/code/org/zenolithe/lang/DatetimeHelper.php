<?php
namespace org\zenolithe\lang;

class DatetimeHelper {
	static public function timestamp($day, $month, $year) {
		$timestamp = 0;
		
		if(($day>=1) && ($day<=31) && ($month>=1) && ($month<=12) && ($year>2003)) {
			$timestamp = gmmktime(0, 0, 0, $month, $day, $year);
		}
		
		return $timestamp;
	}
	
	// Input : '2013-08-23' or '2013-08-23 21:43:41'
	static public function iso2timestamp($date) {
		$timestamp = 0;
		$length = strlen($date);

		if($length == 10) {
			$timestamp = gmmktime(0,0,0,substr($date,5,2),substr($date,8,2),substr($date,0,4));
		} else if($length >= 19) {
			$timestamp = gmmktime(intval(substr($date,11,2)),intval(substr($date,14,2)),intval(substr($date,17,2)),intval(substr($date,5,2)),intval(substr($date,8,2)),intval(substr($date,0,4)));
		}

		return $timestamp;
	}

	static public function iso2W3C($isoDate) {
		$date = date("c", self::iso2timestamp($isoDate));
	
		return $date;
	}
	
	static public function iso2format($iso, $format) {
		$timestamp = null;
		$length = strlen($iso);

		if($length == 10) {
			$timestamp = mktime(0,0,0,substr($iso,5,2),substr($iso,8,2),substr($iso,0,4));
		} else if($length >= 19) {
			$timestamp = mktime(intval(substr($iso,11,2)),intval(substr($iso,14,2)),intval(substr($iso,17,2)),intval(substr($iso,5,2)),intval(substr($iso,8,2)),intval(substr($iso,0,4)));
		} else {
			$timestamp = 0;
		}

		return date($format, $timestamp);
	}

	static public function timestamp2isoDate($date) {
		return gmdate("Y-m-d", $date);
	}

	static public function timestamp2isoDatetime($date) {
		return gmdate("Y-m-d H:i:s", $date);
	}

	static public function timestamp2W3C($timestamp) {
		$date = date("c", $timestamp);
		
		return $date;
	}
	
	static public function frdatetime2tstp($datetime)	{
		$data = explode(' ', $datetime);
		$daydat = explode('/', $data[0]); // date

		if (!empty($data[1])) {
			// time
			$hourdat = explode(':', $data[1]);
			$hour = $hourdat[0];
			$min = $hourdat[1];
			if (isset($hourdat[2]))	$sec = $hourdat[2]; else $sec =0 ;
		} else {
			$hour = $min = $sec = 0 ;
		}

		if (isset($daydat[0]) && isset($daydat[1]) && isset($daydat[2]) && checkdate($daydat[1], $daydat[0], $daydat[2]) )
			return mktime($hour, $min, $sec, $daydat[1], $daydat[0], $daydat[2]) ;
		else
			return -1 ;  //date invalide
	}
	
	/* Compute intersection between 2 periods */
	static public function tstpIntersection($begin1, $end1, $begin2, $end2, &$begin, &$end)	{
		if(($begin1 > $begin2) or ($begin2 == 0))	{
			$begin = $begin1;
		} else {
			$begin = $begin2;
		}
		
		if((($end1 != 0) and ($end1 < $end2)) or ($end2 == 0)) {
			$end = $end1;
		} else {
			$end = $end2;
		}
	
		return (($end>$begin) or ($end==0));
	}
}
?>