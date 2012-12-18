<?php
class Location extends AppModel {

	public $useTable = 'em_locations';

	function getLocation($id) {

		return $this->find('first', array(
			'conditions' => array(
				'location_id' => $id
			)
		));

	}


}
