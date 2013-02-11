<div class="content">
	<div class="slideWrap">
		<div id="slides">
			<?php if(isset($teams)): foreach ($teams as $team): ?>
			<div>
				<img team_id="<?php echo $team->id; ?>" src="<?php echo base_url() . 'uploads/team/thumb/' . $team->team_logo_thumb; ?>">
			</div>
			<?php endforeach; endif; ?>
		</div>
		<div id="timer"></div>
		<div class="slideFormWrap">
			<?php echo form_open('team/draw_lot',array('class' => 'drawLotForm', 'id' => 'draw-lot-form'),array('team_id' => '', 'queue_id' => $queue)); ?>
			<div class="actionWrap">
				<?php echo form_submit(array('class'=>'btn btnPrimary','id'=>'draw-btn','name'=>'submit', 'value'=>'Draw'));?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript">

	$(function(){

		$('input[value="Cancel"]').click(function(e){
			window.location.href = "<?php echo base_url().'team'; ?>";
		});

	});

	// slides the images
	var slide = setInterval(slide, 70);

	$(function(){

		//if the image is less than 2, dont do the slide
		if($("#slides > div").length > 1){

			$("#slides > div:gt(0)").hide();

		}else{

			$("#slides > div").addClass('picked');

			clearInterval(slide);

		}

		//draw button and submit the form for queueing
		$('#draw-btn').click(draw);

		// restarts and refresh the page
		$('#restart').click(function(e){

			window.location.href = "<?php echo base_url() . 'team/draw_lot'; ?>";

		});
		
	});

	//fucntion that slide the images 
	function slide(){

		$('#slides > div:first').removeClass('picked')
		.fadeOut(50)
		.next().addClass('picked')
		.fadeIn(50)
		.end()
		.appendTo('#slides');

	}

	//function that draws the next queue
	function draw(){

		clearInterval(slide);// to be called when you want to stop the slide

		team_id = $('.picked img').attr('team_id');

		$('input[name="team_id"]').val(team_id);

		$('#draw-lot-form').submit();

	}

</script>