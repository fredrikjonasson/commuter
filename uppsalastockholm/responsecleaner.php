<?php
class ResponseCleaner
{
    function CleanResponse($ApiResponse)
    {
        $receivedResponse = json_decode($ApiResponse);
        $cleanedTimeStamp = $this->CleanTimeStamp($receivedResponse);
        $cleanedResponse = $this->ReplaceDestinationAbbrevation($cleanedTimeStamp);
        $encodedResponse = json_encode($cleanedResponse, JSON_UNESCAPED_UNICODE);
        return $encodedResponse;
    }

    function CleanTimeStamp($receivedResponse)
    {
        for ($i = 0; $i < count($receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement); $i++) {
            $receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->AdvertisedTimeAtLocation = substr($receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->AdvertisedTimeAtLocation, 11, 5);
        }
        return $receivedResponse;
    }

    function ReplaceDestinationAbbrevation($receivedResponse)
    {
        for ($i = 0; $i < count($receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement); $i++) {
            if ($receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->ToLocation[0]->LocationName == "Cst") {
                $receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Stockholm Central";
            } elseif ($receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->ToLocation[0]->LocationName == "Sci") {
                $receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Stockholm City";
            } elseif ($receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->ToLocation[0]->LocationName == "Söc") {
                $receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Södertälje Centrum (via Stockholm City)";
            } else {
                $receivedResponse->RESPONSE->RESULT[0]->TrainAnnouncement[$i]->ToLocation[0]->LocationName = "Either Stockholm Central or Stockholm City";
            }
        }
        return $receivedResponse;
    }
}
