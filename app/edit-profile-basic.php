<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile | NeoBook</title>
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
										<h4 class="widget-title">Edit info</h4>
										<ul class="naves">
											<li>
												<i class="ti-info-alt"></i>
												<a href="edit-profile-basic.php#basic_info" title="">Basic Info</a>
											</li>
											<li>
												<i class="ti-mouse-alt"></i>
												<a href="edit-profile-basic.php#profile_image" title="">Profile Image</a>
											</li>
										</ul>
									</div><!-- settings widget -->										
								</aside>
							</div><!-- sidebar -->
							<div class="col-lg-6">
								<div id="basic_info" class="central-meta">
									<div class="editing-info">
										<h5 class="f-title"><i class="ti-info-alt"></i> Edit Basic Information</h5>

										<form method="post">
											<div class="form-group half">	
											  <input type="text" id="input" required="required"/>
											  <label class="control-label" for="input">{userfullname}</label><i class="mtrl-select"></i>
											</div>
											<div class="form-group">	
											  <input type="text" required="required"/>
											  <label class="control-label" for="input">{useremail}</label><i class="mtrl-select"></i>
											</div>
											<div class="form-group">	
											  <input type="text" required="required"/>
											  <label class="control-label" for="input">{userphone}</label><i class="mtrl-select"></i>
											</div>
											<div class="dob">
												<div class="form-group">
													<select>
														<option value="Day">{userbirthday}</option>
                                                        <?php
                                                        for($i=1; $i<=31; $i++)
                                                        {
                                                            echo'<option>'.$i.'</option>';
                                                        }
                                                        ?>
													</select>
												</div>
												<div class="form-group">
													<select>
														<option value="month">{userbirthmonth}</option>
														  <option>Jan</option>
														  <option>Feb</option>
														  <option>Mar</option>
														  <option>Apr</option>
														  <option>May</option>
														  <option>Jun</option>
														  <option>Jul</option>
														  <option>Aug</option>
														  <option>Sep</option>
														  <option>Oct</option>
														  <option>Nov</option>
														  <option>Dec</option>
													</select>
												</div>
												<div class="form-group">
													<select>
													  <option value="year">{userbirthyear}</option>
                                                        <?php
                                                        for($i=date("Y")-18; $i>=1900; $i--)
                                                        {
                                                            echo'<option>'.$i.'</option>';
                                                        }
                                                        ?>
													</select>
												</div>
											</div>
											<div class="form-radio">
											  <div class="radio">
												<label>
												  <input type="radio" checked="checked" name="radio"><i class="check-box"></i>Male
												</label>
											  </div>
											  <div class="radio">
												<label>
												  <input type="radio" name="radio"><i class="check-box"></i>Female
												</label>
											  </div>
											</div>
											<div class="form-group">	
											  <select>
												<option value="country">{usercicty}, {usercountry}</option>
												  <option value="AFG">Afghanistan</option>
												  <option value="ALA">Ƭand Islands</option>
												  <option value="ALB">Albania</option>
											  </select>
											</div>
											<div class="submit-btns">
                                                <button id="updatebtn" type="button" class="mtr-btn"><span>Update</span></button>
												<button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
											</div>
										</form>
									</div>
								</div>
                                <div id="profile_image" class="central-meta">
                                    <div class="editing-info">
                                        <h5 class="f-title"><i class="fa fa-camera-retro"></i></i> Change Profile Image</h5>

                                        <form method="post">
                                            <figure>
                                                <img src="images/resources/user-avatar.jpg" alt="">
                                                <!-- <img src="{userprofileimageurl}" alt=""> -->
                                            </figure>
                                            <div class="form-group">
                                                <input type="text" required="required"/>
                                                <label class="control-label" for="input">New Image URL: </label><i class="mtrl-select"></i>
                                            </div>
                                            <div class="submit-btns">
                                                <button id="changeimagebtn" type="button" class="mtr-btn"><span>Change Image</span></button>
                                                <button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
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
    include("footer.php");
    ?>

</div>
	
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>
	<script src="js/map-init.js"></script>

</body>	

</html>