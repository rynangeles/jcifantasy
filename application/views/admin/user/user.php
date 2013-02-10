<div class="content">
	<div class="operation clearfix">
		<div class="searchBox">
			<?php echo form_open('user'); ?>
			<?php echo form_input(array('name'=>'search', 'placeholder'=>'Search User', 'id'=>'search'),set_value('search'));?>
			<input type="image" src="<?php echo base_url(); ?>images/search.png" class="searchIcon">
			<?php echo form_submit(array('name'=>'submit', 'value'=>'Search', 'class'=>'searchButton'));?>
			<?php echo form_close(); ?>
		</div>
		<?php echo anchor('user/create', 'Create User', array('class'=>'btn btnPrimary btnCreate')); ?>
	</div>

	<?php if(isset($success_message)): ?>
		<div class="success message">
			<?php echo $success_message; ?>
		</div>
	<?php endif; ?>
	
	<table cellpadding="0" cellspacing="0" border="0">
		<thead>
			<tr>
				<th>Username</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Email</th>
				<th>User Type</th>
				<th>Created</th>
				<th>Last Login</th>
				<th>Operation</th>
			</tr>
		</thead>
		<tbody>
			<?php if(isset($users)): foreach($users as $user): ?>
			<tr>
				<td><?php echo $user->username; ?></td>
				<td><?php echo $user->first_name; ?></td>
				<td><?php echo $user->last_name; ?></td>
				<td><?php echo $user->email; ?></td>
				<td><?php echo get_user_type($user->type); ?></td>
				<td><?php echo unix_to_human(strtotime($user->created)); ?></td>
				<td><?php echo unix_to_human(strtotime($user->last_login)); ?></td>
				<td>
					<?php echo anchor('user/view/' . $user->id, 'View'); ?> |
					<?php echo anchor('user/edit/' . $user->id, 'Edit'); ?> |
					<?php echo anchor('user/delete/' . $user->id, 'Delete',array('class'=>'del')); ?>
				</td>
			</tr>
			<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript">
	$('.del').click(function(e){
		
		var del = confirm('Are you sure you want to delete this item');

		if(!del){

			return false;
			
		}

	});
</script>