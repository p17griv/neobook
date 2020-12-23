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
    <title>Photos | NeoBook</title>
    <link rel="icon" href="images/fav.png" type="image/png" sizes="16x16">

    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>
<!--<div class="se-pre-con"></div>-->
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
                                        <a class="active" href="timeline-photos.php?user='.$_GET['user'].'">Photos</a>
                                        <a href="timeline-friends.php?user='.$_GET['user'].'">Followers</a>
                                        <a href="about.php?user='.$_GET['user'].'">Info</a>
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
									<ul class="photos">
                                        <?php
                                        $query = "MATCH (u:User) WHERE u.id = ".$_GET["user"]."\n 
                                            MATCH (u)-[:UPLOADS]->(p:Post) RETURN p ORDER BY p.timestamp DESC LIMIT 50"; // Get all posts of current user
                                        $posts = $client->sendCypherQuery($query)->getResult(); // Execute query

                                        foreach ($posts->getNodes() as $post) {
                                            if($post->getProperty('imageUrl') != '-') {
                                                echo '
                                            <li>
                                                <a class="strip" href="' . $post->getProperty('imageUrl') . '" data-strip-group="mygroup" data-strip-group-options="loop: false">
												    <img src="' . $post->getProperty('imageUrl') . '">
												</a>
										    </li>
                                            ';
                                            }
                                        }
                                        ?>
									</ul>
								</div><!-- photos -->
							</div><!-- centerl meta -->

                            <div class="col-lg-2"></div><!-- sidebar -->
                        </div>
					</div>
				</div>
			</div>
		</div>
	</section>

    <?php
    include('footer.php')
    ?>

</div>

	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>

</body>


</html>
