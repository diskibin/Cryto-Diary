<?php
$dbc = mysqli_connect('localhost', 'root', 'qwerty', 'users');

function registration(){
	global $dbc;
	$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	$mailkey = md5($email);
	$password = mysqli_real_escape_string($dbc, trim($_POST['password']));
	$confirmation = mysqli_real_escape_string($dbc, trim($_POST['confirmation']));
	$base_url='localhost';
	if (empty($_POST['email'])) {
		$info_reg = 'Вы не ввели почту';
	}
	elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $email)) {
		$info_reg = 'Неправильно введен адрес электронной почты';
	}
	elseif (empty($password)) {
		$info_reg = 'Вы не ввели пароль';
	}
	elseif (iconv_strlen($password, 'utf-8') < 8){
		$info_reg = 'Вы ввели слишком короткий пароль';
	}
	elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{8,50}$/', $password)){
		$info_reg = 'Пароль должен содержать хотя бы одну строчную и одну заглавную буквы';
	}
	elseif (empty($confirmation)) {
		$info_reg = 'Вы не ввели подтверждение пароля';
	}
	elseif ($password != $confirmation){
		$info_reg = 'Подтверждение пароля не совпадает с паролем';
	}
	elseif (!empty($_COOKIE['user'])) {
		$to=$email;
		$subject="Подтверждение электронной почты";
		$body='Здраствуйте, <br/> <br/> Нам необходимо убедиться, что вы действительно хотите зарегестрироваться на нашем сервисе. Для этого вам необходимо подтвердить аккаунт, перейдя по ссылке ниже:<br/> <br/> 
		<a href="'.$base_url.'/activation.php?mailkey='.$mailkey.'">'.$base_url.'/activation.php?mailkey='.$mailkey.'</a>';
		$sending = sendemail($to, $subject, $body);

		$vklogin = $_COOKIE['user'];
		$query = "SELECT * FROM `signup` WHERE email = '$email'";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data) == 0) {
			$query ="INSERT INTO `signup` (email, password, mailkey, ok, vk_uid) VALUES ('$email', SHA('$confirmation'), '$mailkey', '0', '$vklogin')";
			mysqli_query($dbc, $query);
			header ('Location: complete.html');
			mysqli_close($dbc);
			exit();

		}
	}
	else{
		$to=$email;
		$subject="Подтверждение электронной почты";
		$body='Здраствуйте, <br/> <br/> Нам необходимо убедиться, что вы действительно хотите зарегестрироваться на нашем сервисе. Для этого вам необходимо подтвердить аккаунт, перейдя по ссылке ниже:<br/> <br/> 
		<a href="'.$base_url.'/activation.php?mailkey='.$mailkey.'">'.$base_url.'/activation.php?mailkey='.$mailkey.'</a>';
		$sending = sendemail($to, $subject, $body);
		
		$query = "SELECT * FROM `signup` WHERE email = '$email'";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data) == 0) {
			$query ="INSERT INTO `signup` (email, password, mailkey, ok, vk_uid) VALUES ('$email', SHA('$confirmation'), '$mailkey', '0', '0')";
			mysqli_query($dbc, $query);
			header ('Location: complete.html');
			mysqli_close($dbc);
			exit();
		}			
	}
	return $info_reg;
};

function login(){
	global $dbc;
	$user_email = mysqli_real_escape_string($dbc, trim($_POST['email1']));
	$user_password = mysqli_real_escape_string($dbc, trim($_POST['password1']));
	if(!empty($user_email) && !empty($user_password)) {
		$query = "SELECT `user_id` , `email` FROM `signup` WHERE email = '$user_email' AND password = SHA('$user_password')";
		$data = mysqli_query($dbc, $query);
		if(mysqli_num_rows($data) == 1) {
			$row = mysqli_fetch_assoc($data);
			setcookie('user_id', $row['user_id'], time() + (60*60*24*30));
			setcookie('email', $row['email'], time() + (60*60*24*30));
			$home_url = 'index.php';
			header('Location: '. $home_url);
		}
		else {
			$info_login = 'Извините, вы должны ввести правильные имя пользователя и пароль';
		} 
	}
	return $info_login;
};

