<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\FileUploader;
use Psr\Log\LoggerInterface;



class LogParseController extends AbstractController
{

    private $logger;

    public function __construct(LoggerInterface $logger) 
    {
        $this->logger = $logger;
    }

    /**
     * @Route("/log/form", name="log_form")
     */
    public function index()
    {
        return $this->render('log_parse/index.html.twig', [
            'controller_name' => 'LogParseController',
        ]);
    }

    /**
     * @Route("/log/doUpload", name="upload")
     */
    public function upload(Request $request, string $uploadDir, FileUploader $uploader, LoggerInterface $logger)
    {
        $token = $request->get("token");
        if (!$this->isCsrfTokenValid('upload', $token)) 
        {
            $logger->info("CSRF failure");
            return new Response("Operation not allowed",  Response::HTTP_BAD_REQUEST,
                ['content-type' => 'text/plain']);
        }        

        $file = $request->files->get('myfile');

        if (empty($file)) 
        {
            return new Response("No file specified",  
            Response::HTTP_UNPROCESSABLE_ENTITY, ['content-type' => 'text/plain']);
        }        

        $filename = $file->getClientOriginalName();
        $uploader->upload($uploadDir, $file, $filename);

        return new Response("File uploaded",  Response::HTTP_OK, ['content-type' => 'text/plain']); 
    }

    /**
     * @Route("/log/parse", name="parse")
     */
    public function parse(string $uploadDir)
    {
        $txtFile = file_get_contents($uploadDir . '/epa-http.txt');
        $rows = explode("\n", $txtFile);
        $result = [];
        foreach($rows as $row => $data)
        {   
            $data = trim($data, " ");
            preg_match('/(^.*?)?(\[[0-9]+:[0-9]+:[0-9]+:[0-9]+\] )?(".+?") ([0-9]+)? ([0-9-]+)?/', $data, $matches);
            
            if(!empty($matches[2]))
            {
                preg_match('/([0-9]+):([0-9]+):([0-9]+):([0-9]+)/', $matches[2], $date);
            }

            if(!empty($matches[3]))
            {
                preg_match('/([A-Z]+)? (\/.*)? ([A-Z]+)?\/?([0-9]+\.[0-9])?/', $matches[3], $request);
            }
                
            $result[$row]['host'] = !empty($matches['1']) ? $matches['1'] : ""; 
            $result[$row]['datetime']['day'] = !empty($date[1]) ? $date[1] : "";
            $result[$row]['datetime']['hour'] = !empty($date[2]) ? $date[2] : "";
            $result[$row]['datetime']['minute'] = !empty($date[3]) ? $date[3] : "";
            $result[$row]['datetime']['second'] = !empty($date[4]) ? $date[4] : "";
            $result[$row]['request']['method'] = !empty($request[1]) ? $request[1] : "";
            $result[$row]['request']['url'] = !empty($request[2]) ? $request[2] : "";
            $result[$row]['request']['protocol'] = !empty($request[3]) ? $request[3] : "";
            $result[$row]['request']['protocol_version'] = !empty($request[4]) ? $request[4] : "";
            $result[$row]['response_code'] = !empty($matches['4']) ? $matches['4'] : ""; 
            $result[$row]['document_size'] = !empty($matches['5']) ? $matches['5'] : ""; 
        }

        $jsonResult = json_encode($result);

        
        
    }

}
