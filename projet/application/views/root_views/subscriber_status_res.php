<!DOCTYPE html>
<html>
<head>
	<title>Status de l'abonné</title>
</head>
<body>
	[  <a href="<?php print base_url();?>root/"> Accueil </a>  ]
	<div align="center">
		<hr>
		
		<?php if(isset( $subscriber_info )) {
			$enterp_data = $subscriber_info['enterp_data'];
			$paid_deadlines = $subscriber_info['paid_deadlines'];
			?>
			<h3>Détails de l'abonné </h3>
			<table border='1'>
				<tr>
					<td><b>Code entreprise : </b></td>
					<td><?php print $enterp_data->code_ent;?></td>
				</tr>

				<tr>
					<td><b>Nom entreprise : </b></td>
					<td><?php print $enterp_data->nom_ent;?></td>
				</tr>
				<tr>
					<td><b>Description de l'entreprise</b></td>
					<td><?php print nl2br($enterp_data->desc_ent); ?></td>
				</tr>

				<tr>
					<td><b>Numéro entreprise : </b></td>
					<td><?php print $enterp_data->tel_ent;?></td>
				</tr>

				<tr>
					<td><b>Nom du propriétaire: </b></td>
					<td><?php print $enterp_data->nom_pro_ent;?></td>
				</tr>
				<tr>
					<td><b>Prénom du propriétaire: </b></td>
					<td><?php print $enterp_data->pnom_pro_ent;?></td>
				</tr>

				<tr>
					<td><b>Sexe du propriétaire: </b></td>
					<td><?php print $enterp_data->sexe_pro_ent;?></td>
				</tr>

				<tr>
					<td><b>Numéro propriétaire: </b></td>
					<td><?php print $enterp_data->tel_pro_ent;?></td>
				</tr>
				
			</table>

			<h3>Echéances payées</h3>
			<table border='1'>
			<tr>
				<td><b>ID</b></td>
				<td><b>Date de début de validité(paiement)</b></td>
				<td><b>Date de fin de validité</b></td>
				<td><b>Prix</b></td>
				<td><b>Supprimer</b></td>
			</tr>

			<?php for( $i=0;$i<count($paid_deadlines);++$i ) { 
				$deadline = $paid_deadlines[$i];
				
				?>
			<tr>
				<td><?php print $deadline->id;?></td>
				<td><?php print $deadline->debut_ech;?></td>
				<td><?php print $deadline->fin_ech;?></td>
				<td><?php print $deadline->prix_ech;?></td>
				<td><a href="<?php print base_url();?>root/drop_deadline/<?php print $deadline->id;?>">Supprimer l'abonnement</a></td>
			</tr>
			<?php } ?>
			</table>

		<?php }?>


	</div>
	<hr>
		
		<span style="color:red" ><?php print validation_errors();?></span>
		<?php print form_open("root/renew_agree_request")?>

			<span style="color:green">
			<?php 
				if(isset( $new_added ) && $new_added==true) 
					print 'Nouvel abonnement ajouté avec succes';
			?>

			</span>
			<h3>Renouveller abonnement</h3>

			<table>
				<tr>
					<td><b>Code de l'entreprise</b></td>
					<td><input type="text" value="<?php if(isset($enterp_data)) print $enterp_data->code_ent?>" name="enterp-code"></td>
				</tr>
				<tr>
					<td>Nombre de mois à ajouter : </td>
					<td><input type="text" name="nb-months"></td>
				</tr>
			</table><br/>
			<input type="submit" value="Ajouter">
		</form>
</body>
</html>