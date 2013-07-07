<?php header('Content-type: text/html; charset=utf-8');

	$config = array();
	$option = array();

	//General configuration
	$config['syspath']					= '_system'; // Folder system path name
	$config['lang']						= 'en'; // 2 letters code lang

	/**
	 * PHP
	 *
	 * generate aliases for all original functions
	 *
	 * legend
	 * ------
	 * gpa_ - generate_php_aliases_
	 *
	 */
	$option['gpa']						= true; // If true generate aliases.php file, else include it (php error + include it benchmark)
	
	$option['gpa_but_exc_obsolescence']	= true; // exclude all obsolete function
	
	$option['gpa_traduc_doc_for']		= 'Documentation pour'; // "Documentation for" in your language

	$option['gpa_doc_path']				= 'doc'; // in general_system_path -> your folder "doc" path name
	$option['gpa_doc_path_lang']		= 'fr'; // in gen_php_aliases_doc_path -> your language folder name

	$option['gpa_exc_functions']		= array('#^gz([a-z]++)#', '#^zlib\_#', '#^array\_#', '#^ldap\_#', '#^mysqli\_#', '__halt_compiler', 'array', 'key', 'echo', 'empty', 'eval', 'exit', 'isset', 'list', 'print', 'unset'); // You can use regular expression with delimiters (only # for delimiters)
	
	$option['gpa_inc_these_versions']	= array(); // You can use regular expression with delimiters (only # for delimiters)
	$option['gpa_exc_these_versions']	= array('#^PECL#'); // You can use regular expression with delimiters (only # for delimiters)

/////////////// Nothing to edit after ////////////////////////

	// CLI requests fix
	if (defined('STDIN'))
	{
		chdir(dirname(__FILE__));
	}

	if (realpath($config['syspath']) !== FALSE)
	{
		$syspath = realpath($config['syspath']).'/';
	}

	// ensure there's a trailing slash
	$syspath = rtrim($syspath, '/').'/';

	// Self
	define('SELF', pathinfo(__FILE__, PATHINFO_BASENAME));

	// Path to the doc folder
	define('SYSPATH', str_replace("\\", "/", $syspath));

	// Path to the root
	define('ROOTPATH', str_replace(SELF, '', __FILE__));

	// lang
	define('LANG', $config['lang']);

	if($option['gpa'] === true)
	{
		$time_start = microtime(true);

		require_once(SYSPATH.'core/codeGenerator.php');

		$time_end = microtime(true);

		$time = $time_end - $time_start;

		echo '<div style="position:fixed;top:0;right:0;left:0;background:green;color:white;padding:10px">Gen aliases: Did it in '.$time.' seconds</div>';
	}
	else
	{
		if(file_exists(SYSPATH.'aliases.php'))
		{
			$time_start = microtime(true);

			require_once(SYSPATH.'aliases.php');
			
			$time_end = microtime(true);

			$time = $time_end - $time_start;

			echo '<div style="position:fixed;top:0;right:0;left:0;background:green;color:white;padding:10px">Inc aliases: Did it in '.$time.' seconds</div>';
		}
	}
/*
 *
 * And away we go...
 *
 */