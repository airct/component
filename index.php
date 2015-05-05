<?php

function __autoload($class_name) {
	echo "section C: " . $class_name;
	echo "<BR />";
    // require_once $class_name . '.php';
}


function myload() {
	echo "section B: <BR />";
}
// use Cache\memcache;
spl_autoload_register("myload");
spl_autoload_register(function ($class) {

	echo "section A: " . $class . "<BR />";
	// exit;
    // project-specific namespace prefix
    $prefix = '';

    // base directory for the namespace prefix
    $base_dir = __DIR__ . '/';

    // does the class use the namespace prefix?
    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        // no, move to the next registered autoloader
        return;
    }

    // get the relative class name
    $relative_class = substr($class, $len);

    // replace the namespace prefix with the base directory, replace namespace
    // separators with directory separators in the relative class name, append
    // with .php
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    // if the file exists, require it
    if (file_exists($file)) {
        require $file;
    }
});


use \Cache;

$server = array(array('host' => 'localhost', 'port' => '11211', 'weight' => 1));


$Cache = new Cache\CacheService(new Cache\MemcacheProvider($server), 'prefix_key');


$Cache->put("key1", "ssssCs00Caaaarrraa", 60);
if($Cache->has("key2")) {
	echo "yes";
} else {
	echo "no";
}
echo $Cache->get("key1");