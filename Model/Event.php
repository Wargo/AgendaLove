<?php
class Event extends AppModel {

	public $useTable = 'em_events';

	/*
	 * Recibe categoría y límite y devuelve eventos
	 */
	function getEvents($category, $limit) {

		$conditions = array(
			'event_start_date >=' => date('Y-m-d')
		);

		if ($category) {
			$ids = ClassRegistry::init('Category')->getEvents($category);
			$conditions['post_id'] = $ids;
		}

		$events = $this->find('all', array(
			'conditions' => $conditions,
			'limit' => $limit,
			'order' => array('event_start_date' => 'asc', 'event_start_time' => 'asc')
		));

		return $events;

	}


}
