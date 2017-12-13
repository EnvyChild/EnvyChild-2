<?php
require_once 'user.php';
require_once 'filter.php';
if(!isset($connection))
{
	$connection = mysqli_connect('localhost', 'root', '', 'WEB_project');
	if($connection == false)
	{
		echo'Error with connection to database!';
		echo mysqli_connect_error();
		exit();
	}
}

function add_filter(&$connection, &$user)
{
	$selectQuery = 'Select category, status From `Filter` Where person = '.$user->id.';';
	$selectResult = mysqli_query($connection, $selectQuery);
	//print_r($selectResult);
	//
	$jsonString = '';
	$selectRow = null;
	$selectRow = mysqli_fetch_assoc($selectResult);
	while(isset($selectRow))
	{
		$jsonString .= ',{"category":"'.$selectRow['category'].'","status":"'.$selectRow['status'].'"}';
		$selectRow = mysqli_fetch_assoc($selectResult);
	}
	$jsonString = '['.substr($jsonString, 1).']';
	setcookie('filters', $jsonString);
	//*/
	if(!isset($_POST['status'])) return;

	$person = $user->id;
	$category = mysqli_real_escape_string($connection, trim($_POST['category']));
	$status = mysqli_real_escape_string($connection, $_POST['status']);


	//$query = "UPDATE `Filter` (person, category, status) VALUES ('$person', '$category', '$status') WHERE ?=?;";
	$query = "INSERT INTO `Filter` (person, category, status) VALUES ('$person', '$category', '$status');";
	//setcookie('query', $query);
	mysqli_query($connection, $query);
	global $filter;
	$filter = new Filter();
	$filter->set($person, $category, $status);
}
function remove_filter(&$connection, &$user)
{
	$deleteQuery = 'DELETE FROM `Filter` WHERE `person`=\''.$user->id.'\' && `category`=\''.$_POST['category'].'\';';
	$deleteResult = mysqli_query($connection, $deleteQuery);
	//
	$selectQuery = 'Select category, status From `Filter` Where person = '.$user->id.';';
	$selectResult = mysqli_query($connection, $selectQuery);
	$jsonString = '';
	$selectRow = null;
	$selectRow = mysqli_fetch_assoc($selectResult);
	while(isset($selectRow))
	{
		$jsonString .= ',{"category":"'.$selectRow['category'].'","status":"'.$selectRow['status'].'"}';
		$selectRow = mysqli_fetch_assoc($selectResult);
		//echo '<p>'.$jsonString.'<p/>';
	}
	$jsonString = '['.substr($jsonString, 1).']';
	//echo '<p>'.$jsonString.'<p/>';
	setcookie('filters', '', time() - 60);
	setcookie('filters', $jsonString);
}


function submit_registration(&$connection)
{
	if(!isset($_POST['submit'])) return;

	$username = mysqli_real_escape_string($connection, trim($_POST['username']));
	$email = mysqli_real_escape_string($connection, trim($_POST['email']));
	$password = mysqli_real_escape_string($connection, $_POST['password']);
	$password2 = mysqli_real_escape_string($connection, $_POST['password2']);

if($password==$password2)
{
	$query = "SELECT * FROM `person` WHERE username = '$username'";
	$data = mysqli_query($connection, $query);

	if(mysqli_num_rows($data) == 0)
	{
		$query = "INSERT INTO `person` (username, email, password) VALUES ('$username', '$email', '$password') ";
		mysqli_query($connection, $query);
		global $user;
		$user = new User();
		$user->set($username, $email, $password, $row['id']);
	}
}
else 
{
	$message = "Check your fields";
	echo "<script type='text/javascript'>alert('$message');</script>";
	 //header('Location: http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['SERVER_NAME'].'/error.php', true, 302);
}
}


function submit_login(&$connection)
{
	if(!isset($_POST['submit'])) return;

	$username = mysqli_real_escape_string($connection, trim($_POST['username']));
	$password = mysqli_real_escape_string($connection, trim($_POST['password']));

	$query = "SELECT * FROM `person` WHERE username = '$username'";
	$data = mysqli_query($connection, $query);
	if(mysqli_num_rows($data) > 0)
	{
		$row = $data->fetch_assoc();
		while($row)
		{
			if($row['password'] == $password)
			{
				global $user;
				$user = new User();
				$user->set($username, $row['email'], $password, $row['id']);
				return $user;
			}
			$row = $data->fetch_assoc();
		}
	}
	else 
	{
		$message = "Check your fields";
		echo "<script type='text/javascript'>alert('$message');</script>";
		//header('Location: http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['SERVER_NAME'].'/login.php', true, 302);
	}
	return null;
}


function getUserInfo(&$email, &$connection)
{
	if(!isset($user))
	{
		global $user;
		$user = null;
	}
	$query = "SELECT * FROM `person` WHERE email = '$email'";
	$result = mysqli_query($connection, $query);
	if(!isset($result) || mysqli_num_rows($result) == 0)
	{
		$user == null;
		return null;
	}
	$row = $result->fetch_assoc();
	$user = new User();
	$user->set($row['username'], $email, $row['password'], $row['id']);
	return $user;
}


?>