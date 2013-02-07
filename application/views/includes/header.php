<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		<title>Namoco Property Management System</title>
		<!--[if lt IE 9]>
			<script src="<?php echo base_url();?>javascripts/html5.js"></script>
			<script src="<?php echo base_url();?>javascripts/IE9.js"></script>
        <![endif]-->
        <link rel="stylesheet" href="<?php echo base_url();?>stylesheets/global.css" type="text/css" media="screen" />
        <?php if(isset($stylesheets)): ?>
		<?php foreach ($stylesheets as $stylesheet): ?>
		<link rel="stylesheet" href="<?php echo base_url();?>stylesheets/<?php echo $stylesheet; ?>.css" type="text/css" media="screen" />
		<?php endforeach; endif; ?>
	</head>
	<body id="<?php echo $page_id; ?>" >