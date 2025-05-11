<?php
class Database {
    private $host;
    private $port;
    private $user;
    private $password;
    private $dbName;
    private $dbConnection;

    public function __construct() 
    {
        $this->host = getenv('DB_HOST');
        $this->port = getenv('DB_PORT');
        $this->user = getenv('DB_USER');
        $this->password = getenv('DB_PASSWORD');
        $this->dbName = getenv('DB_NAME');
        if (!$this->host || !$this->port || !$this->user || !$this->password || !$this->dbName) {
            throw new Exception('Database connection information is not set.');
        }
        
    }
    public function connect() 
    {
        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbName};";
            $this->dbConnection = new PDO($dsn, $this->user, $this->password);
            $this->dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception('Database connection failed: ' . $e->getMessage());
        }
        return $this->dbConnection;
    }
}