<div class="content clearfix">
	<h1>Welcome! JCI Manila Basketball Drafting</h1>
	<h3><?php echo isset($success_message) ? $success_message : ''; ?></h3>
	<?php if(isset($teams)): foreach($teams as $team):?>
	<div class="teamWrap">
		<span class="imgWrap">
			<img width="111" src="<?php echo base_url() . 'uploads/team/' . $team->team_logo; ?>" class="thumb"/>
		</span>
		<h3><?php echo $team->team_name; ?></h3>
		<h4>Players</h4>
		<ul>
			<?php echo get_team_players($team->id); ?>
		</ul>
	</div>
<?php endforeach; endif;  ?>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript">

	var interval = setInterval(refresh,10000);

	$(function(){

		setTimeout(function() { 

			$('.latest').removeClass('latest'); 

		}, 3000); 

	});

	function refresh(){

		location.reload();

	}

</script>