<?php

class DbManager
{
    protected $connections = [];
    protected $repository_connection_map = [];
    protected $repositories = [];

    /**
     * データベースえへ接続
     * @param string $name
     * @param array $params
     */
    public function connect(string $name, array $params)
    {
        $params = array_merge([
            'dsn' => null,
            'user' => '',
            'password' => '',
            'options' => [],
        ], $params);

        $connection = new PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['options']
        );

        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connections[$name] = $connection;
    }

    /**
     * コネクションを取得
     * @param null|string $name
     * @return PDO
     */
    public function getConnection(?string $name=null): PDO
    {
        if (is_null($name)) {
            return current($this->connections);
        }

        return $this->connections[$name];
    }

    /**
     * リポジトリごとのコネクション情報を設定
     * @param string $repository_name
     * @param string $name
     */
    public function setRepositoryConnectionMap(string $repository_name, string $name)
    {
        $this->repository_connection_map[$repository_name] = $name;
    }

    /**
     * 指定されたリポジトリに対応するコネクションを取得
     * @param string $repository_name
     * @return PDO
     */
    public function getConnectionForRepository(string $repository_name): PDO
    {
        $name = $this->repository_connection_map[$repository_name] ?? null;
        $connection = $this->getConnection($name);

        return $connection;
    }

    /**
     * リポジトリを取得
     * @param string $repository_name
     * @return DbRepository
     */
    public function get(string $repository_name): DbRepository
    {
        if (!isset($this->repositories[$repository_name])) {
            $repository_class = $repository_name . 'Repository';
            $connection = $this->getConnectionForRepository($repository_name);

            $repository = new $repository_class($connection);

            $this->repositories[$repository_name] = $repository;
        }

        return $this->repositories[$repository_name];
    }

    /**
     * デストラクタ
     * リポジトリと接続を破棄する
     */
    public function __destruct()
    {
        foreach ($this->repositories as $repository) {
            unset($repository);
        }

        foreach ($this->connections as $connection) {
            unset($connection);
        }
    }

}