<?php header('Content-type: text/html; charset=utf-8');

	$generate = true; // If true generate aliases.php file else include it

	$docpath = 'doc'; // Folder doc path name
	
	$lang   = 'fr'; // language folder in folder doc path
	
	$for    = 'Documentation pour'; // "Documentation for" in your language

	$functions_excluded = array('__halt_compiler', 'array', 'echo', 'empty', 'eval', 'exit', 'isset', 'list', 'print', 'unset'); // A handle of function to completely ignore.

	$exclude_obsolescence = true; // exclude all obsolete function

	$include_these_versions = array(); // You can use regular expression with delimiters (only # for delimiters)

	$exclude_these_versions = array('#^PECL#'); // You can use regular expression with delimiters (only # for delimiters)

/////////////// Nothing to edit after ////////////////////////

	// CLI requests fix
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($docpath) !== FALSE)
	{
		$docpath = realpath($docpath).'/';
	}

	// ensure there's a trailing slash
	$docpath = rtrim($docpath, '/').'/';

	// Self
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// Path to the doc folder
	define('DOCPATH', str_replace("\\", "/", $docpath));

	// Path to the root
	define('ROOTPATH', str_replace(SELF, '', __FILE__));

/*
 *
 * And away we go...
 *
 */

if($generate === true)
{
	$time_start = microtime(true);

	require_once(ROOTPATH.'core/codeGenerator.php');

	$time_end = microtime(true);

	$time = $time_end - $time_start;

	echo '<div style="position:absolute;top:0;right:0;left:0;background:green;color:white;padding:10px">Did it in '.$time.' seconds</div>';
}
else
{
	$time_start = microtime(true);

	include_once(ROOTPATH.'aliases.php');

	$time_end = microtime(true);

	$time = $time_end - $time_start;

	echo '<div style="position:absolute;top:0;right:0;left:0;background:green;color:white;padding:10px">Did it in '.$time.' seconds</div>';
}