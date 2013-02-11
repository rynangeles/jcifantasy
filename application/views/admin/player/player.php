<div class="content">
	<div class="operation clearfix">
		<div class="searchBox">
			<?php echo form_open('player'); ?>
			<?php echo form_input(array('name'=>'search', 'placeholder'=>'Search Player', 'id'=>'search'),set_value('search'));?>
			<input type="image" src="<?php echo base_url(); ?>images/search.png" class="searchIcon">
			<?php echo form_submit(array('name'=>'submit', 'value'=>'Search', 'class'=>'searchButton'));?>
			<?php echo form_close(); ?>
		</div>
		<?php echo anchor('upload_csv', 'Import Players', array('class'=>'btn btnPrimary btnCreate')); ?>
		<?php echo anchor('player/create', 'Create Player', array('class'=>'btn btnPrimary btnCreate')); ?>
	</div>

	<?php if(isset($success_message)): ?>
		<div class="success message">
			<?php echo $success_message; ?>
		</div>
	<?php endif; ?>
	<table cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Position</th>
				<th>Height</th>
				<th>Weight</th>
				<th>Born</th>
				<th>Experience (Yrs.)</th>
				<th>Operation</th>
			</tr>
		</thead>
		<tbody>

			<?php if(isset($players)) : foreach ($players as $player) : ?>
			<tr>
				<td><?php echo $player->first_name; ?></td>
				<td><?php echo $player->last_name; ?></td>
				<td><?php echo readable_position($player->position); ?></td>
				<td><?php echo $player->height; ?> cm</td>
				<td><?php echo $player->weight; ?> kg</td>
				<td><?php echo date('d M Y',strtotime($player->born)); ?></td>
				<td><?php echo $player->experience; ?></td>
				<td>	
					<?php echo anchor('player/view/' . $player->id, 'View'); ?> |
					<?php echo anchor('player/edit/' . $player->id, 'Edit'); ?> |
					<?php echo anchor('player/delete/' . $player->id, 'Delete',array('class'=>'del')); ?>
				</td>
			</tr>
			<?php endforeach; endif; ?>

		</tbody>
	</table>
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
