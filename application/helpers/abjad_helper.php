<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('char_capital'))
{
	function char_capital($id)
	{
		switch ($id) {
			case 1: echo "A"; break;
			default: echo ""; break;
		}
	}
}
?>