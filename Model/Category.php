<?php
class Category extends AppModel {

	public $useTable = false;

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

		$terms = ClassRegistry::init('Term')->find('all', array(
			'conditions' => array(
				'term_id' => $t_id
			)
		));

		return Set::extract('/Term/name', $terms);

	}

}
