<?php 
$config['base_url'] = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == "on") ? "https" : "http");
$config['base_url'] .= "://".$_SERVER['HTTP_HOST'];
$config['base_url'] .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
 ?>
<html>
<head>
	<title><?php echo $heading; ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="shortcut icon" type="image/png" href="<?php echo $config['base_url'];?>/assets/images/logo-icon.png"/>
    <link rel="stylesheet" href="<?php echo $config['base_url'];?>/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $config['base_url'];?>/assets/fontawesome/css/font-awesome.min.css">
    <style type="text/css">
    .turun {margin-top: 10%;}
    </style>
</head>
<body>
<section class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default turun">
				<div class="panel-heading">
					<img src="<?php echo $config['base_url'];?>/assets/images/brand.png" class="pull-right hidden-xs">
					<h3 class="text-danger"><i class="fa fa-warning"></i> <?php echo $heading; ?></h3>
				</div>
			  <div class="panel-body">
			    Dear <span class="text-danger">{User}</span>,
			    <p><?php echo $message; ?></p>
			  </div>
			  <div class="panel-footer">
			  	<small>Powered By :</small>
			  	<img src="<?php echo $config['base_url'];?>/assets/images/icon.png" width="50">
			  	<a href="<?php echo $config['base_url'];?>/" class="btn btn-default pull-right"><i class="fa fa-sign-out"></i> Back to application</a>
			  </div>
			</div>
		</div>
	</div>
</section>
    <script src="../assets/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>