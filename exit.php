<?php
unset($_COOKIE['email']);
setcookie('email', '', -1, '/');
header('Location: http'.(isset($_SERVER['HTTPS']) ? 's' : '').'://'.$_SERVER['SERVER_NAME'].'/HtmlPage.php', true, 302);

?>

