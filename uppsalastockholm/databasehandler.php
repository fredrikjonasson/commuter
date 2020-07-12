<?php

class DatabaseHandler{
	private $DbHost;
	private $DbUser;
	private $DbPassword;
	private $DataBase;
	private $Connection;
	private $LastAPiAnswer;
	private $LastCallTime;

	function __construct(){
		$this->EnterCredentials();
		$this->CreateConnection();
	}

	function EnterCredentials(){
		$this->DbHost = "localhost";
		$this->DbUser = "root";
		$this->DbPassword = "";
		$this->Database = "tag";
	}

	function CreateConnection(){
		$this->Connection = new mysqli($this->DbHost, $this->DbUser, $this->DbPassword, $this->Database);
		if ($this->Connection->connect_error) {
			die("Connection failed". mysqli_connect_error());
		}
	}

	function FetchDeparturesAndTime(){
		$queryResult = $this->Connection->query("SELECT lastapianswer, lastcalltime FROM departures");
		if(!$queryResult) {
			printf("Error: %s\n", $this->Connection->sqlstate);
		}
		$row = $queryResult->fetch_assoc();
		$this->LastAPiAnswer = $row["lastapianswer"];
		$this->LastCallTime = $row["lastcalltime"];
	}

	function SaveDeparturesAndTime($apiAnswer, $callTime){
		if(!$this->Connection->query("INSERT INTO departures (lastapianswer, lastcalltime) VALUES ('$apiAnswer', '$callTime')")){
			printf("Error: %s\n", $this->Connection->sqlstate);
		}
	}

	function ReturnLastCallTime(){
		return $this->LastCallTime;
	}

	function ReturnLastApiAnswer(){
		return $this->LastAPiAnswer;
	}

	function CloseConnection(){
		$this->Connection->close();
	}
}
?>
