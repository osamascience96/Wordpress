<?php

/**
 * FormvalidationController
 */
class FormvalidationController extends Controller
{
	private $field_data;

	public function setRules($rules)
	{
		if (is_array($rules) && !empty($rules)) {
			foreach ($rules as $key => $value) {
				$this->field_data[$value['field']]['field'] = $value['field'];
				$this->field_data[$value['field']]['label'] = $value['label'];
				$this->field_data[$value['field']]['rules'] = preg_split('/\|(?![^\[]*\])/', $value['rules']);
				$this->field_data[$value['field']]['data'] = NULL;
				$this->field_data[$value['field']]['error'] = NULL;
			}
		}
	}

	public function run($data)
	{
		foreach ($this->field_data as $field => &$row)
		{
			$this->field_data[$field]['data'] = $data[$field];
		}
	}



}