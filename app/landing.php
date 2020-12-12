<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Welcome | NeoBook</title>
    <link rel="icon" href="images/fav.png" type="image/png" sizes="16x16"> 
    
    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>
<!--<div class="se-pre-con"></div>-->
<div class="theme-layout">
	<div class="container-fluid pdng0">
		<div class="row merged">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="land-featurearea">
					<div class="land-meta">
						<h1>NeoBook</h1>
						<p>
							NeoBook is a free online social network for everyone who loves graphs!
						</p>
						<div class="friend-logo">
							<span><img src="images/wink.png" alt=""></span>
						</div>
						<a href="https://github.com/p17griv/neobook" title="" class="folow-me">View Project On GitHub</a>
					</div>	
				</div>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<div class="login-reg-bg">
					<div class="log-reg-area sign">
						<h2 class="log-title">Login</h2>
							<p>
								Ready to return? Your followers are missing you!
							</p>
						<form method="post">
							<div class="form-group">	
							  <input type="text" id="input" required="required"/>
							  <label class="control-label" for="input">Username</label><i class="mtrl-select"></i>
							</div>
							<div class="form-group">	
							  <input type="password" required="required"/>
							  <label class="control-label" for="input">Password</label><i class="mtrl-select"></i>
							</div>
							<div class="submit-btns">
								<button class="mtr-btn signin" type="button"><span>Login</span></button>
								<button class="mtr-btn signup" type="button"><span>Register</span></button>
							</div>
						</form>
					</div>
					<div class="log-reg-area reg">
						<h2 class="log-title">Register</h2>
							<p>
								A whole new world is waiting for your content!
							</p>
						<form method="post">
							<div class="form-group">	
							  <input type="text" required="required"/>
							  <label class="control-label" for="input">First & Last Name</label><i class="mtrl-select"></i>
							</div>
							<div class="form-group">	
							  <input type="password" required="required"/>
							  <label class="control-label" for="input">Password</label><i class="mtrl-select"></i>
							</div>
							<div class="form-radio">
							  <div class="radio">
								<label>
								  <input type="radio" name="radio" checked="checked"/><i class="check-box"></i>Male
								</label>
							  </div>
							  <div class="radio">
								<label>
								  <input type="radio" name="radio"/><i class="check-box"></i>Female
								</label>
							  </div>
							</div>
							<div class="form-group">	
							  <input type="text" required="required"/>
							  <label class="control-label" for="input">Email</label><i class="mtrl-select"></i>
							</div>
                            <div class="dob">
                                <div class="form-group">
                                    <h6>Birth Date: </h6>
                                    <select>
                                        <option value="Day">Day</option>
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
                                        <option value="month">Month</option>
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
                                        <option value="year">Year</option>
                                        <?php
                                        for($i=date("Y")-18; $i>=1900; $i--)
                                        {
                                            echo'<option>'.$i.'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
							<div class="checkbox">
							  <label>
								<input type="checkbox" required="required"/><i class="check-box"></i>Accept Terms & Conditions ?
							  </label>
							</div>
							<a href="#" title="" class="already-have">Already have an account</a>
							<div class="submit-btns">
								<button class="mtr-btn signup" type="button"><span>Register</span></button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>

</body>	

</html>