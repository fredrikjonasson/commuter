<?php
require('apirequest.php');
require('databasehandler.php');
require('timetreshold.php');

class Controller{
	private $DatabaseHandler;
	private $Timetreshold;

	function __construct(){
		$this->SetupAndPopulateDatabaseHandler();
		$this->Timetreshold = new Timetreshold();
		$this->GetRequest();
	}

	function SetupAndPopulateDatabaseHandler(){
		$this->DatabaseHandler = new DatabaseHandler();
		$this->DatabaseHandler->FetchDeparturesAndTime();
		$this->DatabaseHandler->CloseConnection();
	}

	function GetRequest(){
		$TimeOfLastApiCall = $this->DatabaseHandler->ReturnLastCallTime();
		if ($this->Timetreshold->IsTresholdReached($TimeOfLastApiCall)) {
			echo("Reached");
		} else {
			echo("Not reached");
		}
	}

	function CallApi(){
		$timeNow = time();
		$timeOfLastCall = "Funktion här";
	}

}
//$testar = time(); 1594435500 45 1594479190 NU 43690

$hej = new Controller();
//var_dump((int)date('i', 43690));
?>
