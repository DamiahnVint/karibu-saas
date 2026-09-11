<?php

declare(strict_types=1);

namespace Src\Contracts;

/**
 * Port pour le cache — toute implémentation (Redis, Memcached, DB)
 * doit respecter ce contrat. Branché via AppServiceProvider.
 */
interface CacheInterface
{
    public function get(string $key, mixed $default = null): mixed;

    public function put(string $key, mixed $value, int $ttlInSeconds = 3600): bool;

    public function forget(string $key): bool;

    public function flush(): bool;

    public function remember(string $key, int $ttlInSeconds, callable $callback): mixed;
}
