<?php
class ApiRequest {
  private $ApiQuestion;
  private $EndPoint;

  public function __construct(){
    $this->ApiQuestion = '<?xml version="1.0" encoding="utf-8"?>
    <REQUEST>
    <LOGIN authenticationkey="4cc0d9097d2e450ab7ec36ebafeed3da" />
    <QUERY objecttype="TrainAnnouncement" schemaversion="1.3" orderby="AdvertisedTimeAtLocation">
    <FILTER>
    <AND>
    <EQ name="ActivityType" value="Avgang" />
    <EQ name="LocationSignature" value="U" />
    <OR>
    <EQ name="ViaToLocation.LocationName" value="Sci" />
    <EQ name="ToLocation.LocationName" value="Sci" />
    <EQ name="ViaToLocation.LocationName" value="Cst" />
    <EQ name="ToLocation.LocationName" value="Cst" />
    </OR>
    <AND>
    <GT name="AdvertisedTimeAtLocation" value="$dateadd(-00:15:00)" />
    <LT name="AdvertisedTimeAtLocation" value="$dateadd(01:00:00)" />
    </AND>
    </AND>
    </FILTER>
    <INCLUDE>AdvertisedTrainIdent</INCLUDE>
    <INCLUDE>AdvertisedTimeAtLocation</INCLUDE>
    <INCLUDE>TrackAtLocation</INCLUDE>
    <INCLUDE>ToLocation</INCLUDE>
    </QUERY>
    </REQUEST>';

    $this->EndPoint = "https://api.trafikinfo.trafikverket.se/v2/data.json";
    //$this->askApi();
  }
  public function askApi() {
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));

    curl_setopt($curl, CURLOPT_URL, $this->EndPoint);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $this->ApiQuestion);

    $result = curl_exec($curl);
    return $result;
  }

}
//$a = new APIRequest();
?>
