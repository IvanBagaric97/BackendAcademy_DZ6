<?php

namespace db;
use \PDO;


class DBDriver
{
    private PDO $db;

    public function __construct()
    {
        $a = new DBPool();
        $this->db = $a -> getInstance();
    }

    /**
     * Unesi novi red u bazu
     * @param string $file
     * @param string $row
     */
    function insert(string $file, string $row): void
    {
        $current = file_get_contents($file);
        $current .= trim($row) . "\n";
        file_put_contents($file, $current, LOCK_EX);
    }

    /**
     * Iz baze uklanja redak s odabranim id-om
     * @param string $table
     * @param string $id
     */
    function delete(string $table, string $id): void
    {
        $sql = "DELETE FROM " . $table ." WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
    }

    /**
     * Vraća redak sa zadanim id-im ili vraća sve retke ako je id == null
     * @param string $table
     * @param string|null $id
     * @return array
     */
    function select(string $table, ?string $id = null): array
    {
        $ret = [];

        if ($id === null) {
            $sql = "SELECT * FROM " . $table;
        }else {
            $sql = "SELECT * FROM " . $table . " WHERE id=" . $id;
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        foreach($stmt as $row){
            $pom = [];
            foreach($row as $item){
                array_push($pom, $item);
            }
            array_push($ret, $pom);
        }
        if($id === null){
            return $ret;
        }else{
            return $ret[0];
        }
    }

    /**
     * Vraca listu filmova cije ime pocinje sa zadanim slovom
     * @param string $letter
     * @return array
     */
    function startsWithLetter(string $letter): array
    {
        $ret = [];

        $sql = "SELECT * FROM films.film WHERE name LIKE " . "'" . $letter . "%'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        foreach($stmt as $row){
            $pom = [];
            foreach($row as $item){
                array_push($pom, $item);
            }
            array_push($ret, $pom);
        }

        return $ret;
    }

    function createNewMovie(string $name, int $genre_id, int $year, int $duration, string $cover) : void {
        $sql = "INSERT INTO films.film (name, id_genre, year, duration, cover)
                VALUES (:ime, :g_id, :godina, :trajanje, :art)";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([":ime"=>$name, ":g_id"=>$genre_id, ":godina"=>$year, ":trajanje"=>$duration, ":art"=>$cover]);
    }

    function getGenreId(string $genre) : ?int {
        $sql = "SELECT id FROM genre WHERE name=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($genre));
        return $stmt->fetch()->id ?? null;
    }

    function getGenres() : array {
        $ret = [];
        $sql = "SELECT name FROM genre";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        foreach($stmt as $row){
            foreach($row as $item){
                array_push($ret, $item);
            }
        }
        return $ret;
    }

    function getImage(string $id)
    {
        $sql = "SELECT cover FROM film WHERE id=?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(array($id));
        return $stmt->fetch()->cover ?? null;
    }
}