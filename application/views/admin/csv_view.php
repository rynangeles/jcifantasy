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
				<th>Member Type</th>
				<th>Mobile</th>
				<th>Born</th>
				<th>Email</th>
				<th>Active</th>
			</tr>
		</thead>
		<tbody>

			<?php if(isset($csv_data)) : foreach ($csv_data as $data) : ?>
			<!-- <tr>
				<?php foreach ($data as $datum) : ?>

					<td><?php echo $datum; ?></td>
				
				<?php endforeach; ?>
			</tr> -->
			<tr>
				<td><?php echo $data['FIRSTNAME']; ?></td>
				<td><?php echo $data['LASTNAME']; ?></td>
				<td><?php echo $data['POSITION']; ?></td>
				<td><?php echo $data['MEMBERTYPE']; ?></td>
				<td><?php echo $data['MOBILE']; ?></td>
				<td><?php echo $data['BORN']; ?></td>
				<td><?php echo $data['EMAIL']; ?></td>
				<td>1</td>
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
