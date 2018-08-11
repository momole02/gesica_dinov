<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title> GESICA - Caisse N° <?php print $checkout_logged->num_caisse ?>::produits</title>
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
          <a class="nav-link" href="<?php print base_url()?>checkout/new_sell_panel">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Nouvelle vente</span>
          </a>
      </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Gérer les articles">
          <a class="nav-link" href="<?php print base_url()?>checkout/ck_products_panel.php">
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
          <a href="<?php print base_url();?>home">GESICA</a>
        </li>
        <li class="breadcrumb-item ">Caisse </li>
        <li class="breadcrumb-item active">Gestion articles</li>
      </ol>

      <div class="row">

        <div class="col-12">
          <!-- CONTENU -->

        <div class="card mb-3">
        <div class="card-header"><h4>Liste des articles</h4></div>
        <div class="card-body">
          <?php if(isset($products)){ 


            if( count($products)==0 ){
              print "<i>Aucun article n'est présent</i>";
            }else{
?>
  <table id="dataTable" class="table table-bordered dataTable" role="grid" aria-describly="dataTable_info">
  <thead>
    <tr role="row">
      <td><b>Code article</b></td>
      <td><b>Nom </b></td>
      <td><b>Type </b></td>
      <td><b>Prix de vente </b></td>
      <td><b>Qté actuelle</b></td>
      <td><b>TVA(%)</b></td>
      <td><b>Remise(%)</b></td>
      <td><b>Opérations</b></td>
    </tr></thead>
  <?php 
    for( $i=0;$i<count($products);++$i ){
      $pd = $products[$i];
     ?>
     <tr>
      <td><?php print $pd->code_article?></td>
      <td><?php print $pd->nom_article?></td>
      <td><?php print $pd->type_article?></td>
      <td><?php print $pd->pv_article?></td>
      <td><?php print $pd->qte_article?></td>
      <td><?php print $pd->tva_article?></td>
      <td><?php print $pd->remise_article?></td>
      <td>
           <a class="btn btn-primary " style="font-size:12px;" href="<?php print base_url().'product/drop_product/'.$i; ?>">
              Sup
           </a>
           <a class="btn btn-primary " style="font-size:12px;" href="<?php print base_url().'product/edit_product/'.$i; ?>">
              Mod
           </a>
           <a class="btn btn-primary " style="font-size:12px;" href="<?php print base_url().'product/supply_product/'.$i; ?>">
              Rav
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
        </div>

        <div class="card-footer small text-muted">

<!--
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Fermer l'entreprise</a> -->
  
        <a class="btn btn-primary"  style="font-size:12px;" href="<?php print base_url(); ?>product/new_product">Nouvel article</a>

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
