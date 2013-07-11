<?php
class EventsController extends AppController {

	function get($category = null, $limit = 0, $debug = false) {

		$this->set(compact('limit', 'category', 'debug'));

		$this->render('/Pages/home');

	}

	function gett($day = 0, $category = null, $debug = false) {

		$this->layout = false;

		$this->set(compact('day', 'category', 'debug'));

		$this->render('get');

	}

}
