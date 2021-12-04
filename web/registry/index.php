<?php 
include '/var/www/ctf/src/core.php';

if (!empty($_POST)) {
  $name = pg_escape_string($_POST['name']);
  $count = pg_escape_string($_POST['count']);
  $login = pg_escape_string($_POST['login']);
  $password = pg_escape_string($_POST['password']);
  $query = $pdo->query("INSERT INTO public.teams (team_name, team_size, score, on_route, reg_date, current_task)
    VALUES ('$name', $count, 0, false, now()::date, NULL);"
  );
  if ($query) {
    $result = $pdo->query("INSERT INTO public.login_data (login, pass) VALUES ('$login', '$password');");
    if ($result) {
      $success = "Вы успешно зарегистрированны";
      header('refresh:2, url=/login/');
    } else {
      $error = 'Ошибка БД';
      $pdo->query("delete from teams where team_name = '$name' AND team_size = $count;");
    }
  } else {
    $error = 'Ошибка БД';
  }
}

includeTemplate('header.php', ['title' => 'Регистрация', '_SESSION' => $_SESSION]);
if (isset($success)) {
  includeTemplate('alert.php', ['message' => $success, 'type' => 'success']);
} else {
  if (isset($error)) {
    includeTemplate('alert.php', ['message' => $error]);
  }
?>

    <form method="post" class="container col-3 text-center ">
      <h1 class="h3 mb-3 fw-normal">Регистрация</h1>
      <h2 class="h4 mb-3 fw-normal">Информация о команде</h1>
      	<div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" placeholder="Название команды" name='name' required>
        <label for="floatingInput">Название команды</label>
      </div>
      <div class="form-floating">
        <input type="number" class="form-control" id="floatingInput" placeholder="Количество человек" name='count' required>
        <label for="floatingInput">Количество человек</label>
      </div>
      <hr>
      <h2 class="h4 mb-3 fw-normal">Аутентификация</h1>
      <div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" placeholder="Логин" name='login' required>
        <label for="floatingInput">Логин</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name='password' required>
        <label for="floatingPassword">Пароль</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary my-2" type="submit">Зарегистрироваться</button>
    </form>
<?php
}
includeTemplate('footer.php');