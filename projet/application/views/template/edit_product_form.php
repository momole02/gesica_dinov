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
      <div class="card-header"> <b>GESICA - Edition d'article ( Article N° <?php print $index+1;?> )</b> </div>
      <div class="card-body">

        <div style="color:red">
          <?php print validation_errors(); ?>

        </div>

        <?php print form_open("product/edit_product_request"); ?>

          <div class="form-group">
            <label for="product-name">Nom de l'article</label>
            <input class="form-control" id="product-name" name="product-name" type="text"  
            value="<?php print $product->nom_article?>" 
            placeholder="Entrez le nom de l'article">
          </div>

          <div class="form-group">
            <label for="product-type">Type de l'article</label>
            <input class="form-control" 
            value="<?php print $product->type_article?>" 
            id="product-type" name="product-type" type="text" placeholder="Entrez le type de l'article">
          </div>
          
          <div class="form-group">
            <label for="product-price">Prix de vente</label>
            <input class="form-control" 
            value="<?php print $product->pv_article?>"
            id="product-price" name="product-price" type="text" placeholder="Entrez le prix de vente">
          </div>

          <div class="form-group">
            <label for="product-amount">Quantité</label>
            <input class="form-control" 
            value="<?php print $product->qte_article?>" 
             id="product-amount" name="product-amount" type="text" placeholder="Entrez la quantité ">
          </div>


          <div class="form-group">
            <label for="product-tax" > TVA(%) </label>
            <input class="form-control" value="<?php print $product->tva_article;?>"type="text" name="product-tax" id="product-tax" value="TVA de l'article">
          </div>

          <div class="form-group">
            <label for="product-discount"> Remise(%) :  </label>
            <input class="form-control" type="text" value="<?php print $product->remise_article?>" name="product-discount" id="product-discount" value="Remise appliquée" >
          </div>


          <input type="hidden" name="product-index" value="<?php print $index?>" >

          <input type="submit" class="btn btn-primary btn-block" value="Modifier l'article">
          </div>
          
        </form>

        <div class="card-footer small text-muted" align="center">
          <a href="<?php print base_url();?>checkout/product_panel" >Retourner au panel produits</a>
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
