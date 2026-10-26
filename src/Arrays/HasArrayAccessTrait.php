<?php

declare(strict_types=1);

namespace TLabsCo\TraitAndHelper\Arrays;

use Illuminate\Support\Arr;

trait HasArrayAccessTrait
{
    protected function arrayDataKey(): string
    {
        return 'data';
    }

    public function has(string $key): bool
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
    public function getMany(array $keys): array
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
     */
    public function set($key, $value = null): void
    {
        $keys = is_array($key) ? $key : [$key => $value];

        foreach ($keys as $key => $value) {
            Arr::set($this->{$this->arrayDataKey()}, $key, $value);
        }
    }

    public function all(): array
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
        Arr::forget($this->{$this->arrayDataKey()}, $key);
    }

    public function __get(string $key): mixed
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
