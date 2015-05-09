<?php 
/**
 * Clone from laravel
 */

namespace Uri;

class Uri {

	/**
	 * URI segments
	 *
	 * @var	array
	 */
	public $segments = array();

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
		return trim(substr($uri, strlen($_SERVER['SCRIPT_NAME'])), "/");
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

		parse_str( $_SERVER['QUERY_STRING'], $query_string );

		return $query_string;
	}

	/**
	 * Get Http request method.
	 *
	 * @return void
	 */
	public function methods()
	{
		if( ! empty( $_SERVER['REQUEST_METHOD'] ) )
			return $_SERVER['REQUEST_METHOD'];
	
		return '';
	}

	/**
	 * Get script file name.
	 *
	 * @return void
	 */
	public function script_name()
	{
		if( ! empty( $_SERVER['SCRIPT_NAME'] ) )
			return $_SERVER['SCRIPT_NAME'];
		
		return '';
	}
	
	/**
	 * Get host domain.
	 *
	 * @return void
	 */
	public function host()
	{
		if( ! empty( $_SERVER['HTTP_HOST'] ) )
			return $_SERVER['HTTP_HOST'];
		
		return '';
	}	
}
