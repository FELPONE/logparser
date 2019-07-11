<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;



class DataController extends AbstractController
{
    /**
     * @Route("/log/methodDistribution", name="methodDistribution", methods={"GET"})
     */
    public function methodDistribution(String $uploadDir)
    {
        $jsonFile = file_get_contents($uploadDir . '/json.txt');
        $arrayFile = json_decode($jsonFile, 1);
        $result = array("POST"   => 0, 
                        "GET"    => 0,
                        "HEAD"   => 0,
                        "PUT"    => 0,
                        "DELETE" => 0,
                        "PATCH"  => 0);
                         
        foreach($arrayFile as $log)
        {
            $method = strtoupper(trim($log["request"]["method"]));

            switch ($method) {
                case "POST":
                    $result['POST']++;
                    break;
                case "GET":
                    $result['GET']++;
                    break;
                case "HEAD":
                    $result['HEAD']++;
                    break;
                case "PUT":
                    $result['PUT']++;
                    break;
                case "DELETE":
                    $result['DELETE']++;
                    break;
                case "PATCH":
                    $result['PATCH']++;
                    break;
            }
        }
        
        $response = new JsonResponse($result ,JsonResponse::HTTP_OK);
        return $response; 
    }

    /**
     * @Route("/log/answerDistribution", name="answerDistribution", methods={"GET"})
     */
    public function answerDistribution(String $uploadDir)
    { 
        $jsonFile = file_get_contents($uploadDir . '/json.txt');
        $arrayFile = json_decode($jsonFile, 1);
        $result = array();
                         
        foreach($arrayFile as $log)
        {
            $responseCode = strtoupper(trim($log["response_code"]));
            
            isset($result[$responseCode])? $result[$responseCode]++ : $result[$responseCode] = 1;
        }
        $response = new JsonResponse($result ,JsonResponse::HTTP_OK);
        return $response; 
    }

    /**
     * @Route("/log/requestMinute", name="requestMinute", methods={"GET"})
     */
    public function requestMinute(String $uploadDir)
    { 
        $jsonFile = file_get_contents($uploadDir . '/json.txt');
        $arrayFile = json_decode($jsonFile, 1);
        $result = array();
                         
        foreach($arrayFile as $log)
        {
            $day = (int)strtoupper(trim($log["datetime"]["day"]));
            $hour = (int)strtoupper(trim($log["datetime"]["hour"]));
            $minute = (int)strtoupper(trim($log["datetime"]["minute"]));
            isset($result[$day][$hour][$minute])? $result[$day][$hour][$minute] ++ : $result[$day][$hour][$minute] = 1;
        }

        //dd($result);


        $response = new JsonResponse($result ,JsonResponse::HTTP_OK);
        return $response; 
    }
}
