<?php

class Request
{
    /**
     * リクエストメソッドがPOSTかどうか判定
     * @return bool
     */
    public function isPost(): bool
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return true;
        }

        return false;
    }

    /**
     * GETパラメータを取得
     * @param string $name
     * @param null $default
     * @return string
     */
    public function getGet(string $name, $default=null): string
    {
        if (isset($_GET[$name])) {
            return $_GET[$name];
        }

        return $default;
    }

    /**
     * POSTパラメータを取得
     * @param string $name
     * @param null $default
     * @return string
     */
    public function getPost(string $name, $default=null): string
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }

        return $default;
    }

    /**
     * ホスト名を取得
     * @return string
     */
    public function getHost(): string
    {
        if (!empty($_SERVER['HTTP_HOST'])) {
            return $_SERVER['HTTP_HOST'];
        }

        return $_SERVER['SERVER_NAME'];
    }

    /**
     * SSLでアクセスされたかどうか判定
     * @return bool
     */
    public function isSsl(): bool
    {
        if (!isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
            return true;
        }

        return false;
    }

    /**
     * リクエストURIを取得
     * @return string
     */
    public function getRequestUri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * ベースURLを取得
     * @return string
     */
    public function getBaseUrl(): string
    {
        $script_name = $_SERVER['SCRIPT_NAME'];
        $request_uri = $this->getRequestUri();

        if (strpos($request_uri, $script_name) === 0) {
            return $script_name;
        } elseif (strpos($request_uri, $script_name) === 0) {
            return rtrim(dirname($script_name), '/');
        }

        return '';
    }

    /**
     * PATH_INFOを取得
     * @return string
     */
    public function getPathInfo(): string
    {
        $base_url = $this->getBaseUrl();
        $request_uri = $this->getRequestUri();

        $pos = strpos($request_uri, '?');
        if ($pos !== false) {
            $request_uri = substr($request_uri, 0, $pos);
        }

        $path_info = (string)substr($request_uri, strlen($base_url));

        return $path_info;
    }
}