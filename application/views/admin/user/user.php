<div class="content">
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
				<td><?php echo $user->type; ?></td>
				<td><?php echo $user->created; ?></td>
				<td><?php echo $user->last_login; ?></td>
				<td>
					<a href="<?php echo base_url().'user/view/'.$user->id;?>">View</a> | 
					<a href="<?php echo base_url().'user/edit/'.$user->id;?>">Edit</a> |
					<a href="<?php echo base_url().'user/delete/'.$user->id;?>">Delete</a>
				</td>
			</tr>
			<?php endforeach; endif; ?>
		</tbody>
	</table>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript"></script>