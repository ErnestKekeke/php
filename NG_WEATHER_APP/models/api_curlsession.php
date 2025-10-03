<?php 
    declare(strict_types=1);
?>

<?php 
class ApiCurlSession{
    private $ch;
    public function __construct(){
            $this->ch = curl_init();
            curl_setopt_array($this->ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_TIMEOUT => 30, 
            CURLOPT_SSL_VERIFYPEER => false
        ]);
    }

    public function setUrl(string $url){
        curl_setopt($this->ch, CURLOPT_URL, $url);
        return $this;
    }

    public function setHeader(array $headers){
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $headers);
        return $this; 
    }

    public function requestMethod(string $method){
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST, $method);
        return $this; 
    }
 
    public function setJsonData(mixed $data){
        curl_setopt($this->ch, CURLOPT_POST, true);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, json_encode($data));
        return $this;
    }

    public function execute():mixed{
        $response = curl_exec($this->ch);
        $httpCode = curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
        
        if (curl_error($this->ch)) {
            throw new Exception('cURL Error: ' . curl_error($this->ch));
        }
        curl_close($this->ch);
        return [
            'data' => $response,
            'http_code' => $httpCode
        ];
    }
}
//...............end of class                     
?>