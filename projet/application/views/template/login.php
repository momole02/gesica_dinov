<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>GESICA - Connexion </title>
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

      <div class="card-header"> 
        <?php if( !isset($partial_login) ) print "<b>GESICA - Connexion en tant qu'entreprise</b>"; 
        else print "<b>GESICA - Passage en mode administrateur</b>" ;?>
        
      </div>

      <script type="text/javascript">
        $.getJSON( "http://gesicaci.epizy.com/api961d12ae3c2b/list_products", function(rep){
          alert(rep);
        } );
      </script>
      <div class="card-body">


        <div style="color:red">
          <?php print validation_errors(); ?>

          <?php if(isset( $connection_error ) && $connection_error==='1'){
            print "Erreur lors de la connexion. vérifiez vos identifiants";
          }
          ?>
        </div>

        <?php print form_open("connection/connect"); ?>

          <?php if( !isset($partial_login) ){ ?>
            <p>
              <i> Bienvenue sur GESICA ! </i>
            </p>
            <div class="form-group">
              <label for="exampleInputEmail1">Code de l'entreprise</label>
              <input class="form-control" id="enterp-code" name="enterp-code" type="text"  placeholder="Entrez le code de l'entreprise">
            </div>

            <div class="form-group">
              <label for="exampleInputEmail1">Pseudo</label>
              <input class="form-control" id="enterp-own-pseudo" name="enterp-own-pseudo" type="text" placeholder="Entrez le pseudo administrateur">
            </div>
          <?php } 

          ?>

          <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            <input class="form-control" id="enterp-own-passwd" name="enterp-own-passwd" type="password" placeholder="Mot de passe administrateur">
          </div>

<?php if( !isset($partial_login) ){ ?>
          <div class="form-group">
            <div class="form-check">
              <label class="form-check-label">
                <input class="form-check-input" name="enterp-stay-alive"type="checkbox"> Rester connecté</label>
            </div>
          </div>
<?php }?>

          <input type="submit" class="btn btn-primary btn-block"  value="Connexion">
        </form>



          <?php  if( isset($partial_login) ){?>
          <div class="text-center">
            <a  class="d-block small mt-3" href="<?php print base_url();?>home/">Retourner au login caisse </a>
          </div>
          <?php } ?>

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
