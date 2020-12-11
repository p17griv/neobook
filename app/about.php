<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info | NeoBook</title>
    <link rel="icon" href="images/fav.png" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>

<div class="theme-layout">

    <?php
    include('nav-bar.php');
    include('timeline-header.php')
    ?>
		
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-2"></div><!-- sidebar -->

                            <div class="col-lg-8">
								<div class="central-meta">
									<div class="about">
										<div class="personal">
											<h5 class="f-title"><i class="ti-info-alt"></i> Personal Info</h5>
                                            <p>
												Hi! I'm {userfullname}, {userage} years old and I live in {usercity}, {usercountry}. Follow me on NeoBook so you don't miss any of my latest new posts!
											</p>
										</div>
										<div class="d-flex flex-row mt-2">
											<ul class="nav nav-tabs nav-tabs--vertical nav-tabs--left" >
												<li class="nav-item">
													<a href="#basic" class="nav-link active" data-toggle="tab" >Basic Information</a>
												</li>
												<li class="nav-item">
													<a href="#location" class="nav-link" data-toggle="tab" >location</a>
												</li>
												<li class="nav-item">
													<a href="#interest" class="nav-link" data-toggle="tab"  >interests</a>
												</li>
												<li class="nav-item">
													<a href="#lang" class="nav-link" data-toggle="tab" >languages</a>
												</li>
											</ul>
											<div class="tab-content">
												<div class="tab-pane fade show active" id="basic" >
													<ul class="basics">
														<li><i class="ti-user"></i>{userfullname}</li>
														<li><i class="ti-map-alt"></i>live in {usercity}, {usercountry}</li>
														<li><i class="ti-mobile"></i>{userphone}</li>
														<li><i class="ti-email"></i>{useremail}</a></li>
													</ul>
												</div>
												<div class="tab-pane fade" id="location" role="tabpanel">
													<div class="location-map">
														<div id="map-canvas"></div>
													</div>
												</div>
												<div class="tab-pane fade" id="interest" role="tabpanel">
													<ul class="basics">
														<li>{userinterest}</li>
														<li>{userinterest}</li>
													</ul>
												</div>
												<div class="tab-pane fade" id="lang" role="tabpanel">
													<ul class="basics">
														<li>{userlanguage}</li>
														<li>{userlanguage}</li>
													</ul>
												</div>
											</div>
										</div>
                                        <div style="text-align: right; font-weight: bold">
                                            <br>
                                            <a title="" href="edit-profile-basic.php">
                                                <i class="ti-info-alt"></i>
                                                Edit Info
                                            </a>
                                        </div>
									</div>
								</div>	
							</div><!-- centerl meta -->

                            <div class="col-lg-2"></div><!-- sidebar -->
						</div>	
					</div>
				</div>
			</div>
		</div>	
	</section>

    <?php
    include('footer.php');
    ?>

</div>
	<div class="side-panel">
			<h4 class="panel-title">General Setting</h4>
			<form method="post">
				<div class="setting-row">
					<span>use night mode</span>
					<input type="checkbox" id="nightmode1"/> 
					<label for="nightmode1" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>Notifications</span>
					<input type="checkbox" id="switch22" /> 
					<label for="switch22" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>Notification sound</span>
					<input type="checkbox" id="switch33" /> 
					<label for="switch33" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>My profile</span>
					<input type="checkbox" id="switch44" /> 
					<label for="switch44" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>Show profile</span>
					<input type="checkbox" id="switch55" /> 
					<label for="switch55" data-on-label="ON" data-off-label="OFF"></label>
				</div>
			</form>
			<h4 class="panel-title">Account Setting</h4>
			<form method="post">
				<div class="setting-row">
					<span>Sub users</span>
					<input type="checkbox" id="switch66" /> 
					<label for="switch66" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>personal account</span>
					<input type="checkbox" id="switch77" /> 
					<label for="switch77" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>Business account</span>
					<input type="checkbox" id="switch88" /> 
					<label for="switch88" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>Show me online</span>
					<input type="checkbox" id="switch99" /> 
					<label for="switch99" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>Delete history</span>
					<input type="checkbox" id="switch101" /> 
					<label for="switch101" data-on-label="ON" data-off-label="OFF"></label>
				</div>
				<div class="setting-row">
					<span>Expose author name</span>
					<input type="checkbox" id="switch111" /> 
					<label for="switch111" data-on-label="ON" data-off-label="OFF"></label>
				</div>
			</form>
		</div><!-- side panel -->		
	
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>
	<script src="js/map-init.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8c55_YHLvDHGACkQscgbGLtLRdxBDCfI"></script>

</body>	

</html>