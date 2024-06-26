<?php

namespace Shibaji\Core;

class View extends Html
{
    protected string $defaultTemplatePath = 'views/';
    protected array $data = [];
    protected Cache $cache;
    protected string $cacheDir = __DIR__ . '/../../cache/views/';
    protected int $cacheDuration = 3600; // 1 hour by default

    public function __construct()
    {
        parent::__construct(); // Call the parent constructor
        $this->cache = new Cache($this->cacheDir);
    }

    public function with($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function setCacheDir($dir)
    {
        $this->cacheDir = rtrim($dir, '/') . '/';
        $this->cache = new Cache($this->cacheDir); // Reinitialize cache with new directory
    }

    public function setCacheDuration($duration)
    {
        $this->cacheDuration = $duration;
    }

    public function render($template, array $data = [], $cache = true)
    {
        $this->data = array_merge($this->data, $data);
        $this->renderTemplate($this->defaultTemplatePath . $template . '.php', $cache);
        $this->renderApp();
    }

    public function partial($template, array $data = [])
    {
        $this->data = array_merge($this->data, $data);
        extract($this->data);
        ob_start();
        include $this->defaultTemplatePath . $template . '.php';
        return ob_get_clean();
    }

    public function renderTemplate($templatePath, $cache = true)
    {
        $cacheKey = $this->getCacheKey($templatePath, $this->data);

        if ($cache && $this->cache->has($cacheKey)) {
            $content = $this->cache->get($cacheKey);
        } else {
            extract($this->data);
            ob_start();
            include $templatePath;
            $content = ob_get_clean();

            if ($cache) {
                $this->cache->set($cacheKey, $content, $this->cacheDuration);
            }
        }

        $this->addElement($content);
        return $content;
    }

    protected function getCacheKey($templatePath, $data)
    {
        return md5($templatePath . serialize($data));
    }
}