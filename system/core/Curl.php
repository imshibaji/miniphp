<?php
namespace Shibaji\Core;

class Curl
{
    protected $ch; // cURL resource handle

    public function __construct()
    {
        $this->ch = curl_init();
        $this->setDefaultOptions();
    }

    /**
     * Set default cURL options.
     */
    protected function setDefaultOptions()
    {
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->ch, CURLOPT_HEADER, false);
    }

    /**
     * Set URL for the request.
     *
     * @param string $url
     */
    public function setUrl(string $url)
    {
        curl_setopt($this->ch, CURLOPT_URL, $url);
    }

    /**
     * Set headers for the request.
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
    }

    /**
     * Set cookies for the request.
     *
     * @param array $cookies
     */
    public function setCookies(array $cookies)
    {
        $cookiesString = http_build_query($cookies, '', '; ');
        curl_setopt($this->ch, CURLOPT_COOKIE, $cookiesString);
    }

    /**
     * Perform a GET request.
     *
     * @return mixed
     */
    public function get()
    {
        // GET request
        curl_setopt($this->ch, CURLOPT_HTTPGET, true);
        return $this->execute();
    }

    /**
     * Perform a POST request.
     *
     * @param array $data
     * @return mixed
     */
    public function post(array $data)
    {
        // POST request
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return $this->execute();
    }

    /**
     * Perform a PUT request.
     *
     * @param array $data
     * @return mixed
     */
    public function put(array $data)
    {
        // PUT request
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        return $this->execute();
    }

    /**
     * Perform a DELETE request.
     *
     * @return mixed
     */
    public function delete()
    {
        // DELETE request
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        return $this->execute();
    }

    /**
     * Execute the cURL request.
     *
     * @return mixed
     */
    protected function execute()
    {
        $response = curl_exec($this->ch);
        if ($response === false) {
            echo 'Curl error: ' . curl_error($this->ch);
        }
        return $response;
    }

    /**
     * Close cURL session.
     */
    public function __destruct()
    {
        curl_close($this->ch);
    }
}
