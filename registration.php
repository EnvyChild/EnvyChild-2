<?php
    include 'db.php';

    submit_registration($connection);
    if(isset($user))
    {
        setcookie('email', $user->email, time()+(60*60*24*30));//кукі зберігаються 1 місяць
        header('Location: http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['SERVER_NAME'].'/Cabinet.php', true, 302);
        include_once 'db-close.php';
        exit;
    }

    include_once 'db-close.php';
?><!DOCTYPE html>
<html>
<head>
    <title> Registration</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
   <link rel="shortcut icon" href="Images/fox.jpg" type="image/png">
</head>


<body>
    <div id="header">
        <header>
            <div id="headerCase">
                <div class="hedderButtons">
                    <form action="login.php">
                        <button id="headerHome" class="buttons"> << </button>
                    </form>
                </div>
            </div>
        </header>
    </div>
    <div id="wrapper">
        <!--<div class="user-icon"></div>
        <div class="pass-icon"></div>-->

        <form name="login-form" class="login-form" action="" method="post">

            <div class="header">
                <h1>Registration</h1>
                <span> Enter your information to registration. </span>
            </div>

            <div class="content">


                <input name="email" type="text" class="input e-mail" placeholder="E-mail" id="socialLink" required="required" onfocus="this.value=''" />
                <input name="username" type="text" class="input username" placeholder="Login" id="Login" required="required" onfocus="this.value=''" />
                <input name="password" type="password" class="input password" placeholder="Password" id="Pasword" required="required" onfocus="this.value=''" />
                <input name="password2" type="password" class="input password" placeholder="Password again" id="Pasword2" required="required" onfocus="this.value=''" />




            </div>

            <div class="footer">
                <!--<input type="submit" name="submit" value="Login" class="button" />-->
                <input onclick="Register()"  type="submit" name="submit" value="Registration" class="button" />
            </div>
            


        </form>
    </div>
    <div class="gradient"></div>

</body>
</html>