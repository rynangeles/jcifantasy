<div class="content">
	<div class="operation clearfix">
		<div class="searchBox">
			<?php echo form_open('team'); ?>
			<?php echo form_input(array('name'=>'search', 'placeholder'=>'Search Team', 'id'=>'search'),set_value('search'));?>
			<input type="image" src="<?php echo base_url(); ?>images/search.png" class="searchIcon">
			<?php echo form_submit(array('name'=>'submit', 'value'=>'Search', 'class'=>'searchButton'));?>
			<?php echo form_close(); ?>
		</div>
		<?php echo anchor('team/create', 'Create Team', array('class'=>'btn btnPrimary btnCreate')); ?>
	</div>

	<?php if(isset($success_message)): ?>
		<div class="success message">
			<?php echo $success_message; ?>
		</div>
	<?php endif; ?>
	<table cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th>Logo</th>
				<th>Team Name</th>
				<th>Manager Name</th>
				<th>Coach Name</th>
				<th>Created</th>
				<th>Queue</th>
				<th>Status</th>
				<th>Operation</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($teams)): foreach($teams as $team): ?>
			<tr>
				<td><img width="90" src="<?php echo base_url() . 'uploads/team/thumb/' . $team->team_logo_thumb; ?>" class="thumb"/></td>
				<td><?php echo $team->team_name; ?></td>
				<td><?php echo get_manager_name($team->manager_id); ?></td>
				<td><?php echo $team->coach_first_name . ' ' . $team->coach_last_name; ?></td>
				<td><?php echo date('d M Y g:i a',strtotime($team->created)); ?></td>
				<td><?php echo ($team->queue != '') ? $team->queue : '0'; ?></td>
				<td><?php echo get_status($team->active); ?></td>
				<td>
					<?php echo anchor('team/view/' . $team->id, 'View'); ?> |
					<?php echo anchor('team/edit/' . $team->id, 'Edit'); ?> |
					<?php echo anchor('team/delete/' . $team->id, 'Delete',array('class'=>'del')); ?>
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