<?php
/**
* Model class
*/
abstract class Model {
	protected $repository;

	public function __construct($repository) {
		$this->repository = $repository;
	}

	public function __get($key) {
		return $this->repository->get($key);
	}

	public function __set($key, $value) {
		$this->repository->set($key, $value);
	}
}