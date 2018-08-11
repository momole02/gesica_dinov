<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title> GESICA - Mode administrateur </title>
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
    <a class="navbar-brand" href="index.html">GESICA</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">
  
        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Editer l'entreprise">
          <a class="nav-link" href="<?php print base_url()?>home/main_panel">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Tableau de bord</span>
          </a>
        </li>

      <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Editer l'entreprise">
          <a class="nav-link" href="index.html">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Opérations</span>
          </a>
        </li>

        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Connexion caisse">
          <a class="nav-link" href="<?php print base_url()?>checkout/login">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text" >Connexion caisse</span>
          </a>
        </li>


        <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Editer l'entreprise">
          <a class="nav-link" href="index.html">
            <i class="fa fa-fw fa-file"></i>
            <span class="nav-link-text">Se désinscrire</span>
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

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-fw fa-bell"></i>
            <span class="d-lg-none">Notifications
              <span class="badge badge-pill badge-warning">6 New</span>
            </span>
            <span class="indicator text-warning d-none d-lg-block">
             <!-- <i class="fa fa-fw fa-circle"></i> --> <!-- En cas de nouvelles notification afficher le cercle jaune-->
            </span>
          </a>


          <div class="dropdown-menu" aria-labelledby="alertsDropdown">
            
            <h6 class="dropdown-header">Nouvelles notifications</h6>


            <div class="dropdown-divider"></div> 

            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Nouvelle vente</strong>
              </span>
              <span class="small float-right text-muted">15:00 </span>
              <div class="dropdown-message small">Une vente de 15 000 Frs à été effectuée</div>
            </a>
            
            <!--
            <div class="dropdown-divider"></div>
            
            <a class="dropdown-item" href="#">
              <span class="text-danger">
                <strong>
                  <i class="fa fa-long-arrow-down fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
            
            <div class="dropdown-divider"></div>
            
            <a class="dropdown-item" href="#">
              <span class="text-success">
                <strong>
                  <i class="fa fa-long-arrow-up fa-fw"></i>Status Update</strong>
              </span>
              <span class="small float-right text-muted">11:21 AM</span>
              <div class="dropdown-message small">This is an automated server response message. All systems are online.</div>
            </a>
          -->
            <div class="dropdown-divider"></div>

            <a class="dropdown-item small" href="#">View all alerts</a>
          
          </div>
        </li>
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
          <a href="index.html">GESICA</a>
        </li>
        <li class="breadcrumb-item active">Panel administrateur</li>
      </ol>

      <div class="row">

        <div class="col-8">
          <!-- CONTENU -->

        <div class="card mb-3">
        <div class="card-header"><h4>Entreprise</h4></div>
        <div class="card-body">
          <ul>
            <?php $d = $admin_data; ?>
            <li><b>Code</b> : <?php print $d->code_ent; ?></li>
            <li><b>Nom</b> : <?php print $d->nom_ent;?></li>
            <li><b>Nom du propriétaire</b> : <?php print $d->nom_pro_ent;?></li>
            <li><b>Prénom du propriétaire</b> : <?php print $d->pnom_pro_ent;?></li>
          </ul>
          <hr/>
          <pre>
            <?php print $d->desc_ent;?>
          </pre>
        </div>

        <div class="card-footer small text-muted">

