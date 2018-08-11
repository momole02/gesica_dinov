<!DOCTYPE html>
<html>
<head>
	<title>[Back office GESICA] Status abonnée</title>
</head>
<body>

	<p>
		
		[  <a href="<?php print base_url();?>root/enterp_crud"> CRUD Abonnés </a>  ] -
		[  <a href="<?php print base_url();?>root/subscriber_status"> Status abonné</a>  ] - 
		[  <a href="<?php print base_url();?>home/signup"> Nouvelle entreprise</a>  ]
	</p>

	<hr/>
	<h1>Status abonné</h1>
	<span style="color:red">
		<?php print validation_errors();?>
	</span>
	
	<?php print form_open("root/subscriber_status_request") ?>
	<h3>récupérer le status d'un abonné</h3>
	<table>
		<tr>
			<td>Code entreprise : </td>
			<td><input type="text" name="enterp-code"></td>
		</tr>
	</table>
	<p>
		<input type="submit" value="Ok">
	</p>
	</form>

</body>
</html>