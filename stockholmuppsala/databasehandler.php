<?php

class DatabaseHandler
{
	private $DbHost;
	private $DbUser;
	private $DbPassword;
	private $DataBase;
	private $Connection;
	private $LastAPiAnswer;
	private $LastCallTime;

	function __construct()
	{
		$this->EnterCredentials();
		$this->CreateConnection();
	}

	function EnterCredentials()
	{
		$this->DbHost = "stockholmuppsala.se.mysql";
		$this->DbUser = "stockholmuppsala_sedatabase";
		$this->DbPassword = "pac4815luk";
		$this->Database = "stockholmuppsala_sedatabase";
	}

	function CreateConnection()
	{
		$this->Connection = new mysqli($this->DbHost, $this->DbUser, $this->DbPassword, $this->Database);
		if ($this->Connection->connect_error) {
			die("Connection failed" . mysqli_connect_error());
		}
	}

	function FetchDeparturesAndTime()
	{
		$queryResult = $this->Connection->query("SELECT lastapianswer, lastcalltime FROM departures where id=1");
		if (!$queryResult) {
			printf("Error: %s\n", $this->Connection->sqlstate);
			die();
		}
		$row = $queryResult->fetch_assoc();
		$this->LastAPiAnswer = $row["lastapianswer"];
		$this->LastCallTime = $row["lastcalltime"];
	}

	function UpdateStoredDeparturesAndTime($apiAnswer, $callTime)
	{
		if (!$this->Connection->query("UPDATE departures SET lastapianswer = '$apiAnswer', lastcalltime = '$callTime' WHERE id=1")) {
			printf("Error: %s\n", $this->Connection->sqlstate);
			die();
		}
	}

	function ReturnLastCallTime()
	{
		return $this->LastCallTime;
	}

	function ReturnLastApiAnswer()
	{
		return $this->LastAPiAnswer;
	}

	function CloseConnection()
	{
		$this->Connection->close();
	}
}
