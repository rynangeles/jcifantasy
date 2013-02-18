<?php 
	// if form submitted with errors 
	// set select value for dropdown
	$position_selected 	= isset($position) ? $position : 0;
	$type_selected 		= isset($type) ? $type : 0;
	$status_selected 	= isset($status) ? $status : 1;
?>
<div class="content">
	<div class="formWrap clearfix">
		<h2>Create Player</h2>
		<?php echo form_open_multipart('player/create'); ?>

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
				echo form_label('Born', 'born');
				echo form_input(array('name'=>'born', 'placeholder'=>'Born'),set_value('born'));
				echo form_error('born');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Member Type', 'member_type');
				echo form_dropdown('member_type', array(0 => 'Member type', 'Assoc/Sen' => 'Assoc/Sen', 'Regular' => 'Regular', 'BJC' => 'BJC') , $type_selected); 
				echo form_error('member_type');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Position', 'position');
				echo form_dropdown('position', array(0 => 'Position', 1 => 'Poin Guard', 2 => 'Shooting Guard', 3 => 'Small Forward', 4 => 'Power Forward', 5 => 'Center') , $position_selected); 
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Last Year Rank', 'last_year_rank');
				echo form_input(array('name'=>'last_year_rank', 'placeholder'=>'Last Year Rank'),set_value('last_year_rank'));
				echo form_error('last_year_rank');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Mobile', 'mobile');
				echo form_input(array('name'=>'mobile', 'placeholder'=>'Mobile'),set_value('mobile'));
				echo form_error('mobile');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Suncell', 'suncell');
				echo form_input(array('name'=>'suncell', 'placeholder'=>'Suncell'),set_value('suncell'));
				echo form_error('suncell');
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
			window.location.href = "<?php echo base_url().'player'; ?>";
		});

		$('input[name="born"]').datepicker({
			inline: true,
			dateFormat: 'yy-mm-dd',
			changeYear: true,
            changeMonth: true,
            showOtherMonths: true,
            selectOtherMonths: true,
            yearRange: '1900:' + new Date().getFullYear()

		});
		
	});


</script>