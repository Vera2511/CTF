<?php
include '/var/www/ctf/src/core.php';
if ($_SESSION && isset($_SESSION['isAdmin'])) {
	includeTemplate('header.php', ['title' => 'Добавить задание', '_SESSION' => $_SESSION]);
	$url = $_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/"; 
	if (!empty($_POST)) {
		$title = pg_escape_string($_POST['name']);
		$descr = pg_escape_string($_POST['descr']);
		$answer = pg_escape_string($_POST['answer']);

		if (!empty($_FILES)) {
			$filename = $_FILES['file']['name'];
			if (move_uploaded_file($_FILES['file']['tmp_name'], $url . "$filename")) {
	 			$pdo->query("INSERT INTO public.tasks (task_name, descr, answer, is_file, filename) VALUES ('$title', '$descr', '$answer', true, '$filename');");
	 		}
		} else {
			$pdo->query("INSERT INTO public.tasks (task_name, descr, answer, is_file, filename) VALUES ('$title', '$descr', '$answer', false, NULL);");
		}
	}


	?>
	   <form method="post" enctype="multipart/form-data" class="container col-3 text-center ">
	      <h1 class="h3 mb-3 fw-normal">Добавить задание <?=var_dump($_POST)?> <?=var_dump($_FILES)?> <?=$error?></h1>
	      <div class="form-floating">
	        <input type="text" class="form-control" id="floatingInput" placeholder="Заголовок" name='name' required>
	        <label for="floatingInput">Заголовок</label>
	      </div>
	      <div class="form-floating">
	        <textarea class="form-control" id="floatingInput" placeholder="Описание" name='descr' required></textarea>
	        <label for="floatingInput">Описание</label>
	      </div>
	      <div class="form-floating">
	        <input type="text" class="form-control" id="floatingInput" placeholder="Ответ" name='answer' required>
	        <label for="floatingInput">Ответ</label>
	      </div>
	      <div class="mb-3">
	        <label for="file" class="form-label">Файл (если требуется)</label>
	        <input class="form-control" type="file" id="file" name='file'>
	      </div>
	      </div>
	      <button class="w-100 btn btn-lg btn-primary my-2" type="submit">Добавить</button>
	    </form>
	<?php 
	includeTemplate('footer.php');
} else {
	header("refresh:0, url=/");
}