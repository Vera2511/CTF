<?php 
include 'functions.php';
session_start();

$pdo = new PG_PDO();
$pdo->connect('postgres', 'ctfrpguser', 'pgpwd4ctf', 'ctf');

if (array_key_exists('logout', $_GET)) {
	session_destroy();
	header('refresh:0, url=/');
}