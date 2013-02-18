<div class="content clearfix">
	<?php if(isset($message)) : ?>
	<div class="message ui-corner-all <?php echo $message['status'] ? 'ui-state-highlight' : 'ui-state-error'; ?>" >
		<p>
			<span class="ui-icon <?php echo $message['status'] ? 'ui-icon-info' : 'ui-icon-alert'; ?>"></span>
			<?php echo $message['message']; ?>
		</p>
	</div>
	<div class="enterWrap">
		<a class="<?php echo $message['status'] ? 'btn btnPrimary' : 'btn'; ?>" href="<?php echo base_url(). 'drafting'?>">Enter The Drafting Page</a>
	</div>
	<?php endif; ?>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript">
	
	var interval = setInterval(refresh,10000);

	function refresh(){

		location.reload();

	}

</script>
