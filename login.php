<?php
	include_once 'db.php';

	submit_login($connection);
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
    <title> Authorization</title>
    <link href="css/style.css" rel="stylesheet" type="text/css" />
	<link rel="shortcut icon" href="Images/fox.jpg" type="image/png">
</head>


<body>
    <div id="header">
        <header>
            <div id="headerCase">
                <div class="hedderButtons">
                    <form action="HtmlPage.php">
                        <button id="headerHome" class="buttons"> << </button>
                    </form>
                </div>
            </div>
        </header>
    </div>
    <div id="wrapper">
            <form name="login-form" class="login-form" action="" method="POST">

                <div class="header">
                    <h1>Authorization</h1>
                    <span> Enter your information to enter your personal account. </span>
                </div>

                <div class="content">
                    <input name="username" type="text" class="input username" value="" placeholder="Login" required="required" onfocus="this.value=''" />
                    <input name="password" type="password" class="input password" value="" placeholder="Password" required="required" onfocus="this.value=''" />
                </div>

                <div class="footer">
                    <input type="submit" name="submit" value="Login" class="button" />
                    <input type="button" name="submit" class="register" value="Registration" onclick="location.href='registration.php';"/>
                </div>
               

            </form>
        </div>
    

</body>
</html>