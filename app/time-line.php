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
    <?php
    $query = "MATCH (u:User) WHERE u.id = " . $_GET["user"] . " RETURN u.fullname"; // Get current user's fullname
    $result = $client->sendCypherQuery($query)->getResult(); // Execute query

    echo '<title>'.$result->get('u.fullname').' | NeoBook</title>';
    ?>
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
                                        <a class="active" href="time-line.php?user='.$_GET['user'].'">Profile</a>
                                        <a href="timeline-photos.php?user='.$_GET['user'].'">Photos</a>
                                        <a href="timeline-friends.php?user='.$_GET['user'].'">Followers</a>
                                        <a href="about.php?user='.$_GET['user'].'">Info</a>
                                    </li>';
                                ?>
                                </ul>
                            </div>
                            <?php
                            /* NOT EFFICIENT

                            if ($_GET['user'] != $_COOKIE['user']) {
                                $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE["user"] . " \n
                                    MATCH (u)-[:FOLLOWS]->(m:User) RETURN m"; // Get the users that logged-in user follows
                                $result = $client->sendCypherQuery($query)->getResult(); // Execute query

                                $count = 0;
                                $cnt = 0;

                                foreach ($result->getNodes() as $follows) {

                                    $query = "MATCH (u:User) WHERE u.id = " . $follows->getProperty('id') . " \n
                                    MATCH (m:User) WHERE m.id =".$_GET['user']." \n
                                    MATCH (u)-[r:FOLLOWS]->(m) RETURN count(r) as rel"; // Get the relationship between user-follow and user of current profile
                                    $result = $client->sendCypherQuery($query)->getResult(); // Execute query

                                    if($result->get('rel') != 0) {
                                        $count++;
                                    }
                                }
                                echo "<span>".$count." of your follows, follow this user</span>";
                            }
                            */
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- top area -->

		
	<section>
		<div class="gap gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row" id="page-contents">
							<div class="col-lg-2"></div><!-- sidebar -->

                            <div class="col-lg-8">
                                <?php
                                if ($_GET['user'] == $_COOKIE['user']) {
                                    $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]." RETURN u.profileImageUrl"; // Get current user's profile image url
                                    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                    $profileImageUrl = $result->get('u.profileImageUrl'); // Get the image url

                                    echo '
                                    <div class="central-meta">
                                        <div class="new-postbox">
                                            <figure>
                                                <img style="width: 100%; height: 80px" src="'.$profileImageUrl.'">
                                            </figure>
                                            <div class="newpst-input">
                                                <form method="post" action="index.php">
                                                    <textarea required="required" name="newPostText" rows="2" placeholder="Tell something to your followers . . ."></textarea>
                                                    <div class="attachments">
                                                        <ul>
                                                            <li>
                                                                <i class="fa fa-image"></i>
                                                                <label class="fileContainer">
                                                                    <input placeholder="Add an Image!" name="imageUrl" type="url">
                                                                </label>
                                                            </li>
                                                            <li>
                                                                <button type="submit">Post</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div><!-- add post new box -->';
                                }
                                ?>

                                <?php
                                $query = "MATCH (u:User) WHERE u.id = ".$_GET["user"]."\n 
                                    MATCH (u)-[:UPLOADS]->(p:Post) RETURN p ORDER BY p.timestamp DESC LIMIT 50"; // Get all posts of current user
                                $posts = $client->sendCypherQuery($query)->getResult(); // Execute query

                                foreach ($posts->getNodes() as $post) {
                                    $query = "MATCH (u)-[:UPLOADS]->(p:Post) WHERE ID(p) = ".$post->getId()." RETURN u.id, u.profileImageUrl, u.fullname"; // Get the user-owner of current post
                                    $postOwner = $client->sendCypherQuery($query)->getResult(); // Execute query

                                    echo '
                                    <div class="central-meta item">
                                        <div class="user-post">
                                            <div class="friend-info">';
                                    // If current user's profile displayed
                                    if($_GET['user'] == $_COOKIE['user']) {
                                        // Show delete button on posts
                                        echo '<ins class="ti-close" onclick="deletePost(this.id)" id="'.$post->getProperty('id').'" style="font-weight: bold; margin-left: 96%; text-decoration: none;"></ins>';
                                    }
                                    echo '
                                                <figure>
                                                    <img style="width: 100%; height: 65px" src="'.$postOwner->get('u.profileImageUrl').'">
                                                </figure>
                                                <div class="friend-name">
                                                    <a href="time-line.php?id='.$postOwner->get('u.id').'">'.$postOwner->get('u.fullname').'</a>
                                                    <span>published: '.$post->getProperty('timestamp').'</span>
                                                </div>
                                                <div class="post-meta">
                                                    <div class="description">
                                                        <p>';
                                    // Check if there is a url in post's text
                                    $urlFound = preg_match('/http.*?\s/', $post->getProperty('text'), $url_orig);
                                    if($urlFound)
                                    {
                                        echo preg_replace('/http.*?\s/', '<br><a href="'.$url_orig[0].'" target="_blank">'.$url_orig[0].'</a>', $post->getProperty('text'));
                                    }
                                    else {
                                        echo $post->getProperty('text');
                                    }
                                    echo '                   
                                                        </p>
                                                    </div>
                                        ';
                                    if($post->getProperty('imageUrl') != '-'){
                                        echo '<img src="'.$post->getProperty('imageUrl').'">';
                                    }
                                    echo '
                                                <div class="we-video-info">
                                                    <ul>
                                                        <li>Likes: </li>
                                                        <li>
                                                            <span class="like" data-toggle="tooltip" title="like">
                                                                <i class="ti-heart"></i>
                                                                <ins id="likesNumber'.$post->getProperty('id').'" onclick="increaseLikes(this.id)">'.$post->getProperty("likesCount").'</ins>
                                                            </span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                     </div>
                                    </div>
                                    ';
                                }
                                echo '
                                <script>
                                    function deletePost(id) {
                                      var xhttp;
                                      xhttp = new XMLHttpRequest();
                                      xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                          location.reload();
                                        }
                                      };
                                      xhttp.open("GET", "delete-post.php?postId="+id, true);
                                      xhttp.send();
                                    }
                                
                                    function increaseLikes(id) {
                                      var xhttp;
                                      xhttp = new XMLHttpRequest();
                                      xhttp.onreadystatechange = function() {
                                        if (this.readyState == 4 && this.status == 200) {
                                          document.getElementById(id).innerHTML = this.responseText;
                                        }
                                      };  
                                      xhttp.open("GET", "likes.php?postId="+id, true);
                                      xhttp.send();
                                    }
                                </script>
                                '
                                ?>
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
	
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>

</body>	

</html>