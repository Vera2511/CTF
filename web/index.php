<?php
include '/var/www/ctf/src/core.php';
includeTemplate('header.php', ['title' => 'Главная', '_SESSION' => $_SESSION]);
?>

<h1>Главная</h1>
<?php
includeTemplate('footer.php');