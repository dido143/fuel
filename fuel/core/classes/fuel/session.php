<?php
/**
 * Fuel
 *
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package		Fuel
 * @version		1.0
 * @license		MIT License
 * @copyright	2010 Dan Horrigan
 * @link		http://fuelphp.com
 */

namespace Fuel;

// --------------------------------------------------------------------

/**
 * Session Class
 *
 * @package		Fuel
 * @subpackage	Core
 * @category	Core
 * @author		Harro "WanWizard" Verton
 */
class Session
{
	/**
	 * loaded session driver instance
	 */
	protected static $_instance = null;

	/**
	 * Initialize by loading config & starting default session
	 */
	public static function _init()
	{
		Config::load('session', true);

		static::instance();
	}

	/**
	 * Factory
	 *
	 * Produces fully configured session driver instances
	 *
	 * @param	array|string	full driver config or just driver type
	 */
	public static function factory($config = array())
	{
		$defaults = Config::get('session', array());

		// When a string was entered it's just the driver type
		if ( ! empty($config) && ! is_array($config))
		{
			$config = array('driver' => $config);
		}

		// Overwrite default values with given config
		$config = array_merge($defaults, $config);

		if (empty($config['driver']))
		{
			throw new Exception('No session driver given or no default session driver set.');
		}

		// Instantiate the driver
		$class = 'Session_'.ucfirst($config['driver']);
		$driver = new $class;

		// And configure it, specific driver config first
		if (isset($config[$config['driver']]))
		{
			$driver->set_config('config', $config[$config['driver']]);
		}

		// Then load globals and/or set defaults
		$driver->set_config('driver', $config['driver']);
		$driver->set_config('match_ip', isset($config['match_ip']) ? (bool) $config['match_ip'] : true);
		$driver->set_config('match_ua', isset($config['match_ua']) ? (bool) $config['match_ua'] : true);
		$driver->set_config('cookie_name', isset($config['cookie_name']) ? (string) $config['cookie_name'] : 'fuelsession');
		$driver->set_config('cookie_domain', isset($config['cookie_domain']) ? (string) $config['cookie_domain'] : '');
		$driver->set_config('cookie_path', isset($config['cookie_path']) ? (string) $config['cookie_path'] : '/');
		$driver->set_config('expire_on_close', isset($config['expire_on_close']) ? (bool) $config['expire_on_close'] : false);
		$driver->set_config('expiration_time', isset($config['expiration_time'])
				? ((int) $config['expiration_time'] > 0
						? (int) $config['expiration_time']
						: 86400 * 365 * 2)
				: 7200);
		$driver->set_config('rotation_time', isset($config['rotation_time']) ? (int) $config['rotation_time'] : 300);
		$driver->set_config('flash_id', isset($config['flash_id']) ? (string) $config['flash_id'] : 'flash');
		$driver->set_config('flash_auto_expire', isset($config['flash_auto_expire']) ? (bool) $config['flash_auto_expire'] : true);
		$driver->set_config('write_on_set', isset($config['write_on_set']) ? (bool) $config['write_on_set'] : false);

		// if the driver has an init method, call it
		if (method_exists($driver, 'init'))
		{
			$driver->init();
		}

		// do we need to set a shutdown event for this driver?
		if ($driver->get_config('write_on_set') === false)
		{
			// register a shutdown event to update the session
			Event::register('shutdown', array($driver, 'write_session'));
		}

		// load the session
		$driver->read();

		return $driver;
	}

	/**
	 * class constructor
	 *
	 * @param	void
	 * @access	private
	 * @return	void
	 */
	final private function __construct() {}

	/**
	 * create or return the driver instance
	 *
	 * @param	void
	 * @access	public
	 * @return	Session_Driver object
	 */
	public static function instance()
	{
		if (is_null(static::$_instance))
		{
			static::$_instance = static::factory();
		}

		return static::$_instance;
	}

	/**
	 * set session variables
	 *
	 * @param	string	name of the variable to set
	 * @param	mixed	value
	 * @access	public
	 * @return	void
	 */
	public static function set($name, $value)
	{
		return static::instance()->set($name, $value);
	}

	// --------------------------------------------------------------------

	/**
	 * get session variables
	 *
	 * @access	public
	 * @param	string	name of the variable to get
	 * @return	mixed
	 */
	public static function get($name)
	{
		return static::instance()->get($name);
	}

	// --------------------------------------------------------------------

	/**
	 * delete a session variable
	 *
	 * @param	string	name of the variable to delete
	 * @param	mixed	value
	 * @access	public
	 * @return	void
	 */
	public static function delete($name)
	{
		return static::instance()->delete($name);
	}

	// --------------------------------------------------------------------

	/**
	 * set session flash variables
	 *
	 * @param	string	name of the variable to set
	 * @param	mixed	value
	 * @access	public
	 * @return	void
	 */
	public static function set_flash($name, $value)
	{
		return static::instance()->set_flash($name, $value);
	}

	// --------------------------------------------------------------------

	/**
	 * get session flash variables
	 *
	 * @access	public
	 * @param	string	name of the variable to get
	 * @return	mixed
	 */
	public static function get_flash($name)
	{
		return static::instance()->get_flash($name);
	}

	// --------------------------------------------------------------------

	/**
	 * keep session flash variables
	 *
	 * @access	public
	 * @param	string	name of the variable to keep
	 * @return	void
	 */
	public static function keep_flash($name)
	{
		return static::instance()->keep_flash($name);
	}

	// --------------------------------------------------------------------

	/**
	 * delete session flash variables
	 *
	 * @param	string	name of the variable to delete
	 * @param	mixed	value
	 * @access	public
	 * @return	void
	 */
	public static function delete_flash($name)
	{
		return static::instance()->delete_flash($name);
	}

	// --------------------------------------------------------------------

	/**
	 * create a new session
	 *
	 * @access	public
	 * @return	void
	 */
	public static function create()
	{
		return static::instance()->create();
	}

	// --------------------------------------------------------------------

	/**
	 * read the session
	 *
	 * @access	public
	 * @return	void
	 */
	public static function read()
	{
		return static::instance()->read();
	}

	// --------------------------------------------------------------------

	/**
	 * write the session
	 *
	 * @access	public
	 * @return	void
	 */
	public static function write()
	{
		return static::instance()->write();
	}

	// --------------------------------------------------------------------

	/**
	 * destroy the current session
	 *
	 * @access	public
	 * @return	void
	 */
	public static function destroy()
	{
		return static::instance()->destroy();
	}

}

/* End of file session.php */
