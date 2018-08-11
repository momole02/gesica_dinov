<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GESICA - Edition du mot de passe </title>
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
      <div class="card-header"> <b>GESICA - Modifiez votre mot de passe</b> </div>
      <div class="card-body">

        <div style="color:red">
          <?php print validation_errors(); ?>

        </div>

        <?php print form_open("checkout/edit_password_request"); ?>

          <div class="form-group">
            <label for="checkout-ex-password">Ancien mot de passe </label>
            <input class="form-control" id="checkout-ex-password" name="checkout-ex-password" type="password"  placeholder="Entrez l'ancien mot de passe" >
          </div>

          <div class="form-group">
            <label for="checkout-password">Mot de passe </label>
            <input class="form-control" id="checkout-password" name="checkout-password" type="password"  placeholder="Entrez le nouveau mot de passe" >
          </div>

          <div class="form-group">
            <label for="checkout-password-conf">Confirmation du mot de passe </label>
            <input class="form-control" id="checkout-password-conf" name="checkout-password-conf" type="password"  placeholder="Confirmez" >
          </div>

          <input type="submit" class="btn btn-primary btn-block" value="Modifier le mot de passe">
          </div>
          
        </form>

        <div class="card-footer small text-muted" align="center">
          <a href="<?php print base_url();?>checkout/checkout_panel" >Retourner au panel caisse</a>
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
