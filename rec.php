<?php   
include 'bootstrap.php';
if(isset($_POST['otred'])) {edit();};
?>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<title> Запись "<?php echo recnameload($_GET['id']) ?>" </title>
	<link rel="stylesheet" type="text/css" href="styles/1.css">
	<style>
	@font-face {
    font-family: Amatic SC;
    src: url(fonts/AmaticSC-Regular.ttf);
	font-weight: regular;
   	}
	@font-face {
    font-family: Amatic SC;
    src: url(fonts/AmaticSC-Bold.ttf);
	font-weight: bold;
	}
	</style>
</head>

<?php   
	$dbc = mysqli_connect('localhost', 'root', 'qwerty', 'users');
	$email = $_COOKIE['email'];
	$id=mysqli_real_escape_string($dbc, $_GET['id']);
	$usl = "SELECT cremail FROM records WHERE id = '$id'";
	$res = mysqli_query($dbc, $usl);
	$u = mysqli_fetch_row($res);
	if($email == $u[0]){
?>

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-sm-12">
				<div class="col-12-1">
                    <p>Запись "<?php echo recnameload($_GET['id']) ?>"</p>
					<div class="col-12-1" style="word-wrap: break-word;"><p id="note33"><?php echo rectextload($_GET['id']); ?></p><br></div>
					<div class="col-12-2" id="note34" style="display: none;">
						<center><input type="text" class="kkk" id='text' name='text'></center>
						<br>
					</div>
					<div class="col-12-2" id="shipr1">
						<p><a onclick=de() class="knopka">Расшифровать</a></p>
					</div>
					<div class="col-12-2" id="shipr2" style="display: none;">
						<p><a onclick="red()" class="knopka">Редактировать</a></p>
					</div>
					<div class="col-12-2" id="shipr3" style="display: none;">
					<form method="POST">
						<p><button name="otred" class="submit" onclick=crypt()>Сохранить</a></p>
						<input type="hidden" class="kkk" name="encr" id="encr">
					</form>
					</div>
					<br>
					<div class="col-12-2">
						<p><a href="diary.php" class="knopka">Вернуться к списку записей</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<input type="hidden" class="kkk" name="pass" id="pass">
	

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
	<script type="text/javascript">
	function de(){
		var note = "<?php echo rectextload($_GET['id']); ?>";
		var pass = prompt('Введите Ключ');
		document.getElementById('pass').value = pass;
		if(pass == "<?php echo recpassload($_GET['id']); ?>"){
			var decrypted = CryptoJS.AES.decrypt(note, pass).toString(CryptoJS.enc.Utf8);
			document.getElementById('note33').innerHTML = decrypted;
			document.getElementById("shipr1").style.display = "none";
			document.getElementById("shipr2").style.display = "block";
		}
		else{
			alert("Вы ввели неверный пароль");
		}
	}

	function red(){
		document.getElementById('note33').style.display = "none";
		document.getElementById('note34').style.display = "block";
		document.getElementById("shipr2").style.display = "none";
		document.getElementById("shipr3").style.display = "block";
		var val = document.getElementById('note33').innerHTML;
        document.getElementById('text').value = val;
	}

	function crypt(){
        var note = document.getElementById("text").value;
        var password = document.getElementById('pass').value;

        var encrypted = CryptoJS.AES.encrypt(note, password).toString();

        document.getElementById('encr').value = encrypted;

    }

	</script>
</body>

<?php   
	}
	else
	{
?>

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-sm-12">
				<div class="col-12-1">
                    <p>Вам запрещен просмотр данной записи</p>
				</div>
			</div>
		</div>
	</div>

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
</body>

<?php   
	}
?>

</html>
