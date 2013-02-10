<?php 
	// if form submitted with errors 
	// set select value for dropdown
	isset($manager) ?  $manager_selected = $manager : $manager_selected = 0;
	isset($status) ?  $status_selected = $status : $status_selected = 1;
?>

<div class="content">
	<div class="formWrap clearfix">
		<h2>Edit User</h2>
		<?php echo form_open_multipart(); ?>

		<div class="inputGroup">
			<?php echo form_label('Team Logo', 'team_logo'); ?>
			<!-- <div class="imageWrap">
				<div class="image">
					<img id="thumb" style="width:100%;height:100%;" src="<?php echo base_url(); ?>images/bg_transparent.png">
				</div>
				<?php echo form_upload(array('name'=>'team_logo', 'id'=>'team_logo')); ?>
			</div> -->
			<?php echo form_upload(array('name'=>'team_logo', 'id'=>'team_logo')); ?>
			<?php echo isset($upload_error) ? $upload_error : ' '; ?>
		</div>

		<!--<?php echo form_hidden('logo_image_filename', ' '); ?>-->
		<div class="inputGroup">
			<?php 
				echo form_label('Team Name', 'team_name');
				echo form_input(array('name'=>'team_name', 'placeholder'=>'Team Name'),set_value('team_name',$default->team_name));
				echo form_error('team_name');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Coach First Name', 'coach_first_name');
				echo form_input(array('name'=>'coach_first_name', 'placeholder'=>'Coach First Name'),set_value('coach_first_name',$default->coach_first_name));
				echo form_error('coach_first_name');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Coach Last Name', 'coach_last_name');
				echo form_input(array('name'=>'coach_last_name', 'placeholder'=>'Coach Last Name'),set_value('coach_last_name',$default->coach_last_name));
				echo form_error('coach_last_name');
			?>
		</div>
		<div class="inputGroup">
			<?php 
				echo form_label('Team Manager', 'manager');
				echo isset($managers_option) ? form_dropdown('manager', $managers_option, $manager_selected) : form_dropdown('manager',array(0=>'Select'), 0); 
				echo form_error('manager');
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
			window.location.href = "<?php echo base_url().'user'; ?>";
		});

		// var thumb = $('#thumb');	

		// new AjaxUpload('team_logo', {
		// 	action: $('#logo-temp-upload').attr('action'),
		// 	name: 'image',
		// 	onSubmit: function(file, extension) {

		// 		$('.imageWrap .image').addClass('loading');
		// 	},
		// 	onComplete: function(file, response) {

		// 		thumb.load(function(){
		// 			$('.imageWrap .image').removeClass('loading');
		// 			thumb.unbind();
		// 		});
		// 		thumb.attr('src', response);

		// 	}

		// });

	});


</script>