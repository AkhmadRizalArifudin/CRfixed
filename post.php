<?php
    include "functions.php";
    session_start();
    $token = $_POST['token'];
    if($token !== $_SESSION['token']){
	echo '<p class="error">Error: invalid form submission</p>';
        header($_SERVER['SERVER_PROTOCOL'] . ' 405 Method Not Allowed');
        exit;
    }else{

    	if (isset($_POST['username']) && isset($_POST['password'])) {
	
        
        	$user = htmlentities($_POST['username']);
        	$pass = htmlentities($_POST['password']);
        	$pdo = pdo_connect();
        	$stmt = $pdo->prepare('SELECT salt FROM users WHERE username = :user LIMIT 1');
		$stmt->bindParam(':user', $user);
		$stmt->execute();
		$salt = $stmt->fetchColumn();

		$stmt = $pdo->prepare('SELECT * FROM users WHERE username = :user AND password = :password LIMIT 1');
		$stmt->bindParam(':user', $user);
		$stmt->bindParam(':password', $password);
		$password = hash('sha256', $pass . $salt);
		$stmt->execute();
		$notif = $stmt->rowCount();
		if ($stmt->rowCount() > 0) {
		    $_SESSION['user'] = $user;
		    header("location: index.php");
		} else {
		    $notif = "Wrong usename or password";
		}
    	}
    }
?>
