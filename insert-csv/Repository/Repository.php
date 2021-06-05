<?php


class Repository
{

    /**
     * @var \Pdo
     */
    public Pdo $dbh;

    /**
     * @var string $host
     */
    private string $host = '127.0.0.1';

    /**
     * @var string $db
     */
    private string $db = 'csv_parser';

    /**
     * @var string $user
     */
    private string $user = 'root';

    /**
     * @var string $pass
     */
    private string $pass = '';

    /**
     * @var string $charset
     */
    private string $charset = 'UTF8';

    /**
     * @var string $dsn
     */
    private string $dsn = "mysql:host=%s;dbname=%s;charset=%s";

    /**
     * @var array $options
     */
    private array $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
        PDO::ATTR_PERSISTENT => true,
    ];

    /**
     * DatabasePdo constructor.
     */
    public function __construct()
    {
        $this->getConnection();
    }

    /**
     * Create PDO object
     */
    private function getConnection(): void
    {
        try {
            $this->buildDsn();
            $this->dbh = new PDO($this->dsn, $this->user, $this->pass, $this->options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    private function buildDsn(): void
    {
        $this->dsn = sprintf(
            $this->dsn,
            $this->host,
            $this->db,
            $this->charset
        );
    }
}