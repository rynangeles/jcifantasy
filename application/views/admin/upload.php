<div class="content">

	<div class="formWrap clearfix">

		<h2>Upload Players via CSV</h2>

	<?php if(isset($errors)){ echo $errors; } ?>

	<?php echo form_open_multipart(); ?>

	<?php echo form_upload(array('name'=>'upload_csv', 'id'=>'upload-csv')); ?>
	<?php echo form_submit(array('name'=>'submit', 'value'=>'Submit', 'class'=>'btn btnPrimary')); ?>
	<?php echo form_reset(array('name'=>'reset', 'value'=>'Cancel', 'class'=>'btn')); ?>

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

	});

</script>
