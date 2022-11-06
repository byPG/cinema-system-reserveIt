<?php

class Review
{
    public $db = null;

    public function __construct(DBController $db)
    {
        if (!isset($db->con)) return null;
        $this->db = $db;
    }

    public function isReviewAdded($filmId, $userId): bool
    {
        $result = $this->db->con->query("SELECT * FROM review WHERE user_id = {$userId} AND film_id = {$filmId}");
        return $result->num_rows > 0;
    }

    public function getLikesCount($reviewId)
    {
        $result = $this->db->con->query("SELECT COUNT(*) as likes FROM likes_reviews WHERE id_review = {$reviewId}");
        return mysqli_fetch_assoc($result);
    }

    public function isLiked($reviewId, $userId): bool
    {
        $result = $this->db->con->query("SELECT * FROM likes_reviews WHERE id_review = {$reviewId} AND id_user = {$userId}");
        return $result->num_rows > 0;
    }

    public function likeReview($reviewId, $userId){
        $this->db->con->query("DELETE FROM dislikes_reviews WHERE id_review = {$reviewId} AND id_user = {$userId}");
        $this->db->con->query("INSERT INTO likes_reviews VALUES ({$reviewId}, {$userId})");
    }

    public function unlikeReview($reviewId, $userId){
        $this->db->con->query("DELETE FROM likes_reviews WHERE id_review = {$reviewId} AND id_user = {$userId}");
    }

    public function getDislikesCount($reviewId)
    {
        $result = $this->db->con->query("SELECT COUNT(*) as likes FROM dislikes_reviews WHERE id_review = {$reviewId}");
        return mysqli_fetch_assoc($result);
    }

    public function isDisliked($reviewId, $userId): bool
    {
        $result = $this->db->con->query("SELECT * FROM dislikes_reviews WHERE id_review = {$reviewId} AND id_user = {$userId}");
        return $result->num_rows > 0;
    }

    public function dislikeReview($reviewId, $userId){
        $this->db->con->query("DELETE FROM likes_reviews WHERE id_review = {$reviewId} AND id_user = {$userId}");
        $this->db->con->query("INSERT INTO dislikes_reviews VALUES ({$reviewId}, {$userId})");
    }

    public function removeDislikeReview($reviewId, $userId){
        $this->db->con->query("DELETE FROM dislikes_reviews WHERE id_review = {$reviewId} AND id_user = {$userId}");
    }
}