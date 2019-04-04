<?php
include 'index.php';
    $msg='';
    if(!empty($_GET['mailkey']) && isset($_GET['mailkey']) )
    {
        $mailkey=mysqli_real_escape_string($dbc, $_GET['mailkey']);
        $c=mysqli_query($dbc,"SELECT user_id FROM signup WHERE mailkey='$mailkey'");
        if(mysqli_num_rows($c) > 0)
        {
            $count=mysqli_query($dbc,"SELECT user_id FROM signup WHERE mailkey='$mailkey' and ok='0'");
            if(mysqli_num_rows($count) == 1) 
            {
                mysqli_query($dbc,"UPDATE signup SET ok='1' WHERE mailkey='$mailkey'");
                $msg="<center>Ваш аккаунт активирован</center>"; 
            }
            else
            {
                $msg ="<br><div class='col-12-2'><center><p>Ваш аккаунт уже активирован, нет необходимости активировать его снова.</p></center></div>";
            }
        }
        else
        {
            $msg ="<center>Неверный код активации.</center>";
        }
    }
?>
<?php echo $msg; ?>