<?php
class Timetreshold{
  private $CurrentTime;
  private $TresholdInMinutes;

  function __construct(){
    $this->CurrentTime = time();
    $this->TresholdInMinutes = 5;
  }

  function GetTimePassed($TimeOfLastApiCall){
    $passedUnixTime = $this->CurrentTime - $TimeOfLastApiCall;
    $passedMinutes = (int)date('i', $passedUnixTime);
    return $passedMinutes;
  }

  function IsTresholdReached($TimeOfLastApiCall){
    $passedMinutes = $this->GetTimePassed($TimeOfLastApiCall);
    if ($passedMinutes > $this->TresholdInMinutes) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}


?>
