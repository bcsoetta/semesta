<?php $this->load->view("default/header.php") ?>
<?php $this->load->view("default/sidebar.php") ?>

<div id="content" class="app-content box-shadow-z2 box-radius-1x" role="main">
	
<?php $this->load->view("default/topnav.php") ?>
<?php $this->load->view("default/copy.php") ?>

<!-- content -->

<?php $this->load->view("contents/".$content.".php") ?>

<!-- end of content -->

</div>

<?php $this->load->view("default/js.php") ?>

<!-- content -->

<?php
	$filejs = APPPATH."views/contents/".$content."_js.php";
	if (file_exists($filejs)) { 
		$this->load->view("contents/".$content."_js.php"); 
	} 
?>

<?php $this->load->view("default/footer.php") ?>