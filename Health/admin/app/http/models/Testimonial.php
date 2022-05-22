<?php

/**
* Testimonial Model
*/
class Testimonial extends Model
{
	public function allTestimonials()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "testimonial` ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getTestimonial($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "testimonial` WHERE `id` = ? LIMIT 1", array($this->database->escape($id)) );
		if ($query->num_rows > 0) {
			return $query->row;
		} else {
			return false;
		}
	}

	public function updateTestimonial($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "testimonial` SET `name` = ?, `email` = ?, `mobile` = ?, `testimonial` = ?, `picture` = ?, `status` = ? WHERE `id` = ?", array($this->database->escape($data['name']), $this->database->escape($data['email']), $this->database->escape($data['mobile']), $data['testimonial'], $this->database->escape($data['picture']), (int)$data['status'], (int)$data['id']));
		return true;
	}

	public function createTestimonial($data)
	{
		$query = $this->database->query( "INSERT INTO `" . DB_PREFIX . "testimonial` (`name`, `email`, `mobile`, `testimonial`, `picture`, `status`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?)", array($this->database->escape($data['name']), $this->database->escape($data['email']), $this->database->escape($data['mobile']), $data['testimonial'], $this->database->escape($data['picture']), (int)$data['status'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deleteTestimonial($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "testimonial` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}