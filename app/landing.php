<?php
// Check if there is someone already logged in
if(isset($_COOKIE["user"])) {
    header('Location: index.php'); // Redirect to index.php
}

include("connect_to_db.php");
?>
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
							<span><img src="https://static.thenounproject.com/png/374726-200.png"></span>
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
						<form method="post" action="landing.php" >
							<div class="form-group">	
							  <input type="text" required="required" name="username"/>
							  <label class="control-label" for="input">Username</label><i class="mtrl-select"></i>
							</div>
							<div class="form-group">	
							  <input type="password" required="required" name="password"/>
							  <label class="control-label" for="input">Password</label><i class="mtrl-select"></i>
							</div>
							<div class="submit-btns">
								<button class="mtr-btn signin" type="submit"><span>Login</span></button>
                                <a href="register.php"><button class="mtr-btn" type="button"><span>Register</span></button></a>
							</div>
                            <?php
                            if(isset($_POST["username"], $_POST["password"])) {
                                $query = 'MATCH (u:User) WHERE u.id = '.$_POST['username'].' RETURN u.password'; // Get the password for the given username (id)
                                $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                $pwd = $result->get('u.password'); // Get the password
                                $hashed_pass = hash('sha256', $_POST["password"]); // Has the given password

                                // Check if given password (hash) value is equal to the password stored in db
                                if ($hashed_pass == $pwd) {
                                    setcookie("user", $_POST['username'], time() + (86400 * 30), "/"); // Create a cookie with user's id
                                    header('Location: index.php'); // Redirect to index.php
                                }
                                else {
                                    echo "<br><br><p style='color: red'>Wrong Username or Password</p>";
                                }
                            }
                            ?>
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
	
	<script src="js/script.js"></script>

</body>	

</html>