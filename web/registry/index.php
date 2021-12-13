<?php 
include '/var/www/ctf/src/core.php';

if (!empty($_POST)) {
  $name = pg_escape_string($_POST['name']);
  $count = pg_escape_string($_POST['count']);
  $login = pg_escape_string($_POST['login']);
  $password = pg_escape_string($_POST['password']);
  $exist = False;
  $teams = $pdo->getData("SELECT login, team_name FROM login_data INNER JOIN teams ON teams.team_id = login_data.team_id");
  foreach ($teams as $team) {
    if ($name == $team['team_name'] || $login == $team['login']) {
      $exist = True;
      break;
    }
  }
  if (!$exist) {
    $query = $pdo->query("INSERT INTO public.teams (team_name, team_size, score, on_route, reg_date)
      VALUES ('$name', $count, 0, false, now()::date);"
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
  } else {
    $error = 'Такая команда уже существует';
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
        <p>Количество человек</p>
        <div class="text-center">
          <input type="radio" class="btn-check" name="count" id="option1" autocomplete="off" value="3">
          <label class="btn btn-outline-primary btn-sm mx-2" for="option1">3</label>
          <input type="radio" class="btn-check" name="count" id="option2" autocomplete="off" value="5">
          <label class="btn btn-outline-primary btn-sm mx-2" for="option2">5</label>
          <input type="radio" class="btn-check" name="count" id="option3" autocomplete="off" value="7">
          <label class="btn btn-outline-primary btn-sm mx-2" for="option3">7</label>
        </div>
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
      <a href="/login/">У меня уже есть аккаунт</a>
    </form>

<?php
}
includeTemplate('footer.php');
