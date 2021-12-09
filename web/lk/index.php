<?php
include '/var/www/ctf/src/core.php';

if ($_SESSION) {
	$team_info = $pdo->getData('select team_name as "Название команды", team_size as "Количество человек", score as "Счет", on_route as "На маршруте", reg_date as "Дата регистрации" from teams where team_id = ' . $_SESSION['team_id']);
	$fields = array_keys($team_info[0]);
	includeTemplate('header.php', ['title' => 'Личный кабинет', '_SESSION' => $_SESSION]);
?>
    <div class="container col-4">
      <div class="list-group">
				<h1 class="text-center">Личный кабинет</h1>
					<?php
			    foreach ($fields as $field) {
			    	$tf = $team_info[0][$field];
			    	if ($tf === False || $tf == '') {
			    		$tf = 'Нет';
			    	}
			    	includeTemplate('lk.php', ['header' => $field, 'info' => $tf]);
			    }
					?>
			</div>

<?php
includeTemplate('footer.php', ['gray' => True]);
} else {
	header("refresh:2, url=/login/");
	echo 'need login';
}

