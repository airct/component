<?php 
/**
 * Clone from laravel
 */

namespace Route;

use \Uri;

class Route {

	/**
	 * Create a new Route instance.
	 *
	 */
	public function __construct()
	{
		$this->className = "welcome";
		$this->methodName = "index";
	}

	private function split_segments($request_uri) 
	{
		$segments = explode("/", $request_uri);
		//print_r($segments);
		if(isset($segments[0])) {
			$this->_set_class($segments[0]);
		}

		if(isset($segments[1])) {
			$this->_set_method($segments[1]);
		}
	}

	public function _set_route($request_uri) 
	{

		$this->split_segments($request_uri);
	}

	public function _set_query_string($parse_query_string) 
	{

		$this->params = $parse_query_string;
	}

	public function _set_class($className = "welcome") 
	{

		$this->className = $className;
	}

	public function _set_method($methodName = "index") 
	{

		$this->methodName = $methodName;
	}

	public function run() {
		
		$uri = new Uri\uri();

		$parse_request_uri = $uri->_parse_request_uri();
		$parse_query_string = $uri->_parse_query_string();

		$this->_set_route($parse_request_uri);
		$this->_set_query_string($parse_query_string);

		$classPath = $this->className . ".php";
		
		require("controller/" . $classPath);
	
		$controller = new $this->className;
		
		call_user_func_array(array(&$controller, $this->methodName), $this->params);
	}
}
