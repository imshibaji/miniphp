<?php
namespace Shibaji\Core;

class View extends Html
{
    protected string $defaultTemplatePath = 'views/';
    protected array $data = [];
    protected string $cacheDir = __DIR__ . '/../cache/';
    protected int $cacheDuration = 3600; // 1 hour by default

    public function with($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function setCacheDir($dir)
    {
        $this->cacheDir = rtrim($dir, '/') . '/';
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

    public function partial($template, array $data = []){
            $this->data = array_merge($this->data, $data);
            extract($this->data);
            ob_start();
            include $this->defaultTemplatePath . $template . '.php';
            $content = ob_get_clean();
        return $content;
    }

    public function renderTemplate($templatePath, $cache = true)
    {
        $cacheFile = $this->getCacheFilePath($templatePath, $this->data);

        if ($cache && $this->isCacheValid($cacheFile)) {
            $content = file_get_contents($cacheFile);
        } else {
            extract($this->data);
            ob_start();
            include $templatePath;
            $content = ob_get_clean();
            
            if ($cache) {
                $this->saveCache($cacheFile, $content);
            }
        }
        $this->addElement($content);
    }

    protected function getCacheFilePath($templatePath, $data)
    {
        $cacheKey = md5($templatePath . serialize($data));
        return $this->cacheDir . $cacheKey . '.html';
    }

    protected function isCacheValid($cacheFile)
    {
        if (!file_exists($cacheFile)) {
            return false;
        }

        return (time() - filemtime($cacheFile)) < $this->cacheDuration;
    }

    protected function saveCache($cacheFile, $content)
    {
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }

        file_put_contents($cacheFile, $content);
    }
}