<?php

/**
* Review Model
*/
class Review extends Model
{
	public function allReviews()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "review` ORDER BY date_of_joining DESC");
		return $query->rows;
	}

	public function getReview($id)
	{
		$query = $this->database->query("SELECT r.*, s.name AS `review_for` FROM `" . DB_PREFIX . "review` AS r LEFT JOIN `" . DB_PREFIX . "service` AS s ON s.id = r.review_for_id WHERE r.id = '".(int)$id."' LIMIT 1");
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateReview($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "review` SET `content` = ?, `status` = ? WHERE `id` = ?", array($data['content'], (int)$data['status'], (int)$data['id']));
	}

	public function deleteReview($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "review` WHERE `id` = ?", array((int)$id));
	}
}