<?php 
/**
 * Clone from laravel
 */

namespace Cache;

class CacheService {

	/**
	 * The cache store implementation.
	 *
	 * @var \Illuminate\Contracts\Cache\Store
	 */
	protected $store;

	/**
	 * The default number of minutes to store items.
	 *
	 * @var int
	 */
	protected $default = 60;

	/**
	 * Create a new cache repository instance.
	 *
	 * @param  \Illuminate\Contracts\Cache\Store  $store
	 */
	public function __construct($store)
	{
		$this->store = $store;
	}

	/**
	 * Determine if an item exists in the cache.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function has($key)
	{
		return ! is_null($this->get($key));
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function get($key, $default = null)
	{
		$value = $this->store->get($key);

		return $value;
	}

	/**
	 * Retrieve an item from the cache and delete it.
	 *
	 * @param  string  $key
	 * @param  mixed   $default
	 * @return mixed
	 */
	public function pull($key, $default = null)
	{
		$value = $this->get($key, $default);

		$this->forget($key);

		return $value;
	}

	/**
	 * Store an item in the cache.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  \DateTime|int  $minutes
	 * @return void
	 */
	public function put($key, $value, $minutes)
	{
		if ( ! is_null($minutes))
		{
			$this->store->put($key, $value, $minutes);
		}
	}

	/**
	 * Store an item in the cache if the key does not exist.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @param  \DateTime|int  $minutes
	 * @return bool
	 */
	public function add($key, $value, $minutes)
	{
		if (method_exists($this->store, 'add'))
		{
			return $this->store->add($key, $value, $minutes);
		}

		if (is_null($this->get($key)))
		{
			$this->put($key, $value, $minutes);

			return true;
		}

		return false;
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
		$this->store->forever($key, $value);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string $key
	 * @return bool
	 */
	public function forget($key)
	{
		$success = $this->store->forget($key);
		
		return $success;
	}

	/**
	 * Get the default cache time.
	 *
	 * @return int
	 */
	public function getDefaultCacheTime()
	{
		return $this->default;
	}

	/**
	 * Set the default cache time in minutes.
	 *
	 * @param  int   $minutes
	 * @return void
	 */
	public function setDefaultCacheTime($minutes)
	{
		$this->default = $minutes;
	}

	/**
	 * Get the cache store implementation.
	 *
	 * @return \Illuminate\Contracts\Cache\Store
	 */
	public function getStore()
	{
		return $this->store;
	}

	/**
	 * Determine if a cached value exists.
	 *
	 * @param  string  $key
	 * @return bool
	 */
	public function offsetExists($key)
	{
		return $this->has($key);
	}

	/**
	 * Retrieve an item from the cache by key.
	 *
	 * @param  string  $key
	 * @return mixed
	 */
	public function offsetGet($key)
	{
		return $this->get($key);
	}

	/**
	 * Store an item in the cache for the default time.
	 *
	 * @param  string  $key
	 * @param  mixed   $value
	 * @return void
	 */
	public function offsetSet($key, $value)
	{
		$this->put($key, $value, $this->default);
	}

	/**
	 * Remove an item from the cache.
	 *
	 * @param  string  $key
	 * @return void
	 */
	public function offsetUnset($key)
	{
		return $this->forget($key);
	}

}

