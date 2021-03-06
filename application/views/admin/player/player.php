<?php isset($player) ? $player_selected = $player : $player_selected = 0; ?>
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
				<th style="width:100px;">First Name</th>
				<th>Last Name</th>
				<th style="width:100px;">Member Type</th>
				<th>Email</th>
				<th style="width:80px;">Mobile</th>
				<th style="width:90px;">Suncell</th>
				<th>Born</th>
				<th>Status</th>
				<th>Operation</th>
			</tr>
		</thead>
		<tbody>

			<?php if(isset($players)) : foreach ($players as $player) : ?>
			<tr>
				<td><?php echo $player->first_name; ?></td>
				<td><?php echo $player->last_name; ?></td>
				<td><?php echo $player->member_type; ?></td>
				<td><p style="width:170px; word-wrap:break-word;"><?php echo $player->email; ?></p></td>
				<td><?php echo $player->mobile; ?></td>
				<td><?php echo $player->suncell; ?></td>
				<td><?php echo date('d M Y',strtotime($player->born)); ?></td>
				<td><?php echo get_status($player->active); ?></td>
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

		$('.del').click(function(e){
			
			var del = confirm('Are you sure you want to delete this item');

			if(!del){

				return false;
				
			}

		});

	});

</script>
