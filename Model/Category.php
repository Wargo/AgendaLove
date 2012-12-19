<?php
class Category extends AppModel {

	public $useTable = false;

	/*
	 * Recibe evento y devuelve sus categorías
	 */
	function getCategories($id) {

		$tt_id = ClassRegistry::init('TermRelationship')->find('all', array(
			'conditions' => array(
				'object_id' => $id
			),
			'fields' => array('term_taxonomy_id'),
		));
		$tt_id = Set::extract('/TermRelationship/term_taxonomy_id', $tt_id);

		$t_id = ClassRegistry::init('TermTaxonomy')->find('all', array(
			'conditions' => array(
				'taxonomy' => 'event-categories',
				'term_taxonomy_id' => $tt_id
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

		//return Set::extract('/Term/name', $terms);

		$return = array();
		foreach ($terms as $key=> $value) {
			$return[$key] = $value;
		}

		return $return;

	}

	/*
	 * Recibe categoría y devuelve eventos
	 */
	function getEvents($id) {

		$tt_id = ClassRegistry::init('TermTaxonomy')->find('all', array(
			'conditions' => array(
				'term_id' => $id
			),
			'fields' => array('term_taxonomy_id')
		));
		$tt_id = Set::extract('/TermTaxonomy/term_taxonomy_id', $tt_id);

		$ids = ClassRegistry::init('TermRelationship')->find('all', array(
			'conditions' => array(
				'term_taxonomy_id' => $tt_id,
			),
			'fields' => array('object_id'),
		));

		return Set::extract('/TermRelationship/object_id', $ids);

	}

}
