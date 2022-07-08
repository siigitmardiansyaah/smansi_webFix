<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view("partials/head.php");?>
</head>
<body>
	<div class="wrapper">
		<div class="main-header">
			<?php $this->load->view("partials/main-header.php") ?>
		</div>

		<!-- Sidebar -->
		<div class="sidebar sidebar-style-2">
			<?php $this->load->view("partials/sidebar.php") ?>
		</div>
		<!-- End Sidebar -->

		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">QR Absensi</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="<?php echo base_url(''); ?> ">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('generate'); ?>">Generate QR</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="<?php echo base_url('generated'); ?>">QR Code</a>
							</li>
						</ul>
					</div>
					<div class="row">
						<div class="col-md-5 ml-auto mr-auto">
							<div id="qr-body" class="card">
								<?php $this->load->view("generated_qr_img") ?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<footer class="footer">
				<?php $this->load->view("partials/footer.php") ?>
			</footer>
		</div>
	</div>
	<?php $this->load->view("partials/footer-js.php")?>

<script type="text/javascript">
	var counter_refresh = setInterval(
	function (){
     	var value = parseInt($('#timer').find('.value').text(), 10);
 			if (value < 2){
 				value = 30;
 			} else {
 				value--;
 			}		  
  		$('#timer').find('.value').text(value);
	}, 1000);
</script>

</body>
</html>