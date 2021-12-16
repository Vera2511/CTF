<?php
include '/var/www/ctf/src/core.php';
if ($_SESSION && isset($_SESSION['isAdmin'])) {
	includeTemplate('header.php', ['title' => 'Админ-панель', '_SESSION' => $_SESSION]);

	$teams = $pdo->getData('SELECT teams.team_id as id, login as "Логин", team_name as "Название команды", team_size as "Количество игроков", reg_date as "Дата регистрации", score as "Счет" FROM teams
		INNER JOIN login_data ON login_data.team_id = teams.team_id ORDER BY teams.team_id');
	$tasks = $pdo->getData('SELECT task_id as id, task_name as "Заголовок", descr as "Описание", answer as "Ответ", is_file, filename as "Файл" FROM tasks');
	$teamFields = array_keys($teams[0]);
	$taskFields = array_keys($tasks[0]);
	array_pop($taskFields);
	array_pop($taskFields);
	if (isset($_POST['deleteTask'])) {
		$url = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/";
		$id = pg_escape_string($_POST['deleteTask']);
		$filename = $pdo->getData("SELECT filename FROM tasks WHERE task_id = $id")[0]['filename'];
		$pdo->query("DELETE FROM tasks WHERE task_id = $id");
		if ($filename) {
			exec("rm -rf $url$filename");
		}
		header("refresh:0, url=/admin");
	}
	if (isset($_POST['deleteTeam'])) {
		$id = pg_escape_string($_POST['deleteTeam']);
		$pdo->query("DELETE FROM teams WHERE team_id = $id");
		header("refresh:0, url=/admin");
	}
	?>

	<main class="container-xxl">
	</br></br></br>
	    <main class="container-xxl">
	        <div class="col-md-4 mb-3 ms-md-3 p-3" style="background-color: white; border-radius: 4px; width: 100%;">
	            <h5 class="text-center">Админ-панель</h5>
	            <nav>
	                <div class="nav nav-tabs d-flex justify-content-evenly" id="nav-tab" role="tablist">
	                    <button class="nav-link active" id="nav-team-tab" data-bs-toggle="tab" data-bs-target="#nav-team" type="button" role="tab" aria-controls="nav-team" aria-selected="true">Команды</button>
	                    <button class="nav-link" id="nav-task-tab" data-bs-toggle="tab" data-bs-target="#nav-task" type="button" role="tab" aria-controls="nav-task" aria-selected="false">Задания</button>
	                </div>
	            </nav>
	            <div class="tab-content" id="nav-tabContent">
					<div class="tab-pane fade show active" id="nav-team" role="tabpanel" aria-labelledby="nav-team-tab">
						<table class="table text-center">
							<thead>
								<th>&nbsp;</th>
								<?php 
								foreach ($teamFields as $field) { 
									if ($field == 'id') {
										continue;
									}
									?>
								<th><?=$field?></th>
								<?php } ?>
							</thead>
							<tbody>
	<?php 
	foreach ($teams as $team) {
	?>
								<tr>
									<td>
										<form method="post">
						                    <button class="btn btn-primary " type="submit" name="deleteTeam" value="<?=$team['id']?>">
						                        <i class="bi bi-trash-fill"></i>
						                    </button>
						                </form>
									</td>
									<?php 
								foreach ($teamFields as $field) { 
									if ($field == 'id') {
										continue;
									}
									?>
									<td><?=$team[$field]?></td>
								<?php } ?>
								</tr>
	<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="tab-pane fade" id="nav-task" role="tabpanel" aria-labelledby="nav-task-tab">
						<table class="table text-center">
							<thead>
								<th>&nbsp;</th>
								<?php 
								foreach ($taskFields as $field) { 
									if ($field == 'id') {
										continue;
									}
									?>
								<th><?=$field?></th>
								<?php } ?>
								<th>Файл</th>
							</thead>
							<tbody>
	<?php 
	foreach ($tasks as $task) {
	?>
								<tr>
									<td>
										<form method="post">
						                    <button class="btn btn-primary " type="submit" name="deleteTask" value="<?=$task['id']?>">
						                        <i class="bi bi-trash-fill"></i>
						                    </button>
						                </form>
									</td>
									<?php 
								foreach ($taskFields as $field) { 
									if ($field == 'id') {
										continue;
									}
									?>
									<td><?=$task[$field]?></td>
								<?php }
								if ($task['is_file']) { ?>
									<td><a href="/download?filename=<?=$task['Файл']?>"><?=$task['Файл']?></a></td>
								<?php } else {
									echo '<td>Нет</td>';
								} ?>
								</tr>
	<?php } ?>
							</tbody>
						</table>
						<button onclick="location.href = '/admin/createTask'" class="btn btn-lg btn-primary my-2 w-100">Добавить задание</button>
					</div>
				</div>
			</div>
		</main>
	</main>
	<?php 
	includeTemplate('footer.php');
} else {
	header("refresh:0, url=/");
}