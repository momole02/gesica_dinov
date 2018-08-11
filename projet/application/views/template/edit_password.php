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
    <div class="card mx-auto mt-5 ">
      <div class="card-header"> <b>Modifier le mot de passe</b> </div>


      <div class="card-body">

        <?php print form_open('enterprise/edit_password_request'); ?>

        <h3> Editer le mot de passe </h3>


        <div style="color:red">
          <?php print validation_errors(); ?>
        </div>

        <div class="form-group">

            <label for="enterp-own-tel" > Mot de passe actuel :</label>
            <input class="form-control" name="enterp-own-ex-passwd" id="enterp-own-ex-passwd" type="password" placeholder="Entrez le mot de passe actuel ">
        </div>


        <div class="form-group">
            <label for="enterp-own-tel" > Nouveau mot de passe :</label>
            <input class="form-control" name="enterp-own-passwd" id="enterp-own-passwd" type="password" placeholder="Entrez le nouveau mot de passe">
        </div>

        <div class="form-group">
            <label for="enterp-own-tel" > Confirmation du mot de passe:</label>
            <input class="form-control" name="enterp-own-passwd-conf" id="enterp-own-passwd-conf" type="password" placeholder="Confirmez">
        </div>

        <input type="submit" class="btn btn-primary btn-block" style="width:200px" value="Modifier" >


        </form>

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
