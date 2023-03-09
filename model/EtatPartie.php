<?php

class EtatPartie
{
    private PDO $db;
    private $id;
    private $j1;
    private $j2;
    private $winner;
    private $board;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=partiespuissance4';
        $username = 'root';
        $password = '';

        try {
            $this->db = new PDO($dsn, $username, $password);
        } catch (PDOException $e) {
            echo 'Connexion échouée : ' . $e->getMessage();
            exit();
        }
    }

    public function creerEtatPartie() {
        $sql = "INSERT INTO partie (j1, j2, winner, board) VALUES (:j1, :j2, :winner, :board)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':j1', $this->j1);
        $stmt->bindParam(':j2', $this->j2);
        $stmt->bindParam(':winner', $this->winner);
        $stmt->bindParam(':board', $this->board);
        $stmt->execute();

        $this->id = $this->db->lastInsertId();
    }

    /**
     * @return mixed
     */
    public function getJ1()
    {
        return $this->j1;
    }

    /**
     * @param mixed $j1
     */
    public function setJ1($j1): void
    {
        $this->j1 = $j1;
    }

    /**
     * @return mixed
     */
    public function getJ2()
    {
        return $this->j2;
    }

    /**
     * @param mixed $j2
     */
    public function setJ2($j2): void
    {
        $this->j2 = $j2;
    }

    /**
     * @return mixed
     */
    public function getWinner()
    {
        return $this->winner;
    }

    /**
     * @param mixed $winner
     */
    public function setWinner($winner): void
    {
        $this->winner = $winner;
    }

    /**
     * @return mixed
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * @param mixed $board
     */
    public function setBoard($board): void
    {
        $this->board = $board;
    }

    /**
     * @return PDO
     */
    public function getDb(): PDO
    {
        return $this->db;
    }

    /**
     * @param PDO $db
     */
    public function setDb(PDO $db): void
    {
        $this->db = $db;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

}