<?php
$file = new GetFile();
$file->id = 13824;
print_r($file->getData());

class GetFile{
	private $host = "CHANGE ME";
	private $clientId = "CHANGE ME";
	private $clientSecret = "CHANGE ME";
	public $id;//id of file to retrieve
	
	public function getData(){
		$url = $this->host . "/rest/asset/v1/file/" . $this->id . ".json?access_token=" . $this->getToken();
		$ch = curl_init($url);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = curl_exec($ch);
		return $response;
	}
	
	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}
}