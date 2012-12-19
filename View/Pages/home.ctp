<?php

$events = ClassRegistry::init('Event')->getEvents($category, $limit);

$return = array();

foreach ($events as $event) {

	extract($event);

	$image = ClassRegistry::init('PostMeta')->getImage($Event['post_id']);
	$categories = ClassRegistry::init('Category')->getCategories($Event['post_id']);
	$Location = ClassRegistry::init('Location')->getLocation($Event['location_id']);

	if (!$categories) {
		continue;
	}

	$to_return['info_evento'] = array(
		'event_id' => trim($Event['event_id']),
		'post_id' => trim($Event['post_id']),
		'nombre' => trim($Event['event_name']),
		'descripcion' => trim(strip_tags($Event['post_content'])),
		'images' => trim($image),
		'hora_inicio' => trim($Event['event_start_time']),
		'hora_fin' => trim($Event['event_end_time']),
		'fecha_inicio' => trim($Event['event_start_date']),
		'fecha_fin' => trim($Event['event_end_date']),
		'precio' => null,
		'link' => 'http://www.lovevalencia.com/evento/' . trim($Event['event_slug']),
		'categorias' => $categories
	);

	$to_return['info_recinto'] = array(
		'location_id' => trim($Location['location_id']),
		'website' => trim($Location['web']),
		'twitter' => trim($Location['twitter']),
		'facebook' => trim($Location['facebook']),
		'nombre_recinto' => trim($Location['location_name']),
		'coordenadas' => trim($Location['location_latitude'] . ',' . $Location['location_longitude']),
		'email' => trim($Location['email']),
		'direccion' => trim($Location['location_address']),
		'ciudad' => trim($Location['location_town']),
		'telefono' => trim($Location['telefono']),
	);

	$return[substr($Event['event_start_date'], 5, 2)][substr($Event['event_start_date'], 8, 2)][] = $to_return;

}

if ($debug) {

	debug($return);

} else {

	header('Content-type: application/json');
	echo json_encode($return);

}
die;
