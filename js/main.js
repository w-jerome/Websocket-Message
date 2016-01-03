var Server,
	Pseudo,
	$body = $('body'),
	$formLogin = $('.form_login'),
	$formPseudo = $('.form_login .form_pseudo');

function send(data) {
	Server.send('message', data);
}

$formLogin.submit(function () {
	
	if ($formPseudo.val() != '') {
		Pseudo = $formPseudo.val();
		
		console.log('Connecting...');
		Server = new FancyWebSocket('ws://' + HOST + ':' + PORT);
		
		Server.bind('open', function(){
			console.log("Connected");
			$body.addClass('is-connected');
		});
	
		Server.bind('close', function(data){
			console.log("Disconnected");
			$body.removeClass('is-connected');
		});
	
		Server.bind('message', function(data){
	        console.log(data);
		});
	
		Server.connect();
		
	}
	
	return false;
});