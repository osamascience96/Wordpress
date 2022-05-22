<?php

/**
* Blog Model
*/
class Blog extends Model
{
	public function allBlogs()
	{
		$query = $this->database->query("SELECT b.id, b.title, b.author, b.date_of_joining, CONCAT( u.firstname, ' ' ,u.lastname ) As name, u.user_id As user_id FROM `" . DB_PREFIX . "blog` AS b LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = b.user_id ORDER BY date_of_joining DESC");
		return $query->rows;
	}

	public function allCategory()
	{
		$query = $this->database->query("SELECT `id`, `name`, `parent`, ('') as `status` FROM `" . DB_PREFIX . "category` ORDER BY `id`");
		return $query->rows;

	}

	public function allCategoryWithCheck($id)
	{
		$query = $this->database->query("SELECT c.id, c.name, c.parent, IF ( bc.blog_id = ? , 'checked', '' ) as status FROM `" . DB_PREFIX . "category` AS c LEFT JOIN `" . DB_PREFIX . "blog_to_category` AS bc ON (c.id = bc.category_id AND bc.blog_id = ?) ORDER BY c.id", array((int)$id, (int)$id));
		return $query->rows;
	}

	public function getBlog($id)
	{
		$query = $this->database->query("SELECT b.id, b.title, b.short_post, b.long_post, b.picture, b.author, b.status, b.date_of_joining, CONCAT( u.firstname, ' ' ,u.lastname ) As name, u.user_id As user_id FROM `" . DB_PREFIX . "blog` AS b LEFT JOIN `" . DB_PREFIX . "users` AS u ON u.user_id = b.user_id WHERE b.id = ? LIMIT 1", array((int)$id));
		
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function getComments($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "comment` WHERE blog_id = ?", array((int)$id));
		return $query->rows;
	}

	public function getBlogCategories($id)
	{
		$query = $this->database->query("SELECT `category_id` FROM `" . DB_PREFIX . "blog_to_category` WHERE `blog_id` = ?", array($this->database->escape($id)));

		if ($query->num_rows > 0) {
			foreach ($query->rows as $value) {
				$blog_category[] = $value['category_id'];
			}
			return $blog_category;
		} else {
			return array();
		}
	}

	public function checkUrlinDb($data)
	{
		$query = $this->database->query( "SELECT COUNT(id) AS count FROM `" . DB_PREFIX . "blog` WHERE blog_url = ? ORDER BY id DESC", array($data['url']));
		if ($query->row['count'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updateBlogUrl($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "blog` SET `blog_url` = ? WHERE `id` = ?" , array($data['url'], (int)$data['id']));
	}

	public function updateBlog($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "blog` SET `title` = ?, `short_post` = ?,  `long_post` = ?, `picture` = ?, `author` = ?, `status` = ? WHERE `id` = ?", array($this->database->escape($data['title']), $data['short_post'], $data['long_post'], $this->database->escape($data['picture']), $this->database->escape($data['author']), (int)$data['status'], (int)$data['id']));

		$this->database->query("DELETE FROM `" . DB_PREFIX . "blog_to_category` WHERE `blog_id` = ?", array((int)$data['id']));

		if (isset($data['category']) && !empty($data['category'])) {
			foreach ($data['category'] as $category_id) {
				$this->database->query("INSERT INTO " . DB_PREFIX . "blog_to_category (`blog_id`, `category_id`) VALUES (?, ?)", array((int)$data['id'], (int)$category_id ));
			}
		}
		return true;
	}

	public function createBlog($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "blog` (`title`, `short_post`, `long_post`, `picture`, `user_id`, `author`, `status`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['title']), $data['short_post'], $data['long_post'], $this->database->escape($data['picture']), $this->database->escape($data['user_id']), $this->database->escape($data['author']), (int)$data['status'], $data['datetime']));

		if ($query->num_rows > 0) {
			$id = $this->database->last_id();
			if (isset($data['category']) && !empty($data['category'])) {
				foreach ($data['category'] as $category_id) {
					$this->database->query("INSERT INTO " . DB_PREFIX . "blog_to_category (`blog_id`, `category_id`) VALUES (?, ?)", array((int)$id, (int)$category_id ));
				}
			}
			return $id;
		} else {
			return false;
		}
	}

	public function deleteBlog($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "blog_to_category` WHERE `blog_id` = ?", array((int)$id));
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "blog` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}