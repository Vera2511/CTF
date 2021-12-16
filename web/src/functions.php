<?php 
include 'Pg_Pdo.php';
function includeTemplate($templatePath, $data = [])
{
    extract($data);
    include '/var/www/ctf/templates/' . ltrim($templatePath, '/');
}

function file_force_download($file) 
{
  if (file_exists($file)) {
    if (ob_get_level()) {
      ob_end_clean();
    }
    header('Content-Description: File Transfer');
    header('application/octet-stream');
    header('Content-Disposition: attachment; filename=' . end(explode('/', $file)));
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($file));
    if ($fd = fopen($file, 'rb')) {
      while (!feof($fd)) {
        print fread($fd, 1024);
      }
      fclose($fd);
    }
    return True;
  }
  exit;
}

function getTask($id, $pdo) {
    $tasks = $pdo->getData("select task_id as id from tasks");
    foreach ($tasks as $key => $task) {
        $tasks[$key] = $tasks[$key]['id'];
    }
    $taskCount = count($tasks);
    $finishedTasks = $pdo->getData("select task from teams_tasks where team = $id and status");
    if (!$finishedTasks) {
        return $tasks[rand(1, $taskCount)];
    }
    foreach ($finishedTasks as $key => $value) {
        $finishedTasks[$key] = $finishedTasks[$key]['task'];
    }
    // return $finishedTasks;
    if (count($finishedTasks) == $taskCount) {
        return false;
    }
    $taskNumber = $tasks[rand(1, $taskCount)];
    while (array_search($taskNumber, $finishedTasks) !== false) {
        $taskNumber = $tasks[rand(1, $taskCount)];
    }
    return $taskNumber;
}