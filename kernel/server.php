<?php
// include config
require("../config.php");

// prevent the server from timing out
set_time_limit(0);

// include the web sockets server script (the server is started at the far bottom of this file)
require 'class.PHPWebSocket.php';

// when a client sends data to the server
function wsOnMessage($clientID, $message, $messageLength, $binary) {
	
	global $Server;
	
	$message = json_decode($message, true);
	
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	// check if message length is 0
	if ($messageLength == 0) {
		$Server->wsClose($clientID);
		return;
	}
	
	if ($message["type"] == "connect") {
		
		$Server->wsClients[$clientID]["username"] = $message["message"]["username"];
		
		$Server->log( "$ip ($clientID - ". $Server->wsClients[$clientID]["username"] .") has connected." );
		
//		foreach ( $Server->wsClients as $id => $client ){
//			$Server->wsSend($id, $message);
//		}
		
	}else if ($message["type"] == "message") {
		
		//The speaker is the only person in the room. Don't let them feel lonely.
		if ( sizeof($Server->wsClients) == 1 ){
			$Server->wsSend($clientID, "Il n'y a personne dans le channel");
		}else{

			//Send the message to everyone but the person who said it
			foreach ( $Server->wsClients as $id => $client ){
	//			if ( $id != $clientID ){
	//				$Server->wsSend($id, "Visitor $clientID ($ip) said:<br> $message");
					$Server->wsSend($id, $message);
	//			}
			}

		}
	}
}

// when a client connects
function wsOnOpen($clientID) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );
	
//	$Server->log( "$ip ($clientID) has connected." );
//    
//	//Send a join notice to everyone but the person who joined
//	foreach ( $Server->wsClients as $id => $client ){
//		if ( $id != $clientID ){
//			$Server->wsSend($id, "Visitor $clientID ($ip) has joined the room.<br>");
//			
//		}
//	}
//	
//	if(!empty($listUsers)){
//		$Server->wsSend($clientID, "You are connected");
//	}
}

// when a client closes or lost connection
function wsOnClose($clientID, $status) {
	global $Server;
	$ip = long2ip( $Server->wsClients[$clientID][6] );

	$Server->log( "$ip ($clientID) has disconnected." );

	//Send a user left notice to everyone in the room
	foreach($Server->wsClients as $id => $client){
		$Server->wsSend($id, "Visitor $clientID ($ip) has left the room.");
    }
}

// start the server
$Server = new PHPWebSocket();
$Server->bind('message', 'wsOnMessage');
$Server->bind('open', 'wsOnOpen');
$Server->bind('close', 'wsOnClose');
// for other computers to connect, you will probably need to change this to your LAN IP or external IP,
// alternatively use: gethostbyaddr(gethostbyname($_SERVER['SERVER_NAME']))
$Server->wsStartServer(HOST, PORT);
