<div class="content clearfix">
	<h1>Welcome! JCI Manila Basketball Drafting</h1>
	<?php if(isset($teams)): foreach($teams as $team):?>
	<div class="teamWrap">
		<span class="imgWrap">
			<img width="200" src="<?php echo base_url() . 'uploads/team/' . $team->team_logo; ?>" class="thumb"/>
		</span>
		<h3><?php echo $team->team_name; ?></h3>
		<h4><span class="label">Head Coach:</span> <?php echo ucfirst($team->coach_first_name) . ' ' . ucfirst($team->coach_last_name); ?></h4>
		<h4><span class="label">Manager :</span> <?php echo get_manager_name($team->manager_id); ?></h4>
	</div>
<?php endforeach; endif;  ?>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript"></script>