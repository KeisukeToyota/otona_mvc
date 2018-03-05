<?php

class Session
{
    protected static $sessionStarted = false;
    protected static $sessionIdRegenerated = false;

    /**
     * コンストラクタ
     * セッションを自動的に開始する
     */
    public function __construct()
    {
        if (!self::$sessionStarted) {
            session_start();

            self::$sessionStarted = true;
        }
    }

    /**
     * セッションに値を設定
     * @param string $name
     * @param mixed $value
     */
    public function set(string $name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * セッションから値を取得
     * @param string $name
     * @param mixed $default 指定したキーが存在しない場合のデフォルト値
     * @return mixed
     */
    public function get(string $name, $default=null)
    {
        return $_SESSION[$name] ?? $default;
    }

    /**
     * セッションから値を削除
     * @param string $name
     */
    public function remove(string $name)
    {
        unset($_SESSION[$name]);
    }

    /**
     * セッションを空にする
     */
    public function clear()
    {
        $_SESSION = [];
    }

    /**
     * セッションIDを再生成する
     *
     * @param boolean $destroy trueの場合は古いセッションを破棄する
     */
    public function regenerate(bool $destroy=true)
    {
        if (!self::$sessionIdRegenerated) {
            session_regenerate_id($destroy);

            self::$sessionIdRegenerated = true;
        }
    }

    /**
     * 認証状態を設定
     * @param bool $bool
     */
    public function setAuthenticated(bool $bool)
    {
        $this->set('_authenticated', $bool);
        $this->regenerate();
    }

    /**
     * 認証済みか判定
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->get('_authenticated', false);
    }
}