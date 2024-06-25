<?php

namespace Shibaji\Core;

class Cache
{
    protected $cacheDir;

    public function __construct($cacheDir)
    {
        $this->cacheDir = rtrim($cacheDir, '/') . '/';

        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function set($key, $data, $ttl = 3600)
    {
        $cacheFile = $this->getCacheFilePath($key);
        $expires = time() + $ttl;
        $cacheData = serialize(['expires' => $expires, 'data' => $data]);
        file_put_contents($cacheFile, $cacheData);
    }

    public function get($key)
    {
        $cacheFile = $this->getCacheFilePath($key);

        if (!file_exists($cacheFile)) {
            return null;
        }

        $cacheData = unserialize(file_get_contents($cacheFile));

        if ($cacheData['expires'] < time()) {
            unlink($cacheFile);
            return null;
        }

        return $cacheData['data'];
    }

    public function has($key)
    {
        return $this->get($key) !== null;
    }

    protected function getCacheFilePath($key)
    {
        return $this->cacheDir . md5($key) . '.cache';
    }
}
