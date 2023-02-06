<?php
class Database
{
    //使用するデータベースを定義
    private  $dsn      = 'mysql:dbname=test;host=localhost;charset=utf8mb4';
    private  $username = 'root';
    private  $password = '';
    protected $conn;

    //このクラスは継承されているので、インスタンスが生成されるときにコンストラクタが実行される。
    public function __construct()
    {
        try {
            //PDOを使用してデータベースに接続する。
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
        } catch (PDOException $e) {
            $message = $e->getMessage();
            return $message;
        }
    }
}
