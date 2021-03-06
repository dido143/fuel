<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package		Fuel
 * @version		1.0
 * @author		Fuel Development Team
 * @license		MIT License
 * @copyright	2010 Dan Horrigan
 * @link		http://fuelphp.com
 */

$loader = new Autoloader;

$loader->default_path(__DIR__.'/classes/');

$loader->add_namespaces(array(
	'Fuel'	=>	__DIR__.'/classes/',
));


$loader->add_namespace_alias(APP_NAMESPACE, 'Fuel');

$loader->add_prefixes(array(
	'Fuel_'		=> COREPATH.'classes/',
));

$loader->add_aliases(array(
	'Arr'			=> 'Fuel\\Arr',
	'Asset'			=> 'Fuel\\Asset',
	'Benchmark'		=> 'Fuel\\Benchmark',

	'Cache'						=> 'Fuel\\Cache',
	'Cache_Handler_Driver'		=> 'Fuel\\Cache_Handler_Driver',
	'Cache_Handler_Json'		=> 'Fuel\\Cache_Handler_Json',
	'Cache_Handler_Serialized'	=> 'Fuel\\Cache_Handler_Serialized',
	'Cache_Handler_String'		=> 'Fuel\\Cache_Handler_String',
	'Cache_Storage_Driver'		=> 'Fuel\\Cache_Storage_Driver',
	'Cache_Storage_File'		=> 'Fuel\\Cache_Storage_File',

	'Config'		=> 'Fuel\\Config',

	'Cookie'		=> 'Fuel\\Cookie',
	'DB'			=> 'Fuel\\DB',
	'Database'		=> 'Fuel\\Database',
	'Date'			=> 'Fuel\\Date',
	'Debug'			=> 'Fuel\\Debug',
	'Crypt'			=> 'Fuel\\Crypt',
	'Env'			=> 'Fuel\\Env',
	'Event'			=> 'Fuel\\Event',
	'Error'			=> 'Fuel\\Error',
	'Form'			=> 'Fuel\\Form',
	'Ftp'			=> 'Fuel\\Ftp',
	'Html'			=> 'Fuel\\Html',
	'Input'			=> 'Fuel\\Input',
	'Lang'			=> 'Fuel\\Lang',
	'Log'			=> 'Fuel\\Log',
	'Migrate'		=> 'Fuel\\Migrate',
	'Model'			=> 'Fuel\\Model',
	'Output'		=> 'Fuel\\Output',
	'Pagination'	=> 'Fuel\\Pagination',
	'Request'		=> 'Fuel\\Request',
	'Route'			=> 'Fuel\\Route',

	'Session'			=> 'Fuel\\Session',
	'Session_Driver'	=> 'Fuel\\Session_Driver',
	'Session_Db'		=> 'Fuel\\Session_Db',
	'Session_Cookie'	=> 'Fuel\\Session_Cookie',
	'Session_File'		=> 'Fuel\\Session_File',
	'Session_Memcached'	=> 'Fuel\\Session_Memcached',

	'URI'			=> 'Fuel\\URI',
	'URL'			=> 'Fuel\\URL',

	'Validation'		=> 'Fuel\\Validation',
	'Validation_Object'	=> 'Fuel\\Validation_Object',
	'Validation_Error'	=> 'Fuel\\Validation_Error',

	'View'				=> 'Fuel\\View',
	'View_Exception'	=> 'Fuel\\View_Exception',

	'Fuel'			=> 'Fuel\\Fuel',

	'Controller\\Base'		=> 'Fuel\\Controller\\Base',
	'Controller\\Rest'		=> 'Fuel\\Controller\\Rest',
	'Controller\\Template'	=> 'Fuel\\Controller\\Template'
));

$loader->register();
return $loader;

/* End of file autoload.php */