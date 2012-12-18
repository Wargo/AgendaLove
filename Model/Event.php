<?php
class Event extends AppModel {

	public $useTable = 'em_events';

	function getEvents() {

		$events = $this->find('all', array(
			'conditions' => array(
				'event_start_date >=' => date('Y-m-d')
			),
			'limit' => 10,
			'order' => array('event_start_date' => 'asc', 'event_start_time' => 'asc')
		));

		return $events;

	}


}
