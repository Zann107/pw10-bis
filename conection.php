<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=myuser','root','mysql');

if (isset($_POST['gotoco']))
{
	$pseudoco = htmlspecialchars($_POST['pseudoco']);
	$mdpco = sha1($_POST['mdpco']);

	if(!empty($_POST['pseudoco']) AND !empty($_POST['mdpco']))
	{
		$repuser = $bdd->prepare("SELECT * FROM user WHERE pseudo = ? AND mdp = ?");
		$repuser->execute(array($pseudoco, $mdpco));
		$userexit = $repuser->rowCount();

		if ($userexit == 1)
		{
			$userinfo= $repuser->fetch();
			$_SESSION['id'] = $userinfo['id'];
			$_SESSION['pseudo'] = $userinfo['pseudo'];
			$_SESSION['mail'] = $userinfo['mail'];
			header("Location: profil.php?id=".$_SESSION['id']);
		}
		else
		{
			$erreur ="Pseudo ou mot de passe invalide";
		}
	}
	else
	{
		$erreur = " Tous les champs doivent etre remplie";
	}

}
?>

<html>
	<head>
		<title>Pw10bis</title>
		<meta charset="utf-8">
	</head>
	<body>
		<div align="center">
			<h2>Connexion</h2>
			<br>
			<form method="POST" action="">
				<input type="text" name="pseudoco" placeholder="Pseudo">
				<input type="password" name="mdpco" placeholder="mdp">
				<input type="submit" name="gotoco" value="Se connecter">

			</form>
			<?php
			if(isset($erreur))
			{
				echo $erreur;
			}
			?>
	</body>
</html>