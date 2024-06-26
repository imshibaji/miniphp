<?php
namespace Shibaji\Core;

class Template
{
    protected array $data = [];
    private $templateDir;
    private $cacheDir;
    private $cacheDuration;
    private $cacheEnabled;

    /**
     * TemplateManager constructor.
     *
     * @param string $templateDir The directory where templates are located.
     * @param string $cacheDir The directory where cached templates will be stored.
     * @param int $cacheDuration The duration in seconds for which the cache is valid.
     * @param bool $cacheEnabled Whether caching is enabled.
     */
    public function __construct($templateDir = __DIR__ . '/../../views/', $cacheDir = __DIR__ . '/../../cache/views/', $cacheDuration = 3600, $cacheEnabled = true)
    {
        $this->templateDir = rtrim($templateDir, '/') . '/';
        $this->cacheDir = rtrim($cacheDir, '/') . '/';
        $this->cacheDuration = $cacheDuration;
        $this->cacheEnabled = $cacheEnabled;

        // Ensure cache directory exists
        if (!file_exists($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    /**
     * Adds data to the template.
     *
     * @param string $key The name of the data.
     * @param mixed $value The value of the data.
     * @return $this
     */
    public function with($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * Renders a template with provided data, optionally using caching.
     *
     * @param string $templateName The name of the template file (without extension).
     * @param array $data The data to pass into the template.
     * @param bool $useCache Whether to use caching for this template rendering.
     * @return string|false The rendered template as a string, or false on failure.
     */
    public function render($templateName, $data = [], $useCache = true)
    {
        $data = array_merge($this->data, $data);
        if ($useCache && $this->cacheEnabled) {
            $cacheKey = $this->getCacheKey($templateName, $data);

            $cacheFile = $this->cacheDir . $cacheKey . '.html';

            if ($this->isCacheValid($cacheFile)) {
                return file_get_contents($cacheFile);
            }
        }

        // Render the template
        $templateFile = $this->templateDir . $templateName . '.php';

        if (!file_exists($templateFile)) {
            echo $templateFile . ' does not exist'. PHP_EOL;
            // Template not found
            echo "Template '$templateName' not found.";
            return false;
        }

        ob_start();
        extract($data); // Extract data to make variables available in the template
        include $templateFile;
        $output = ob_get_clean();

        // Save to cache
        if ($useCache && $this->cacheEnabled) {
            $this->saveToCache($cacheFile, $output);
        }

        return $output;
    }

    /**
     * Generates a cache key based on template name and data.
     *
     * @param string $templateName The name of the template file (without extension).
     * @param array $data The data to pass into the template.
     * @return string The cache key.
     */
    private function getCacheKey($templateName, $data)
    {
        $hash = md5($templateName . serialize($data));
        return 'template_' . $hash;
    }

    /**
     * Checks if the cached file is still valid based on cache duration.
     *
     * @param string $cacheFile The path to the cached file.
     * @return bool True if cache is valid, false otherwise.
     */
    private function isCacheValid($cacheFile)
    {
        if (!file_exists($cacheFile)) {
            return false;
        }

        return (time() - filemtime($cacheFile)) < $this->cacheDuration;
    }

    /**
     * Saves rendered template output to cache file.
     *
     * @param string $cacheFile The path to the cache file.
     * @param string $output The rendered template output to save.
     */
    private function saveToCache($cacheFile, $output)
    {
        file_put_contents($cacheFile, $output);
    }
}