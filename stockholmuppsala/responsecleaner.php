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
        $trimmedAnswer = $this->TrimResponse($fixedAbbrevations);
        return $trimmedAnswer;
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
            if ($receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->LocationName == "Cst") {
                $receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->LocationName = "Stockholm Central";
            } elseif ($receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->LocationName == "Sci") {
                $receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->LocationName = "Stockholm City";
            } elseif ($receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->LocationName == "Söc") {
                $receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->LocationName = "Södertälje Centrum (via Stockholm City)";
            } else {
                $receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->LocationName = "Either Stockholm Central or Stockholm City";
            }
        }
        return $receivedResponse;
    }
    function TrimResponse($receivedResponse)
    {
        for ($i = 0; $i < count($receivedResponse->TrainAnnouncement); $i++) {
            unset($receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->Priority);
            unset($receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->Priority);
            unset($receivedResponse->TrainAnnouncement[$i]->FromLocation[0]->Order);
            unset($receivedResponse->TrainAnnouncement[$i]->ToLocation[0]->Order);
        }
        return $receivedResponse;
    }
}
