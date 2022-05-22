<?php

/**
* Pages Model
*/
class Pages extends Model
{
	public function pageData($page_name)
	{
		$query = $this->database->query("SELECT page_data, page_title, meta_tag, meta_description FROM `" . DB_PREFIX . "page` WHERE `page_name` = ? LIMIT 1 ", array($this->database->escape($page_name)));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function doctors()
	{
		$query = $this->database->query("SELECT CONCAT(firstname, ' ', lastname) AS name, `picture`, `about`, `social`, `priority` FROM `" . DB_PREFIX . "doctors` WHERE `web_status` = ? ORDER BY `priority` ASC LIMIT 3", array(1));
		return $query->rows;
	}

	public function testimonials() 
	{
		$query = $this->database->query("SELECT `name`, `picture`, `testimonial` FROM `" . DB_PREFIX . "testimonial` WHERE `status` = ? ", array(1));
		return $query->rows;
	}

	public function blogs() 
	{
		$query = $this->database->query("SELECT `id`, `title`, `blog_url`, `picture`, `short_post`, `author`, `date_of_joining` AS `date` FROM `" . DB_PREFIX . "blog` WHERE `status` = ? ORDER BY `date_of_joining` DESC " , array(1));
		return $query->rows;
	}

	public function recentBlog() 
	{
		$query = $this->database->query("SELECT `id`, `title`, `blog_url`, `picture`, `date_of_joining` FROM `" . DB_PREFIX . "blog` WHERE `status` = ? ORDER BY `date_of_joining` DESC LIMIT 5", array(1));
		return $query->rows;
	}

	public function getSliderDoctors()
	{
		$query = $this->database->query("SELECT `id`, CONCAT(firstname, ' ', lastname) AS name, `picture`, `about` FROM `" . DB_PREFIX . "doctors` WHERE `web_status` = ? ORDER BY `priority` ASC LIMIT 6", array(1));
		return $query->rows;
	}

	public function getSliderServices()
	{
		$query = $this->database->query("SELECT `id`, `name`, `picture`, `service_url` FROM `" . DB_PREFIX . "service` WHERE `status` = ? ORDER BY `priority` ASC LIMIT 6", array(1));
		return $query->rows;
	}

	public function getGalleries()
	{
		$query = $this->database->query("SELECT media FROM `" . DB_PREFIX . "gallery`");
		return $query->rows;
	}

	public function trendingBlog()
	{
		$query = $this->database->query("SELECT `id`, `title`, `blog_url`, `picture`, `hits`, `date_of_joining` FROM `" . DB_PREFIX . "blog` WHERE `status` = ? ORDER BY `hits` DESC LIMIT 5", array(1));
		return $query->rows;
	}

	public function allDoctors() 
	{
		$query = $this->database->query("SELECT `id`, CONCAT(firstname, ' ', lastname) AS name, picture, about, social FROM `" . DB_PREFIX . "doctors` WHERE `web_status` = ?", array(1));
		return $query->rows;
	}

	public function allDepartments()
	{ 
		$query = $this->database->query("SELECT name, icon, description FROM `" . DB_PREFIX . "departments` WHERE status = ?", array(1));
		return $query->rows;
	}


	public function homeServices()
	{
		$query = $this->database->query("SELECT `name`, `icon`, `priority`, `short_post`, `service_url` FROM `" . DB_PREFIX . "service` ORDER BY `priority` ASC LIMIT 6");
		return $query->rows;
	}

	public function allFacilities()
	{
		$query = $this->database->query("SELECT `name`, `icon`, `description` FROM `" . DB_PREFIX . "facility` WHERE `status` = ?", array(1));
		return $query->rows;
	}

	public function homeBlogs($limit)
	{
		$query = $this->database->query("SELECT `id`, `title`, `blog_url`, `short_post`, `picture`, `author`, `date_of_joining` AS `date` FROM `" . DB_PREFIX . "blog` ORDER BY `date_of_joining` DESC LIMIT ".$limit." ");
		return $query->rows;
	}

	public function allServices()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "service` WHERE status = ?", array(1) );
		return $query->rows;
	}

	public function getSingleService($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "service` WHERE `service_url` = ? LIMIT 1", array($id));
		return $query->row;
	}

	public function getSingleBlog($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "blog` WHERE `blog_url` = ? LIMIT 1", array($this->database->escape($id)));
		if ($query->num_rows > 0) {
			$result = $query->row;
			$this->database->query("UPDATE `" . DB_PREFIX . "blog` SET `hits` = `hits` + 1 WHERE `id` = ?", array($result['id']));
			return $result;
		} else {
			return false;
		}
	}

	public function getComments($id)
	{
		$query = $this->database->query("SELECT `author`, `content`, `date_of_joining` FROM `" . DB_PREFIX . "comment` WHERE `blog_id` = ? AND `status` = ? ORDER BY date_of_joining DESC", array((int)$id, 1));
		if ($query->num_rows > 0) {
			return $query->rows;
		} else {
			return false;
		}
	}

	public function getCategories()
	{
		$query = $this->database->query("SELECT c.id, c.name, c.slug, c.icon, count(bc.category_id) as count FROM `" . DB_PREFIX . "category` AS c LEFT JOIN `" . DB_PREFIX . "blog_to_category` AS bc ON c.id = bc.category_id GROUP BY c.id");
		if ($query->num_rows > 0) {
			return $query->rows;
		} else {
			return false;
		}
	}

	public function allCategoryWithChild($id)
	{
		$query = $this->database->query("SELECT c1.id FROM `" . DB_PREFIX . "category` AS c LEFT JOIN `" . DB_PREFIX . "category` AS c1 ON c.id = c1.parent WHERE c.id = ? OR c.parent = ?", array((int)$id, (int)$id));
		if ($query->num_rows > 0) {
			return $query->rows;
		} else {
			return false;
		}
	}

	public function getBlogByCategory($list)
	{
		$query = $this->database->query("SELECT `blog_id` FROM `" . DB_PREFIX . "blog_to_category` WHERE `category_id` IN (".implode(',', $list).")");
		$blog_ids = array_unique(array_map(function($current){
			return $current['blog_id'];
		}, $query->rows));

		if ($query->num_rows > 0) {
			 $blog_query = $this->database->query("SELECT `id`, `title`, `blog_url`, `short_post`, `picture`, `author`, `date_of_joining` AS `date` FROM `" . DB_PREFIX . "blog` WHERE `id` IN (".implode(',', $blog_ids).")");
			 return $blog_query->rows;
		} else {
			return false;
		}

	}

	public function getCategory($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "category` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function allServiceReviews($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "review` WHERE `review_for` = ? AND `review_for_id` = ? AND `status` = ? ORDER BY date_of_joining DESC", array(1, (int)$id, 1));
		if ($query->num_rows > 0) {
			return $query->rows;
		} else {
			return false;
		}
	}
}