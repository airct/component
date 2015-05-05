<?php 
/**
 * Clone from laravel
 */

namespace Cache;

use Memcached;
use RuntimeException;

class MemcacheConnector {

	/**
	 * Create a new Memcached connection.
	 *
	 * @param  array  $servers
	 * @return \Memcached
	 *
	 * @throws \RuntimeException
	 */
	public static function connect(array $servers)
	{
		
		$memcached = new Memcached;

		// For each server in the array, we'll just extract the configuration and add
		// the server to the Memcached connection. Once we have added all of these
		// servers we'll verify the connection is successful and return it back.
		foreach ($servers as $server)
		{
			$memcached->addServer(
				$server['host'], $server['port'], $server['weight']
			);
		}

		$memcachedStatus = $memcached->getVersion();
print_r($memcachedStatus);
		if ( ! is_array($memcachedStatus))
		{
			throw new RuntimeException("No Memcached servers added.");
		}

		if (in_array('255.255.255', $memcachedStatus) && count(array_unique($memcachedStatus)) === 1)
		{
			throw new RuntimeException("Could not establish Memcached connection.");
		}

		return $memcached;
	}
}
