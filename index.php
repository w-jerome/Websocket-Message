<?php require("config.php"); ?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>HTML 5 - Websockets</title>
		
		<meta name="description" content="HTML 5 - Websockets">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" href="./css/normalize.css">
		<link rel="stylesheet" href="./css/style.css">
		
		<script src="./js/jquery-2.1.3.min.js"></script>
        <script src="./js/fancywebsocket.js"></script>
		
		<script>
		var HOST = "<?= HOST; ?>",
			PORT = "<?= PORT; ?>";
		</script>
    </head>
    <body>
		<div class="page_login">
			<form action="./" method="post" enctype="multipart/form-data" class="form_login">
				<input type="text" name="pseudo" class="form_pseudo" placeholder="Pseudo ..." autocomplete="off">
				<div class="text-right">
					<input type="submit" value="Se connecter" class="form_submit">
				</div>
			</form>
		</div>
		<div class="page_channel">
			<div class="channel-action">
				<div class="channel-history"></div>
				<div class="channel-message">
					<form action="./" method="post" enctype="multipart/form-data" class="form_channel">
						<textarea name="message" class="form_channel-message"></textarea>
						<input type="submit" value="Envoyer" class="form_channel-submit">
					</form>
				</div>
			</div>
			<div class="channel-members">
				
			</div>
		</div>
		<script src="./js/main.js"></script>
	</body>
</html>