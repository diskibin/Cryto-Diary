<?php
include 'bootstrap.php';
userdelete();
createrec();
deleterec();
vkset();
logout();
?>


<!DOCTYPE HTML>

<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <title> Дневник </title>
    <link rel="stylesheet" type="text/css" href="styles/3.css">
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
    $email = $_COOKIE['email'];
    $query ="SELECT ok FROM signup WHERE email = '$email'";
    $result = mysqli_query($dbc, $query);
    $data = mysqli_fetch_row($result);
    if(empty($_COOKIE['email'])) 
    {
?> 

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-sm-12">
				<div class="col-12-1">
                    <p>Для того, чтобы пользоваться сервисом, вам необходимо совершить авторизацию</p>
                    <p>(или регистрацию)</p>
				</div>
			</div>
		</div>
    </div>
    
    <div class="container">
		<div class="row justify-content-center">
	
			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
						<p><a href="index.php" class="knopka">Вернуться на главную</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php 
    } 
    elseif($data[0] == 0) 
    { 
?> 

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-12 col-sm-12">
				<div class="col-12-1">
                    <p>Для того, чтобы пользоваться сервисом, вам необходимо подтвердить почту</p>
				</div>
			</div>
		</div>
    </div>
    
    <div class="container">
		<div class="row justify-content-center">
	
			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
						<p><a href="index.php" class="knopka">Вернуться на главную</a></p>
					</div>
				</div>
			</div>
		</div>
    </div>
    
<?php } elseif($data[0] == 1 && !empty($_COOKIE['email'])) {?> 

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-4 col-sm-12">
				<div class="col-12-1">
					<p>Ваши записи</p>
				</div>
			</div>
		</div>
	</div>
	<hr color=#faffff width=80%>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8 col-sm-12">
				<div class="col-12-6">
                    <p>На этой странице можно увидеть имеющиеся и добавить новые записи в ваш дневник</p>
                    <br>
                    <p>Имеющиеся записи <?php if(empty($_COOKIE['email'])) {?> <?php } else { ?> пользователя <?php echo $_COOKIE['email']; ?> <?php } ?></p>
                    <?php if(empty($_COOKIE['email'])) {?> <?php } else { ?> 
                    <center>
                    <div class="row justify-content-center">
                        <form method="POST"action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <button name="logout" class="submit">Выйти из аккаунта</button>
                        <button class="submit" formaction="passchange.php">Изменить пароль</button>
                        <button name="vkconnect" class="submit">Подключить ВК</button>
                        <button name="delete" class="submit">Удалить аккаунт</button>
                        </form>
                    </div>
                    </center>
                    <?php } ?>
				</div>
			</div>
		</div>
    </div>
    <br>

    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="table-responsive">
                    <table id="notes" class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="width:20%"><div class="col-12-9"><p>Дата создания</p></div></th>
                                <th scope="col" style="width:20%"><div class="col-12-9"><p>Тема</p></div></th>
                                <th scope="col" style="width:20%"><div class="col-12-9"><p>Название</p></div></th>
                                <th scope="col" style="width:35%"><div class="col-12-9"><p>Действия</p></div></th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        createtable()
                        ?>

                        </tbody>
                    </table>
            </div>
        </div>
    </div>
    <br>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12">
                <div class="col-12-6">
                    <div class="form-group">
                        <input class="form-control" type="text" placeholder="Поиск по теме" id="search-text" onkeyup="myFunction()">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>    

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12">
                <div class="col-12-6">
                    <p>Добавление новой записи</p>
                </div>
            </div>
        </div>
    </div>
    <hr color=#faffff width=70%>

    <form method="POST"action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <div class="container">
		<div class="row justify-content-center">

			<div class="col-md-2 col-sm-12">
				<div class="row">
					<div class="col-12">
                        <p>Тема</p>
                        <hr color=#faffff width=100%>
                        <input type="text" class="kkk" name="topic" size="15">
					</div>
				</div>
            </div>
            
            <div class="col-md-2 col-sm-12">
				<div class="row">
					<div class="col-12">
                        <p>Название</p>
                        <hr color=#faffff width=100%>
                        <input type="text" class="kkk" name="name" size="15">
					</div>
				</div>
			</div>

			<div class="col-md-2 col-sm-12">
				<div class="row">
					<div class="col-12">
                        <p>Ключ</p>
                        <hr color=#faffff width=100%>
                        <input type="text" class="kkk" name="password" id="password" size="15">
					</div>
				</div>
			</div>

			<div class="col-md-4 col-sm-12">
				<div class="row">
					<div class="col-12">
                        <p>Текст записи</p>
                        <hr color=#faffff width=100%>
                        <input type="text" class="kkk" name="note" id="note" size="35">
					</div>
				</div>
			</div>

		</div>
    </div>

	<div class="container">
		<div class="row justify-content-center">

			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
                        <button name="sipr" id="submit" class="knopka" onclick=crypt()><a>ЗАШИФРОВАТЬ</a></button>
					</div>
				</div>
			</div>

		</div>
    </div>

    <input type="hidden" class="kkk" name="note1" id="note1" size="35">
    <input type="hidden" class="kkk" name="ide" id="ide" size="35">
    <form method="POST" id='qwerty' action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <button name="del" id='del' class='submit' style="visibility: hidden;"></button>
    </form>

    </form>

    <div class="container">
		<div class="row justify-content-center">
	
			<div class="col-md-3 col-sm-12">
				<div class="row justify-content-center">
					<div class="col-12-2">
						<p><a href="index.php" class="knopka">Вернуться на главную</a></p>
					</div>
				</div>
			</div>
		</div>
    </div>


    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
    <script type="text/javascript" src="tablesorter/jquery-latest.js"></script> 
    <script type="text/javascript" src="tablesorter/jquery.tablesorter.js"></script> 
    <script type="text/javascript">
    function zap(q){
        var z = document.getElementById('notes').rows[q+1].cells[4].innerHTML;
        window.location = "rec.php?id=" + z;
    }

    function crypt(){
        var note = document.getElementById("note").value;
        var password = document.getElementById("password").value;

        var encrypted = CryptoJS.AES.encrypt(note, password).toString();

        document.getElementById('note1').value = encrypted;

    }

    function dl(z){
        var val = document.getElementById(z).innerHTML;
        document.getElementById('ide').value = val;
        document.getElementById('del').click();
    }

    function myFunction() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-text");
        filter = input.value.toUpperCase();
        table = document.getElementById("notes");
        tr = table.getElementsByTagName("tr");

        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            } 
        }
    }

    $(document).ready(function() 
        { 
            $("#notes").tablesorter({
        headers: {  
            1: { sorter: false }, 
            2: { sorter: false },  
            3: { sorter: false } 
        } 
    }); 
});
    
    </script>

</body>
<?php } ?>
</html>