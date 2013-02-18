<div class="content">
	<h1>Draw Lots</h1>
	<div class=" clearfix">

		<?php if(isset($turns)): foreach ($turns as $turn): ?>
		<div class="accending">
			<h2>
				<?php 
					if($turn->queue == 1){

						echo $turn->queue . 'st';

					}elseif($turn->queue == 2){

						echo $turn->queue . 'nd';

					}elseif($turn->queue == 3){

						echo $turn->queue . 'rd';

					}else{

						echo $turn->queue . 'th';

					}
				?>
			</h2>

			<span class="imgWrap">
				<img src="<?php echo base_url() . 'uploads/team/' . $turn->team_logo; ?>">
			</span>
			<h3><?php echo $turn->team_name; ?></h3>
			<h4><span class="label">Owner:</span><?php echo isset($turn->owner_name) ? ucfirst($turn->owner_name): ''; ?></h4>
			<h4><span class="label">Manager :</span> <?php echo get_manager_name($turn->manager_id); ?></h4>
			
		</div>
		<?php endforeach; endif; ?>

		<div class="slideWrap">
		<h2>Spin &amp; Draw</h2>
		<div id="slides">
			<?php if(isset($teams)): foreach ($teams as $team): ?>
			<div>
				<img team_id="<?php echo $team->id; ?>" src="<?php echo base_url() . 'uploads/team/' . $team->team_logo; ?>">
			</div>
			<?php endforeach; endif; ?>
		</div>

		<div class="slideFormWrap">
			<?php echo form_open('team/draw_lot',array('class' => 'drawLotForm', 'id' => 'draw-lot-form'),array('team_id' => '', 'queue_id' => $queue)); ?>
			<div class="actionWrap">
				<?php echo form_submit(array('class'=>'btn spin','id'=>'draw-btn','name'=>'submit', 'value'=>'Spin'));?>
			</div>
			<?php echo form_close(); ?>
		</div>
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

	// init spin image
	var spin;

	$(function(){

		//if the image is less than 2, dont do the slide
		if($("#slides > div").length > 1){

			$("#slides > div:gt(0)").hide();

			//draw button and submit the form for queueing
			$('#draw-btn').click(function(e){

				if($(this).hasClass('spin')){

					e.preventDefault();

					spin = setInterval(slide, 70);

					$(this).removeClass('spin').addClass('draw btnPrimary').val('Draw');

				}else{

					draw();

					$(this).removeClass('draw').addClass('spin').val('Spin');

				}
			});

		}else if($("#slides > div").length < 1){

			$(".slideWrap").hide();

		}else{

			$("#slides > div").addClass('picked');

			$('#draw-btn').removeClass('spin').addClass('draw btnPrimary').val('Draw');

			$('#draw-btn').click(draw);

			clearInterval(spin);

		}

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

		clearInterval(spin);// to be called when you want to stop the slide

		team_id = $('.picked img').attr('team_id');

		$('input[name="team_id"]').val(team_id);

		$('#draw-lot-form').submit();

	}

</script>