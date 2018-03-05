<?php

abstract class DbRepository
{
    protected $connection;

    /**
     * コンストラクタ.
     * @param PDO $connection
     */
    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    /**
     * クエリを実行
     * @param string $sql
     * @param array $params
     * @return PDOStatement
     */
    public function execute(string $sql, array $params=[]): PDOStatement
    {
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }

    /**
     * クエリを実行し、結果を１行取得
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetch(string $sql, array $params=[]): array
    {
        return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * クエリを実行し、結果を全て取得
     * @param string $sql
     * @param array $params
     * @return array
     */
    public function fetchAll(string $sql, array $params=[]): array
    {
        return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
    }
}