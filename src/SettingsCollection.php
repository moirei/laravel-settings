<?php

namespace MOIREI\Settings;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class SettingsCollection extends Collection
{
    private array $original = [];
    private array $defaults = [];

    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     * @return void
     */
    public function __construct($settings = [], $defaults = [])
    {
        parent::__construct(Helpers::arrayMergeRecursiveDistinct($defaults, $settings));
        $this->original = $settings;
        $this->defaults = $defaults;
    }

    /**
     * Dynamically access collection proxies.
     *
     * @param  string  $key
     * @return mixed
     *
     * @throws \Exception
     */
    public function __get($key)
    {
        if (Arr::has($this->items, $key)) {
            return Arr::get($this->items, $key);
        }

        return parent::__get($key);
    }

    /**
     * Put an item in the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return $this
     */
    public function set($key, $value)
    {
        return $this->put($key, $value);
    }

    /**
     * Get an item from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $value = Arr::get($this->original, $key);
        return $value ?? $default ?? Arr::get($this->defaults, $key);
    }

    /**
     * Put an item in the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return $this
     */
    public function put($key, $value)
    {
        Arr::set($this->items, $key, $value);
        Arr::set($this->original, $key, $value);
        return $this;
    }

    /**
     * Get changes
     *
     * @return array
     */
    public function original(): array
    {
        return $this->original;
    }
}
