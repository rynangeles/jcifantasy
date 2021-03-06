<?php 
	// if form submitted with errors 
	// set select value for dropdown
	isset($type) ?  $type_selected = $type : $type_selected = 0;
	isset($status) ?  $status_selected = $status : $status_selected = 1;
?>

<div class="content">
	<div class="formWrap clearfix">
		<h2>Create User</h2>
		<?php echo form_open('user/create'); ?>

		<div class="inputGroup">
			<?php 
				echo form_label('Username', 'username');
				echo form_input(array('name'=>'username', 'placeholder'=>'Username'),set_value('username'));
				echo form_error('username');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('First Name', 'first_name');
				echo form_input(array('name'=>'first_name', 'placeholder'=>'First Name'),set_value('first_name'));
				echo form_error('first_name');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Last Name', 'last_name');
				echo form_input(array('name'=>'last_name', 'placeholder'=>'Last Name'),set_value('last_name'));
				echo form_error('last_name');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Email', 'email');
				echo form_input(array('name'=>'email', 'placeholder'=>'Email'),set_value('email'));
				echo form_error('email');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Password', 'password');
				echo form_password(array('name'=>'password', 'placeholder'=>'Password'));
				echo form_error('password');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Confirm Password', 'confirm_password');
				echo form_password(array('name'=>'confirm_password', 'placeholder'=>'Confirm Password'));
				echo form_error('confirm_password');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('User Type', 'usertype');
				echo form_dropdown('usertype',array(0=>'Select',1=>'Admin',2=>'Team Manager'), $type_selected); 
				echo form_error('usertype');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Status', 'status');
				echo form_dropdown('status',array(0=>'Inactive',1=>'Active'), $status_selected); 
				echo form_error('status');
			?>
		</div>

		<div class="inputGroup action">
			<?php 
				echo form_reset(array('name'=>'reset', 'value'=>'Cancel', 'class'=>'btn'));
				echo form_submit(array('name'=>'submit', 'value'=>'Submit', 'class'=>'btn btnPrimary'));
			?>
		</div>

		<?php echo form_close(); ?>
	</div>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript">
	$(function(){

		$('input[value="Cancel"]').click(function(e){
			window.location.href = "<?php echo base_url().'user'; ?>";
		});

	});


</script>