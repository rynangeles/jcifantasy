<footer>
    &copy; Copyright <?php echo date("Y"); ?> | Designed and developed by RSolutions Inc.
</footer>
<script type="text/javascript" src="<?php echo base_url();?>javascripts/jquery-1.9.0.js"></script>
<?php if(isset($javascripts)): ?>
<?php foreach ($javascripts as $javascript): ?>
<script type="text/javascript" src="<?php echo base_url();?>javascripts/<?php echo $javascript; ?>.js"></script>
<?php endforeach; endif; ?>
<script type="text/javascript">

    $(function() {

    	$(window).load(function(){
			if(!checkScrollBar()){

				if($('.mainContent').outerHeight(true) < $(window).height()){

		    		var init_height = $(window).height()-$('header').outerHeight(true)-$('footer').outerHeight(true);
					$('.content').height(init_height-25); // 25 is the sum of margin-top/bottom of .mainContent
				}

	    	}

			function checkScrollBar() {
		        var contentHeight = $("body").height(); // get the height of your content
		        var docHeight = $(window).height(); // get the height of the visitor's browser window

		        return contentHeight > docHeight;
		    }
		    
		});

	});
</script>