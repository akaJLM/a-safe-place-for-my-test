<?php header('Content-type: text/html; charset=utf-8');

	$generate = true; // If true generate aliases.php file else include it

	$docpath = 'doc'; // Folder doc path name
	
	$lang   = 'fr'; // language folder in folder doc path
	
	$for    = 'Documentation pour'; // "Documentation for" in your language

	$functions_excluded = array('__halt_compiler', 'array', 'echo', 'empty', 'eval', 'exit', 'isset', 'list', 'print', 'unset');

	$exclude_obsolescence = true;

	$include_these_versions = array();

	$exclude_these_versions = array();

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

	// Is the doc path correct?
	if ( ! is_dir($docpath))
	{
		exit("Your php doc folder path does not appear to be set correctly. Please open the following file and correct this: ".pathinfo(__FILE__, PATHINFO_BASENAME));
	}

/*
 * -------------------------------------------------------------------
 *  Now that we know the path, set the main path constants
 * -------------------------------------------------------------------
 */
	// The name of THIS file
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// Path to the system folder
	define('DOCPATH', str_replace("\\", "/", $docpath));

	// Path to the front controller (this file)
	define('ROOTPATH', str_replace(SELF, '', __FILE__));

/*
 *
 * And away we go...
 *
 */

if($generate === true)
{
	require_once ROOTPATH.'core/codeGenerator.php';
}
else
{
	include_once(ROOTPATH.'aliases.php');
}


/* End of file index.php */
/* Location: ./index.php */
