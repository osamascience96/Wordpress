<?php

/**
* Comment Model
*/
class Comment extends Model
{
	public function allComments()
	{
		$query = $this->database->query("SELECT c.id, c.author, c.email, c.content, c.author_ip, c.status, c.date_of_joining, b.title FROM `" . DB_PREFIX . "comment` AS c LEFT JOIN `" . DB_PREFIX . "blog` AS b ON b.id = c.blog_id ORDER BY date_of_joining DESC");
		return $query->rows;
	}

	public function getComment($id)
	{
		$query = $this->database->query("SELECT c.*, b.title FROM `" . DB_PREFIX . "comment` AS c LEFT JOIN `" . DB_PREFIX . "blog` AS b ON b.id = c.blog_id WHERE c.id = ?", array((int)$id));
		return $query->row;
	}

	public function updateComment($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "comment` SET `content` = ?, `status` = ? WHERE `id` = ?", array($data['content'], (int)$data['status'], (int)$data['id']));
	}

	public function deleteComment($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "comment` WHERE `id` = ?", array((int)$id));
	}
}