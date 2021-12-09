<?php
include '/var/www/ctf/src/core.php';
includeTemplate('header.php', ['title' => 'Задание', '_SESSION' => $_SESSION]);
$taskNumber = 4;
$taskInfo = $pdo->getData("SELECT * FROM tasks where task_id = $taskNumber")[0];
if (!$taskInfo) {
	header("refresh:0, url=/");
	exit;
}

?>

<form method="post">

<h1>Задание № <?=$taskNumber?></h1>

<h2><?=$taskInfo['task_name']?></h2>

<p><?=$taskInfo['descr']?></p>

<p><input type="text" name="ansver"></p>

<button type="submit">Отправить</button>
</form>


<?php
includeTemplate('footer.php');