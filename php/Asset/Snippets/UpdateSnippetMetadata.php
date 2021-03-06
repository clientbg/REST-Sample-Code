<?php
/*
   UpdateSnippetMetadata.php

   Marketo REST API Sample Code
   Copyright (C) 2016 Marketo, Inc.

   This software may be modified and distributed under the terms
   of the MIT license.  See the LICENSE file for details.
*/
$snippet = new UpdateSnippet();
$snippet->id = 1001;
$snippet->description = "This description has been updated";
print_r($snippet->postData());

class UpdateSnippet{
	private $host = "CHANGE ME";
	private $clientId = "CHANGE ME";
	private $clientSecret = "CHANGE ME";
	public $id;//id of , required
	public $name;//name of 
	public $description;//optional description of 
	
	public function postData(){
		$url = $this->host . "/rest/asset/v1/snippet/" . $this->id . ".json?access_token=" . $this->getToken();
		$ch = curl_init($url);
		$requestBody = "";
		if (isset($this->name)){
			$requestBody .= "&name=" . $this->name;
		}
		if (isset($this->description)){
			$requestBody .= "&description=" . $this->description;
		}
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $requestBody);
		curl_getinfo($ch);
		$response = curl_exec($ch);
		return $response;
	}
	private function getToken(){
		$ch = curl_init($this->host . "/identity/oauth/token?grant_type=client_credentials&client_id=" . $this->clientId . "&client_secret=" . $this->clientSecret);
		curl_setopt($ch,  CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('accept: application/json',));
		$response = json_decode(curl_exec($ch));
		curl_close($ch);
		$token = $response->access_token;
		return $token;
	}	
}