<?php
include '/var/www/ctf/src/core.php';
includeTemplate('header.php', ['title' => 'Главная', '_SESSION' => $_SESSION]);
if ($_SESSION) {
$id = $_SESSION['team_id'];
$onRoute = $pdo->getData("SELECT on_route FROM teams WHERE team_id = $id")[0]['on_route'];
}
$top1 = $pdo->getData("select top_score(3) limit 3");
$top2 = $pdo->getData("select top_score(5) limit 3");
$top3 = $pdo->getData("select top_score(7) limit 3");

?>
<main class="container-xxl">
</br></br></br>
    <main class="container-xxl">
        <div class="col-md-4 float-md-end mb-3 ms-md-3 p-3" style="background-color: white; border-radius: 4px;">
            <h5 class="text-center">Топ 3</h5>
            <nav>
                <div class="nav nav-tabs d-flex justify-content-evenly" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">3 игрока</button>
                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">5 игроков</button>
                    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">7 игроков</button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
				<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
					<table class="table">
						<thead>
							<th>Имя</th>
							<th>Счет</th>
						</thead>
						<tbody>
<?php 
foreach ($top1 as $team) {
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
				</div>
				<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
					<table class="table">
						<thead>
							<th>Имя</th>
							<th>Счет</th>
						</thead>
						<tbody>
<?php 
foreach ($top2 as $team) {
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
				</div>
				<div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
					<table class="table">
						<thead>
							<th>Имя</th>
							<th>Счет</th>
						</thead>
						<tbody>
<?php 
foreach ($top3 as $team) {
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
				</div>
			</div>
		</div>
<?php
if (isset($onRoute)) {
	if ($onRoute) {
		$buttonText = 'Продолжить выполнение заданий';
	} else {
		$buttonText = 'Начать выполнение заданий';
	}
	$buttonHref = '/task/';
} else {
	$buttonText = 'Начать';
	$buttonHref = '/registry';
}
?>
		<div class="m-5">
            Формат Сapture the Flag используется в пейнтболе, среди ролевиков, в компьютерных играх и в информационной безопасности. Сapture the Flag или CTF в ИБ — это соревнования в форме командной игры, главная цель которой — захватить «флаг» у соперника в приближенных к реальности условиям. Команды решают прикладные задачи, чтобы получить уникальную комбинацию символов (флаг). Далее участники отправляют флаг в специальную платформу и получают подтверждение, что задача решена верно или стоит попытаться дать ответ ещё раз.
        </div>
        <div class="text-center">
            <button onclick="location.href = '<?=$buttonHref?>'" class="btn btn-primary btn-lg p-4" style="font-size:24pt"><?=$buttonText?></button>
        </div>
</main>
<?php
includeTemplate('footer.php');
