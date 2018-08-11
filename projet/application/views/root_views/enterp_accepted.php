 <!DOCTYPE HTML>
<html>
<head>
	<title>GESICA Back-Office</title>
</head>
<body>
	<p>
		
		[  <a href="<?php print base_url();?>root/enterp_crud"> CRUD Abonnés </a>  ] -
		[  <a href="<?php print base_url();?>root/subscriber_status"> Status abonné</a>  ] - 
		[  <a href="<?php print base_url();?>home/signup"> Nouvelle entreprise</a>  ]-
		[  <a href="<?php print base_url();?>root/close"> Fermer</a>  ]
	</p>
	<hr>
	<h1>Back-Office GESICA</h1>
	<hr>
	<p>
		Inscription validée !<br/><br/>

		le code la nouvelle entreprise est :<b><?php if( isset($enterp_code) ) print $enterp_code; ?></b>

	</p>
</body>
</html>