<?php
class EventsController extends AppController {

	function get($category = null, $limit = 0, $debug = false) {

		$this->set(compact('limit', 'category', 'debug'));

		$this->render('/Pages/home');

	}

}
