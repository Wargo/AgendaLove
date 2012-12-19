<?php

$events = ClassRegistry::init('Event')->getEvents($category, $limit);

$return = array();

foreach ($events as $event) {

	extract($event);

	$image = ClassRegistry::init('PostMeta')->getImage($Event['post_id']);
	$categories = ClassRegistry::init('Category')->getCategories($Event['post_id']);
	extract(ClassRegistry::init('Location')->getLocation($Event['location_id']));

	$to_return['info_evento'] = array(
		'event_id' => $Event['event_id'],
		'post_id' => $Event['post_id'],
		'nombre' => $Event['event_name'],
		'descripcion' => strip_tags($Event['post_content']),
		'images' => $image,
		'hora_inicio' => $Event['event_start_time'],
		'hora_fin' => $Event['event_end_time'],
		'fecha_inicio' => $Event['event_start_date'],
		'fecha_fin' => $Event['event_end_date'],
		'precio' => null,
		'categorias' => $categories
	);

	$to_return['info_recinto'] = array(
		'website' => null,
		'twitter' => null,
		'facebook' => null,
		'nombre_recinto' => $Location['location_name'],
		'coordenadas' => $Location['location_latitude'] . ',' . $Location['location_longitude'],
		'email' => null,
		'direccion' => $Location['location_address'],
		'ciudad' => $Location['location_town'],
		'telefono' => null
	);

	$return[substr($Event['event_start_date'], 5, 2)][substr($Event['event_start_date'], 8, 2)][] = $to_return;

}

header('Content-type: application/json');
echo json_encode($return);
die;
