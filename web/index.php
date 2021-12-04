<?php
include '/var/www/ctf/src/core.php';
if (isset($_GET['logout'])) {
	session_destroy();
	header("refresh:0, url=/");
}
includeTemplate('header.php', ['title' => 'Главная', '_SESSION' => $_SESSION]);
?>

<h1>Главная</h1>
<?php
includeTemplate('footer.php');