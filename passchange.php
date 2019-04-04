<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<title> Смена пароля </title>
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

<body>
    <div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6 col-sm-12">
				<div class="col-12-1">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<div class="row justify-content-center">
							<div class="col-12-1"><p><a>Смена пароля</a></p></div>
						</div>
						<br>
						<div class="row justify-content-center">
							<div class="col-12-20"><p><a>Введите старый пароль:</a></p></div>
						</div>
						<div class="row justify-content-center">
							<div class="col-12"><input type="password"class="kkk" name="old" size="35"></div>
						</div>
						<br>
						<div class="row justify-content-center">
							<div class="col-12-20"><p><a>Введите новый пароль:</a></p></div>
						</div>
						<div class="row justify-content-center">
							<div class="col-12"><input type="password"class="kkk" name="new" size="35"></div>
						</div>
						<br>
						<div class="row justify-content-center">
							<div class="col-12-20"><p><a>Повторите новый пароль:</a></p></div>
						</div>
						<div class="row justify-content-center">
							<div class="col-12"><input type="password"class="kkk" name="newconf" size="35"></div>
						</div>
						<br>
						<div class="row justify-content-center">
							<div class="col-12-20" id='message'></div>
						</div>
						<div class="row justify-content-center">
							<div class="col-12"><button type="submit" name="submit" class="submit">Изменить</button></div>
						</div>
						<br>
						<div class="col-12-2">
							<p><a href="diary.php" class="knopka">Вернуться к дневнику</a></p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
	

	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
</body>
</html>

<?php
include 'bootstrap.php';
passchange();
?>