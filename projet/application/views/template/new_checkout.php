<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GESICA - Nouvelle caisse </title>
  <!-- Bootstrap core CSS-->
  <link href="<?php print base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php print base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?php print base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
</head>

<body class="bg-dark">
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header"> <b>GESICA - Nouvelle caisse</b> </div>
      <div class="card-body">

        <div style="color:red">
          <?php print validation_errors(); ?>

        </div>

        <?php print form_open("checkout/new_checkout_request"); ?>

          <div class="form-group">
            <label for="checkout-user-lname">Nom du gestionnaire</label>
            <input class="form-control" id="checkout-user-lname" name="checkout-user-lname" type="text"  placeholder="Entrez le nom du caissier ou caissière">
          </div>

          <div class="form-group">
            <label for="checkout-user-fname">Prenom du gestionnaire</label>
            <input class="form-control" id="checkout-user-fname" name="checkout-user-fname" type="text" placeholder="Entrez le prénom du caissier ou caissière">
          </div>
          
          <div class="form-group">
            <label for="checkout-number">N° de la caisse(unique)</label>
            <input class="form-control" id="checkout-number" name="checkout-number" type="text" placeholder="Entrez le numéro de la caisse">
          </div>


          <div class="form-group">
            <label for="checkout-pseudo">Pseudo de la caisse</label>
            <input class="form-control" id="checkout-pseudo" name="checkout-pseudo" type="text" placeholder="Le pseudo du caisser pour se connecter">
          </div>

          <p> <i>Les gestionnaire pourront toujours changer ce mot de passe</i></p>
          <div class="form-group">
            <label for="checkout-password">Mot de passe</label>
            <input class="form-control" id="checkout-password" name="checkout-password" type="password" placeholder="Mot de passe d'accès à la caisse">
          </div>

          <div class="form-group">
            <label for="checkout">Confirmation</label>
            <input class="form-control" id="checkout-password-conf" name="checkout-password-conf" type="password" placeholder="Confirmation du mot de passe">
          </div>

          <input type="submit" class="btn btn-primary btn-block" value="Créer la caisse">

        </form>
        </div>

        <div class="card-footer small text-muted" align="center">
          <a href="<?php print base_url();?>home/main_panel" >Retourner au panel admin</a>
        </div>

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
