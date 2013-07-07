<?php  if ( ! defined('ROOTPATH')) exit('No direct script access allowed');

ob_start();

$lang                   = $option['gpa_doc_path_lang'];
$exclude_obsolescence   = $option['gpa_but_exc_obsolescence'];
$functions_excluded     = $option['gpa_exc_functions'];
$include_these_versions = $option['gpa_inc_these_versions'];
$exclude_these_versions = $option['gpa_exc_these_versions'];
$for                    = $option['gpa_traduc_doc_for'];

$phpdoc = json_decode(file_get_contents(SYSPATH . 'doc/php/'.$lang.'/database.json'), true);
//var_dump($phpdoc);

echo '<?php ';
echo "\r\n";
$count = 0;

foreach ($phpdoc as $key => $value)
{
	///*CONFS
	$inc_obs = true;

	if($exclude_obsolescence == true)
	{
		$inc_obs = isset($value['desc']) ? !preg_match('/O?o?bsolète/', $value['desc']) : false;
	}

	$inc_func = true;

	if(!empty($functions_excluded))
	{
		$inc_func = isset($value['name']) ? !in_array($value['name'], $functions_excluded) : false;

		foreach ($functions_excluded as $k => $v)
		{
			if(preg_match('/^#(.+)#$/', $v) && isset($value['name']) && preg_match($v, $value['name']))
			{
				$inc_func = false;
			}
		}
	}

	if(!empty($value['params'][0]) && !preg_match('/::/', $key) && $inc_obs && $inc_func)
	{
		$version   = $value['ver'];
		$version   = explode(', ', $version);
		
		$one_version_match = true;

		if(!empty($include_these_versions))
		{
			foreach ($version as $val)
			{
				if(in_array($val, $include_these_versions))
				{
					$one_version_match = true;
				}

				foreach ($include_these_versions as $k => $v)
				{
					if(preg_match('/^#(.+)#$/', $v))
					{
						$one_version_match = preg_match($v, $val);
					}
				}
			}
		}

		if(!empty($exclude_these_versions))
		{
			foreach ($version as $val)
			{
				if(in_array($val, $exclude_these_versions))
				{
					$one_version_match = false;
				}

				foreach ($exclude_these_versions as $k => $v)
				{
					if(preg_match('/^#(.+)#$/', $v))
					{
						$one_version_match = !preg_match($v, $val);
					}
				}
			}
		}
		//CONFS*/

		///*RESULTS
		if($one_version_match === true)
		{
			$list = $value['params'][0]['list'];

			///*Comments
			echo  '/**';
			echo  "\r\n";
			echo  ' * '.$value['name'].'This';
			echo  "\r\n";
			echo  ' *';
			echo  "\r\n";
			echo  ' * '.$value['desc'].'';
			echo  "\r\n";
			echo  ' *';
			echo  "\r\n";
			echo  ' * @link http://php.net/manual/'.$lang.'/'.$value['url'].'.php '.$for.' '.$value['name'].'.';
			echo  "\r\n";
			echo  ' *';
			echo  "\r\n";

			foreach ($version as $val)
			{
				echo  ' * @version '.$val.'';
				echo  "\r\n";
			}

			if(!empty($list))
			{
				echo  ' *';
				echo  "\r\n";
			}

			foreach ($list as $k => $val)
			{
				if($val['type'] == 'resource') 
					$space = '';
				elseif($val['type'] == 'resouce')
					$space = ' ';
				elseif($val['type'] == 'int')
					$space = '     ';
				elseif($val['type'] == 'integer')
					$space = ' ';
				elseif($val['type'] == 'bool')
					$space = '    ';
				elseif($val['type'] == 'boolean')
					$space = ' ';
				elseif($val['type'] == 'float')
					$space = '   ';
				elseif($val['type'] == 'double')
					$space = '  ';
				elseif($val['type'] == 'real')
					$space = '    ';
				elseif($val['type'] == 'string')
					$space = '  ';
				elseif($val['type'] == 'array')
					$space = '   ';
				elseif($val['type'] == 'object')
					$space = '  ';
				elseif($val['type'] == 'variant')
					$space = ' ';
				elseif($val['type'] == 'callable')
					$space = '';
				elseif($val['type'] == 'callback')
					$space = ' ';
				elseif($val['type'] == 'mixed')
					$space = '   ';
				elseif($val['type'] == 'char')
					$space = '    ';
				else
					$space = '    ';

				///*Some var php doc rectification
				if(preg_match('/^\$[0-9]+/', $val['var']))
				{
					//Place @ the end some digits when $var start with some digit in the php doc...
					$total_digit = preg_match_all( "/[0-9]/", $val['var']);
					$vals = explode('$', $val['var']);
					$str = substr(strrev($vals[1]), 0, -$total_digit);
					$digit = substr(strrev($vals[1]), -$total_digit);
					$val['var'] = '$' . strrev($str) . $digit;
				}
				if(preg_match('/\$(.+)\-(.+)/', $val['var']))
				{
					$val['var'] = str_replace('-', '_', $val['var']);
				}
				if(preg_match('/\*/', $val['var']))
				{
					$val['var'] = str_replace('*', '', $val['var']);
				} 
				//Some var php doc rectification*/

				echo  ' * @param '.$val['type'].$space.' '.$val['var'];
				
				if($val['desc'] !== "")
				{
					echo  '    '.$val['desc'];
				}
				echo  "\r\n";
			}

			if(!empty($value['ret_desc']))
			{
				if(!empty($list))
				{
					echo  " *";
					echo  "\r\n";
				}

				echo  ' * @return '.$value['params'][0]['ret_type'] . '';

				echo  '	' . $value['ret_desc'];
				echo  "\r\n";
				echo  " *";
				echo  "\r\n";

			}
			else 
			{
				echo  " *";
				echo  "\r\n";
			}
			echo  ' */';
			echo  "\r\n";
			//Comments*/

			echo  'if(!function_exists(\''.$value['name'].'This\'))';
			echo  "\r\n";
			echo  '{';

			echo  "\r\n";
			
			echo  '    function '.$value['name'].'This(';

			$countvar  = count($list) - 1;

			foreach($list as $k => $val)
			{
				if(preg_match('/^\$[0-9]+/', $val['var']))
				{
					$total_digit = preg_match_all( "/[0-9]/", $val['var']);
					$vals = explode('$', $val['var']);
					$str = substr(strrev($vals[1]), 0, -$total_digit);
					$digit = substr(strrev($vals[1]), -$total_digit);
					$val['var'] = '$' . strrev($str) . $digit;
				}
				if(preg_match('/\$(.+)\-(.+)/', $val['var']))
				{
					$val['var'] = str_replace('-', '_', $val['var']);
				}
				if(preg_match('/\*/', $val['var']))
				{
					$val['var'] = str_replace('*', '', $val['var']);
				}
				if(preg_match('/\$(.+)\/(.+)/', $val['var']))
				{
					$val['var'] = str_replace('/', '_', $val['var']);
				}
				if(preg_match('/\.\.\./', $val['var']))
				{
					$val['var'] = str_replace('...', substr($char = (string)$list[$k != 0 ? ($k-1) : 0]['var'], 1).($char[strlen($char)-1]+1), trim($val['var']));
				}
				if(isset($val['def']) && preg_match('/^[a-z](.+)\((.+)?\)/', $val['def']))
				{
					$val['def'] = 'NULL';
				}
				if(isset($val['def']) && preg_match('/^[A-Z](.+) \||\+ (.+)/', $val['def']))
				{
					$val['def'] = 'NULL';
				}
				if($val['beh'] == 1)
				{
					echo  isset($val['def']) ? $val['var'] .' = ' . $val['def'] : $val['var'] .' = NULL';
					
					if($k < $countvar)
					{
						echo  ', ';
					}
				}
				if($val['beh'] == 0)
				{
					echo  $val['var'] .'';

					if($k < $countvar)
					{
						echo  ', ';
					}
				}
			}

			echo  ')';
			echo  "\r\n";
			echo  '    {';
			echo  "\r\n";
			
			foreach($list as $k => $v)
			{
				if(preg_match('/^\$[0-9]+/', $v['var']))
				{
					$total_digit = preg_match_all( "/[0-9]/", $v['var']);
					$vals = explode('$', $v['var']);
					$str = substr(strrev($vals[1]), 0, -$total_digit);
					$digit = substr(strrev($vals[1]), -$total_digit);
					$v['var'] = '$' . strrev($str) . $digit;
				}
				if(preg_match('/\$(.+)\-(.+)/', $v['var']))
				{
					$v['var'] = str_replace('-', '_', $v['var']);
				}
				if(preg_match('/\*/', $v['var']))
				{
					$v['var'] = str_replace('*', '', $v['var']);
				}
				if(preg_match('/\$(.+)\/(.+)/', $v['var']))
				{
					$v['var'] = str_replace('/', '_', $v['var']);
				}
				if($v['var'][0] == '&')
				{
					$v['var'] = str_replace($v['var'][0], '', $v['var']);
				}
				if(preg_match('/\.\.\./', $v['var']))
				{
					$v['var'] = str_replace('...', substr($char = (string)$list[$k != 0 ? ($k-1) : 0]['var'], 1).($char[strlen($char)-1] + 1), trim($v['var']));
				}

				//var_dump($v);
				if(isset($v['def']) && preg_match('/^[a-z](.+)\((.+)?\)/', $v['def']))
				{
					if(isset($v['type']) && $v['type'] == 'mixed')
					{
						echo  '		'.$v['var'].' = empty('.$v['var'].') ? (' . $v['def'] . ') : ('.$v['var'] . ');';
						echo  "\r\n";
					}
					else
					{
						echo  '		'.$v['var'].' = empty('.$v['var'].') ? ('.$v['type'].')' . $v['def'] . ' : ('.$v['type'].')'.$v['var'] . ';';
						echo  "\r\n";
					}
				}
				elseif(isset($v['def']) && preg_match('/^[A-Z](.+) \||\+ (.+)/', $v['def']))
				{
					if(isset($v['type']) && $v['type'] == 'mixed')
					{
						echo  '		'.$v['var'].' = empty('.$v['var'].') ? (' . $v['def'] . ') : ('.$v['var'] . ');';
						echo  "\r\n";
					}
					else
					{
						echo  '		'.$v['var'].' = empty('.$v['var'].') ? ('.$v['type'].')' . $v['def'] . ' : ('.$v['type'].')'.$v['var'] . ';';
						echo  "\r\n";
					}
				}
				elseif($v['type'] == 'resource' || $v['type'] == 'resouce' || preg_match('/sql/', $v['type']) || preg_match('/cach/', $v['type']))
				{
					echo  '		'.$v['var'].' = is_resource('.$v['var'].') ? '.$v['var']. ' : NULL;';
					echo  "\r\n";
				}
				elseif($v['type'] == 'SimpleXMLElement' || $v['type'] == 'DOMNode' || $v['type'] == 'OCI-Lob' || $v['type'] == 'tidy')
				{
					echo  '		'.$v['var'].' = is_object('.$v['var'].') ? '.$v['var']. ' : NULL;';
					echo  "\r\n";
				}
				elseif($v['type'] == 'char')
				{
					echo  '		'.$v['var'].' = (string) '.$v['var'].';';
					echo  "\r\n";
				}
				elseif($v['type'] == 'number')
				{
					echo  '		'.$v['var'].' = (float) '.$v['var'].';';
					echo  "\r\n";
				}
				elseif($v['type'] == 'mixed' || $v['type'] == 'variant')
				{
					echo  '		'.$v['var'].' = ('.$v['var'].');';
					echo  "\r\n";
				}
				elseif($v['type'] == 'callable' || $v['type'] == 'callback')
				{
					echo  '		'.$v['var'].' = is_callable('.$v['var'].') ? '.$v['var']. ' : NULL;';
					echo  "\r\n";
				}
				elseif($v['type'] == 'Traversable')
				{
					echo  '		'.$v['var'].' = (is_array('.$v['var'].') || '.$v['var'].' instanceof Traversable) ? '.$v['var']. ' : NULL;';
					echo  "\r\n";
				}
				elseif($v['type'] == 'Judy')
				{
					echo  '		'.$v['var'].' = (array)'.$v['var']. ';';
					echo  "\r\n";
				}
				elseif(preg_match('/^C?c?airo/', $v['type']))
				{
					echo  '		'.$v['var'].' = ('.$v['var'].');';
					echo  "\r\n";
				}
				else
				{
					echo  '		'.$v['var'].' = ('.$v['type'].')'.$v['var'].';';
					echo  "\r\n";
				}
				if($k === $countvar && $v['type'] !== 'mixed')
				{
					echo  "\r\n";
				}
			}
			echo  '		return '.$value['name'].'(';

			foreach($list as $k => $v)
			{
				if(preg_match('/^\$[0-9]+/', $v['var']))
				{
					$total_digit = preg_match_all( "/[0-9]/", $v['var']);
					$vals = explode('$', $v['var']);
					$str = substr(strrev($vals[1]), 0, -$total_digit);
					$digit = substr(strrev($vals[1]), -$total_digit);
					$v['var'] = '$' . strrev($str) . $digit;
				}
				if(preg_match('/\$(.+)\-(.+)/', $v['var']))
				{
					$v['var'] = str_replace('-', '_', $v['var']);
				}
				if(preg_match('/\*/', $v['var']))
				{
					$v['var'] = str_replace('*', '', $v['var']);
				}
				if(preg_match('/\$(.+)\/(.+)/', $val['var']))
				{
					$val['var'] = str_replace('/', '_', $val['var']);
				}
				if($v['var'][0] == '&')
				{
					$v['var'] = str_replace($v['var'][0], '', $v['var']);
				}
				if(preg_match('/\.\.\./', $v['var']))
				{
					$v['var'] = str_replace('...', substr($char = (string)$list[$k != 0 ? ($k-1) : 0]['var'], 1).($char[strlen($char)-1] + 1), trim($v['var']));
				}

				echo  $v['var'] .'';

				if($k < $countvar)
				{
					echo  ', ';
				}
			}

			echo  ');';
			echo  "\r\n";
			echo  '    }';
			echo  "\r\n";
			echo  '}';
			echo  "\r\n";
			echo  "\r\n";

		}
	}

	$count++;
}
//Some correction until best match
$large_string = str_replace('arr23', 'arr3', str_replace('arr12', 'arr2', str_replace('arr01', 'arr1', str_replace('array01', 'array1', str_replace('array12', 'array2', str_replace('array23', 'array3', str_replace('$...', '$item',  str_replace('$ ', '$', str_replace('$$', '$', ob_get_contents())))))))));
file_put_contents(SYSPATH.'aliases.php', $large_string);
ob_end_clean();