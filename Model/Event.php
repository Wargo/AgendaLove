<?php
class Event extends AppModel {

	public $useTable = 'em_events';

	/*
	 * Recibe categoría y límite y devuelve eventos
	 */
	function getEvents($category, $limit) {

		$conditions = array(
			//'event_start_date >=' => date('Y-m-d'),
			'event_start_date >=' => date('Y-m-d H:i:s', strtotime("-10 days")),
			'event_end_date >=' => date('Y-m-d'),
			'event_status' => 1
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

	/*
	 * Recibe el día y devuelve eventos de ese día
	 */
	function getEvents2($day, $category) {

		$conditions = array(
			//'event_start_date >=' => date('Y-m-d'),
			'event_start_date <=' => date('Y-m-d', strtotime("+$day days")),
			'event_end_date >=' => date('Y-m-d', strtotime("+$day days")),
			'event_status' => 1
		);

		if ($category) {
			$ids = ClassRegistry::init('Category')->getEvents($category);
			$conditions['post_id'] = $ids;
		}

		$events = $this->find('all', array(
			'conditions' => $conditions,
			//'order' => array('event_start_time' => 'asc'),
			'order' => array('event_end_date' => 'asc'),
		));

		return $events;

	}


}
