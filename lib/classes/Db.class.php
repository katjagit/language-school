<?php declare(strict_types=1);

class Db
{
    /**
     * The PDO object
     * @var PDO
     */
    protected $pdo;

    /** Connected to the database
     * @var bool
     */

    private $isConnected;

    /** The database settings
     * @var array
     */
    protected $settings = [
            'host' => 'localhost',
            'dbname' => 'school',
            'user' => 'root',
            'password' => 'root',
            'charset' => 'utf8'
    ];


    /** Database constructor
     * @param array $settings
     */
    public function __construct()
    {
//        $this->settings = $settings;
        $this->connect();
    }

    private function connect()
    {
        $dsn = 'mysql:dbname=' . $this->settings['dbname'] . ';host=' . $this->settings['host'];

        try
        {
            $this->pdo = new \PDO($dsn, $this->settings['user'], $this->settings['password'], [
                \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->settings['charset']
            ]);

            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

            $this->isConnected = true;
        } catch (\PDOException $e)
        {
            echo "Leider ist die Verbindung mit der Datenbank fehlgeschlagen";
            exit(file_put_contents('db.errors.txt', $e->getMessage().PHP_EOL,FILE_APPEND));
        }
    }

    public function closeConnection()
    {
        $this->pdo = null;
    }

    public function executeSql($sql, $arg)
    {
        return $this->pdo->prepare($sql)->execute($arg);
    }


    public function selectFirstRow($sql, $arg)
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($arg);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function selectRows($sql)
    {
        return $this->pdo->query($sql)->fetchAll();
    }

}