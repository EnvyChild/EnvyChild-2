<?php
	include_once 'db.php';

	$email = $_COOKIE['email'];
	$user = getUserInfo($email, $connection);
	if(!isset($user))
	{
		//header('HTTP/1.1 403 Forbidden', true, 403);
		header('Location: http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['SERVER_NAME'].'/error.php'/*, true, 403*/);
        include_once 'db-close.php';
        exit();
	}

	function changePassword(&$connection, &$pass, &$email)
	{
		$pass = mysqli_real_escape_string($connection, $pass);
		$query = "UPDATE `person` SET `password` = '$pass' WHERE `email` = '$email';";
		// UPDATE `person` SET `password` = '456' WHERE `email` = 'testtest';
		mysqli_query($connection, $query);
	}
	if(isset($_POST['newpassword']) && $_POST['changePassword'] == 1)
	{
		changePassword($connection, $_POST['newpassword'], $email);
	}
	if($_POST['submit'] == 'delete')
	{
		remove_filter($connection, $user);
	}

	$filtersList = json_decode($_COOKIE['filters']);
?><!DOCTYPE html>
<html>
<head>
	<link href="CSS/StyleCabinet.css" type="text/css" rel="stylesheet">
    <link rel="shortcut icon" href="Images/fox.jpg" type="image/png">

	<title>Account</title>
	<meta  charset="utf-8" >
</head>
<body>
<header>
	<div id="HeaderCase">
		<div class="image">
			<a href="HtmlPage.php"><img src="../Images/qwe.png" align="left" width="450px" height="150px"  /></a>
		</div>

			<div>
			<a href ="exit.php">
			<button class="buttonExit"> Exit </button></a>
		</div>
	</div>
</header>

	<div class="four">
		<h1>
			Join the news center to receive the latest news, important information and opportunities for development from over 3 million locations worldwide. 
			It's free! 
		</h1>
	</div>



	<div class ="sectionTitle">
	<div class ="sectionTitle1">
		<div id="titleLike" class="like">Like</div>
        <div id="containerLike" class="z">
        	<?php
        		for($i = 0; $i < count($filtersList); ++$i)
				{
					if($filtersList[$i]->status == '+')
					{
			?>		
			</div>
			 <div id="containerLike" class="z">
					<div class="filterContainer">
						<form action="" method="post"><?=$filtersList[$i]->category?>
							<input type="hidden" name="category" value="<?=$filtersList[$i]->category?>" />
							<input type="submit" name="submit" value="delete" />
						</form>
					</div>
			<?php
					}
				}
        	?>
        </div>
    </div>
	</div>
	
	    <div class ="sectionTitle">
    <div class ="sectionTitle2">
		<div id="titleDislike" class="dislike">Dislike</div>
        <div id="containerDislike" class="z">
        	<?php
        		for($i = 0; $i < count($filtersList); ++$i)
				{
					if($filtersList[$i]->status == '-')
					{
			?>
			</div>
			 <div id="containerDislike" class="z">
					<div class="filterContainer">
						<form action="" method="post"><?=$filtersList[$i]->category?>
							<input type="hidden" name="category" value="<?=$filtersList[$i]->category?>" />
							<input type="submit" name="submit" value="delete" />
						</form>
					</div>
			<?php
					}
				}
        	?>

        </div>	
        </div>
    </div>
	<div class="contU">
		<div id="wrapper">
			<div class="border">
				<div class="qwerty">
					<div class="form-group">
						<ul class="menu">
							<h3><b class="bt">Username</b></h3>
						</ul>
					</div>
				<div class="q">
					<div id="usernameField">
					<?php
						if($user == null)
						{
							echo 'guest';
						}
						else
						{
							echo $user->username;
						}
					?>
					</div>
				</div>
			</div>
				<div class="qwerty">
					<div class="form-group">
						<ul class="menu">
							<h3><b class="bt">E-mail</b></h3>
						</ul>
					</div>
				
					<div class="q">
						<div id="emailField">
						<?php
							if($user == null)
							{
								echo 'guest';
							}
							else
							{
								echo $user->email;
							}
						?>
						</div>
					</div>
				</div>
		</div>

<div class="qwerty">
	<ul class="menu">
		<div>

		<form  action="" method="post">	
		
		
					<!--<form action="HtmlPage.php">
                        <button  class="buttonChange">Change password</button>
                    </form>-->
		

			<input name="newpassword" type="password" class="input password" placeholder="New password"  required="required" onfocus="this.value=''" />
			<input type="submit" name="changePassword" class="button" value="Change" />
		

        </form>
	</div>
	</ul>
	
	</div>
		
</div>	

</div>	
	
	
	
	
	
</body>

</html>