function vk_api(){
	global $dbc;
	$client_id = '6876897'; // ID приложения
	$client_secret = 'oulBGgQa62TkIxfxG7hd'; // Защищённый ключ
	$redirect_uri = 'http://localhost'; // Адрес сайта

	$url = 'http://oauth.vk.com/authorize';

	$params = array(
		'client_id'     => $client_id,
		'redirect_uri'  => $redirect_uri,
		'response_type' => 'code'
	);

	if (isset($_GET['code'])) {
		$result = false;
		$params = array(
			'client_id' => $client_id,
			'client_secret' => $client_secret,
			'code' => $_GET['code'],
			'redirect_uri' => $redirect_uri
		);
		$token = json_decode(file_get_contents('https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params))), true);

		if (isset($token['access_token'])) {
			$params = array(
				'user_ids'         => $token['user_id'],
				'fields'       => 'uid',
				'access_token' => $token['access_token'],
				'v'            => '5.92'
			);
			$userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);
			
			if (isset($userInfo['response'][0]['id'])) {
				$userInfo = $userInfo['response'][0];
				$result = true;
			}
		}
		if ($result) {
			$_SESSION['user'] = $userInfo['id'];
			setcookie('user', $userInfo['id'], time() + (60*60*24*30));
		}
	}
}

function vk(){
	global $dbc;
	vk_api();

	$link = '<a href="' . $url . '?' . urldecode(http_build_query($params)) . '">ВКонтакте</a>';

	$vkid = $_COOKIE['user'];
	$query1 = "SELECT email FROM signup WHERE vk_uid = '$vkid'";
	$result1 = mysqli_query($dbc, $query1);
	$data = mysqli_fetch_row($result1);
	setcookie('email', $data[0], time() + (60*60*24*30));
	header ("Location: index.php");
	mysqli_close($dbc);
	exit();
};

function userdelete(){
	global $dbc;
	$mail = $_COOKIE['email'];
	$query ="DELETE FROM signup WHERE email = '$mail'";
	$result = mysqli_query($dbc, $query);
	unset($_COOKIE['user_id']);
	unset($_COOKIE['email']);
	setcookie('user_id', '', -1, '/');
	setcookie('email', '', -1, '/');
	header('Location: index.php');
	mysqli_close($dbc);
	exit();
};

function createrec(){
	global $dbc;
	$cremail = $_COOKIE['email'];
	$crtopic = mysqli_real_escape_string($dbc, trim($_POST['topic']));
	$crname = mysqli_real_escape_string($dbc, trim($_POST['name']));
	$crtext = mysqli_real_escape_string($dbc, trim($_POST['note1']));
	$crpassword = mysqli_real_escape_string($dbc, trim($_POST['password']));
	$crdate = date("Y-m-d H:i:s");
	$query ="INSERT INTO `records` (cremail, crtopic, crname, crtext, crpassword, crdate) VALUES ('$cremail', '$crtopic', '$crname', '$crtext', '$crpassword', '$crdate')";
	mysqli_query($dbc, $query);
	header ('Location: diary.php');
	mysqli_close($dbc);
	exit();
};

function deleterec(){
	global $dbc;
	$name = mysqli_real_escape_string($dbc, trim($_POST['ide']));
	$query ="DELETE FROM records WHERE crname = '$name'";
	$result = mysqli_query($dbc, $query);
	header ('Location: diary.php');
	mysqli_close($dbc);
	exit();
};

function vkset(){
	global $dbc;
	$mail = $_COOKIE['email'];
	vk_api();

	$link = '<a href="' . $url . '?' . urldecode(http_build_query($params)) . '">ВКонтакте</a>';

	$vkid = $_COOKIE['user'];
	$query2 ="UPDATE signup SET vk_uid='$vkid' WHERE email='$mail'";
	$result2 = mysqli_query($dbc, $query2);
	header ("Location: diary.php");
	mysqli_close($dbc);
	exit();
};

function createtable(){
	global $dbc;
	$mail = $_COOKIE['email'];
	$query ="SELECT * FROM records WHERE cremail = '$mail'";
	$result = mysqli_query($dbc, $query);
	if($result) {
		$rows = mysqli_num_rows($result);
		for ($i = 0 ; $i < $rows ; ++$i) {
			$row = mysqli_fetch_row($result);
			echo "<tr>";
				if ($j = 6) echo "<td>$row[$j]</td>";
				if ($j = 2) echo "<td >$row[$j]</td>";
				if ($j = 3) echo "<td id='$i'>$row[$j]</td>";
				if ($j = 100) echo "<td><button class='knopka' id='$i' onclick='zap($i)'><a>Открыть запись</a></button> 
										<button class='knopka' value='$row[3]'  onclick='dl($i)'><a>Удалить запись</a></button></td>";
				if ($j = 7) echo "<td style='visibility: hidden;'>$row[0]</td>";
			echo "</tr>";
		}
		echo "</table>";
		
		mysqli_free_result($result);
	}
	mysqli_close($dbc);
};

function passrestore(){
	global $dbc;
	$email = mysqli_real_escape_string($dbc, trim($_POST['email']));
	if (empty($_POST['email'])) {
		$text = '<p><a>Вы не ввели почту</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
	else{
		$zapros = "SELECT 'user_id' FROM signup WHERE email = '$email'";
		$sql = mysqli_query($dbc, $zapros);
		if (mysqli_num_rows($sql)==1) {
			$simv = array ("92", "66", "45", "4", "36", "22", "k", "l", "m", "n", "o", "p", "W", "B", "A", "U", "Z", "S",);
			for ($k = 0; $k < 8; $k++) {
				shuffle ($simv);
				$string = $string.$simv[1];
			}
			$zapros = "UPDATE signup SET password = SHA('$string') WHERE email = '$email'";
			$sql = mysqli_query($dbc, $zapros);

			$to=$email;
			$subject="Восстановление пароля";
			$body='Здраствуйте, <br/> <br/> Вот ваш новый пароль: '.$string.'';
			$sending = sendemail($to, $subject, $body);;
			$text = '<p><a>Письмо с новым паролем отправлено вам на почту</a></p>';
			echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
		}
		else{
			$text = '<p><a>Такого e-mail у нас не зарегистрировано!</a></p>';
			echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
		}
	}
};

function passchange(){
	global $dbc;
	$email = $_COOKIE['email'];
	$old = mysqli_real_escape_string($dbc, trim($_POST['old']));
	$new = mysqli_real_escape_string($dbc, trim($_POST['new']));
	$newconf = mysqli_real_escape_string($dbc, trim($_POST['newconf']));
	$zapros= "SELECT password FROM signup WHERE email = '$email'";
	$sql = mysqli_query($dbc, $zapros);
	$arr = mysqli_fetch_assoc($sql);
	if(empty($_POST['old'])){
		$text = '<p><a>Вы не ввели старый пароль</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
	else if(empty($_POST['new'])){
		$text = '<p><a>Вы не ввели новый пароль</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
	else if(empty($_POST['newconf'])){
		$text = '<p><a>Вы не ввели подтверждение пароля</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
	else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z!@#$%]{8,50}$/', $new)){
		$text = '<p><a>Пароль должен содержать хотя бы одну строчную и одну заглавную буквы и состоять из 8 символов</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
	else if(sha1($old) != $arr['password']){
		$text = '<p><a>Старый пароль введен неверно</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
	else if($new != $newconf){
		$text = '<p><a>Введенные пароли не совпадают</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
	else{
		$zapros = "UPDATE signup SET password = SHA('$newconf') WHERE email = '$email'";
		$sql = mysqli_query($dbc, $zapros);
		$text = '<p><a>Пароль успешно изменен!</a></p>';
		echo("<script type='text/javascript'>$('#message').html('".$text."')</script>");
	}
};

function recnameload($id){
	global $dbc;
	if(!empty($_GET['id']) && isset($_GET['id'])) {
		$id=mysqli_real_escape_string($dbc, $_GET['id']);
		$c=mysqli_query($dbc,"SELECT crname FROM records WHERE id='$id'");
		if(mysqli_num_rows($c) > 0){
			$query2 = "SELECT crname FROM records WHERE id = '$id'";
			$result2 = mysqli_query($dbc, $query2);
			$data2 = mysqli_fetch_row($result2);
		}
	}
	return $data2[0];
};

function recpassload($id){
	global $dbc;
	if(!empty($_GET['id']) && isset($_GET['id'])) {
		$id=mysqli_real_escape_string($dbc, $_GET['id']);
		$c=mysqli_query($dbc,"SELECT crname FROM records WHERE id='$id'");
		if(mysqli_num_rows($c) > 0){
			$query1 = "SELECT crpassword FROM records WHERE id = '$id '";
			$result1 = mysqli_query($dbc, $query1);
			$data1 = mysqli_fetch_row($result1);
		}
	}
	return $data1[0];
};

function rectextload($id){
	global $dbc;
	if(!empty($_GET['id']) && isset($_GET['id'])) {
		$id=mysqli_real_escape_string($dbc, $_GET['id']);
		$c=mysqli_query($dbc,"SELECT crname FROM records WHERE id='$id'");
		if(mysqli_num_rows($c) > 0){
			$query = "SELECT crtext FROM records WHERE id = '$id'";
			$result = mysqli_query($dbc, $query);
			$data = mysqli_fetch_row($result);
		}
	}
	return $data[0];
};

function edit(){
	global $dbc;
	$otred = mysqli_real_escape_string($dbc, trim($_POST['encr']));
	$id=mysqli_real_escape_string($dbc, $_GET['id']);
	$query ="UPDATE records SET crtext='$otred' WHERE id='$id'";
	$result = mysqli_query($dbc, $query);
	header ("Location: rec.php?id=$id");
	mysqli_close($dbc);
	exit();
};

function logout(){
	global $dbc;
	unset($_COOKIE['user_id']);
	unset($_COOKIE['email']);
	setcookie('user_id', '', -1, '/');
	setcookie('email', '', -1, '/');
	header('Location: index.php');
};

function vksetcookies(){
	global $dbc;
	vk_api();

	$link = '<a href="' . $url . '?' . urldecode(http_build_query($params)) . '">ВКонтакте</a>';
	echo("<script type='text/javascript'>$('#vkreg').html('".$link."')</script>");
	
	$link = 'Ваш vk id: '.$_COOKIE['user'].'';
	echo("<script type='text/javascript'>$('#vkreginfo').html('".$link."')</script>");
};

function sendemail($toemail, $subject, $message) {
	date_default_timezone_set("Europe/Moscow"); // устанавливаем часовую зону
	require "PHPMailer/PHPMailerAutoload.php"; // подключаем файл автозагрузки
	$mail = new PHPMailer;
	$mail->CharSet = 'UTF-8';

	// Настройки SMTP
	$mail->isSMTP();
	$mail->SMTPAuth = true;

	$mail->Host = 'ssl://smtp.gmail.com';
	$mail->Port = 465;
	$mail->Username = 'diskibin';
	$mail->Password = 'Dimas2197';

	$mail->setFrom("diskibin@gmail.com", "CryptoDiary");       
	$mail->addAddress($toemail, $toemail); 
	$mail->Subject = $subject;
	$mail->msgHTML($message);

	$mail->send();
};
?>