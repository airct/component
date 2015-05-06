<?php 
/**
 * Clone from laravel
 */

namespace Uri;

class Uri {

	/**
	 * script file name;
	 *
	 * @var string
	 */
	private $script_name = null;


	/**
	 * Create a new Uri instance.
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * Parser Http request uri .
	 *
	 * @return bool
	 */
	public function _parse_request_uri()
	{

		$request_uri = parse_url($_SERVER['REQUEST_URI']);

		return ;
	}

	/**
	 * Parser Http query string.
	 *
	 */
	public function _parse_query_string()
	{
		parse_str(urldecode($_SERVER['QUERY_STRING']), $query_string);

		return $query_string;
	}

	/**
	 *
	 */
	public function _parse_argv($key, $default = null)
	{
	}

	/**
	 * Get Http request method.
	 *
	 * @return void
	 */
	public function method()
	{
		! empty( $_SERVER['REQUEST_METHOD'] ) && $this->method = $_SERVER['REQUEST_METHOD'];
	}

	/**
	 * Get script file name.
	 *
	 * @return void
	 */
	public function script_name()
	{
		! empty( $_SERVER['SCRIPT_NAME'] ) && $this->script_name = $_SERVER['SCRIPT_NAME'];
	}
	
}

