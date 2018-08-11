<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GESICA - Connexion caisse </title>
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
      <div class="card-header"> <b>GESICA - Connexion caisse</b> </div>
      <div class="card-body">

        <div style="color:red">
          <?php print validation_errors(); ?>

          <?php if(isset( $connection_error ) && $connection_error==='1'){
            print "Erreur lors de la connexion. vérifiez vos identifiants";
          }
          ?>
        </div>
        
        <?php print form_open("checkout/connect"); ?>
          <p>
            <i> Entreprise : <?php print $enterp_name; ?></i>
          </p>
          <div class="form-group">

          <div class="form-group">
            <label for="exampleInputEmail1">Pseudo</label>
            <input class="form-control" id="checkout-user-pseudo" name="checkout-user-pseudo" type="text" placeholder="Entrez le pseudo de caisse">
          </div>
          
          <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            <input class="form-control" id="checkout-user-passwd" name="checkout-user-passwd" type="password" placeholder="Mot de passe">
          </div>

          <input type="submit" class="btn btn-primary btn-block" value="Connexion">
        </form>

        <div class="text-center">
          <a class="d-block small mt-3" href="<?php print base_url(); ?>home/login">Passer en mode admin</a>
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
