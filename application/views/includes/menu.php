<header class="clearfix">

	<?php if($page_id != 'login'): ?>
	<nav>
		<ul>
			<li><a href="<?php echo base_url();?>admin">Home</a> | </li>
			<?php if(isset($menus)): foreach($menus as $menu): ?>
			<li><a href="<?php echo base_url().$menu;?>"><?php echo ucfirst($menu); ?></a> | </li>
			<?php endforeach; endif; ?>
			<li><a href="<?php echo base_url();?>logout">Logout</a></li>
		</ul>
	</nav>
	<?php endif; ?>

	<a id="logo" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>images/main-logo.png"/></a>
</header>