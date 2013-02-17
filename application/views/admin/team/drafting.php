<div class="content clearfix">
	<!-- <h1>Drafting</h1> -->
	<div id="team" class="playerWrap">
		<h2><?php echo $team->team_name; ?></h2>
		<div class="teamWrap">
			<div class="teamDetail">
				<span class="imageWrap">
					<img width="200" height="150" src="<?php echo base_url() . 'uploads/team/' . $team->team_logo; ?>" class="thumb"/>
				</span>
				<h4><span class="label">Head Coach:</span> <?php echo ucfirst($team->coach_first_name) . ' ' . ucfirst($team->coach_last_name); ?></h4>
				<h4><span class="label">Manager :</span> <?php echo get_manager_name($team->manager_id); ?></h4>
			</div>
			<div class="formWrap">
				<h4>Player details</h4>
				<ul>
					<li id="player_name">
						<span class="label">Name : </span>
						<span class="value"></span> 
					</li>
					<li id="player_postion">
						<span class="label">Position : </span> 
						<span class="value"></span> 
					</li>
					<li id="player_mobile">
						<span class="label">Mobile : </span> 
						<span class="value"></span>
					</li>
					<li id="player_born">
						<span class="label">Born : </span> 
						<span class="value"></span> 
					</li>
					<li id="player_email">
						<span class="label">Email : </span> 
						<span class="value"></span>
					</li>
					<li id="player_lyr">
						<span class="label">Last Year Rank : </span> 
						<span class="value"></span>
					</li>

					<li class="form">
						<?php echo form_open('',array('class' => 'draftForm', 'id' => 'draft-form'),array('player_id' => '', 'team_id' => $team->id)); ?>
						<div class="actionWrap">
							<?php echo form_reset(array('name'=>'reset', 'value'=>'Clear', 'class'=>'btn')); ?>
							<?php echo form_submit(array('class'=>'btn','id'=>'draft-btn','name'=>'pass', 'value'=>'Pass'));?>
						</div>
						<?php echo form_close(); ?>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="team-player" class="playerWrap">
		<h2>My Players</h2>
		<ul>
			<li class="droppable"></li>
			<?php if(isset($team_players)) : foreach ($team_players as $team_player) : ?>
			<li>
				<span class="position"><?php echo readable_position($team_player->position);?></span> 
				<span class="name"><?php echo ucfirst($team_player->first_name) . ' ' . ucfirst($team_player->last_name); ?></span> 
			</li>
			<?php endforeach; endif; ?>
		</ul>

	</div>
	<div id="all-player" class="playerWrap">
		<h2>All Players</h2>
		<div class="searchWrap">
			<label for="search">Search</label>
		    <input type="text" id="search" placeholder="Search" name="searchword" value="" />
		    <input type="reset" id="clear-searh"  class="btn" value="Clear" />
	    </div>
		<ul id="player-list">

			<?php if(isset($all_players)) : foreach ($all_players as $all_player) : ?>
			<li  player='{ "player_id":<?php echo $all_player->id ?>,"position":"<?php echo readable_position($all_player->position) ?>","name":"<?php echo ucfirst($all_player->first_name) . ' ' . ucfirst($all_player->last_name); ?>","mobile":"<?php echo $all_player->mobile ?>","email":"<?php echo $all_player->email ?>","lyr":"<?php echo $all_player->last_year_rank ?>","born":"<?php echo date('d M Y',strtotime($all_player->born)); ?>"}'>
				<span class="position"><?php echo readable_position($all_player->position);?></span> 
				<span class="name"><?php echo ucfirst($all_player->first_name) . ' ' . ucfirst($all_player->last_name); ?></span> 
			</li>
			<?php endforeach; endif; ?>
		</ul>
	</div>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript">

	$(function(){

		ul_height = $('#all-player').height() - $('.searchWrap').outerHeight(true) - $('#all-player h2').outerHeight(true);

		$('#player-list').height(ul_height);

		$('input[name="reset"]').click(function(e){

			window.location.href = "<?php echo base_url().'drafting'; ?>";

		});


		searchWord = $('#search').val();

		search_players(searchWord);

		$('#search').bind("change keyup", function() {
		    
		    searchWord = $(this).val();

		    search_players(searchWord);
		    
		});

		$('#clear-searh').click(function(e){

			$('ul#player-list li').show();

		});

		$('#player-list li').draggable({
	        helper: 'clone',
	        cursor: 'move',
			revert: function (socketObj) {
				if (socketObj === true) {
					// drop success
					return false;
				}
				else {
					//reverted
	        		$(this).removeClass('drafting');
					return true;
				}
			},
	        start: function(e, ui){

	        	$(this).addClass('drafting');
	        	$('.ui-draggable-dragging').innerWidth($('#player-list').innerWidth());

	        },
	        drag: function(e, ui){

	        	$(".droppable").addClass('dropit');

	        },
	        stop: function(e, ui){

	        	$(".droppable").removeClass('dropit');

	        }
	    });

	    $(".droppable").droppable({

	        drop: function (e, ui) {


	            ui.helper.remove();
	            //recreate an object based on dropped object
	            var player = $(ui.draggable)[0];
				//set this oject to jquery
	            player = $(player);
	            //only one player should be drafted per pick
	            player.siblings().removeClass('drafted');

	            player.addClass('drafted');

	            cloned_player = player.clone();

	            player_attr = jQuery.parseJSON(player.attr('player'));

	            /*
	            player_attr = {
	            	'player_id':5,
	            	'position':5,
	            	'name':'Lexter Acosta',
	            	'exp':3,
	            	'weight':100,
	            	'height':100,
	            	'born':'15 Oct 1986'
	            };
	            */

	            $('#player_name .value').text(player_attr.name);
	            $('#player_postion .value').text(player_attr.position);
	            $('#player_mobile .value').text(player_attr.mobile);
	            $('#player_born .value').text(player_attr.born);
	            $('#player_email .value').text(player_attr.email);
	            $('#player_lyr .value').text(player_attr.lyr);
	            $('input[name="player_id"]').val(player_attr.player_id);
	            $('input[name="pass"]').val('Draft').attr('name', 'submit').addClass('btnPrimary');

	            html = $('<div />');

	            html = html.append(cloned_player.html());

	            $(this).html(html);

	        }

	    });

	});

	function search_players(searchWord){

		if (searchWord.length >= 1) {
		         
	        $('ul#player-list li span.name').each(function(i, data) {

	            text = $(this).text();

	            if (!text.match(RegExp(searchWord, 'i'))) {
	            	
	            	$(this).parent().hide(100);
	                
	            }else{

	            	$(this).parent().not('.drafted').show();
	            }
	        });

	    }else{

	    	$('ul#player-list li').not('.drafted').show();

	    }

	}

</script>
