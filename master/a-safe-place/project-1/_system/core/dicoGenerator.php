<?php  if ( ! defined('ROOTPATH')) exit('No direct script access allowed');

$lang = $config['lang'];

$dicodoc = file_get_contents(SYSPATH . 'doc/lang/words-'.strtolower($lang).'.txt');

$dicodoc = preg_replace('/\s+/', '|', $dicodoc);
$dicodoc = explode('|', $dicodoc);
$letter_array = array();
$temp_array = array();

//var_dump($dicodoc); exit();
function sortByLength($a,$b)
{
	$alen = strlen($a);
	$blen = strlen($b);
	if($alen == $blen)
	{
		return 0;
	}
	elseif($alen < $blen)
	{
		return -1;
	}
	else
	{
		return 1;
	}
}

foreach ($dicodoc as $key => $value)
{
	$count_letter = strlen($value);
	$first_letter = isset($value[0]) ? (string)$value[0] : NULL;
	$previous_letter = (string)$dicodoc[$key != 0 ? ($key-1) : 0][0];

	if($first_letter === $previous_letter && $count_letter > 3)
	{
		$temp_array[] = $value;
	}
	
	if($first_letter !== $previous_letter)
	{
		$temp = usort($temp_array,'sortByLength');
		$first_letter_array[$previous_letter] = $temp_array;
		$temp_array = NULL;
	}
}
file_put_contents(SYSPATH.'words-'.$lang.'.json', json_encode($first_letter_array, JSON_PRETTY_PRINT));
//var_dump($phpdoc);