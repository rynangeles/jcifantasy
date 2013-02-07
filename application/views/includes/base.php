<?php $this->load->view('includes/header'); ?>

<div class="mainContent">
	<?php $this->load->view('includes/menu'); ?>
	<?php if(isset($content)){ $this->load->view($content);} ?>
</div>

<?php $this->load->view('includes/footer'); ?>