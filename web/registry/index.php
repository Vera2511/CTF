<?php 
include '/var/www/ctf/src/core.php';

includeTemplate('header.php', ['title' => 'Регистрация', '_SESSION' => $_SESSION]);
?>

    <form method="post" class="container col-3 text-center ">
      <h1 class="h3 mb-3 fw-normal">Регистрация</h1>
      <h2 class="h4 mb-3 fw-normal">Информация о команде</h1>
      	<div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" placeholder="Название команды" name='name'>
        <label for="floatingInput">Название команды</label>
      </div>
      <div class="form-floating">
        <input type="number" class="form-control" id="floatingInput" placeholder="Количество человек" name='login'>
        <label for="floatingInput">Количество человек</label>
      </div>
      <hr>
      <h2 class="h4 mb-3 fw-normal">Аутентификация</h1>
      <div class="form-floating">
        <input type="text" class="form-control" id="floatingInput" placeholder="Логин" name='login'>
        <label for="floatingInput">Логин</label>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name='password'>
        <label for="floatingPassword">Пароль</label>
      </div>
      <button class="w-100 btn btn-lg btn-primary my-2" type="submit">Зарегистрироваться</button>
    </form>
<?php
includeTemplate('footer.php');