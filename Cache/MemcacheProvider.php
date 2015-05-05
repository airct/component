<?php 
/**
 * Clone from laravel
 */

namespace Cache;

use Memcached;
use RuntimeException;

class MemcacheProvider implements ICache {

	/**
	 * The Memcached instance.
	 *
	 * @var \Memcached
	 */
	protected $memcached;

	/**
	 * A string that should be prepended to keys.
	 *
	 * @var string
	 */
	protected $prefix;

	/**
	 * Create a new Memcached connection.
	 *
	 * @param  array  $servers
	 * @return \Memcached
	 *
	 * @throws \RuntimeException
	 */
	public function __construct(array $servers, $prefix = '')
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
		
		if ( ! is_array($memcachedStatus))
		{
			throw new RuntimeException("No Memcached servers added.");
		}

		if (in_array('255.255.255', $memcachedStatus) && count(array_unique($memcachedStatus)) === 1)
		{
			throw new RuntimeException("Could not establish Memcached connection.");
		}

		$this->connect($memcached, $prefix);
	}

	/**
	 * Create a new Memcached store.
	 *
	 * @param  \Memcached  $memcached
	 * @param  string      $prefix
	 * @return void
	 */
	private function connect($memcache, $prefix = '')
	{

		$this->memcached = $memcache;
		
		$this->prefix = strlen($prefix) > 0 ? $prefix . ':' : '';
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function get($key)
	{
		$value = $this->memcached->get($this->prefix.$key);

		if ($this->memcached->getResultCode() == 0)
		{
			return $value;
		}
	}

	/**
	 * Store an item in the cache for a given number of minutes.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $minutes
	 * @return void
	 */
	public function put($key, $value, $minutes)
	{
		$this->memcached->set($this->prefix.$key, $value, $minutes * 60);
	}

	/**
	 * Store an item in the cache if the key doesn't exist.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  int     $minutes
	 * @return bool
	 */
	public function add($key, $value, $minutes)
	{
		return $this->memcached->add($this->prefix.$key, $value, $minutes * 60);
	}

	/**
	 * Increment the value of an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return int|bool
	 */
	public function increment($key, $value = 1)
	{
		return $this->memcached->increment($this->prefix.$key, $value);
	}

	/**
	 * Decrement the value of an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return int|bool
	 */
	public function decrement($key, $value = 1)
	{
		return $this->memcached->decrement($this->prefix.$key, $value);
	}

	/**
	 * Store an item in the cache indefinitely.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function forever($key, $value)
	{
		return $this->put($key, $value, 0);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function forget($key)
	{
		return $this->memcached->delete($this->prefix.$key);
	}

	/**
	 * Remove all items from the cache.
	 *
	 * @return void
	 */
	public function flush()
	{
		$this->memcached->flush();
	}

	/**
	 * Get the cache key prefix.
	 *
	 * @return string
	 */
	public function getPrefix()
	{
		return $this->prefix;
	}

}
