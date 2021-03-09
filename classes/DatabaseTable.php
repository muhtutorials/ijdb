<?php

class DatabaseTable {
	private $pdo;
	private $table;
	private $primaryKey;

	public function __construct(PDO $pdo, string $table, string $primaryKey)
	{
		$this->pdo = $pdo;
		$this->table = $table;
		$this->primaryKey = $primaryKey;
	}

	private function query($sql, $params=[])
	{
		$query = $this->pdo->prepare($sql);

		// foreach ($query as $key => $value) {
		// 	$query->bindValue($name, $value);
		// }

		$query->execute($params);

		return $query;
	}

	public function findById($value)
	{
		$params = [":$this->primaryKey" => $value];

		$query = $this->query("SELECT * FROM `$this->table` WHERE `$this->primaryKey` = :$this->primaryKey", $params);

		return $query->fetch();
	}

	public function findAll()
	{
		$query = $this->query("SELECT * FROM `$this->table`");

		return $query->fetchAll();
	}

	public function total()
	{
		$query = $this->query("SELECT COUNT(*) FROM `$this->table`");

		$row = $query->fetch();

		return $row[0];
	}

	private function insert($fields)
	{
		$sql = "INSERT INTO `$this->table` (";
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

		$this->query($sql, $fields);
	}

	private function update($fields)
	{
		$sql = "UPDATE `$this->table` SET ";

		foreach ($fields as $key => $value) {
			$sql .= "`$key` = :$key,";
		}

		$sql = rtrim($sql, ',');

		$sql .= " WHERE `$this->primaryKey` = :$this->primaryKey";

		$fields['primaryKey'] = $fields['id'];

		$this->query($sql, $fields);
	}

	public function delete($id)
	{
		$params = [':id' => $id];

		$query = $this->query("DELETE FROM `$this->table` WHERE `$this->primaryKey` = :id", $params);
	}

	public function save($fields)
	{
		try {
			if ($fields[$this->primaryKey] == '') {
				// if primary key isn't equal to an empty string but to an existing value
				// db raises "Duplicate key" error and catch block is executed updating an existing record
				// if primary key is equal to an empty string
				// db creates a new record with primary key set to an empty string
				// which should be prevented
				// when primary key is set to null db auto increments it
				// and creates a new record
				$fields[$this->primaryKey] = null;
			}
			$this->insert($fields);
		} catch (PDOException $e) {
			$this->update($fields);
		}
	}
}
