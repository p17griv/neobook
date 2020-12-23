<?php
include("connect_to_db.php");

// Check if no one is logged in
if(!isset($_COOKIE["user"])) {
    header('Location: landing.php'); // Redirect to landing.php
}
?>
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
                                        <form method="post" action="edit-profile-basic.php">
                                        <?php
                                        $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]." RETURN u.birthDate, u.city, u.country, u.phone, u.email"; // Get current user's info
                                        $results = $client->sendCypherQuery($query)->getResult(); // Execute query
                                        preg_match('/([0-9]*)\/([0-9]*)\/([0-9]*)/', $results->get('u.birthDate'), $birthDate); // Get the year, month, day of birth from birth date

                                        echo '
                                        <div class="form-group half">	
											  <input name="newFullname" type="text" id="input" required="required"/>
											  <label class="control-label" for="input">Fullname</label><i class="mtrl-select"></i>
											</div>
											<div class="form-group">	
											  <input disabled type="text"/>
											  <label class="control-label" for="input">'.$results->get('u.email').'</label><i class="mtrl-select"></i>
											</div>
											<div class="form-group">	
											  <input name="newPhone" value="'.$results->get('u.phone').'" type="number" required="required"/>
											  <label class="control-label" for="input">Phone Number</label><i class="mtrl-select"></i>
											</div>
											<div class="dob">
												<div class="form-group">
													<select id="selectDay" name="newBirthDay">
                                                        <option value="Day">Day</option>
                                                        <script>
                                                            var select = document.getElementById("selectDay");
                                                            for (var i = 1; i <= 31; i++){
                                                                var opt = document.createElement("option");
                                                                opt.value = i;
                                                                opt.innerHTML = i;
                                                                select.appendChild(opt);
                                                            }
                                                        </script>
                                                    </select>
												</div>
												<div class="form-group">
													<select name="newBirthMonth">
														<option value="Month">Month</option>
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
													<select id="selectYear" name="newBirthYear">
                                                        <option value="Year">Year</option>
                                                        <script>
                                                            var select = document.getElementById("selectYear");
                                                            var max = new Date().getFullYear();
                                                            for (var i = max - 18; i > 1901; i--){
                                                                var opt = document.createElement("option");
                                                                opt.value = i;
                                                                opt.innerHTML = i;
                                                                select.appendChild(opt);
                                                            }
                                                        </script>
                                                    </select>
												</div>
												<br>
												<div class="form-group">
													<select name="newCity">
													    <option value="City">City</option>';

                                        if (($handle = fopen("../Data/worldcities.csv",     "r")) !== FALSE) {
                                            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                if ($data[1] != 'city_ascii') {
                                                    echo '<option value="&quot;'.$data[1].'&quot;">'.$data[1].', '.$data[4].'</option>';
                                                }
                                            }
                                        echo '				  
													</select>
												</div>';
                                            fclose($handle);
                                        }
                                        echo '
											</div>
											<div class="submit-btns">
                                                <button type="submit" class="mtr-btn"><span>Update</span></button>
												<button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
											</div>';
                                        if(isset($_POST['newFullname'])) {

                                            // Get country, longitude, latitude based on the given city
                                            if (($handle = fopen("../Data/worldcities.csv", "r")) !== FALSE) {
                                                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                                    $city = '"'.$data[1].'"';
                                                    if ($city == $_POST['newCity']) {
                                                        $newCountry = '"'.$data[4].'"';
                                                        $newLatitude = '"'.$data[2].'"';
                                                        $newLongitude = '"'.$data[3].'"';
                                                    }
                                                }
                                            }

                                            // Check if new birthDate has the defaults values
                                            if ($_POST['newBirthDay'] == 'Day' or $_POST['newBirthMonth'] == 'Month' or $_POST['newBirthYear'] == 'Year') {
                                                // Check if new city has the default value
                                                if ($_POST['newCity'] == 'City') {
                                                    // Update user information
                                                    $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE['user']."\n
                                                    SET u.fullname = '".$_POST['newFullname']."', u.phone = '".$_POST['newPhone']."', u.city = '";
                                                }
                                                else {
                                                    // Update user information
                                                    $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE['user']."\n
                                                    SET u.fullname = '".$_POST['newFullname']."', u.phone = '".$_POST['newPhone']."', u.city = '".$_POST['newCity']."', u.country = '".$newCountry."', u.longitude = '".$newLongitude."', u.latitude = '".$newLatitude."'";
                                                }
                                            }
                                            else {
                                                // Make day in an appropriate format
                                                $day = (int)$_POST["newBirthDay"];
                                                if ($day < 10) {
                                                    $day = '0' . $day;
                                                }

                                                // Make month in an appropriate format
                                                $arrayVariable = [
                                                    'Jan' => 1, 'Feb' => 2, 'Mar' => 3, 'Apr' => 4,
                                                    'May' => 5, 'Jun' => 6, 'Jul' => 7, 'Aug' => 8,
                                                    'Sep' => 9, 'Oct' => 10, 'Nov' => 11, 'Dec' => 12,
                                                ];
                                                $month = $arrayVariable[$_POST["newBirthMonth"]];
                                                if ($month < 10) {
                                                    $month = '0' . $month;
                                                } else {
                                                    $month = $arrayVariable[$_POST["month"]];
                                                }

                                                // Make birthDate in an appropriate format
                                                $birthDate = $_POST["newBirthYear"] . '/' . $month . '/' . $day;

                                                // Check if new city has the default value
                                                if ($_POST['newCity'] == 'City') {
                                                    // Update user information
                                                    $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE['user']."\n
                                                    SET u.fullname = '".$_POST['newFullname']."', u.phone = '".$_POST['newPhone']."', u.birthDate = '".$birthDate."'";
                                                }
                                                else {
                                                    // Update user information
                                                    $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE['user']."\n
                                                    SET u.fullname = '".$_POST['newFullname']."', u.phone = '".$_POST['newPhone']."', u.birthDate = '".$birthDate."', u.city = '".$_POST['newCity']."', u.country = '".$newCountry."', u.longitude = '".$newLongitude."', u.latitude = '".$newLatitude."'";
                                                }
                                            }
                                            $client->sendCypherQuery($query); // Execute query
                                            echo '<p style="font-weight: bold; color: green">Information updated successfully!</p>';
                                        }
                                        ?>
										</form>
									</div>
								</div>
                                <div id="profile_image" class="central-meta">
                                    <div class="editing-info">
                                        <h5 class="f-title"><i class="fa fa-camera-retro"></i></i> Change Profile Image</h5>

                                        <form method="post" action="edit-profile-basic.php">
                                            <figure>
                                                <?php
                                                $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]." RETURN u.profileImageUrl"; // Get current user's info
                                                $result = $client->sendCypherQuery($query)->getResult(); // Execute query

                                                echo '<img style="width: 200px; height: 200px" src="'.$result->get('u.profileImageUrl').'">';
                                                ?>

                                            </figure>
                                            <div class="form-group">
                                                <input name="newProfileImageUrl" type="text" required="required"/>
                                                <label class="control-label" for="input">New Image URL: </label><i class="mtrl-select"></i>
                                            </div>
                                            <div class="submit-btns">
                                                <button id="changeimagebtn" type="submit" class="mtr-btn"><span>Change Image</span></button>
                                                <button type="button" class="mtr-btn" onclick="window.location.reload()"><span>Cancel</span></button>
                                            </div>
                                        </form>
                                        <?php
                                        if (isset($_POST['newProfileImageUrl'])) {
                                            $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE['user']."\n
                                                    SET u.profileImageUrl = '".$_POST['newProfileImageUrl']."'";
                                            $client->sendCypherQuery($query); // Execute query

                                            echo '<p style="font-weight: bold; color: green">Profile image updated successfully!</p>';
                                        }
                                        ?>
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