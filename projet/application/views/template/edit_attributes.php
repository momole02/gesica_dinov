<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GESICA - Edition des paramètre d'entreprise </title>

  <!-- Bootstrap core CSS-->
  <link href="<?php print base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php print base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?php print base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card mx-auto mt-5 ">
      <div class="card-header"> <b>Modifiez les paramètres de votre entreprise</b> </div>
        
      <div class="card-body">

        <div style="color:red">
          <?php print validation_errors(); ?>
        </div>

          <?php print form_open('enterprise/edit_request'); ?>
          <h3>Informations concernant l'entreprise</h3>
          <div class="form-group">
            <label for="enterp-name">Nom de l'entreprise </label>
            <input class="form-control" name="enterp-name" id="enterp-name" type="text" 
            value="<?php print $admin_data->nom_ent?>" 
            placeholder="Entrez le nom de l'entreprise ">
          </div>

          <div class="form-group">
            <label for="enterp-tel">N° Tel entreprise</label>
            <input value="<?php print $admin_data->tel_ent ?>" class="form-control" name="enterp-tel" id="enterp-tel" type="text" placeholder="Entrez le numéro de tel de l'entreprise">
          </div>


          <div class="form-group">
            <label for="enterp-desc">Description de l'entreprise</label><br/>
            <textarea name="enterp-desc" id="enterp-desc" ><?php print $admin_data->desc_ent; ?></textarea>
          </div>


        <div class="form-group">
            <label for="enterp-address" > Adresse :</label>
            <input class="form-control" value="<?php print (isset($admin_data)) ? $admin_data->adresse : ''?>" name="enterp-adress" id="enterp-address" type="text" placeholder="Situation géographique + Adresse postale ">
        </div>


        <div class="form-group">
            <label for="enterp-footer-message" > Slogan ou autre :</label>
            <input class="form-control" value="<?php print (isset($admin_data)) ? $admin_data->message_bas : ''?>" name="enterp-footer-message" id="enterp-footer-message" type="text" placeholder="Un petit message pour egayer les clients... ">
        </div>


        <div class="form-group">
            <label for="enterp-open-time" > Heure d'ouverture :</label>
            <input class="form-control" value="<?php print (isset($admin_data)) ? $admin_data->heure_ouverture : ''?>" name="enterp-open-time" id="enterp-open-time" type="time" placeholder="Vous ouvrez à quelle heure ?">
        </div>


        <div class="form-group">
            <label for="enterp-close-time" > Heure de fermeture :</label>
            <input class="form-control" value="<?php print (isset($admin_data)) ? $admin_data->heure_fermeture : ''?>" name="enterp-close-time" id="enterp-close-time" type="time" placeholder="Vous fermez à quelle heure ? ">
        </div>


          <h3> Informations sur le propriétaire</h3>


          <div class="form-group">
            <label for="enterp-own-last-name">Nom du propriétaire : </label>
            <input  class="form-control" name="enterp-own-lname" id="enterp-own-lname" 
            value="<?php print $admin_data->nom_pro_ent?>"
            type="text" placeholder="Entrez le nom du propriétaire">
          </div>

          <div class="form-group">
            <label for="enterp-own-first-name">Prénom du propriétaire :</label>
            <input class="form-control" value="<?php print $admin_data->pnom_pro_ent;?>" name="enterp-own-fname" id="enterp-own-fname" type="text" placeholder="Entrez le prénom du propriétaire">
          </div>

          <div class="form-group">
            <label for="enterp-own-tel">Téléphone du propriétaire :</label>
            <input class="form-control" value="<?php print $admin_data->tel_pro_ent?>"name="enterp-own-tel" id="enterp-own-tel" type="text" placeholder="Entrez le numéro de tel du propriétaire">
          </div>


          <div class="form-group">
            <label >Sexe du propriétaire:</label>
            <select name="enterp-own-sex">
              <option name="M" <?php if($admin_data->sexe_pro_ent === 'M') print "selected"?> > M </option>
              <option name="F" <?php if($admin_data->sexe_pro_ent === 'F') print "selected"?> > F </option>
            </select>
          </div>

        <h3>Informations de connexion </h3>

        <div class="form-group">
            <label for="enterp-own-tel" > Pseudo administrateur :</label>
            <input class="form-control" value="<?php print $admin_data->pseudo_adm_ent?>" name="enterp-own-pseudo" id="enterp-own-pseudo" type="text" placeholder="Entrez le pseudo administrateur ">
        </div>
        

          <input type="submit" class="btn btn-primary btn-block" style="width:200px" value="Modifier" >


        </form>


      </div>

        <div class="card-footer small text-muted" align="center">
          <a href="<?php print base_url();?>home/main_panel" >Retourner au panel admin</a>
        </div>

    </div>
  </div>
  <!-- Bootstrap core JavaScript-->
  <script src="<?php print base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php print base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="<?php print base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
