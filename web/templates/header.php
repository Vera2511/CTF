<!doctype html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <title><?=$title?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css"/>
    <link rel="shortcut icon" href="/assets/icon.ico" type="image/x-icon">
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      .b-example-divider {
			  height: 3rem;
			  background-color: rgba(0, 0, 0, .1);
			  border: solid rgba(0, 0, 0, .15);
			  border-width: 1px 0;
			  box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
			}

      .btn-light{
        opacity: .75;
      }
      .btn-light:hover{
        opacity: 1;
      }
    </style>
  </head>
  <body style="background-color: #efefef">
    <header class=" d-flex  justify-content-between py-3 mb-4 mx-4 border-bottom">
        <a href="/" class="text-dark text-decoration-none">
          <span class="fs-4">
            &nbsp;<i class="bi bi-bug-fill"></i>&nbsp;CTF соревнования
          </span>
        </a>

      <ul class="nav nav-pills">
        <li class="nav-item"><a href="/" class="nav-link" aria-current="page">Главная</a></li>
<?php 
if ($_SESSION) {
?>
        <li class="nav-item"><a href="/lk/" class="nav-link" aria-current="page"> <i class="bi bi-person-fill"></i> Личный кабинет</a></li>
        <li class="nav-item"><a href="/?logout=1" class="nav-link active"><i class="bi bi-door-open-fill"></i> Выйти</a></li>
<?php
} else {
?>
        <li class="nav-item"><a href="/registry/" class="nav-link"> <i class="bi bi-file-earmark-person"></i> Регистрация</a></li>
        <li class="nav-item"><a href="/login/" class="nav-link active"> <i class="bi bi-door-closed-fill"></i> Войти</a></li>
<?php } ?>
        <li class="nav-item">&nbsp;</li>
      </ul>

    </header>