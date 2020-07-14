<?php
class ResponseCleaner
{

    function ResponseCleanerHandler($ApiResponse)
    {
        $receivedResponse = json_decode($ApiResponse);
        $receivedResponse = $receivedResponse->RESPONSE->RESULT[0];
        $cleanedResponse = $this->CleanResponse($receivedResponse);
        $encodedResponse = json_encode($cleanedResponse, JSON_UNESCAPED_UNICODE);
        return $encodedResponse;
    }

    function CleanResponse($receivedResponse)
    {
        $cleanedTimeStamp = $this->CleanTimeStamp($receivedResponse);
        $fixedAbbrevations = $this->ReplaceDestinationAbbrevation($cleanedTimeStamp);
        return $fixedAbbrevations;
    }

    function CleanTimeStamp($receivedResponse)
    {
        for ($i = 0; $i < count($receivedResponse->TrainAnnouncement); $i++) {
            $receivedResponse->TrainAnnouncement[$i]->AdvertisedTimeAtLocation = substr($receivedResponse->TrainAnnouncement[$i]->AdvertisedTimeAtLocation, 11, 5);
        }
        return $receivedResponse;
    }

    function ReplaceDestinationAbbrevation($receivedResponse)
    {
        for ($i = 0; $i < count($receivedResponse->TrainAnnouncement); $i++) {
            if ($receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->LocationName == "Cst") {
                $receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Stockholm Central";
            } elseif ($receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->LocationName == "Sci") {
                $receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Stockholm City";
            } elseif ($receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->LocationName == "Söc") {
                $receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Södertälje Centrum (via Stockholm City)";
            } else {
                $receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Either Stockholm Central or Stockholm City";
            }
        }
        return $receivedResponse;
    }
}
