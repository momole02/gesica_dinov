<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GESICA - Edition d'article </title>
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
      <div class="card-header"> <b>GESICA - Ravitailler article ( Article N° <?php print $index+1;?> )</b> </div>
      <div class="card-body">

        <div style="color:red">
          <?php print validation_errors(); ?>

        </div>

        <?php print form_open("product/supply_product_request"); ?>

          <div class="form-group">
            <label for="product-supply-amount">Quantité à ajouter</label>
            <input class="form-control" id="product-supply-amount" name="product-supply-amount" type="text" 
            placeholder="Entrez la quantité à ajouter">
          </div>

          <input type="submit" class="btn btn-primary btn-block" value="Valider" >

          <input type="hidden" name="product-index" value="<?php print $index?>" >
          
        </form>

      </div>

      <div class="card-footer small text-muted" align="center">
          <a href="<?php print base_url();?>checkout/product_panel" >Retourner au panel produits</a>
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
