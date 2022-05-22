<?php

/**
 * 
 */
class Filesystem
{
	public function moveUpload($file, $data, $filetype = array('jpg', 'jpeg', 'gif', 'png', 'pdf'))
	{
		$ext = pathinfo($file['name'], PATHINFO_EXTENSION);
		if (!empty($filetype)) {
			if (!in_array($ext, $filetype)) {
				return array("error" => true, "message" => "Supported file type".implode(',', $filetype));
			}
		}

		if ($file['error'] != 0) {
			return array("error" => true, "message" => "No file uploaded.");
		}

		if ($file['size'] > 4999999) {
			return array("error" => true, "message" => "Docuement under 5MB are accepted for upload.");
		}
		$name = $data['file_name'].'.'.$ext;
		$target_file = $data['filedir'].$name;
		if (move_uploaded_file($file['tmp_name'], $target_file)) {
			return array("error" => false, "name" => $name);
		} else {
			return array("error" => false, "message" => "No file uploaded.");
		}
	}
}