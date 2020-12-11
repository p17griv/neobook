<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings | NeoBook</title>
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
								<div class="col-lg-3">
									<aside class="sidebar static">
										<div class="widget stick-widget">
											<h4 class="widget-title">Account Settings</h4>
											<ul class="naves">
                                                <li>
													<i class="ti-settings"></i>
													<a href="setting.php#email" title="">Change Email</a>
												</li>
												<li>
													<i class="ti-lock"></i>
													<a href="setting.php#password" title="">Change Password</a>
												</li>
                                                <li>
                                                    <i style="color:red;" class="ti-heart-broken"></i>
                                                    <a href="setting.php#delete" title="">Delete Account</a>
                                                </li>
											</ul>
										</div><!-- settings widget -->										
									</aside>
								</div><!-- sidebar -->

                                <div class="col-lg-6">
									<div id="email" class="central-meta">
										<div class="editing-info">
											<h5 class="f-title"><i class="ti-settings"></i></i>Change Email</h5>
											
											<form method="post">
												<div class="form-group">	
												  <input type="email" id="input" required="required"/>
												  <label class="control-label" for="input">New Email</label><i class="mtrl-select"></i>
												</div>
												<div class="form-group">	
												  <input type="email" required="required"/>
												  <label class="control-label" for="input">Confirm Email</label><i class="mtrl-select"></i>
												</div>
												<div class="submit-btns">
                                                    <button type="button" class="mtr-btn"><span>Change</span></button>
                                                    <button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
												</div>
											</form>
										</div>
									</div>
                                    <div id="password" class="central-meta">
                                        <div class="editing-info">
                                            <h5 class="f-title"><i class="ti-lock"></i>Change Password</h5>

                                            <form method="post">
                                                <div class="form-group">
                                                    <input type="password" id="input" required="required"/>
                                                    <label class="control-label" for="input">New password</label><i class="mtrl-select"></i>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" required="required"/>
                                                    <label class="control-label" for="input">Confirm password</label><i class="mtrl-select"></i>
                                                </div>
                                                <div class="form-group">
                                                    <input type="password" required="required"/>
                                                    <label class="control-label" for="input">Current password</label><i class="mtrl-select"></i>
                                                </div>
                                                <div class="submit-btns">
                                                    <button type="button" class="mtr-btn"><span>Change</span></button>
                                                    <button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="delete" class="central-meta">
                                        <div class="editing-info">
                                            <h5 class="f-title"><i style="color:red;" class="ti-heart-broken"></i>Delete Account</h5>
                                            <form method="post">
                                                <div class="submit-btns">
                                                    <button style="color: darkred" type="delete" class="mtr-btn"><span>Delete Account</span></button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- centerl meta -->

                                <div class="col-lg-3"></div><!-- sidebar -->
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
	
	<script src="js/main.min.js"></script>
	<script src="js/script.js"></script>

</body>	

</html>