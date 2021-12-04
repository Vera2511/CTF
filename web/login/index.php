<?php 
include '/var/www/ctf/src/core.php';

if (!empty($_POST)) {
	$login = $_POST['name'];
	$password = $_POST['password'];
	$result = $pdo->getData("select team_id, pass from login_data where login='$login'");
	if ($result){
		if (md5($password) == $result[0]['pass']) {
			$pdo->disconnect();
			$_SESSION['team_id'] = $result[0]['team_id'];
			$_SESSION['team_name'] = $login;
			header("refresh:0, url=/");
		} else {
			echo 'Неверный логин или пароль';
		}
	} else {
		echo 'Неверный логин или пароль';
	}
}
includeTemplate('header.php', ['title' => 'Вход', '_SESSION' => $_SESSION]);
?>

    <form method="post" class="container col-3 text-center ">
      <h1 class="h3 mb-3 fw-normal">Войти</h1>
      <div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" placeholder="Название команды" name='name'>
        <label for="floatingInput">Название команды</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name='password'>
        <label for="floatingPassword">Пароль</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary my-2" type="submit">Войти</button>
    </form>
<?php
includeTemplate('footer.php');