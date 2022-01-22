<?php if(!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<!-- container -->
<div class="container-fluid">
	<!-- breadcrumb -->
	<div class="breadcrumb-header justify-content-between">
		<div>
			<h4 class="content-title mb-2">Hi <?php echo $user_data['franchise_name']; ?>, welcome back!</h4>
			<?php
		        if(isset($breadcrumb) && !empty($breadcrumb))
		        {
		            echo $breadcrumb;
		        }
		    ?>
			<!-- <nav aria-label="breadcrumb">
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="#">Dashboard</a></li>
					<li class="breadcrumb-item active" aria-current="page">Project</li>
				</ol>
			</nav> -->
		</div>
	</div>
	<!-- /breadcrumb -->

	<!-- main-content-body -->
	<div class="main-content-body">