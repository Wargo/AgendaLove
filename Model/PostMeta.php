<?php
class PostMeta extends AppModel {

	public $useTable = 'postmeta';

	function getImage($id) {

		$image_id = $this->find('first', array(
			'conditions' => array(
				'post_id' => $id,
				'meta_key' => '_thumbnail_id'
			),
			'fields' => array('meta_value')
		));

		$url = $this->find('first', array(
			'conditions' => array(
				'post_id' => $image_id['PostMeta']['meta_value'],
				'meta_key' => '_wp_attached_file',
			),
			'fields' => array('meta_value')
		));

		return 'http://www.lovevalencia.com/wp-content/uploads/' . $url['PostMeta']['meta_value'];

	}

	function getTime($id) {
		$return = $this->find('first', array(
			'conditions' => array(
				'post_id' => $id,
				'meta_key' => '_wp_attached_file',
			),
			'fields' => array('meta_value')
		));

		debug($return);
	}

}
