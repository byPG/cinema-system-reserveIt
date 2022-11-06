<?php

class Filmy
{
    public $db = null;

    public function __construct(DBController $db)
    {
        if (!isset($db->con)) return null;
        $this->db = $db;
    }

    /*pobieranie danych o produkcie za pomocą metody getData*/
    public function getData($table = 'filmy'){
        $this->disableFilms();
        $result = $this->db->con->query("SELECT * FROM {$table} WHERE status = 'aktywny'");

        $resultArray = array();

        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $resultArray[] = $item;
        }

        return $resultArray;
    }

    public function getAllFilms($table = 'filmy'){
        $this->disableFilms();
        $result = $this->db->con->query("SELECT * FROM {$table}");

        $resultArray = array();

        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $resultArray[] = $item;
        }

        return $resultArray;
    }

    public function disableFilms($table = 'filmy'){
        $this->db->con->query("UPDATE {$table} SET status = 'nieaktywny' WHERE CURRENT_TIMESTAMP() > data_seansu");
    }

    public function getFilmById($id){
        $result = $this->db->con->query("SELECT * FROM filmy WHERE id_film = {$id}");

        return mysqli_fetch_assoc($result);
    }

    public function followFilm($filmId, $userId){
        return $this->db->con->query("INSERT INTO followed_films VALUES ({$filmId}, {$userId})");
    }

    public function checkFollowing($filmId, $userId): bool
    {
        $result = $this->db->con->query("SELECT * FROM followed_films WHERE film_id = {$filmId} AND user_id = {$userId}");
        return $result->num_rows > 0;
    }

    public function getFollowedFilms($userId){
        $result = $this->db->con->query("SELECT * FROM filmy f, followed_films ff WHERE ff.user_id = {$userId} AND f.id_film = ff.film_id");
        $resultArray = array();

        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $resultArray[] = $item;
        }

        return $resultArray;
    }

    public function removeFromFollowed($filmId, $userId){
        $this->db->con->query("DELETE FROM followed_films WHERE film_id = {$filmId} AND user_id = {$userId}");
    }

}