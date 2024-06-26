<?php

namespace Instagram\Driver;

/**
 * @template T
 */
interface DriverInterface
{
    /**
     * @return T
     */
    public function handle(string $url);
}
