<?php
include '/var/www/ctf/src/core.php';
if ($_SESSION) {
	includeTemplate('header.php', ['title' => 'Смена пароля', '_SESSION' => $_SESSION]);
	$id = $_SESSION['team_id'];
	$truePassword = $pdo->getData("SELECT pass FROM login_data WHERE team_id = $id")[0]['pass'];
	if (!empty($_POST)) {
		$oldPass = pg_escape_string($_POST['oldpass']);
		$password = pg_escape_string($_POST['password']);
		$confirm = pg_escape_string($_POST['confirm']);
		if (md5($oldPass) == $truePassword) {
			if ($password == $confirm) {
				if ($pdo->query("UPDATE login_data SET pass = '$password' WHERE team_id = $id")) {
					$success = 'Пароль успешно изменен';
					header("refresh:1, url=/lk");
				} else {
					$error = 'Ошибка БД';
				}
			} else {
				$error = "Пароли не совпадают";
			}
		} else {
			$error = 'Неверный старый пароль';
		}
	}
	if (isset($success)) {
	  includeTemplate('alert.php', ['message' => $success, 'type' => 'success']);
	} else {
		if (isset($error)) {
	    	includeTemplate('alert.php', ['message' => $error]);
	    }
?>

   <form method="post" class="container col-3 text-center ">
      <h2 class="h4 mb-3 fw-normal">Смена пароля</h1>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingInput" placeholder="Старый пароль" name='oldpass' required>
        <label for="floatingInput">Старый пароль</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingInput" placeholder="Пароль" name='password' required>
        <label for="floatingInput">Пароль</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingInput" placeholder="Подтверждение пароля" name='confirm' required>
        <label for="floatingInput">Подтверждение пароля</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary my-2" type="submit">Сменить</button>
    </form>

<?php 
	includeTemplate('footer.php');
	}
} else {
	header("refresh:2, url=/login/");
	echo 'need login';
}