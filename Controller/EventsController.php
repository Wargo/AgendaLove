<?php
class EventsController extends AppController {

	function get($debug = false, $day = 0, $category = null, $location_id = null) {
		extract($this->request->data);
		$this->set(compact('day', 'category', 'debug', 'location_id'));
	}

	function get2($category = null, $limit = 0, $debug = false) {

		$this->set(compact('limit', 'category', 'debug'));

		$this->render('/Pages/home');

	}

	function cat($category = null, $limit = 0, $debug = false) {

		$t_id = ClassRegistry::init('TermTaxonomy')->find('all', array(
			'conditions' => array(
				'taxonomy' => 'event-categories',
			),
			'fields' => array('term_id'),
		));
		$t_id = Set::extract('/TermTaxonomy/term_id', $t_id);
		$terms = ClassRegistry::init('Term')->find('list', array(
			'conditions' => array(
				'term_id' => $t_id
			),
			'fields' => array('term_id', 'name')
		));
		echo json_encode($terms);
		die;

	}

	function gett($day = 0, $category = null, $debug = false) {

		$this->layout = false;

		$this->set(compact('day', 'category', 'debug'));

		$this->render('get');

	}

}
