<?php 
	// if form submitted with errors 
	// set select value for dropdown
	isset($manager) ?  $manager_selected = $manager : $manager_selected = 0;
	isset($status) ?  $status_selected = $status : $status_selected = 1;
?>

<div class="content">
	<h2>Create Team</h2>
	<div class="formWrap clearfix">
		<?php echo form_open_multipart('team/create'); ?>

		<div class="inputGroup">
			<?php 
				echo form_label('Team Logo', 'team_logo');
				echo form_upload(array('name'=>'team_logo')); 
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Coach First Name', 'coach_first_name');
				echo form_input(array('name'=>'coach_first_name', 'placeholder'=>'Coach First Name'),set_value('coach_first_name'));
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Coach Last Name', 'coach_last_name');
				echo form_input(array('name'=>'coach_last_name', 'placeholder'=>'Coach Last Name'),set_value('coach_last_name'));
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Team Manager', 'manager');
				echo isset($managers_option) ? form_dropdown('manager', array_unshift($managers_option, 'Select'), $manager_selected) : form_dropdown('manager',array(0=>'Select'), 0); 
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Team Status', 'status');
				echo form_dropdown('status', array(0 => 'Inactive', 1 => 'Active') , $status_selected); 
			?>
		</div>

		<div class="inputGroup action">
			<?php 
				echo form_reset(array('name'=>'reset', 'value'=>'Clear', 'class'=>'btn'));
				echo form_submit(array('name'=>'submit', 'value'=>'Submit', 'class'=>'btn btnPrimary'));
			?>
		</div>

		<?php echo form_close(); ?>
	</div>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript"></script>