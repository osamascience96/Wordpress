<?php

/**
 * Salarytemplate
 */
class Salarytemplate extends Model
{

	public function getSalarytemplates()
	{
		$query = $this->database->query("SELECT `id`, `grade`, `basic_salary`, `gross_salary`, `net_salary`, `date_of_joining` FROM `" . DB_PREFIX . "salarytemplate`");
		return $query->rows;
	}

	public function getSalarytemplate($id)
	{
		$query = $this->database->query("SELECT * FROM `" . DB_PREFIX . "salarytemplate` WHERE id = ?", array($id));
		return $query->row;
	}

	public function updateSalarytemplate($data)
	{
		$this->database->query("UPDATE `" . DB_PREFIX . "salarytemplate` SET `grade` = ?, `basic_salary` = ?, `allowance` = ?, `deduction` = ?, `gross_salary` = ?, `total_deduction` = ?, `net_salary` = ? WHERE `id` = ? ", array($data['grade'], $data['basic_salary'], $data['allowance'], $data['deduction'], $data['gross_salary'], $data['total_deduction'], $data['net_salary'], (int)$data['id']));
		
	}

	public function createSalarytemplate($data)
	{
		$query = $this->database->query("INSERT INTO `" . DB_PREFIX . "salarytemplate` (`grade`, `basic_salary`, `allowance`, `deduction`, `gross_salary`, `total_deduction`, `net_salary`) VALUES (?, ?, ?, ?, ?, ?, ?)", array($data['grade'], $data['basic_salary'], $data['allowance'], $data['deduction'], $data['gross_salary'], $data['total_deduction'], $data['net_salary']));

		if ($query->num_rows > 0) {
			return $this->database->last_id();
		} else {
			return false;
		}
	}


	public function deleteSalarytemplate($id)
	{
		$query = $this->database->query("DELETE FROM `" . DB_PREFIX . "salarytemplate` WHERE `id` = ?", array((int)$id));
		if ($query->num_rows > 0) {
			return true;
		} else {
			return false;
		}
	}
}