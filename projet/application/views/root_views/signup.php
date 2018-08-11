<!DOCTYPE HTML>
<html>
<head>
	<title>Nouvelle entreprise GESICA</title>
	<style type="text/css">

	input[type="text"]{
		width:500px;
		padding:5px;
	}
	</style>
</head>
<body>
	<p>
		[  <a href="<?php print base_url();?>root/enterp_crud"> CRUD Abonnés </a>  ] -
		[  <a href="<?php print base_url();?>root/subscriber_status"> Status abonné</a>  ] - 
		[  <a href="<?php print base_url();?>home/signup"> Nouvelle entreprise</a>  ] - 
		[  <a href="<?php print base_url();?>root/close"> Fermer</a>  ]
	</p>
	<hr>
	<h1>Nouvelle entreprise</h1>
	<hr>

	<span style="color:red"><?php print validation_errors(); ?></span>
	<?php print form_open("root/signup_request"); ?>

	<h3>Informations concernant l'entreprise</h3>
	<table>
		<tr>
			<td>Nom de l'entreprise : </td>
			<td><input type="text" name="enterp-name"></td>
		</tr>


		<tr>
			<td>N° Tel entreprise: </td>
			<td><input type="text" name="enterp-tel"></td>
		</tr>


		<tr>
			<td>Description de l'entreprise: </td>
			<td><textarea name="enterp-desc" cols='50'></textarea></td>
		</tr>


	</table>

	<h3>Informations sur le propriétaire</h3>
	<table>
		<tr>
			<td>Nom du propriétaire: </td>
			<td><input type="text" name="enterp-own-lname"></td>
		</tr>


		<tr>
			<td>Prénom du propriétaire : </td>
			<td><input type="text" name="enterp-own-fname"></td>
		</tr>

		<tr>
			<td>Sexe du propriétaire</td>
			<td>
				<select name="enterp-own-sex">
	              <option name="M" selected="true"> M </option>
	              <option name="F"> F </option>
	            </select>
			</td>
		</tr>
		<tr>
			<td>N° de téléphone du propriétaire </td>
			<td><input type="text" name="enterp-own-tel"></td>
		</tr>
	</table>

	<h3>Informations de connexion</h3>
	<table>
		<tr>
			<td>Pseudo de connexion: </td>
			<td><input type="text" name="enterp-own-pseudo"></td>
		</tr>


		<tr>
			<td>Mot de passe : </td>
			<td><input type="password" name="enterp-own-passwd"></td>
		</tr>


		<tr>
			<td>Confirmation du mot de passe: </td>
			<td><input type="password" name="enterp-own-passwd-conf"></td>
		</tr>

	</table>
	<br><br><br>

	<input  type="submit" value="Créer">

	</form>
	
</body>
</html>