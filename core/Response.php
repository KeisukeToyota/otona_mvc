<?php

class Response
{
    protected $content;
    protected $status_code = 200;
    protected $status_text = 'OK';
    protected $http_header = [];

    /**
     * レスポンスを送信
     */
    public function send()
    {
        header('HTTP/1.1' . $this->status_code . ' ' . $this->status_text);

        foreach ($this->http_header as $name => $value) {
            header($name . ':' . $value);
        }

        echo $this->content;
    }

    /**
     * コンテンツを設定
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * ステータスコードを設定
     * @param int $status_code
     * @param string $status_text
     */
    public function setStatusCode(int $status_code, string $status_text='')
    {
        $this->status_code = $status_code;
        $this->status_text = $status_text;
    }

    /**
     * HTTPレスポンスヘッダを設定
     * @param string $name
     * @param mixed $value
     */
    public function setHttpHeader(string $name, $value)
    {
        $this->http_header[$name] = $value;
    }

}