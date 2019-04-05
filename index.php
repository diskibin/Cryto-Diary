<?php
include 'bootstrap.php';
registration();
login();
logout();
vk();
?>

<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
	<title> Сервис </title>
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
<div id="php">
</div>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4 col-sm-12">
				<div class="col-12-1">
					<p>Добро пожаловать на страницу нашего сервиса</p>
				</div>
			</div>
		</div>
	</div>
	<hr color=#ddeaed width=80%><br>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4 col-sm-12">
				<div class="col-12-1">
					<a><p>С нами проще хранить свои воспоминания без опасения за их сохранность благодаря:</p></a>
				</div>
			</div>
		</div>
	</div>
	<br>

	<div class="container">
		<div class="row justify-content-center">

			<div class="col-md-2 col-sm-12">
				<div class="row">
					<div class="col-12">
						<div class="d1">
							<img src="img/free.png">
							<p>Наш сервис абсолютно бесплатный</p>
						</div>
						<div class="d2">
							<img src="img/free1.png">
							<p>Наш сервис абсолютно бесплатный</p>
						</div>
					</div>
				</div>
			</div>


			<div class="col-md-2 col-sm-12">
				<div class="row">
					<div class="col-12">
						<div class="d1">
							<img src="img/devices.png">
							<p>Ваши записи всегда доступны с любого устройства</p>
						</div>
						<div class="d2">
							<img src="img/devices1.png">
							<p>Ваши записи всегда доступны с любого устройства</p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-2 col-sm-12">
				<div class="row">
					<div class="col-12">
						<div class="d1">
							<img src="img/key.png">
							<p>Полная конфиденциальность за счет шифрования записей</p>
						</div>
						<div class="d2">
							<img src="img/key1.png">
							<p>Полная конфиденциальность за счет шифрования записей</p>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-2 col-sm-12">
				<div class="row">
					<div class="col-12">
						<div class="d1">
							<img src="img/unlim.png">
							<p>Нет ограничений по количеству документов</p>
						</div>
						<div class="d2">
							<img src="img/unlim1.png">
							<p>Нет ограничений по количеству документов</p>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<br>
	<br>

	<div class="container">
		<div class="row justify-content-center">

			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
						<p><a href="diary.php" class="knopka">Начать пользоваться</a></p>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php
	    if(empty($_COOKIE['email'])) {
	?>
	
	<br>
	<div class="container">
		<div class="row justify-content-center">

			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
						<p><a href="#" class="knopka" data-toggle="modal" data-target="#myModal">Регистрация</a></p>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php
	}
	else {
	}
	?>

	<div class="modal" id="myModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body">
                <form method="POST"action="<?php echo $_SERVER['PHP_SELF']; ?>">
				<div class="row">
					<br>
					<div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
				</div>
				<div class="row justify-content-center">
					<div class="col-12"><p><a>Регистрация</a></p></div>
				</div>
					<div class="row justify-content-center">
						<div class="col-12"><input type="text" placeholder="Адрес электронной почты" class="kkk" name="email" size="35"></div>
					</div>
					<br>
					<div class="row justify-content-center">
						<div class="col-12"><input type="password" placeholder="Пароль" class="kkk" name="password" size="35"></div>
					</div>
					<br>
					<div class="row justify-content-center">
						<div class="col-12"><input type="password" placeholder="Повторите пароль" class="kkk" name="confirmation" size="35"></div>
					</div>
					<div class="row justify-content-center">
						<div class="col-12"><p><?php echo(registration())?></p></div>
					</div>
					<br>
					<center><div class="row justify-content-center"><div class="col-12"><p><a id='vkreginfo'></a></p></div></div></center>
					<div class="row justify-content-center">
						<div class="col-12"><button type="submit" name="submit" class="submit">Завершить регистрацию</button></div>
					</div>
					<br>
					<div class="row">
						<div class="col-12"><p>Регистрируясь на сайте вы подтверждаете согласие с политикой конфиденциальности</p></div>
					</div>
					<hr color=#ddeaed width=90%>
					<div class="row">
						<div class="col-12"><p>Или зарегестрируйтесь с помощью <a id='vkreg'></a></p></div>
                    </div>
                </form>
				</div>
			</div>
		</div>
	</div>

	<br>

	<?php
	    if(empty($_COOKIE['email'])) {
    ?>

	<div class="container">
		<div class="row justify-content-center">

			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
						<p><a href="#" class="knopka" data-toggle="modal" data-target="#myModal2">Войти в аккаунт</a></p>
					</div>
				</div>
			</div>

		</div>
	</div>

	<?php
	}
	else {
	?>
	<div class="container">
		<div class="row justify-content-center">

			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
						<form method="POST"action="<?php echo $_SERVER['PHP_SELF']; ?>">
							<div class="col-12"><button type="submit" name="logout" class="submit">Выйти из аккаунта</button></div>
						</form>
					</div>
				</div>
			</div>

		</div>
	</div>
	<?php
	}
	?>

	<div class="modal" id="myModal2">
		<div class="modal-dialog">
			<div class="modal-content">
			<div class="modal-body">
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
				<div class="row">
					<br>
					<div class="col-12"><button type="button" class="close" data-dismiss="modal">&times;</button></div>
				</div>
				<div class="row justify-content-center">
					<div class="col-12"><p><button type="submit" name="vkvhod" class="knopka3">Войти с помощью Вконтакте</button></p></div>
				</div>
				<hr color=#ddeaed width=90%><br>
				<div class="row justify-content-center">
					<div class="col-12"><input type="text" placeholder="Адрес электронной почты" class="kkk" name="email1" size="35"></div>
				</div>
				<br>
				<div class="row justify-content-center">
					<div class="col-12"><input type="password" placeholder="Пароль" class="kkk" name="password1" size="35"></div>
				</div>
				<div class="row justify-content-center">
					<div class="col-12"><p><?php echo(login())?></p></div>
				</div>
				<br>
				<div class="row justify-content-center">
					<div class="col-12"><button type="submit" name="submit1" class="submit">Войти</button></div>
				</div>
				<br>
				<div class="row justify-content-center">
					<div class="col-12"><center><p><a href="pass.php">Забыли пароль?</a></p></center></div>
				</div>
				<hr color=#ddeaed width=90%>
				<div class="row">
					<div class="col-12"><p>Не зарегестрированы? <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#myModal">Зарегистрируйтесь</a></p></div>
                </div>
            </form>
			</div>
			</div>
		</div>
	</div>
    
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
</body>
</html>

<?php
vksetcookies();
?>