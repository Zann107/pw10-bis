<?php
session_start();

$bdd = new PDO('mysql:host=localhost;dbname=myuser','root','mysql');

if (isset($_GET['id']) AND $_GET['id'] > 0)
{
	$getid = intval($_GET['id']);
	$requser = $bdd->prepare("SELECT * FROM user WHERE id");
	$requser->execute(array($getid));
	$userinfo = $requser->fetch();
}
?>
<html>
	<head>
		<title>Pw10bis</title>
		<meta charset="utf-8">
	</head>
	<body>
		<div align="center">
			<h2>Bon retour parmit nous  <?php echo $userinfo['pseudo']; ?></h2>
			<br>
			<br>
			Mon pseudo : <?php echo $userinfo['pseudo']; ?>
			<br>
			Mon mail : <?php echo $userinfo['mail']; ?>
			<br>
			<?php
			if (isset($_SESION['id']) AND $userinfo['id'] == $_SESION['id']);
			{
				?>
				<a href="deco.php"> deconnection</a>
				<a href="#"> home</a>
				<?php
			}
			?>
	</body>
</html>