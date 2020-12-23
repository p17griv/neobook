<?php
include("connect_to_db.php");

// Check if no one is logged in
if(!isset($_COOKIE["user"])) {
    header('Location: landing.php'); // Redirect to landing.php
}
else {
    // Check if user parameter was not given in the url
    if(!isset($_GET['user']) or $_GET['user'] == null) {
        header('Location: time-line.php?user='.$_COOKIE['user']); // Redirect to logged-in user's profile
    }

    $query = "MATCH (u:User) WHERE u.id = " .$_GET["user"]." RETURN count(u) as cu";
    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
// Check if there is a user with id equal to user parameter
    if($result->get('cu') != 1) {
        header('Location: time-line.php?user='.$_COOKIE['user']); // Redirect to logged-in user's profile
    }
}
?>
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
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>

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
                $query = "MATCH (u:User) WHERE u.id = " .$_GET["user"]. "\n
                    MATCH (m:User)-[:FOLLOWS]->(u) RETURN count(m) as cm"; // Get current user's number of followers
                $result = $client->sendCypherQuery($query)->getResult(); // Execute query

                echo '<span>'.$result->get('cm').' followers</span>';

                if ($_GET['user'] != $_COOKIE['user']) {
                    $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE["user"] . "\n 
                        MATCH (m:User) WHERE m.id = ".$_GET['user']."\n 
                        MATCH (u)-[:FOLLOWS]->(m) RETURN count(m) as cm"; // Check if logged-in user follows current user
                    $result = $client->sendCypherQuery($query)->getResult(); // Execute query

                    if ($result->get('cm') > 0) {
                        //logged-in user follows current user
                        echo '<a id="followbtn" href="" onclick="unfollow('.$_COOKIE['user'].', '.$_GET['user'].')">Unfollow</a>';
                        echo '
            <script>
                function unfollow(id1, id2) {
                  var xhttp;
                  xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("followbtn").innerHTML = this.responseText;
                    }
                  };  
                  xhttp.open("GET", "unfollow.php?user1="+id1+"&user2="+id2, true);
                  xhttp.send();
                }
            </script>
            ';
                    }
                    else {
                        //logged-in user does not follow current user
                        echo '<a id="followbtn" href="" onclick="follow('.$_COOKIE['user'].', '.$_GET['user'].')">Follow</a>';
                        echo '
            <script>
                function follow(id1, id2) {
                  var xhttp;
                  xhttp = new XMLHttpRequest();
                  xhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                      document.getElementById("followbtn").innerHTML = this.responseText;
                    }
                  };  
                  xhttp.open("GET", "follow.php?user1="+id1+"&user2="+id2, true);
                  xhttp.send();
                }
            </script>
            ';
                    }
                }
                ?>

            </div>
            <div class="container-fluid">
                <div class="row merged">
                    <div class="col-lg-2 col-sm-3">
                        <div class="user-avatar">
                            <figure>
                                <?php
                                if ($_GET['user'] == $_COOKIE['user']) {
                                    $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE["user"] . " RETURN u.profileImageUrl , u.fullname, u.city, u.country"; // Get current user's profile info
                                    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                    echo "<img style='width: 100%; height: 200px' src='" . $result->get('u.profileImageUrl') . "'>";
                                } else {
                                    $query = "MATCH (u:User) WHERE u.id = " . $_GET["user"] . " RETURN u.profileImageUrl , u.fullname, u.city, u.country"; // Get current user's profile info
                                    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                    echo "<img style='width: 100%; height: 200px' src='" . $result->get('u.profileImageUrl') . "'>";
                                }

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
                                        <a href="time-line.php?user='.$_GET['user'].'">Profile</a>
                                        <a href="timeline-photos.php?user='.$_GET['user'].'">Photos</a>
                                        <a href="timeline-friends.php?user='.$_GET['user'].'">Followers</a>
                                        <a class="active" href="about.php?user='.$_GET['user'].'">Info</a>
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
							<div class="col-lg-2"></div><!-- sidebar -->

                            <div class="col-lg-8">
								<div class="central-meta">
									<div class="about">
										<div class="personal">
											<h5 class="f-title"><i class="ti-info-alt"></i> Personal Info</h5>
                                            <p>
                                                <?php
                                                $query = "MATCH (u:User) WHERE u.id = ".$_GET["user"]." RETURN u.fullname, u.birthDate, u.city, u.country"; // Get current user's info
                                                $results = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                preg_match('/[0-9]*/', $results->get('u.birthDate'), $birthYear); // Get the year of birth from birth date
                                                $userAge = (int)date("Y") - (int)$birthYear[0]; // Calculate user's age
                                                echo "Hi! I'm ".$results->get('u.fullname').", ".$userAge." years old and I live in ".str_replace('"', '', $results->get('u.city')).", ".str_replace('"', '', $results->get('u.country')).". Follow me on NeoBook so you don't miss any of my latest new posts!";
                                                ?>
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
                                                        <?php
                                                        $query = "MATCH (u:User) WHERE u.id = ".$_GET["user"]." RETURN u.fullname, u.birthDate, u.city, u.country, u.phone, u.email"; // Get current user's info
                                                        $results = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                        preg_match('/[0-9]*/', $results->get('u.birthDate'), $birthYear); // Get the year of birth from birth date
                                                        $userAge = (int)date("Y") - (int)$birthYear[0]; // Calculate user's age
                                                        echo '
                                                        <li><i class="ti-user"></i>'.$results->get('u.fullname').'</li>
														<li><i class="ti-calendar"></i>'.$results->get('u.birthDate').' ('.$userAge.')</li>
														<li><i class="ti-map-alt"></i>live in '.str_replace('"', '', $results->get('u.city')).', '.str_replace('"', '', $results->get('u.country')).'</li>
														<li><i class="ti-mobile"></i>'.$results->get('u.phone').'</li>
														<li><i class="ti-email"></i><a href="mailto:'.$results->get('u.email').'">'.$results->get('u.email').'</a></li>';
                                                        ?>
													</ul>
												</div>
												<div class="tab-pane fade" id="location" role="tabpanel">
													<div class="location-map">
														<div id="map-canvas"></div>
                                                        <?php
                                                        $query = "MATCH (u:User) WHERE u.id = ".$_GET["user"]." RETURN u.longitude, u.latitude"; // Get current user's coordinates
                                                        $results = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                        echo '
                                                        <script type="text/javascript">
                                                            var myOptions = {
                                                                zoom: 11,
                                                                center: new google.maps.LatLng('.$results->get('u.latitude').', '.$results->get('u.longitude').'),
                                                                mapTypeId: google.maps.MapTypeId.ROADMAP
                                                            };

                                                            var map = new google.maps.Map(document.getElementById("map-canvas"), myOptions);
                                                        </script>';
                                                        ?>
                                                    </div>
												</div>
												<div class="tab-pane fade" id="interest" role="tabpanel">
													<ul class="basics">
                                                    <?php
                                                    $query = "MATCH (u:User) WHERE u.id = ".$_GET["user"]." RETURN u.interests"; // Get current user's interests
                                                    $interests = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                    if ($interests->get('u.interests') != null){
                                                        foreach ($interests->get('u.interests') as $interest) {
                                                            echo '<li>'.$interest.'</li>';
                                                        }
                                                    }

                                                    ?>
													</ul>
												</div>
												<div class="tab-pane fade" id="lang" role="tabpanel">
													<ul class="basics">
                                                        <?php
                                                        $query = "MATCH (u:User) WHERE u.id = ".$_GET["user"]." RETURN u.languages"; // Get current user's languages
                                                        $languages = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                        if ($languages->get('u.languages') != null) {
                                                            foreach ($languages->get('u.languages') as $language) {
                                                                echo '<li>' . $language . '</li>';
                                                            }
                                                        }
                                                        ?>
													</ul>
												</div>
											</div>
										</div>
                                        <?php
                                        if($_GET['user'] == $_COOKIE['user']) {
                                            echo '
                                            <div style="text-align: right; font-weight: bold">
                                                <br>
                                                <a title="" href="edit-profile-basic.php">
                                                    <i class="ti-info-alt"></i>
                                                    Edit Info
                                                </a>
                                            </div>';
                                        }
                                        ?>
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

    <script src="js/main.min.js"></script>
	<script src="js/script.js"></script>

</body>	

</html>