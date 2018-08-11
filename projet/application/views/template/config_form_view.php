<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title> GESICA - Configuration </title>
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
          <a class="nav-link" href="<?php print base_url()?>home/main_panel">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Tableau de bord</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Connexion caisse">
          <a class="nav-link" href="<?php print base_url()?>checkout/login">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text" >Connexion caisse</span>
          </a>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Paramètres">
          <a class="nav-link" href="<?php print base_url()?>enterprise/config">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Paramètres</span>
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
        <li class="breadcrumb-item ">Panel administrateur</li>
        <li class="breadcrumb-item active">Configuration</li>
      </ol>

      <div class="row">

        <div class="col-8">
          <!-- CONTENU -->

        <div class="card mb-3">
        <div class="card-header"><h4>Configuration</h4></div>
        <div class="card-body">

          <h4>Configuration actuelle</h4>
          Format papier : <?php if(isset($paper_format) ) print $paper_format;?><br><br>
          
          Signature :
          <p style="color:gray"><i>
            <?php if(isset($mark)) print nl2br( $mark ); ?>
          </i>
          </p>

          <h4>Editer la configuration</h4>
          <?php print validation_errors(); ?>
          <?php print form_open("enterprise/config_setup");  ?>

          <p>
          Format de la facture : <br/>

          <select name="enterp-cf-bill-format">
            <option value="a4">Format A4 - 210x297 mm</option>
            <option value="a5">Format A5 - 148x210 mm</option>
            <option value="a6">Format A6 - 105x148 mm </option>
            <option value="a7">Format A7 - 74x105 mm </option>
            <option value="a8">Format A8 - 52x74 mm</option>
          </select>
          </p>
          <p>
            Signature: <br/>
            <textarea name="enterp-cf-mark"></textarea>
          </p>
          <input type="submit" class="btn btn-primary" value="Valider">
          
        </form>
      </div>
        <div class="card-footer small text-muted">

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
            <a class="btn btn-primary" href="<?php print base_url(); ?>home/logout">Deconnecter</a>
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
