<div class="content clearfix">
	<div id="team-player" class="playerWrap">
		<h2>My Players</h2>
		<ul id="team-player-list">
			<?php if(isset($team_players) && $team_players != FALSE) : foreach ($team_players as $team_player) : ?>
			<li>
				<span class="position"><?php echo readable_position($team_player->position);?></span> 
				<span class="name"><?php echo ucfirst($team_player->first_name) . ' ' . ucfirst($team_player->last_name); ?></span> 
				<span class="seed"><?php echo $team_player->seed; ?></span>
			</li>
			<?php endforeach; endif; ?>
		</ul>

	</div>
	<div id="all-player" class="playerWrap">
		 <?php echo form_dropdown('member_type', array('all' => 'All','Assoc/Sen' => 'Assoc/Sen', 'Regular' => 'Regular', 'BJC' => 'BJC')); ?>
		<h2>All Players</h2>
		<div class="searchWrap">
			<label for="search">Search</label>
		    <input type="text" id="search" placeholder="Search" name="searchword" value="" />
		    <input type="reset" id="clear-searh"  class="btn" value="Clear" />
	    </div>
		<ul id="player-list">

			<?php if(isset($all_players)) : foreach ($all_players as $all_player) : ?>
			<li type="<?php echo $all_player->member_type; ?>"  player='{ "player_id":<?php echo $all_player->id ?>,"position":"<?php echo readable_position($all_player->position) ?>","name":"<?php echo ucfirst($all_player->first_name) . ' ' . ucfirst($all_player->last_name); ?>","mobile":"<?php echo $all_player->mobile ?>","email":"<?php echo $all_player->email ?>","lyr":"<?php echo $all_player->last_year_rank ?>","born":"<?php echo date('d M Y',strtotime($all_player->born)); ?>"}'>
				<span class="position"><?php echo readable_position($all_player->position);?></span> 
				<span class="name"><?php echo ucfirst($all_player->first_name) . ' ' . ucfirst($all_player->last_name); ?></span> 
				<?php echo is_drafted($all_player->id) == TRUE ? '<span class="drafted true">Drafted</span>' : '<span class="drafted false">Undrafted</span>'; ?>
			</li>
			<?php endforeach; endif; ?>
		</ul>
	</div>
</div>

<!-- load javascripts -->
<?php $this->load->view('includes/javascripts'); ?>
<script type="text/javascript">

	$(function(){

		ul_height 	= $('#all-player').height() - $('.searchWrap').outerHeight(true) - $('#all-player h2').outerHeight(true);
		ul_height2 	= $('#team-player').height() - $('#team-player h2').outerHeight(true);

		$('#player-list').height(ul_height);
		$('#team-player-list').height(ul_height2);

		$('input[name="reset"]').click(function(e){

			window.location.href = "<?php echo base_url().'drafting'; ?>";

		});

		$('select[name="member_type"]').change(function(e){

			val = $(this).val(); 

			$('ul#player-list li').each(function(i,ele){

				if(val == 'all'){

					$(ele).removeClass('untyped');

				}else{

					if($(ele).attr('type') == val){

						$(ele).removeClass('untyped');

					}else{

						$(ele).addClass('untyped');

					}

				}

			});

		});


		searchWord = $('#search').val();

		search_players(searchWord);

		$('#search').bind("change keyup", function() {
		    
		    searchWord = $(this).val();

		    search_players(searchWord);
		    
		});

		$('#clear-searh').click(function(e){


		});

	});

	var interval = setInterval(refresh,10000);

	function refresh(){

		location.reload();

	}

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
