<?php

function query($pdo, $sql, $params=[]) {
	$query = $pdo->prepare($sql);

	// foreach ($query as $key => $value) {
	// 	$query->bindValue($name, $value);
	// }

	$query->execute($params);

	return $query;
}

function getJoke($pdo, $id) {
	$params = [':id' => $id];

	$query = query($pdo, 'SELECT * FROM `joke` WHERE `id` = :id', $params);

	return $query->fetch();
}

function allJokes($pdo) {
	$query = query($pdo, 'SELECT `joke`.`id`, `text`, `timestamp`, `name`, `email` FROM `joke` INNER JOIN `author` ON `author_id` = `author`.`id`');

	return $query->fetchAll();
}

function totalJokes($pdo) {
	$query = query($pdo, 'SELECT COUNT(*) FROM `joke`');

	$row = $query->fetch();

	return $row[0];
}

function insertJoke($pdo, $fields) {
	$sql = 'INSERT INTO `joke` (';
	// SET `text` = :text, `author_id` = :author_id';
	foreach ($fields as $key => $value) {
		$sql .= "`$key`,";
	}

	$sql = rtrim($sql, ',');

	$sql .= ') VALUES (';

	foreach ($fields as $key => $value) {
		$sql .= ":$key,";
	}

	// automatic date formatting if date object is supllied
	// not needed here since mysql server creates timestamps automatically
	// foreach ($fields as $key => $value) {
	// 	if ($value instanceof DataTime) {
	// 		$fields[$key] = $value->format('Y-m-d');
	// 	}
	// }

	$sql = rtrim($sql, ',');

	$sql .= ')';

	query($pdo, $sql, $fields);
}

function updateJoke($pdo, $fields) {
	$sql = 'UPDATE `joke` SET ';

	foreach ($fields as $key => $value) {
		$sql .= "`$key` = :$key,";
	}

	$sql = rtrim($sql, ',');

	$sql .= ' WHERE `id` = :primaryKey';

	$fields['primaryKey'] = $fields['id'];

	query($pdo, $sql, $fields);
}

function deleteJoke($pdo, $id) {
	$params = [':id' => $id];

	$query = query($pdo, 'DELETE FROM `joke` WHERE `id` = :id', $params);
}
