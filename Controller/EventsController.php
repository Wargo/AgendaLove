<?php
class EventsController extends AppController {

	function get($category = null, $limit = 10) {

		$this->set(compact('limit', 'category'));

		$this->render('/Pages/home');

	}

}
