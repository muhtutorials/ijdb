<?php

function query($pdo, $sql, $params=[]) {
	$query = $pdo->prepare($sql);

	// foreach ($query as $key => $value) {
	// 	$query->bindValue($name, $value);
	// }

	$query->execute($params);

	return $query;
}

function findById($pdo, $table, $primaryKey, $value) {
	$params = [":$primaryKey" => $value];

	$query = query($pdo, "SELECT * FROM `$table` WHERE `$primaryKey` = :$primaryKey", $params);

	return $query->fetch();
}

function findAll($pdo, $table) {
	$query = query($pdo, "SELECT * FROM `$table`");

	return $query->fetchAll();
}

function total($pdo, $table) {
	$query = query($pdo, "SELECT COUNT(*) FROM `$table`");

	$row = $query->fetch();

	return $row[0];
}

function insert($pdo, $table, $fields) {
	$sql = "INSERT INTO `$table` (";
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

function update($pdo, $table, $primaryKey, $fields) {
	$sql = "UPDATE `$table` SET ";

	foreach ($fields as $key => $value) {
		$sql .= "`$key` = :$key,";
	}

	$sql = rtrim($sql, ',');

	$sql .= " WHERE `$primaryKey` = :primaryKey";

	$fields['primaryKey'] = $fields['id'];

	query($pdo, $sql, $fields);
}

function delete($pdo, $table, $primaryKey, $id) {
	$params = [':id' => $id];

	$query = query($pdo, "DELETE FROM `$table` WHERE `$primaryKey` = :id", $params);
}

function save($pdo, $table, $primaryKey, $fields) {
	try {
		if ($fields[$primaryKey] == '') {
			// if primary key isn't equal to an empty string but to an existing value
			// db raises "Duplicate key" error and catch block is executed updating an existing record
			// if primary key is equal to an empty string
			// db creates a new record with primary key set to an empty string
			// which should be prevented
			// when primary key is set to null db auto increments it
			// and creates a new record
			$fields[$primaryKey] = null;
		}
		insert($pdo, $table, $fields);
	} catch (PDOException $e) {
		update($pdo, $table, $primaryKey, $fields);
	}
}
