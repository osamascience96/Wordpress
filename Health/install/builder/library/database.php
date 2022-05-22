<?php

/**
* Database
*/
class Database
{
	private $obj;
	private $result = null;
	public $current_field = '';
	public $length = '';
	public $num_rows = '';

	public function connect($host, $username, $password, $database, $port = NULL)
	{
		$this->obj = new mysqli($host, $username, $password, $database);
		if ($this->obj->connect_error) {
			'Error: ' .$this->obj->error. '<br />Error No: ' . $this->obj->errno;
		}
		$this->obj->set_charset("utf8");
		$this->obj->query("SET SQL_MODE = ''");
	}

	public function checkDb($host, $username, $password, $database, $port = NULL)
	{
		$this->obj = @new mysqli($host, $username, $password, $database, $port);
		if($this->obj->connect_errno) {
			return $this->obj->connect_error;
		} else {
			if ($this->obj->select_db($database) === false) {
				return $this->obj->connect_error;
			} else {
				$this->obj->set_charset("utf8");
				$this->obj->query("SET SQL_MODE = ''");
				return true;
			}
		}
	}

	public function changeDB($database)
	{
		$this->obj->select_db($database);
	}

	public function refValues($arr)
	{
		if (strnatcmp(phpversion(), "5.4") >= 0) {
			$refs= array();

			foreach ($arr as $key => $value) {
				$refs[$key] = &$arr[$key];
			}
			return $refs;
		}
		return $arr;
	}

	public function query($query, $args = null) 
	{
		if (is_null($args)) {
			$query = $this->obj->query($query);
			$result = new \stdClass();
			
			$result->num_rows = $query->num_rows;

			while ($row = $query->fetch_assoc()) {
				$query_result[] = $row;
			}
			$result->row = isset($query_result[0]) ? $query_result[0] : array();
			$result->rows = isset($query_result) ? $query_result : array();
			return $result;
		} else {
			if ($stmt = $this->obj->prepare($query)) {
				$datatypes = '';
				foreach ($args as $value) {
					if (is_int($value)) {
						$datatypes .= 'i';
					} elseif (is_double($value)) {
						$datatypes .= 'd';
					} elseif (is_string($value)) {
						$datatypes .= 's';
					} else {
						$datatypes .= 'b';
					}
				}
				
				array_unshift($args, $datatypes);

				if(call_user_func_array(array($stmt, 'bind_param'), $this->refValues($args))) {

					$stmt->execute();
					$stmt->store_result();

					$result = new \stdClass();
					if ($stmt->num_rows > 0) {
						$meta = $stmt->result_metadata();

						while ($field = $meta->fetch_field()) {
							$var = $field->name; 
							$$var = null; 
							$fields[$var] = &$$var;

						}
						
						call_user_func_array(array($stmt,'bind_result'),$fields);
						$i = 0;
						$query_result = array();
						while ($stmt->fetch()) {
							foreach($fields as $key => $value) {
								$query_result[$i][$key] = $value;
							}
							$i++;
						}
						$result->num_rows = $stmt->num_rows;
						$result->row = isset($query_result[0]) ? $query_result[0] : array();
						$result->rows = $query_result;
						$meta->close();
					} else {
						$result->row = [];
						$result->rows = [];
						$result->num_rows = $stmt->affected_rows;
					}
					$this->error = $stmt->error;
					$stmt->free_result();
					$stmt->close();
					return $result;
				} else {
					return false;
				}
			} else {
				return false;
			}
		}
	}

	public function createDBTable($query)
	{
		$this->obj->query($query);
	}

	public function alterQuery($query, $args = null)
	{
		$query = $this->obj->query($query);
		$result = new \stdClass();
		return $result;
	}

	public function escape($value)
	{
		return $this->obj->real_escape_string($value);
	}

	public function error()
	{
		return $this->obj->error;
	}

	public function last_id()
	{
		return $this->obj->insert_id;
	}

	public function error_no()
	{
		return $this->obj->errno();
	}
}