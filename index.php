<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
And Modified by RikiOktopan
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'lCLx6A1xEzqDLT5/MlizmbyApl9tEdddkl6unVh4dOl/whDihYdxSkB6n1Vy9rlcY73aFTcXJeGvilglnx/yHX5GjDlu3zwZMjMfwfe0PzhlxkpAYFTMHYEity3OOvJ/a03VWCSKMpvOZakJv94KvAdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = 'Sm3f92f0d4ff548702d574f57ef480bb56';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['text'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Sticker mulu ga bisa ngetik ya'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'c2ab9b79-0690-467f-a2ff-bb2d9464139c'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' Server Kami Sedang Sibuk Sekarang.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
