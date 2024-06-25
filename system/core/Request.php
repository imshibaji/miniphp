<?php
namespace Shibaji\Core;
class Request
{
    private $body;
    private $params;


    public function __construct($params = [])
    {
        $this->body = $_REQUEST;
        $this->params = $params;
    }

    public function getBody()
    {
        return $this->body;
    }
    public function __get($name)
    {
        return $this->body[$name] ?? $this->params[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->body[$name] = trim($value);
        $this->params[$name] = trim($value);
    }

    public function input($name){ 
        return trim($this->get($name)) ?? null;
    }

    public function isset($name)
    {
        return isset($this->params[$name]);
    }

    public function unset($name)
    {
        unset($this->params[$name]);
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getJsonBody(){
        return json_encode($this->body);
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function get($key)
    {
        if (isset($this->body[$key])) {
            return $this->body[$key];
        }
        return null;
    }

    public function set($key, $value)
    {
        $this->body[$key] = $value;
    }

    public function getAll()
    {
        return $this->body;
    }

    public function remove($key)
    {
        unset($this->body[$key]);
    }

    public function has($key)
    {
        return isset($this->body[$key]);
    }

    public function getContentType()
    {
        return $_SERVER['CONTENT_TYPE'];
    }

    public function getAccept()
    {
        return $_SERVER['HTTP_ACCEPT'];
    }

    public function getAcceptLanguage()
    {
        return $_SERVER['HTTP_ACCEPT_LANGUAGE'];
    }

    public function getHost()
    {
        return $_SERVER['HTTP_HOST'];
    }

    public function getOrigin()
    {
        return $_SERVER['HTTP_ORIGIN'];
    }

    public function getRequestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getRequestUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getRemoteAddr()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public function getRemoteHost()
    {
        return $_SERVER['REMOTE_HOST'];
    }

    public function getRemoteIdent()
    {
        return $_SERVER['REMOTE_IDENT'];
    }

    public function getRemoteUser()
    {
        return $_SERVER['REMOTE_USER'];
    }

    public function getRemotePort()
    {
        return $_SERVER['REMOTE_PORT'];
    }

    public function getServerAddr()
    {
        return $_SERVER['SERVER_ADDR'];
    }

    public function getServerPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    public function getDevice()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'];
    }

    public function getReferer()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    public function getProtocol()
    {
        return $_SERVER['SERVER_PROTOCOL'];
    }

    public function getPort()
    {
        return $_SERVER['SERVER_PORT'];
    }

    public function getServerName()
    {
        return $_SERVER['SERVER_NAME'];
    }

    public function getServer($key)
    {
        return $_SERVER[$key];
    }

    public function setServer($key, $value)
    {
        $_SERVER[$key] = $value;
    }

    public function removeServer($key)
    {
        unset($_SERVER[$key]);
    }

    public function hasServer($key)
    {
        return isset($_SERVER[$key]);
    }

    public function getCookie($key)
    {
        return $_COOKIE[$key];
    }

    public function setCookie($key, $value)
    {
        $_COOKIE[$key] = $value;
    }

    public function removeCookie($key)
    {
        unset($_COOKIE[$key]);
    }

    public function hasCookie($key)
    {
        return isset($_COOKIE[$key]);
    }

    public function getHeaders()
    {
        return getallheaders();
    }

    public function getHeader($key)
    {
        return $this->getHeaders()[$key];
    }

    public function setHeader($key, $value)
    {
        $this->getHeaders()[$key] = $value;
    }

    public function removeHeader($key)
    {
        unset($this->getHeaders()[$key]);
    }  

    public function hasHeader($key)
    {
        return isset($this->getHeaders()[$key]);
    }

    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function getUri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function getPath()
    {
        $uri = $this->getUri();
        $path = explode('?', $uri)[0];
        return $path;
    }

    public function getQueryParams()
    {
        return $_GET;
    }

    public function getQuery($key)
    {
        return $this->getQueryParams()[$key];
    }

    public function setQuery($key, $value)
    {
        $this->getQueryParams()[$key] = $value;
    }

    public function removeQuery($key)
    {
        unset($this->getQueryParams()[$key]);
    }

    public function hasQuery($key)
    {
        return isset($this->getQueryParams()[$key]);
    }

    public function getBodyParams()
    {
        return $this->getBody();
    }

    public function session($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function getSession($key)
    {
        return $_SESSION[$key];
    }

    public function removeSession($key)
    {
        unset($_SESSION[$key]);
    }

    public function hasSession($key)
    {
        return isset($_SESSION[$key]);
    }
}