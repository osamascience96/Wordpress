<?php

/**
* Form Submit Class
*/
class Forms extends Model
{
	public function createComment($data, $ip) 
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "comment` (`author`, `email`, `content`, `blog_id`, `author_ip`) VALUES (?, ?, ?, ?, ?) ",  array($this->database->escape($data['name']), $this->database->escape($data['email']), $data['content'], (int)$data['blog_id'], $ip));
	}

	public function createReview($data, $ip) 
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "review` (`review_for`, `review_for_id`, `name`, `email`, `content`, `reviewer_ip`) VALUES (?, ?, ?, ?, ?, ?) ",  array(1, (int)$data['review_for_id'], $this->database->escape($data['name']), $this->database->escape($data['email']), $data['content'], $ip));
	}
}