<!--
        <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
            <i class="fa fa-fw fa-sign-out"></i>Fermer l'entreprise</a> -->
  
        <a class="btn btn-primary"  style="font-size:12px;" href="<?php print base_url(); ?>enterprise/edit_attributes">Modifier les attributs</a>

        <a class="btn btn-primary " style="font-size:12px;" href="<?php print base_url(); ?>enterprise/edit_password">Modifier le mot de passe</a>

        </div>
        </div>


        <div class="card mb-3">
        <div class="card-header"><h4>Caisses</h4></div>
        <div class="card-body">
        <?php 
          if( count( $checkouts ) == 0 ){
            print "<i>Aucune caisse n'a été crée</i>";
          }else{
            print '<table id="dataTable" class="table table-bordered dataTable" role="grid" aria-describly="dataTable_info">';
            $cd = $checkouts;
?>
            <thead><tr role="row"><td><b>Numero caisse</b></td><td><b>Nom </b></td><td><b>Prénom </b></td><td><b>Pseudo </b></td><td><b>Opérations</b></td></tr></thead>
<?php 
            for( $i=0;$i<count($checkouts);++$i ){
?>
              <tr>
                  <td><?php print $cd[$i]->num_caisse; ?></td>                  
                  <td><?php print $cd[$i]->nom_caisse;?></td>
                  <td><?php print $cd[$i]->pnom_caisse;?></td>
                  <td><?php print $cd[$i]->pseudo_caisse;?></td>
                  <td>

                    <a class="btn btn-primary " style="font-size:12px;" href="<?php print base_url().'enterprise/drop_checkout/'.$i; ?>">
                      Supprimer
                    </a>

                  </td>
              </tr>
<?php 
            }
          }
          print '</table>';
        ?>
        </div>
        <div class="card-footer small text-muted">  


        <a class="btn btn-primary " style="font-size:12px;" href="<?php print base_url(); ?>checkout/new_checkout">Nouvelle caisse</a>

        </div>
        </div>

        <div class="card mb-3">
        <div class="card-header"><h4>Ajouter mes articles</h4></div>
        <div class="card-body">
          Ce panel vous permettra d'ajouter vos articles rapidement.<br/>
          Rédiger vos articles à l'interieur d'un fichier excel, en respectant l'ordre 
          des champs suivants : <br/>
          <pre>-------------------------------------------------------
|Nom_article|Type_article|Quantité|Prix_vente_article|
-------------------------------------------------------</pre>

        Enregistrez le au format <b>CSV avec séparateur point virgule</b>, puis spécifiez le dans le champ ci dessous. <br><br>

        <b style="color:red"><?php if(isset($upload_error)) print $upload_error; ?></b>
        <?php print form_open_multipart("product/magic_insert")?>

        <p>
          <div class="form-group">
            <input type="file" name="products-csv-file" >
          </div>
        </p>

        <input type="submit" class="btn btn-primary btn-block" style="width:100px"value="Envoyer">
        <br>
        </form>
        <p>
          <b>Pour pouvoir gérer vos articles créez un nouveau compte en tant que gestionnaire(nouvelle caisse).</b>
        </p>
        </div>

        <div class="card-footer small text-muted">

          
        </div>
        </div>

        <div class="card mb-3">
        <div class="card-header"><h4>Etats de sortie</h4></div>
        <div class="card-body">

          <a class="btn btn-primary" href="<?php print base_url(); ?>Sadiicrudgenerator/article">Listing des articles</a><br/><br/>
          <a class="btn btn-primary" href="<?php print base_url(); ?>Sadiicrudgenerator/operation_caisse">Listing des opérations caisses</a><br/><br/>
          <a class="btn btn-primary" href="<?php print base_url(); ?>Sadiicrudgenerator/operationentr"> Listing des opérations de l'entreprise</a><br/><br/>          
          <a class="btn btn-primary" href="<?php print base_url(); ?>Sadiicrudgenerator/rel_vendre"> Listing des ventes</a><br/><br/>
          <a class="btn btn-primary" href="<?php print base_url(); ?>Sadiicrudgenerator/rel_appro"> Listing ravitaillement</a><br/><br/>

        </div>

        <div class="card-footer small text-muted">
          
        </div>
        </div>
   

        </div>


      <div class="col-4">
      <div class="card mb-3">
        <div class="card-header"><h4>Logo</h4></div>
        <div class="card-body">
          <img width="150" src="<?php if(isset($logo_image_path)) print $logo_image_path;   ?>"/>


        <div style="color:red">
          <?php if(isset($upload_error_logo)) print $upload_error_logo; ?>
        </div>

            <?php print form_open_multipart("enterprise/set_logo")?>
          <input type="file" name="enterp-logo" />
          <input class="btn btn-primary" type="submit" value="Modifier"/>
          </form>

        </div>
      
        <div class="card-footer small text-muted">


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
          <small>Copyright © SADII 2018 </small>
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
