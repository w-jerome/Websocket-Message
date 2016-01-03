var Server,
	Pseudo,
	Request = function (type, message) {
		var _this = {};
		_this.type = type;
		_this.message = message;
		
		return JSON.stringify(_this);
	},
	$body = $('body'),
	$formLogin = $('.form_login'),
	$formPseudo = $('.form_login .form_pseudo');
	$channelMembers = $('.channel-members');
	$channelHistory = $('.channel-history');
	$formChannel = $('.form_channel');
	$formChannelMessage = $('.form_channel-message');

function send(data) {
	Server.send('message', data);
}

$formLogin.submit(function () {
	
	if ($formPseudo.val() != '') {
		Pseudo = $formPseudo.val();
		
		console.log('Connecting...');
		Server = new FancyWebSocket('ws://' + HOST + ':' + PORT);
		
		Server.bind('open', function(){
			console.log('Connected');
			$body.addClass('is-connected');
			
			var messageConnected = Request( 'connect', { username: Pseudo } );
			
			send(messageConnected);
		});
		
		Server.bind('close', function(data){
			console.log('Disconnected');
			$body.removeClass('is-connected');
			$channelHistory.html('');
			$formChannelMessage.val('');
		});
	
		Server.bind('message', function(message){
	        console.log(message);
			$channelHistory.append('<div>' + message + '</div>');
		});
	
		Server.connect();
		
	}
	
	return false;
});

$formChannel.submit(function () {
	
	var message = $formChannelMessage.val();
	
	if (message != '') {
		send(message);
		$formChannelMessage.val('');
	}
	
	return false;
}).keypress(function (event) {
	
	if (event.keyCode == 13) {
		$formChannel.submit();
	}
	
});
