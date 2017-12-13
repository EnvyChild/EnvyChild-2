<?php
include_once 'db.php';
	$email = $_COOKIE['email'];
	$user = getUserInfo($email, $connection);
$submit = $_POST ['submit'];
$keyWord = $_POST ['search-form'];
if(!isset($_POST['search-form']) && isset($_POST['searchText']))
{
	$keyWord = $_POST['searchText'];
}
if(!isset($_POST['page']))
	$page = 1;
else
{
	$page = $_POST['page'];
	if(isset($_POST['next']))
		++$page;
	if(isset($_POST['prev']) && $page > 1)
		--$page;
}

if($submit || $_POST['next'] || $_POST['prev'])
{
	if(strlen($keyWord) >= 1)
			{
				$counter = 0;
				$url = 'https://newsapi.org/v2/everything?q='.$keyWord.'&page='.$page.'&apiKey=d3b64cd0b8fc4530bb2d3b2e3d8bd869';
				$content = json_decode(file_get_contents($url));
			}
}
?><!DOCTYPE html>
<html>
	<head>
		<title>Search results (page <?=$page;?>)</title>
		<link href="CSS/StyleSheet.css" type="text/css" rel="stylesheet">
		<link href="CSS/HeaderStyles.css" type="text/css" rel="stylesheet">
		<link href="CSS/StyleLoad.css" type="text/css" rel="stylesheet">
	</head>
	<body>
		<div id="header">
		<header>
			<div id="headerCase">

			<div class="image">
				<a href="HtmlPage.php"><img src="../Images/qwe.png" align="left" width="450px" height="125px"  /></a>
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

		<div id="main">													<!--контейнер в якому з'являються новини-->
			<?php
			if(strlen($keyWord) <= 1)
			{	
				echo 'Word is to short';
			}
			else
			{
				while($content->articles[$counter]->title)
					{
						//самі контейнери з новинами, в дів можна будь що дописувати, не використовуй подвійні лапки
						echo "<div class = 'topic'><a href = ".$content->articles[$counter]->url."><span class = 'title'>".
						$content->articles[$counter]->title."</span><span class = 'publisedDate'>".$content->articles[$counter]->publishedAt.
						"</span></a><hr /><div><img class ='img' alt='image not found' src='".$content->articles[$counter]->urlToImage.
						"' /></div><hr /><div class='description'>".$content->articles[$counter]->description."</div></div>";
						$counter = $counter + 1;
					}
					if($counter <= 1)
					{
						echo "No results found";
					}
			}
			?>
																				<!--кнопки прогортування-->
			<div class="scrolingButtons">
				<form action"" method="post">
					<input class="butt1" type="submit" name="prev" value=" << " />
					<input class="butt2" type="submit" name="next" value=" >> " />
																				<!--ці поля не трогати-->
					<input type="hidden" name="page" value="<?=$page;?>" />
					<input type="hidden" name="searchText" value="<?=$keyWord;?>" />
				</form>
			</div>
		</div>
	</body>

</html>