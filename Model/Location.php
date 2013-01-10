<?php
class Location extends AppModel {

	public $useTable = 'em_locations';

	function getLocation($id) {

		$location = $this->find('first', array(
			'conditions' => array(
				'location_id' => $id
			)
		));

		if (!$location) {
			return false;
		}

		extract($location);

		$metas = ClassRegistry::init('PostMeta')->find('all', array(
			'conditions' => array(
				'post_id' => $Location['post_id'],
				'meta_key' => array(
					'Telefono', 'Web', 'Twitter', 'Facebook', 'Email'
				)
			)
		));

		$Location['facebook'] = null;
		$Location['twitter'] = null;
		$Location['web'] = null;
		$Location['email'] = null;
		$Location['telefono'] = null;

		foreach ($metas as $meta) {
			extract($meta);
			$Location[strtolower($PostMeta['meta_key'])] = $PostMeta['meta_value'];
		}

		return $Location;

	}


}
