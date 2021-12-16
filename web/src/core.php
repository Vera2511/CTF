<?php 
include 'functions.php';
session_start();

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/src/adminProperties.php') && $_SERVER['REQUEST_URI'] != '/install/') {
	header('refresh:0,url=/install/');
	exit;
} else {
	include 'adminProperties.php';
	$pdo = new PG_PDO();
	$pdo->connect('postgres', 'ctfrpguser', 'pgpwd4ctf', 'ctf');

	if (array_key_exists('logout', $_GET)) {
		session_destroy();
		header('refresh:0, url=/');
	}
}