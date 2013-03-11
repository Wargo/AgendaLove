<?php

$events = ClassRegistry::init('Event')->getEvents($category, $limit);

$return = array();

$current_day = date('d');
$current_month = date('m');

foreach ($events as $event) {

	extract($event);

	$image = ClassRegistry::init('PostMeta')->getImage($Event['post_id']);
	$categories = ClassRegistry::init('Category')->getCategories($Event['post_id']);
	$Location = ClassRegistry::init('Location')->getLocation($Event['location_id']);

	if (!$categories) {
		continue;
	}
	if (!in_array('Eventos destacados', $categories)) {
		continue;
	}

	$to_return['info_evento'] = array(
		'event_id' => trim($Event['event_id']),
		'post_id' => trim($Event['post_id']),
		'nombre' => trim($Event['event_name']),
		'descripcion' => trim(nl2br($Event['post_content'])),
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
		'app_location_id' => trim($Location['id-app']),
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

	$day = substr($Event['event_start_date'], 8, 2);
	$month = substr($Event['event_start_date'], 5, 2);

/*
	while ((int)$day != (int)$current_day) {
		if (empty($return[zerofill((int)$current_month)][zerofill((int)$current_day)])) {
			//debug(count($return[zerofill((int)$current_month)][zerofill((int)$current_day)]));
			$return[zerofill((int)$current_month)][zerofill((int)$current_day)][] = array('ko' => compact('day', 'current_day', 'current_month'));
		}
		$current_day ++;
		$aux_month = date('m', mktime(0, 0, 0, $current_month, $current_day, date('y')));
		$aux_day = date('d', mktime(0, 0, 0, $current_month, $current_day, date('y')));
		$current_month = $aux_month;
		$current_day = $aux_day;
	}

	if ((int)$day == (int)$current_day) {
		$current_day ++;
	}

*/

	$return[$month][$day][] = $to_return;

	$duration = (strtotime($Event['event_end_date']) / 86400 - strtotime($Event['event_start_date']) / 86400);

	for ($i = 0; $i < $duration; $i ++) {
		$aux_month = date('m', mktime(0, 0, 0, substr($Event['event_start_date'], 5, 2), substr($Event['event_start_date'], 8, 2) + $i + 1, substr($Event['event_start_date'], 0, 4)));
		$aux_day = date('d', mktime(0, 0, 0, substr($Event['event_start_date'], 5, 2), substr($Event['event_start_date'], 8, 2) + $i + 1, substr($Event['event_start_date'], 0, 4)));
		$return[$aux_month][$aux_day][] = $to_return;
	}

}

if ($debug) {

	debug($return);

} else {

	header('Content-type: application/json');
	echo json_encode($return);

}

function zerofill($number) {

	if ($number < 10) {
		return '0' . $number;
	} else {
		return $number;
	}

}
die;
