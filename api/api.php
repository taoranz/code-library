<?php

require_once "../lib/php/helpers.php";

$output = [];

// print_p($_GET);
// print_p($_POST);
// die;

if(!isset($_GET['type']))
	$output = ["error"=>"No Type"];

else {
	switch($_GET['type']){
		case 1:
			$output['result'] =
			makeQuery(
				makeConn(),
				"SELECT *
				FROM `products`
				ORDER BY `date_create` DESC
				LIMIT 12
				"
			);
			break;

		case 2:
			if(!isset($_POST['id']))
				$output['error']="No ID";
			else $output['result'] =
			makeQuery(
				makeConn(),
				"SELECT *
				FROM `products`
				WHERE id = ".$_POST['id']
			);
			break;

		case 3:
			if(!isset($_POST['category']))
				$output['error']="No Collection";
			else $output['result'] =
			makeQuery(
				makeConn(),
				"SELECT *
				FROM `products`
				WHERE `collection` = '{$_POST['collection']}'
				ORDER BY `date_create` DESC
				LIMIT 12
				"
			);
			break;

		case 10:
			if(!isset($_POST['search']))
				$output['error']="No Search";
			else $output['result'] =
			makeQuery(
				makeConn(),
				"SELECT *
				FROM `products`
				WHERE
				`name` LIKE '%{$_POST['search']}%' OR
				`description` LIKE '%{$_POST['search']}%' OR
				`collection` LIKE '%{$_POST['search']}%'
				ORDER BY `date_create` DESC
				LIMIT 12
				"
			);
			break;

		case 20:
			if(!isset($_POST['sort'])||!isset($_POST['dir']))
				$output['error']="Incomplete Data";
			else $output['result'] =
			makeQuery(
				makeConn(),
				"SELECT *
				FROM `products`
				ORDER BY `{$_POST['sort']}` {$_POST['dir']}
				LIMIT 12
				"
			);
			break;
		case 343452: break;
	}
}

echo json_encode(
	$output,
	JSON_UNESCAPED_UNICODE |
	JSON_NUMERIC_CHECK
);
