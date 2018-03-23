

<!DOCTYPE HTML>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<title>Контактная форма</title>
		<link rel="stylesheet" href="phonecode.css">

		<style>
			body {font-family: arial, helvetica, sans-serif; font-size: 14px; margin: 0; padding: 0;}
			.form {width: 300px; margin: 20px auto;}
			.field input {font-size: 14px; padding: 2px; border: 0; outline: none;}
			.field label {padding: 2px 0; display: block; color: #666;}
			.code {padding: 30px 0 20px 0;}
			code {background: #eee; display: block; color: #f50;}
			.licence {font-size: 12px; color: #555; padding: 30px 0;}
			.licence a {color: #222;}

			.feedback-form {
			max-width: 590px;
			margin:0 auto;
			padding: 2%;
			border-radius: 3px;
			}
			.feedback-form input {
				width:100%;
				height:20px;
				margin-bottom:20px;
				padding-left:10px;
			}
			.feedback-form .border {
			border-radius: 1px;
			border-width: 1px;
			border-style: solid;
			border-color: #C0C0C0 #D9D9D9 #D9D9D9;
			box-shadow: 0 1px 1px rgba(255,255,255,.5), 0 1px 1px rgba(0,0,0,.1) inset;
			}
			.feedback-form .border:focus {
			outline: none;
			border-color: #abd9f1 #bfe3f7 #bfe3f7;
			}
			.feedback-form .border:hover {
			border-color: #7eb4ea #97cdea #97cdea;
			}
			.feedback-form .border:focus::-moz-placeholder {
			color: transparent;
			}
			.feedback-form .border:focus::-webkit-input-placeholder {
			color: transparent;
			}
			.feedback-form .border:not(:focus):not(:hover):valid {
			opacity: .8;
			}
			#submitFF {
			padding: 2%;
			border: none;
			border-radius: 3px;
			box-shadow: 0 0 0 1px rgba(0,0,0,.2) inset;
			background: #669acc;
			color: #fff;
			}
			.feedback-form br {
			height: 0;
			clear: both;
			}
			#submitFF:hover {
			background: #5c90c2;
			}
			#submitFF:focus {
			box-shadow: 0 1px 1px #fff, inset 0 1px 2px rgba(0,0,0,.8), inset 0 -1px 0 rgba(0,0,0,.05);
			}
			.field-num input{
				border:none;
				margin-bottom:0;
				padding-left:10px;
				width:80%;
				outline:none;
			}
			.field-num{
				width:102%;
				background:white;
				margin-bottom:20px;
			}
			#messageFF{
				width:100%;
				padding:5px 5px 5px 10px;
			}
		</style>

		
	</head>
	<body>

		<?php echo $output; ?>
		<form enctype="multipart/form-data" method="post" class="feedback-form" id="feedback-form">
			<label for="nameFF">Имя:</label><br><br>
			<input type="text" name="nameFF" id="nameFF" required placeholder="например, Иван Иванович Иванов" x-autocompletetype="name" class="w100 border" require><br>
				
			<label for="phone">Ваш телефон:</label><br><br>
		
			<div class="field-num border">
				<input type="text" id="phone" name="phone" autofocus="true" placeholder="9990000000" class="w100">
				<input type="hidden" id="code" name="code">
			</div>
		
			
			<label for="contactFF">Email:</label><br><br>
			<input type="text" name="contactFF" id="contactFF" required placeholder="например, ivan@yandex.ru" x-autocompletetype="email" class="w100 border">
			<br>
			
			<label for="fileFF">Прикрепить файл:</label><br><br>
			<input type="file" name="fileFF[]" multiple id="fileFF" class="w100"><br><br>
			<label for="messageFF">Сообщение:</label><br><br>
			<textarea name="messageFF" id="messageFF" rows="5" placeholder="Детали заявки…" class="w100 border"></textarea>
			<br><br>
			<button type="submit" id="submitFF">Отправить</button>
		</form>

		<script src="jquery-1.11.0.min.js"></script>
		<script src="jquery-ui-1.10.4.custom.min.js"></script>
		<script src="jquery.maskedinput.min.js"></script>
		<script src="counties.js"></script>
		<script src="phonecode.js"></script>
		<script>
			$(function(){
				$('#phone').phonecode({
					preferCo: 'ru'
				});
			});
	$(document).ready(function() {
		$('#submitFF').click(function(){
			var res = $('.country-phone-selected span').html();
			if(res!= undefined){
			res = res.split('<');
			$('#code').val(res[0]);
			}else{
			$('#code').val("+7");
			}
		});
		$('#fileFF').change(function(){
			updateSize();
			});
		});
		$('#contactFF').blur(function() {
			var pattern = /^([a-z0-9_\.-])+@[a-z0-9-]+\.([a-z]{2,6}\.)?[a-z]{2,6}$/i;
			var address = $(this).val();
			var com =  address.substr(-3);
			var ru = address.substr(-2);

			if(pattern.test(address)==false ||( ru!='ru' && com !='com') ) {
				alert("Email не должен содержать символы ! \$ & * - = ^ ` | ~ # % ' + / ? _ { } и должен заканчиваться на 'ru' или  'com' ")
				$('#submitFF').attr("disabled", "disabled");
			}
			else{
			$('#submitFF').removeAttr('disabled');
			}
			});
			$("#phone").mask("(999) 999-99-99");
			function updateSize() {
			var files = document.getElementById("fileFF").files,
				ext = "не определилось";
			var size_files=0;
				
			for(var i =0;i< files.length;i++ ){
				size_files += files[i].size;
			}
			return size_files;
			
			}


			document.getElementById('feedback-form').addEventListener('submit', function(evt){
			var sizefiles = updateSize();
			if(sizefiles<1000000){
			var http = new XMLHttpRequest(), f = this;
			evt.preventDefault();
			http.open("POST", "contacts.php", true);
			http.onreadystatechange = function() {
				if (http.readyState == 4 && http.status == 200) {
				alert(http.responseText);
				if (http.responseText.indexOf(f.nameFF.value) == 0) { // очистить поле сообщения, если в ответе первым словом будет имя отправителя
					f.messageFF.removeAttribute('value');
					f.messageFF.value='';
				}
				}
			}
			http.onerror = function() {
				alert('Извините, данные не были переданы');
			}
			http.send(new FormData(f));}
			else{
			alert("Размер файлов больше 1m");
			}
			}, false);

		</script>

	</body>
</html>

