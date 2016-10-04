<?php


if ($_SERVER['REQUEST_URI']='/' && !isset($_SERVER['QUERY_STRING'])) {
	header('HTTP/1.1 200 OK');
	header('Content-Type: application/hal+json');

	echo json_encode(returnHalArray(getMovieEntries()));
}

elseif ($_SERVER['QUERY_STRING']) {
	if (isset($_GET["title"])) {
		foreach (listAllMoviesAsArray() as $key => $value) {
			if ($value["Title"] == $_GET["title"]){
				echo json_encode(returnHalArray($value));

			}
		}
	}
}

function listAllMoviesAsArray() {
	$movies = file_get_contents("data/movies.json");
	return json_decode($movies,true);
}

function returnHalArray($movieEntries) {
	$hal = array();
	$hal['_links'] = array(
			'self' => array(
				"href"=> "/"
			), 
			'next' => array(
				"href"=> "/"//TODO
			), 
			'find' => array(
				"href"=> "/"//TODO
			), 
		);
	$hal['_embedded'] = array(
		'movies' => $movieEntries
	);
	return $hal;
}

function getMovieEntries() {
	$movieEntriesArray = array();
	foreach (listAllMoviesAsArray() as $key => $value) {
		array_push($movieEntriesArray,$value);
	}
	return $movieEntriesArray;
}

?>