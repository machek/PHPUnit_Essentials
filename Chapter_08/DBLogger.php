<?php

class DBLogger implements ILogger
{
    private $db;

    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function log($request, $priority)
    {
        $sql = "insert into transaction_log(priority, timestamp, data)
                values (:priority, :timestamp, :data)";

        $statement = $this->db->prepare($sql);

        $statement->bindParam(':priority', $priority);
        $statement->bindParam(':timestamp', time());
        $statement->bindParam(':data', $request);

        return $statement->execute();
    }
}
