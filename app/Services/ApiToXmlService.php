<?php
// app/Services/ApiToXmlService.php

namespace App\Services;

use GuzzleHttp\Client;
use SimpleXMLElement;

class ApiToXmlService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchApiAndSaveAsXml($apiUrl, $outputPath)
    {
        try {
            // جلب البيانات من API
            $response = $this->client->get($apiUrl);
            $data = $response->getBody()->getContents();
            
            // إذا كانت النتيجة JSON نحولها إلى XML
            if ($this->isJson($data)) {
                $data = $this->jsonToXml(json_decode($data, true));
            }
            
            // حفظ الملف
            file_put_contents($outputPath, $data);
            
            return true;
            
        } catch (\Exception $e) {
            \Log::error("API Error: " . $e->getMessage());
            return false;
        }
    }
    
    protected function isJson($string)
    {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
    
    protected function jsonToXml($data, $rootNode = 'root')
    {
        $xml = new SimpleXMLElement("<$rootNode/>");
        $this->arrayToXml($data, $xml);
        return $xml->asXML();
    }
    
    protected function arrayToXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item';
                }
                $subnode = $xml->addChild($key);
                $this->arrayToXml($value, $subnode);
            } else {
                $xml->addChild($key, htmlspecialchars($value));
            }
        }
    }
}