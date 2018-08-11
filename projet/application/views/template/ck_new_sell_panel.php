<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title> GESICA - Nouvelle vente</title>
  <!-- Bootstrap core CSS-->
  <link href="<?php print base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="<?php print base_url(); ?>assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <!-- Custom styles for this template-->
  <link href="<?php print base_url(); ?>assets/css/sb-admin.css" rel="stylesheet">
</head>

<body class="fixed-nav sticky-footer bg-dark" id="page-top">

  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <a class="navbar-brand" href="<?php print base_url();?>home">GESICA</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
  
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Tableau de bord">
          <a class="nav-link" href="<?php print base_url()?>checkout/checkout_panel">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Tableau de bord</span>
          </a>
        </li>

      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Nouvelle vente">
          <a class="nav-link" href="<?php print base_url();?>checkout/new_sell_panel">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Nouvelle vente</span>
          </a>
      </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gérer les articles">
          <a class="nav-link" href="<?php print base_url()?>checkout/product_panel">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text" >Gerer les articles</span>
          </a>
        </li>
      </ul>
      
      <ul class="navbar-nav sidenav-toggler">
        <li class="nav-item">
          <a class="nav-link text-center" id="sidenavToggler">
            <i class="fa fa-fw fa-angle-left"></i>
          </a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto">

        <li class="nav-item" style="width:100px">
 
        </li>
        <li class="nav-item">
          <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Se déconnecter</a>
        </li>
      </ul>
    </div>


  </nav>

  <div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
      <ol class="breadcrumb">
        <li class="breadcrumb-item">
          <a href="<?php print base_url();?>home/">GESICA</a>
        </li>
        <li class="breadcrumb-item ">Caisse</li>
        <li class="breadcrumb-item active">Nouvelle vente </li>
      </ol>

      <div class="row">

        <div class="col-12">
          <!-- CONTENU -->

        <div class="card mb-3">
        <div class="card-header"><h4>Check-list </h4></div>
        <div class="card-body">
          <?php 

          if(isset($cart)){ 

            if( count($cart)==0 ){
              print "<i>Vide</i>";
            }else{
?>
  <table id="dataTable" class="table table-bordered dataTable" role="grid" aria-describly="dataTable_info">
  <thead><tr role="row"><td><b>Code article</b></td>
    <td><b>Nom </b></td>
    <td><b>Prix U </b></td>
    <td><b>Qté </b></td>
    <td><b>Prix total brut</b></td>
    <td><b>TVA(%)</b></td>
    <td><b>Remise(%)</b></td>
    <td><b>Prix total </b></td>
    <td><b>Opérations</b></td></tr>
  </thead>
  <?php

    for( $i=0;$i<count($cart);++$i ){
      $pd = $cart[$i];
     ?>

     <tr>
      <td><?php print $pd['product-code']?></td>
      <td><?php print $pd['product-name']?></td>
      <td><?php print $pd['product-price']?></td>
      <td><?php print $pd['product-amount']?></td>
      <td><?php print $pd['product-raw-total']?></td>
      <td><?php print $pd['product-tax']?>%</td>
      <td><?php print $pd['product-discount']?>%</td>
      <td><?php print $pd['product-total']?></td>
      <td>
           <a class="btn btn-primary " style="font-size:12px;" href="<?php print base_url().'checkout/drop_cart_product/'.$i; ?>">
              Supprimer
           </a>
      </td>
     </tr>
     <?php 
    }
  ?>
</table>
<?php 
            }

          ?>

          <?php }  ?>


     <?php print form_open("checkout/add_cart_product")?>

     <hr/>
     <div class="card card-login mx-auto mt-5" style="padding:4px">

     	<div class="card-header"><h4>Inserer produit</h4></div>
     	<div style="color:red"><?php print validation_errors(); ?></div>
     	

	     <div class="form-group">
	     	<label for="product-code">Code:</label>
	     	<input type="text" class="form-control" id="product-code" name="product-code">
	     </div>

	     <div class="form-group">
	     	<label for="product-amount">Quantité:</label>
	     	<input type="text" class="form-control" id="product-amount" name="product-amount">
	     </div>	

      <div class="form-group">
        <label for="product-discount">Remise:</label>
        <input type="text" value="0" class="form-control" id="product-discount" name="product-discount">
       </div> 


	   <input type="submit" class="btn btn-primary btn-block" value="Ajouter">

     </div>

     </form>

     Remise totale : 
     <?php 

       if(isset( $global_discount ) ) 
        print $global_discount ; 
       else
        print "[Non défini]"; 
    ?>(%) 

    <a href="<?php print base_url()?>checkout/edit_global_discount" class="btn btn-primary">
      Editer la remise globale  
    </a>
    <br/> 

     Total :<?php 
     if( isset($global_total) ){
          print $global_total;      
     }else{
        print "[non défini]";
     }

      ?> FCFA. 
      <br/> 
      
     
     

    </div>

        <div class="card-footer small text-muted">

<!--
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Fermer l'entreprise</a> -->
 

        <a class="btn btn-primary"  style="font-size:12px;color:red" href="<?php print base_url(); ?>checkout/cancel_sell">Annuler la vente</a>


        <a class="btn btn-primary"  style="font-size:12px;" href="<?php print base_url(); ?>checkout/apply_sell">Valider la vente</a>

        <a class="btn btn-primary"  style="font-size:12px;" href="<?php print base_url(); ?>checkout/apply_sell/1">Valider la vente et imprimer la facture</a>

        </div>
        </div>      

        </div>
  
      </div>


    </div>

  
    <!-- /.container-fluid-->
    <!-- /.content-wrapper-->
    <footer class="sticky-footer">
      <div class="container">
        <div class="text-center">
          <small>Par : <img width="100" src="<?php print base_url();?>assets/dinov.png"></small>
        </div>
      </div>
    </footer>
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fa fa-angle-up"></i>
    </a>


    <!-- Logout Modal-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        
        <div class="modal-content">
          
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Voulez vous vraiment vous déconnecter ?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          
          <div class="modal-body">Cliquez sur "Deconnecter" pour continuer</div>
          
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Annuler</button>
            <a class="btn btn-primary" href="<?php print base_url(); ?>checkout/logout">Deconnecter</a>
          </div>

        </div>
      </div>
    </div>


    <!-- Bootstrap core JavaScript-->
    <script src="<?php print base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
    <script src="<?php print base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="<?php print base_url(); ?>assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="<?php print base_url(); ?>assets/js/sb-admin.min.js"></script>


  </div>
</body>

</html>
