<?
	include_once 'db.php';
	$email = $_COOKIE['email'];
	$user = getUserInfo($email, $connection);
	if(isset($email))
		add_filter($connection, $user);
?><!DOCTYPE html>
<html>
<head>
	<title>COW</title>
	<meta  charset="utf-8" >
	<link href="CSS/StyleSheet.css" type="text/css" rel="stylesheet">
	<link href="CSS/HeaderStyles.css" type="text/css" rel="stylesheet">
	<link href="CSS/StyleLoad.css" type="text/css" rel="stylesheet">
	<link rel="shortcut icon" href="Images/fox.jpg" type="image/png">
	<script src="Scripts/jquery-3.2.1.js"></script>
	<script src="Scripts/loadContent.js"></script>
</head>
<body onload="loadContent();">
	<!--<h1></h1>-->
	
	<div id="header">
		<header>
			<div id="headerCase">

			<div class="image">
				<a href="HtmlPage.php"><img src="../Images/Н.png" align="left" width="450px" height="125px"  /></a>
			</div>

				<!--Кнопки додому і категорії-->
			<div class="hedderButtons">
				<ul class="menu">
                    <form action="HtmlPage.php">
                        <button id="headerHome" class="buttons">Home</button>
                    </form>
				</ul>
                </div>

				<div class="hedderButtons">
					<ul class="menu">
						<li class="menu__list">
						<!--<a class="main-item" href="javascript:void(0);" tabindex="1" >Открыть подменю</a> -->
							<button id="headerCategories" class="buttons" tabindex="1" >Categories</button>
							<ul class="menu__drop">
							</ul>
						</li>
					</ul>
				</div>
				<!--Кнопка логіну-->
			<div class="hedderButtons">
					<ul class="menu">
				<form action="
				<?if($user == null)echo 'Login.php';else echo 'Cabinet.php';?>
				">   <button onclick="document.getElementById('id01').style.display = 'block'" id="headerLogin" class="buttons">
					<?if($user == null)echo 'Login';else echo $user->username;?>
				</button></form>
				</ul>
				</div>



                <!--Поле пошуку-->
                <div class="hedderButtons">
					<ul class="menu">
                <?
                if($user != null)
						{
							echo '
								<form class="search-form" action="search.php" method="POST">
								<div class="hedderButtons">
								<input id="search" name="search-form" minlength ="1" type="text" placeholder="Search" class="button">
								</div>
								<input type="submit" name="submit" value="OK" class="button" />
								</form>';
						}
				?>
				
					</ul>
				</div>
			</div>
		</header>
	</div>

	
	<div id="main">
	</div>
	
	
	<div id = "toTop" > ^  </div >
</body>
</html>