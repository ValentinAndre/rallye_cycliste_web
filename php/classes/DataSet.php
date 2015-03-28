<?php
class DataSet {
	private $labels;
	private $values;
	
	public function __construct($keys, $values) {
		$this->keys = $keys; $this->values = $values;
	}
	
	public function __toString() {
		return array_combine($keys, $values);
	}
}

?>