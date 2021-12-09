<?php
include '/var/www/ctf/src/core.php';
includeTemplate('header.php', ['title' => 'Главная', '_SESSION' => $_SESSION]);
$id = $_SESSION['team_id'];
$onRoute = $pdo->getData("SELECT on_route FROM teams WHERE team_id = $id")[0]['on_route'];
$top[] = $pdo->getData("select top_score(3)");
$top[] = $pdo->getData("select top_score(5)");
$top[] = $pdo->getData("select top_score(7)");
?>
<main class="container-xxl">
<h1>Главная</h1>
<h5>Топ 3</h5>

<?php foreach ($top as $value) { ?>
<table>
	<thead>
		<th>Название команды</th>
		<th>Счет</th>
	</thead>
	<tbody>
<?php 
foreach ($value as $team) {
	$team = explode(',', str_replace(['(', ')'], '', $team['top_score']));
	$teamName = $team[0];
	$teamScore = $team[1];
?>
<tr>
<td><?=$teamName?></td>
<td><?=$teamScore?></td>
</tr>
<?php } ?>
	</tbody>
</table>
<?php } 
if ($onRoute) {
	$buttonText = 'Продолжить выполнение заданий';
} else {
	$buttonText = 'Начать выполнение заданий';
}
?>
<button onclick="location.href = '/task/'"><?=$buttonText?></button>
</main>
<?php
includeTemplate('footer.php');