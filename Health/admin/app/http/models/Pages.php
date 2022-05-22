<?php

/**
* Pages Model
*/
class Pages extends Model
{
	public function getPages()
	{
		$query = $this->database->query( "SELECT id, page_title, predefined, last_modified, date_of_joining FROM `" . DB_PREFIX . "page` WHERE page_name != 'header' AND page_name != 'footer' ORDER BY `date_of_joining` DESC");
		return $query->rows;
	}

	public function getPageforLink($id)
	{
		$query = $this->database->query( "SELECT id, page_name, page_title FROM `" . DB_PREFIX . "page` WHERE id = ? LIMIT 1", array($id));
		return $query->row;
	}

	public function getPage($id)
	{
		$query = $this->database->query( "SELECT * FROM `" . DB_PREFIX . "page` WHERE id = ? AND page_name != 'header' AND page_name != 'footer'", array((int)$id));
		return $query->row;
	}

	public function getGalleries()
	{
		$query = $this->database->query( "SELECT * FROM `" . DB_PREFIX . "gallery`");
		return $query->rows;
	}

	public function checkUrlinDb($data)
	{
		$query = $this->database->query( "SELECT COUNT(id) AS count FROM `" . DB_PREFIX . "page` WHERE page_name = ? ORDER BY id DESC", array($data['url']));
		if ($query->row['count'] > 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getPageThemes()
	{
		$query = $this->database->query( "SELECT * FROM `" . DB_PREFIX . "setting` WHERE name = ?", array('pagetheme'));
		return $query->row['data'];
	}

	public function getMenu()
	{
		$query = $this->database->query( "SELECT * FROM `" . DB_PREFIX . "setting` WHERE id = ? AND name = ?", array(9, 'pageheader'));
		return $query->row;
	}

	public function getFooter()
	{
		$query = $this->database->query( "SELECT * FROM `" . DB_PREFIX . "setting` WHERE id = ? AND name = ?", array(10, 'pagefooter'));
		return $query->row;
	}

	public function updatePage($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "page` SET `page_title` = ?, `page_data` = ?, `meta_tag` = ?, `meta_description` = ?, `last_modified` = ? WHERE `id` = ? " , array($data['title'], $data['content'], $data['meta']['tag'], $data['meta']['description'], $data['datetime'], (int)$data['id']));
	}

	public function updateMenu($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `id` = ? AND `name` = ? " , array($data['page_data'], 9, 'pageheader'));
	}

	public function updateFooter($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `id` = ? AND `name` = ? ", array($data, 10, 'pagefooter'));
	}

	public function updatePageTheme($data)
	{
		$query = $this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ?, `status` = ? WHERE `name` = ? ", array($data, 1, 'pagetheme'));

	}

	public function updatePageUrl($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "page` SET `page_name` = ? WHERE `id` = ?" , array($data['url'], (int)$data['id']));
	}

	public function createPage($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "page` (`page_title`, `page_data`, `meta_tag`, `meta_description`, `predefined`, `last_modified`, `date_of_joining`) VALUES (?, ?, ?, ?, ?, ?, ?) " , array($data['title'], $data['content'], $data['meta']['tag'], $data['meta']['description'], 0, $data['datetime'], $data['datetime']));
		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}

	public function deletePage($id)
	{
		$this->database->query("DELETE FROM `" . DB_PREFIX . "page` WHERE `id` = ? AND `predefined` = ?", array((int)$id, '0'));
	}

	public function getWebSetting()
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "setting` WHERE `name` IN ('customcss', 'generalsetting')");
		return $query->rows;
	}

	public function updateWebSetting($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `name` = ?", array($data['generalsettings'], 'generalsetting'));
		$this->database->query("UPDATE `" . DB_PREFIX . "setting` SET `data` = ? WHERE `name` = ?", array($data['customcss'], 'customcss'));
		$setting = json_decode($data['generalsettings'], true);

		if (isset($setting['comment']['approve']) && !empty($setting['comment']['approve'])) {
			$this->database->alterQuery("ALTER TABLE `" . DB_PREFIX . "comment` MODIFY `status` tinyint DEFAULT 0");
		} else {
			$this->database->alterQuery("ALTER TABLE `" . DB_PREFIX . "comment` MODIFY `status` tinyint DEFAULT 1");
		}

		if (isset($setting['review']['approve']) && !empty($setting['review']['approve'])) {
			$this->database->alterQuery("ALTER TABLE `" . DB_PREFIX . "review` MODIFY `status` tinyint DEFAULT 0");
		} else {
			$this->database->alterQuery("ALTER TABLE `" . DB_PREFIX . "review` MODIFY `status` tinyint DEFAULT 1");
		}
	}
}