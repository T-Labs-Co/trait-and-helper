<?php

/*
 * This file is a part of package t-co-labs/trait-and-helper
 *
 * (c) T.Labs & Co.
 * Contact for Work: T. <hongty.huynh@gmail.com>
 *
 * We're PHP and Laravel whizzes, and we'd love to work with you! We can:
 *  - Design the perfect fit solution for your app.
 *  - Make your code cleaner and faster.
 *  - Refactoring and Optimize performance.
 *  - Ensure Laravel best practices are followed.
 *  - Provide expert Laravel support.
 *  - Review code and Quality Assurance.
 *  - Offer team and project leadership.
 *  - Delivery Manager
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace TLabsCo\TraitAndHelper\Arrays;

use Illuminate\Support\Arr;

trait HasArrayAccessTrait
{
    protected function arrayDataKey()
    {
        return 'data';
    }

    /**
     * @param  string  $key
     * @return bool
     */
    public function has($key)
    {
        return Arr::has($this->{$this->arrayDataKey()}, $key);
    }

    /**
     * @param  array|string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (is_array($key)) {
            return $this->getMany($key);
        }

        return Arr::get($this->{$this->arrayDataKey()}, $key, $default);
    }

    /**
     * @param  array<string|int,mixed>  $keys
     * @return array<string,mixed>
     */
    public function getMany($keys)
    {
        $config = [];

        foreach ($keys as $key => $default) {
            if (is_numeric($key)) {
                [$key, $default] = [$default, null];
            }

            $config[$key] = Arr::get($this->{$this->arrayDataKey()}, $key, $default);
        }

        return $config;
    }

    /**
     * @param  array|string  $key
     * @param  mixed  $value
     * @return void
     */
    public function set($key, $value = null)
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->{$this->arrayDataKey()}, $key, $value);
        }
    }

    /**
     * @return array
     */
    public function all()
    {
        return $this->{$this->arrayDataKey()};
    }

    /**
     * @param  string  $key
     */
    public function offsetExists($key): bool
    {
        return $this->has($key);
    }

    /**
     * Get a configuration option.
     *
     * @param  string  $key
     */
    public function offsetGet($key): mixed
    {
        return $this->get($key);
    }

    /**
     * @param  string  $key
     * @param  mixed  $value
     */
    public function offsetSet($key, $value): void
    {
        $this->set($key, $value);
    }

    /**
     * @param  string  $key
     */
    public function offsetUnset($key): void
    {
        $this->set($key, null);
    }

    public function __get(string $key)
    {
        return $this->offsetGet($key);
    }

    public function __set(string $key, $value): void
    {
        $this->offsetSet($key, $value);
    }

    public function __unset(string $key): void
    {
        $this->offsetUnset($key);
    }
}
