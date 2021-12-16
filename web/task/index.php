<?php
include '/var/www/ctf/src/core.php';
includeTemplate('header.php', ['title' => 'Задание', '_SESSION' => $_SESSION]);
$id = $_SESSION['team_id'];
$taskNumber = $pdo->getData("SELECT task FROM teams_tasks WHERE team = $id AND NOT status");
if (!$taskNumber) {
  $taskNumber = getTask($id, $pdo);
  if ($taskNumber === false) {
    $taskInfo = ['task_id' => 0, 
    'task_name' => 'Задания закончились :(',
    'descr' => 'К сожалению, в базе не осталось доступных заданий. Подождите несколько дней, пока мы добавим новые или обратитесь к администрации по адресу '. ADMIN_MAIL,
    'is_file' => false,
    'filename' => null];
  } else {
    $pdo->query("INSERT INTO teams_tasks (team, task, status) VALUES ($id, $taskNumber, false)");
    $pdo->query("UPDATE teams SET on_route = true WHERE team_id = $id");
  }
} else {
  $taskNumber = $taskNumber[0]['task'];
}
if (!isset($taskInfo)) {
  $taskInfo = $pdo->getData("SELECT * FROM tasks where task_id = $taskNumber")[0];
}
if (!$taskInfo) {
	header("refresh:0, url=/");
	exit;
}
if ($taskNumber == 4) {
	$description = explode(' ', $taskInfo['descr']);
  $desc = '';
  for ($i=0; $i < count($description) - 1; $i++) { 
    $desc .= $description[$i] . ' ';
  }
	$task = end(explode(' ', $taskInfo['descr']));
} else {
  $desc = $taskInfo['descr'];
}
if (!empty($_POST)) {
  $answer = pg_escape_string($_POST['answer']);
  if ($answer == $taskInfo['answer']) {
    $success = 'Выполнено успешно';
    $pdo->query("update teams_tasks set status = true where team = $id and task = $taskNumber");
    $pdo->query("update teams set score = score + 15 where team_id = $id");
    header("refresh:1; url=/task");
  } else {
    $error = 'Ответ неверен';
  }
}
?>

<main class="container-xxl">
<?php
if (isset($success)) {
  includeTemplate('alert.php', ['message' => $success, 'type' => 'success']);
} else {
if (isset($error)) {
  includeTemplate('alert.php', ['message' => $error]);
  }
?>
  <div class="card my-2">
    <div class="card-body">
      <h2 class="h2"><?=$taskInfo['task_name']?></h2>
      <p><?=$desc?></p>
<?php
if ($taskInfo['task_id'] != 0) { ?>
      <p><?=isset($task) ? $task : ''?></p>
      <?php if ($taskInfo['is_file']) { ?>
      <a href='/download?filename=<?=$taskInfo['filename']?>'><?=$taskInfo['filename']?></a> 
      <?php }?>
    </div>
  </div>
  <form class="form-floating my-1" method="post">
    <input class="form-control" id="answer" name="answer" required>
    <label for="answer">Ответ: </label>
    <button class="w-100 btn btn-lg btn-primary col-md-6 my-2" type="submit">Отправить</button>
  <?php } else { ?>
    <button onclick="location.href = '/'" class="w-100 btn btn-lg btn-primary col-md-6 my-2" type="submit">Вернуться на главную</button>
  <?php } ?>
  </form>
</main>


<?php
}
includeTemplate('footer.php');
