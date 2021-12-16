<?php

include_once $_SERVER['DOCUMENT_ROOT'] . "/src/functions.php";

$filename = $_GET['filename'];

file_force_download($_SERVER['DOCUMENT_ROOT'] . "/assets/uploads/$filename");
?>

<script>window.close()</script>