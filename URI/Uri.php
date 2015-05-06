<?php 
/**
 * Clone from laravel
 */

namespace Uri;

class Uri {

	/**
	 * script file name.
	 *
	 * @var string
	 */
	public $script_name = null;

	/**
	 * http request query string.
	 *
	 * @var string
	 */
	public $query_string = null;

	/**
	 * http request uri string.
	 *
	 * @var string
	 */
	public $request_uri = null;

	/**
	 * http request method.
	 *
	 * @var string
	 */
	public $method = null;

	/**
	 * Create a new Uri instance.
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * Parser Http request uri.
	 *
	 * @return bool
	 */
	public function _parse_request_uri()
	{
    	$request_uri 	= parse_url($_SERVER['REQUEST_URI']);
		$query 		= isset($request_uri['query']) ? $request_uri['query'] : '';
		$uri 	= isset($request_uri['path']) ? $request_uri['path'] : '';

		// return explode("/", trim(substr($uri, strlen($_SERVER['SCRIPT_NAME'])), "/"));
		$this->request_uri = trim(substr($uri, strlen($_SERVER['SCRIPT_NAME'])));
	}

	/**
	 * Parser Http query string.
	 *
	 */
	public function _parse_query_string()
	{
		if ( trim( $_SERVER['QUERY_STRING'], '/' ) === '' )
		{
			return '';
		}

		parse_str( $_SERVER['QUERY_STRING'], $this->query_string );

		return $this->query_string;
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

