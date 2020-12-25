<?php
include("connect_to_db.php");

// Check if no one is logged in
if(!isset($_COOKIE["user"])) {
    header('Location: landing.php'); // Redirect to landing.php
}

if(isset($_POST['deleteAction']) and $_POST['deleteAction'] == '1') {
    $query = "MATCH (u:User) WHERE u.id = ". $_COOKIE['user'] ."\n
        MATCH (u)-[r:UPLOADS]->(p:Post) \n
        DELETE r, p"; // Delete user's posts
    $client->sendCypherQuery($query); // Execute query

    $query = "MATCH (u:User) WHERE u.id = ". $_COOKIE['user'] ."\n
        MATCH (u)-[r:FOLLOWS]-(m:User) \n
        DELETE r"; // Delete user's follow connections
    $posts = $client->sendCypherQuery($query)->getResult(); // Execute query

    $query = "MATCH (u:User {id: ". $_COOKIE['user'] ."}) \n 
        DELETE u"; // Delete user
    $client->sendCypherQuery($query); // Execute query

    setcookie("user", "", time() - 3600, "/"); // Delete the cookie with the user's id as value
    header('Location: index.php'); // Redirect to index.php
}
?>
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
    ?>

    <section>
        <div class="feature-photo">
            <figure><img src="images/resources/timeline-1.jpg" alt=""></figure>
            <div class="add-btn">
                <?php
                $query = "MATCH (u:User) WHERE u.id = " .$_COOKIE["user"]. "\n
                    MATCH (m:User)-[:FOLLOWS]->(u) RETURN count(m) as cm"; // Get current user's number of followers
                $result = $client->sendCypherQuery($query)->getResult(); // Execute query

                echo '<span>'.$result->get('cm').' followers</span>';
                ?>

            </div>
            <div class="container-fluid">
                <div class="row merged">
                    <div class="col-lg-2 col-sm-3">
                        <div class="user-avatar">
                            <figure>
                                <?php
                                    $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE["user"] . " RETURN u.profileImageUrl , u.fullname, u.city, u.country"; // Get current user's profile info
                                    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                    echo "<img style='width: 100%; height: 200px' src='" . $result->get('u.profileImageUrl') . "'>";
                                echo '
                            </figure>
                            </div>
                        </div>
                        <div class="col-lg-10 col-sm-9">
                            <div class="timeline-info">
                                <ul>
                                    <li class="admin-name">
                                      <h5>'.$result->get('u.fullname').'</h5>
                                      <span>'.str_replace('"', '', $result->get('u.city')).', '.str_replace('"','',$result->get('u.country')).'</span>
                                    </li>
                                    <li>
                                        <a href="time-line.php?user='.$_COOKIE['user'].'">Profile</a>
                                        <a href="timeline-photos.php?user='.$_COOKIE['user'].'">Photos</a>
                                        <a href="timeline-friends.php?user='.$_COOKIE['user'].'">Followers</a>
                                        <a href="about.php?user='.$_COOKIE['user'].'">Info</a>
                                        <a class="active" href="#">More</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- top area -->';
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
											
											<form method="post" action="setting.php">
												<div class="form-group">	
												  <input name="email" type="email" id="input" required="required"/>
												  <label class="control-label" for="input">New Email</label><i class="mtrl-select"></i>
												</div>
												<div class="form-group">	
												  <input name="emailConfirm" type="email" required="required"/>
												  <label class="control-label" for="input">Confirm Email</label><i class="mtrl-select"></i>
												</div>
												<div class="submit-btns">
                                                    <button type="submit" class="mtr-btn"><span>Change</span></button>
                                                    <button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
												</div>
                                                <?php
                                                if(isset($_POST['email'])){
                                                    if($_POST['email'] == $_POST['emailConfirm']) {
                                                        $query = "MATCH (u:User) WHERE u.email = '" . $_POST['email'] . "' RETURN u.email"; // Get a user email that's equal to the given email
                                                        $result = $client->sendCypherQuery($query)->getResult(); // Execute query

                                                        // If there isn't an email in db that's equal with the given email
                                                        if ($result->get('u.email') != $_POST["email"]) {
                                                            $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE['user'] . "\n 
                                                                SET u.email = '".$_POST['email']."'"; // Update user's email
                                                            $client->sendCypherQuery($query); // Execute query
                                                            echo '<p style="font-weight: bold; color: green">Email changed successfully!</p>';
                                                        }
                                                        else {
                                                            echo '<p style="font-weight: bold; color: red">Email: "'.$_POST["email"].'" is already claimed!</p>';
                                                        }
                                                    }
                                                    else {
                                                        echo '<p style="font-weight: bold; color: red">"New Email" and "Confirm Email" have different values!</p>';
                                                    }
                                                }
                                                ?>
                                            </form>
										</div>
									</div>
                                    <div id="password" class="central-meta">
                                        <div class="editing-info">
                                            <h5 class="f-title"><i class="ti-lock"></i>Change Password</h5>

                                            <form method="post">
                                                <div class="form-group">
                                                    <input name="newPassword" type="password" id="input" required="required"/>
                                                    <label class="control-label" for="input">New Password</label><i class="mtrl-select"></i>
                                                </div>
                                                <div class="form-group">
                                                    <input name="passwordConfirm" type="password" required="required"/>
                                                    <label class="control-label" for="input">Confirm Password</label><i class="mtrl-select"></i>
                                                </div>
                                                <div class="form-group">
                                                    <input name="currentPassword" type="password" required="required"/>
                                                    <label class="control-label" for="input">Current Password</label><i class="mtrl-select"></i>
                                                </div>
                                                <div class="submit-btns">
                                                    <button type="submit" class="mtr-btn"><span>Change</span></button>
                                                    <button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
                                                </div>
                                                <?php
                                                if(isset($_POST['newPassword'])){
                                                    if($_POST['newPassword'] == $_POST['passwordConfirm']) {
                                                        $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE['user'] . " RETURN u.password"; // Get the hash of current user's password
                                                        $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                        $hashed_current_pass = hash('sha256', $_POST["currentPassword"]); // Hash the given current password text
                                                        $hashed_new_pass = hash('sha256', $_POST["newPassword"]); // Hash the given new password text

                                                        // If the hash of the current password is not equal to the hash of the db's hash password
                                                        if ($result->get('u.password') == $hashed_current_pass) {
                                                            $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE['user'] . "\n 
                                                                SET u.password = '".$hashed_new_pass."'"; // Update user's password
                                                            $client->sendCypherQuery($query); // Execute query
                                                            echo '<p style="font-weight: bold; color: green">Password changed successfully!</p>';
                                                        }
                                                        else {
                                                            echo '<p style="font-weight: bold; color: red">Wrong password!</p>';
                                                        }
                                                    }
                                                    else {
                                                        echo '<p style="font-weight: bold; color: red">"New Password" and "Confirm Password" have different values!</p>';
                                                    }
                                                }
                                                ?>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="delete" class="central-meta">
                                        <div class="editing-info">
                                            <h5 class="f-title"><i style="color:red;" class="ti-heart-broken"></i>Delete Account</h5>
                                            <form id="deleteForm" method="post" action="setting.php">
                                                <div class="submit-btns">
                                                    <button onclick="alertUser()" style="color: darkred" type="delete" class="mtr-btn"><span>Delete Account</span></button>
                                                    <input id="deleteInput" type="hidden" name="deleteAction"/>
                                                    <script>
                                                        function alertUser() {
                                                            if (confirm("Are you sure you want to delete your account? This action is irreversible!")) {
                                                                document.getElementById("deleteInput").value = "1";
                                                                document.getElementById("deleteForm").submit();
                                                            } else {
                                                                document.getElementById("deleteInput").value = "0";
                                                            }
                                                        }
                                                    </script>
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