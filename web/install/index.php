<?php 
include '/var/www/ctf/src/core.php';
includeTemplate('header.php', ['title' => 'Установка приложения', '_SESSION' => $_SESSION, 'install' => true]);
if (!empty($_POST)) {
	$login = pg_escape_string($_POST['login']);
	$password = pg_escape_string($_POST['password']);
	$confirm = pg_escape_string($_POST['confirm']);
	if ($password == $confirm) {
		$pass = md5($password);
		$properties = "<?php\ndefine('ADMIN_LOGIN', '$login');\ndefine('ADMIN_PASSWORD', '$pass');";
		$file = fopen($_SERVER['DOCUMENT_ROOT'] . '/src/adminProperties.php', 'w');
		$fw = fwrite($file, $properties);
		if ($fw) {
			fclose($file);
			header("refresh:0, url=/");
		}
	}
}
?>

   <form method="post" class="container col-3 text-center ">
      <h2 class="h4 mb-3 fw-normal">Создание администратора</h1>
      <div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" placeholder="Логин администратора" name='login' required>
        <label for="floatingInput">Логин администратора</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingInput" placeholder="Пароль" name='password' required>
        <label for="floatingInput">Пароль</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingInput" placeholder="Подтверждение пароля" name='confirm' required>
        <label for="floatingInput">Подтверждение пароля</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary my-2" type="submit">Создать</button>
    </form>
<?php 
includeTemplate('footer.php');