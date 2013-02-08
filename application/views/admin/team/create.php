<div class="content">
	<div class="formWrap clearfix">
		<?php echo form_open('team/create'); ?>
		<?php echo form_input(array('name'=>'coach_first_name', 'placeholder'=>'Coach First Name'),set_value('coach_first_name'));?>
		<?php echo form_input(array('name'=>'coach_last_name', 'placeholder'=>'Coach Last Name'),set_value('coach_last_name'));?>
		<?php echo form_submit(array('name'=>'submit', 'value'=>'Search', 'class'=>'searchButton'));?>
		<?php echo form_close(); ?>
		<?php echo anchor('team/create', 'Create Team', array('class'=>'btn btnPrimary btnCreate')); ?>
	</div>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript"></script>