<div class="content">
	<h1>Review players</h1>
	<?php if(isset($success_message)):?>
	<h3><?php echo $success_message; ?></h3>
	<?php endif;?>
	<table>
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Position</th>
				<th>Height</th>
				<th>Weight</th>
				<th>Born</th>
				<th>Experience</th>
				<th>Active</th>
			</tr>
		</thead>
		<tbody>

			<?php if(isset($csv_data)) : foreach ($csv_data as $data) : ?>
			<tr>
				<?php foreach ($data as $datum) : ?>

					<td><?php echo $datum; ?></td>
				
				<?php endforeach; ?>
			</tr>
			<?php endforeach; endif; ?>

		</tbody>
	</table>
	<div class="saveWrap">

		<?php 
			echo form_open(); 
			echo form_reset(array('name'=>'reset', 'value'=>'Cancel', 'class'=>'btn'));
			echo form_submit(array('name'=>'submit', 'value'=>'Save Players', 'class'=>'btn btnPrimary')); 
			echo form_close(); 
		?>

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
