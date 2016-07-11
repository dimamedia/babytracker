<?php

/*
 * PDO Extension
 * 
 * https://github.com/dimamedia/PHP-PDO-extension
 */

class db extends PDO {

/* SETTINGS START */
	private $options = array(	PDO::ATTR_PERSISTENT => true, 
								PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
							);

/* SETTINGS END */

	private $error;
	private $sql;
	private $bind;
	private $errorCallbackFunction;
	private $errorMsgFormat;
	
	public function __construct($db) {
		// $db = array(host, dbname, user, password);
		$dsn = 'mysql:host='.$db[0].';dbname='.$db[1].';charset=utf8';
		$user = $db[2];
		$passwd = $db[3];

		try {
			parent::__construct($dsn, $user, $passwd, $this->options);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
		
		$this->query('SET NAMES utf8');
	}

	private function debug() {
		if(!empty($this->errorCallbackFunction)) {
			$error = array("Error" => $this->error);
			if(!empty($this->sql)) $error["SQL Statement"] = $this->sql;
			if(!empty($this->bind)) $error["Bind Parameters"] = trim(print_r($this->bind, true));

			$backtrace = debug_backtrace();
			if(!empty($backtrace)) {
				foreach($backtrace as $info) {
					if($info["file"] != __FILE__) $error["Backtrace"] = $info["file"] . " at line " . $info["line"];	
				}		
			}

			$msg = "";
			if($this->errorMsgFormat == "html") {
				if(!empty($error["Bind Parameters"])) $error["Bind Parameters"] = "<pre>" . $error["Bind Parameters"] . "</pre>";
				$msg .= '<div style="padding: 0.75em; margin: 0.75em; border: 1px solid #990000; color: #990000; background-color: #FDF0EB; -moz-border-radius: 0.5em; -webkit-border-radius: 0.5em;"><h3 style="margin: 0; padding-bottom: 0.25em; border-bottom: 1px solid #990000;">SQL Error</h3>';
				foreach($error as $key => $val) $msg .= '<label style="display: block; padding-top: 1em; font-weight: bold;">' . $key . ':</label> ' . $val;
				$msg .= "</div>";
			}
			elseif($this->errorMsgFormat == "text") {
				$msg .= "SQL Error\n" . str_repeat("-", 50);
				foreach($error as $key => $val) $msg .= "\n\n$key:\n$val";
			}

			$func = $this->errorCallbackFunction;
			$func($msg);
		}
	}
	
	public function setErrorCallbackFunction($errorCallbackFunction, $errorMsgFormat="html") {
		//Variable functions for won't work with language constructs such as echo and print, so these are replaced with print_r.
		if(in_array(strtolower($errorCallbackFunction), array("echo", "print"))) $errorCallbackFunction = "print_r";

		if(function_exists($errorCallbackFunction)) {
			$this->errorCallbackFunction = $errorCallbackFunction;	
			if(!in_array(strtolower($errorMsgFormat), array("html", "text"))) $errorMsgFormat = "html";
			$this->errorMsgFormat = $errorMsgFormat;	
		}	
	}

	private function filter($table, $info) { // Check that required fields in $info exsist in the table
		if(false !== ($list = $this->run("DESCRIBE $table"))) {
			$fields = array();
			foreach($list as $record)
				$fields[] = $record['Field'];
			return array_values(array_intersect($fields, array_keys($info)));
		}
		return array();
	}

	private function cleanup($bind) { // Return $bind always as an array, no matter what
		if(!is_array($bind)) {
			if(!empty($bind)) $bind = array($bind);
			else $bind = array();
		}
		return $bind;
	}

	public function run($sql, $bind="", $fetch="") {
		$this->sql = trim($sql);
		$this->bind = $this->cleanup($bind);
		$this->error = "";

		try {
			$pdostmt = $this->prepare($this->sql);
			if($pdostmt->execute($this->bind) !== false) {
				if(preg_match("/^(" . implode("|", array("select", "describe", "pragma")) . ") /i", $this->sql)) {
					if($fetch == "both") return $pdostmt->fetchAll();
					else return $pdostmt->fetchAll(PDO::FETCH_ASSOC);
				}
				elseif(preg_match("/^(" . implode("|", array("delete", "update")) . ") /i", $this->sql))
					return $pdostmt->rowCount();
				elseif(preg_match("/^(" . implode("|", array("insert")) . ") /i", $this->sql)) {
					return $this->lastInsertId();
				}
			}	
		} catch (PDOException $e) {
			$this->error = $e->getMessage();	
			$this->debug();
			return false;
		}
	}

	public function select($table, $where="", $bind="", $fields="*", $limit="") {
		$sql = "SELECT " . $fields . " FROM " . $table;
		if(!empty($where)) $sql .= " WHERE " . $where;
		if(!empty($limit)) $sql .= " LIMIT $limit";
		$sql .= ";";
		return $this->run($sql, $bind);
	}

	public function insert($table, $info) {
		$fields = $this->filter($table, $info);
		$sql = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
		$bind = array();
		foreach($fields as $field)
			$bind[":$field"] = $info[$field];
		return $this->run($sql, $bind);
	}

	public function update($table, $info, $where, $bind="") {
		$fields = $this->filter($table, $info);
		$fieldSize = sizeof($fields);

		$sql = "UPDATE " . $table . " SET ";
		for($f = 0; $f < $fieldSize; ++$f) {
			if($f > 0)
				$sql .= ", ";
			$sql .= $fields[$f] . " = :update_" . $fields[$f]; 
		}
		$sql .= " WHERE " . $where . ";";

		$bind = $this->cleanup($bind);
		foreach($fields as $field)
			$bind[":update_$field"] = $info[$field];
		
		return $this->run($sql, $bind);
	}

	public function delete($table, $where, $bind="") {
		$sql = "DELETE FROM " . $table . " WHERE " . $where . ";";
		return $this->run($sql, $bind);
	}
	
}	
?>
