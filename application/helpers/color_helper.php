<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function colorChart($no)
{
	switch ($no) {
		case 1:
			$color = "#9C2B2B";
			break;
		case 2:
			$color = "#329262";
			break;
		case 3:
			$color = "#E67300";
			break;
		case 4:
			$color = "#3B3EAC";
			break;
		case 5:
			$color = "#994499";
			break;
		case 6:
			$color = "#B77322";
			break;
		case 7:
			$color = "#68768A";
			break;
		case 8:
			$color = "#43B1A9";
			break;
		case 9:
			$color = "#DC3912";
			break;
		default:
			$color = "#009A83";
			break;
	}
	return $color;
}



?>