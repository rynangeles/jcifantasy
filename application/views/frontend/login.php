<div class="content formWrap" id="login_form">
	<h1>JCI Manila Basketball Drafting</h1>
	<?php echo form_open('login');?>
	<fieldset>
		<legend>Login</legend>
		<label for="username">Username :</label>
		<?php echo form_input(array('name'=>'username', 'placeholder'=>'Username'),set_value('username'));?>
		<?php echo form_error('username'); ?>
		<label for="password">Password :</label>
		<?php echo form_password(array('name'=>'password', 'placeholder'=>'Password'));?>
		<?php echo form_error('password'); ?>
		
		<!-- messaging -->
		<?php if(isset($invalid_login)): ?>
		<span class="error"><?php echo $invalid_login; ?></span>
		<?php endif; ?>

		<?php if(isset($logout_message)): ?>
		<span class="alert"><?php echo $logout_message; ?></span>
		<?php endif; ?>

		<?php if(isset($not_loggedin_message)): ?>
		<span class="error"><?php echo $not_loggedin_message; ?></span>
		<?php endif; ?>

		<?php if(isset($inactive_message)): ?>
		<span class="error"><?php echo $inactive_message; ?></span>
		<?php endif; ?>
		<!--end  messaging -->

		<div class="submitWrap">
		<?php echo form_submit(array('name'=>'submit', 'value'=>'Login', 'class'=>'btn btnPrimary'));?>
		</div>
	</fieldset>
	<?php echo form_close();?>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript"></script>