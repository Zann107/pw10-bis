<?php

$bdd = new PDO('mysql:host=localhost;dbname=myuser','root','mysql');

if (isset($_POST['inscrip']))
{
		$pseudo = htmlspecialchars($_POST['pseudo']);
		$mail = htmlspecialchars($_POST['mail']);
		$mdp = sha1($_POST['mdp']);
		$mdp2 = sha1($_POST['mdp2']);

	if(!empty($_POST['pseudo']) AND !empty($_POST['mail']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2'] ))
	{


		$pseudoleng = strlen($pseudo);
		if($pseudoleng <= 255)
		{
			$reqmail = $bdd->prepare("SELECT * FROM user WHERE mail = ?");
			$reqmail->execute(array($mail));
			$mailexist = $reqmail->rowCount();

			if ($mailexist == 0)
			{
				$reqpseudo = $bdd->prepare("SELECT * FROM user WHERE pseudo = ?");
				$reqpseudo->execute(array($pseudo));
				$pseudoexist = $reqpseudo->rowCount();

				if ($pseudoexist == 0)
				{
					if($mdp == $mdp2)
					{
						$inseruser = $bdd ->prepare("INSERT INTO user(pseudo, mail, mdp) VALUES(?, ?, ?) ");
						$inseruser ->execute(array($pseudo, $mail, $mdp));
						$erreur = "Votre comptes a été crée";
					}
					else
					{
						$erreur = "Vos mot de passe sont différent";
					}
				}
				else
				{
					$erreur ="Ce pseudo et deja pris";
				}
			}
			else
			{
				$erreur = " Ce mail est deja utiliser";
			}
		}
		else
		{
			$erreur ="Votre pseudo ne doit pas inférieur a 255 carractère";
		}
	}
	else
	{
		$erreur = "Tous les chmaps doivent etre compléter";
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
			<h2>Inscription</h2>
			<br>
			<form method="POST" action="">
				<table>
					<tr> 
						<td align="right">
							<label for="pseudo">Pseudo : </label>
						</td>
						<td>
							<input type="text" name="pseudo" placeholder="votre pseudo" id="pseudo" value="<?php if(isset($pseudo)){echo $pseudo;} ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mail">Mail : </label>
						</td>
						<td>
							<input type="email" name="mail" placeholder="votre mail" id="mail" value="<?php if(isset($mail)){echo $mail;} ?>">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mdp">Password : </label>
						</td>
						<td>
							<input type="password" name="mdp" placeholder="votre mdp" id="mdp">
						</td>
					</tr>
					<tr>
						<td align="right">
							<label for="mdp2">Password : </label>
						</td>
						<td>
							<input type="password" name="mdp2" placeholder="confirmation mdp" id="mdp2">
						</td>
					</tr>
				</table>
				<input type="submit" value="Terminer" name=inscrip>
			</form>
			<?php
			if(isset($erreur))
			{
				echo $erreur;
			}
			?>
	</body>
</html>