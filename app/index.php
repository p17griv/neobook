<?php
// Check if no one is logged in
if(!isset($_COOKIE["user"])) {
    header('Location: landing.php'); //Redirect to landing.php
}

include("connect_to_db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>NeoBook</title>
    <link rel="icon" href="images/fav.png" type="image/png" sizes="16x16"> 
    
    <link rel="stylesheet" href="css/main.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/color.css">
    <link rel="stylesheet" href="css/responsive.css">

</head>
<body>

<div class="theme-layout">

    <?php
    include("nav-bar.php");
    ?>
		
	<section>
		<div class="gap2 gray-bg">
			<div class="container-fluid">
				<div class="row">
					<div class="col-lg-12">
						<div class="row merged20" id="page-contents">

                            <div class="col-lg-3">
								<aside class="sidebar static left">
									<div class="widget stick-widget">
										<h4 class="widget-title">Who's follownig</h4>
										<ul class="followers">
                                            <?php
                                            $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                                MATCH (m:User)-[r:FOLLOWS]->(u) RETURN m ORDER BY m.fullname"; // Get all followers of current user
                                            $followers = $client->sendCypherQuery($query)->getResult(); // Execute query

                                            foreach ($followers->getNodes() as $node) {
                                                echo "
                                                <li>
												    <figure><img style='width: 50px; height: 40px' src='".$node->getProperty('profileImageUrl')."'></figure>
												    <div class='friend-meta'>
													    <h4><a href='time-line.html'>".$node->getProperty('fullname')."</a></h4>
													    <a href='#' class='underline'>Follow Back</a>
                                                    </div>
											    </li>
                                                ";
                                            }
                                            ?>
										</ul>
									</div><!-- who's following -->
								</aside>
							</div><!-- sidebar -->

                            <div class="col-lg-6">
								<div class="central-meta">
									<div class="new-postbox">
										<figure>
                                            <?php
                                            $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]." RETURN u.profileImageUrl"; // Get current user's profile image url
                                            $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                            $profileImageUrl = $result->get('u.profileImageUrl'); // Get the image url

                                            echo "<img style='width: 100%; height: 60px' src='".$profileImageUrl."'>";
                                            ?>

										</figure>
										<div class="newpst-input">
											<form method="post" action="index.php">
												<textarea required="required" name="newPostText" rows="2" placeholder="Share your thoughts . . ."></textarea>
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
                                            <?php
                                            if(isset($_POST['newPostText'])) {
                                                $query = 'MATCH (p:Post) RETURN MAX(p.id) AS mx'; // Get the maximum value of post's id
                                                $lastId = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                $newId = $lastId->get('mx');
                                                $newId = (int)$newId + 1; // Calculate the id of the new post

                                                // Check if an image Url was given
                                                if(isset($_POST['imageUrl'])) {
                                                    // Create a post with image
                                                    $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE['user']."\n 
                                                    CREATE (u)-[:UPLOADS]->(p:Post {id: ".$newId.", text: '".$_POST['newPostText']."', imageUrl: '".$_POST['imageUrl']."', timestamp: '".date("Y/m/d h:i")."', likesCount: 0 })";
                                                }
                                                else {
                                                    // Create a post with only text
                                                    $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE['user']."\n 
                                                    CREATE (u)-[:UPLOADS]->(p:Post {id: ".$newId.", text: '".$_POST['newPostText']."', timestamp: '".date("Y/m/d h:i")."', likesCount: 0 })";
                                                }
                                            }

                                            $client->sendCypherQuery($query)->getResult(); // Execute query
                                            ?>
										</div>
									</div>
								</div><!-- add post new box -->

                                <?php
                                $query = "
                                    CALL { MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                    MATCH (u)-[:UPLOADS]->(p:Post) RETURN p AS posts\n
                                    UNION
                                    MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                    MATCH (u)-[:FOLLOWS]->(m:User)\n
                                    MATCH (m)-[:UPLOADS]->(p:Post) RETURN p AS posts }
                                    RETURN posts ORDER BY posts.timestamp DESC
                                    "; // Get all posts of all follows of current user (included current user's posts)
                                $posts = $client->sendCypherQuery($query)->getResult(); // Execute query

                                foreach ($posts->getNodes() as $post) {
                                    $query = "MATCH (u)-[:UPLOADS]->(p:Post) WHERE p.id = ".$post->getProperty('id')." RETURN u.id, u.profileImageUrl, u.fullname"; // Get the user-owner of current post
                                    $postOwner = $client->sendCypherQuery($query)->getResult(); // Execute query

                                    echo '
                                    <div class="central-meta item">
                                        <div class="user-post">
                                            <div class="friend-info">
                                                <figure>
                                                    <img style="width: 100%; height: 45px" src="'.$postOwner->get('u.profileImageUrl').'">
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
                                                                <form id="likesForm" style="display:inline;" method="post" action="index.php">
                                                                    <input type="hidden" name="postId" value="'.$post->getProperty('id').'"/>
                                                                    <ins onclick="increaseLikes()">'.$post->getProperty("likesCount").'</ins>
                                                                </form>
                                                                <script>
                                                                    function increaseLikes() {
                                                                        document.getElementById("likesForm").submit();
                                                                    }
                                                                </script>
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
                                if(isset($_POST["postId"])) {
                                    $query = "MATCH (p:Post) WHERE p.id = ".$_POST["postId"]."\n
                                    SET p.likesCount = p.likesCount + 1"; // Increase current post's likes number by 1
                                    $client->sendCypherQuery($query)->getResult(); // Execute query
                                }
                                ?>

							</div><!-- centerl meta -->

							<div class="col-lg-3">
								<aside class="sidebar static right">
									<div class="widget stick-widget">
										<h4 class="widget-title">Your stats</h4>
										<div class="your-page">
											<div class="page-meta">
                                                <?php
                                                $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]." RETURN u.fullname"; // Get current user's fullname
                                                $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                $fullname = $result->get('u.fullname'); // Get the fullname

                                                echo "<a href='time-line.php' class='underline'>".$fullname."</a>";

                                                $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                                    MATCH (u)-[:UPLOADS]->(p:Post) RETURN p"; // Get all posts of current user
                                                $posts = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                $totalLikes = $totalImages = $totalPosts = 0;

                                                foreach ($posts->getNodes() as $post) {
                                                    $totalPosts++; // Count posts
                                                    $totalLikes += $post->getProperty('likesCount'); // Count likes
                                                    if ($post->getProperty('imageUrl') != '-') {
                                                        $totalImages++; // Count post images
                                                    }
                                                }
                                                echo "
                                                <span>Total Posts <em>".$totalPosts."</em></span>
												<span>Total Photos <em>".$totalImages."</em></span>
                                                <span>Total Likes <em>".$totalLikes."</em></span>
                                                ";
                                                ?>

											</div>
											<div class="page-likes">
												<ul class="nav nav-tabs likes-btn">
													<li class="nav-item"><a class="active" href="#link1" data-toggle="tab">followers</a></li>
													 <li class="nav-item"><a class="" href="#link2" data-toggle="tab">follows</a></li>
												</ul>
												<!-- Tab panes -->
												<div class="tab-content">
                                                    <div class="tab-pane active fade show " id="link1" >
                                                        <?php
                                                        $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                                            MATCH (m:User)-[r:FOLLOWS]->(u) RETURN count(m) as nf"; // Get the number of followers
                                                        $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                        $numberOfFollowers = $result->get('nf'); // Get the count of followers

                                                        echo '<span><i class="ti-heart"></i>'.$numberOfFollowers.'</span>';

                                                        $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                                            MATCH (m:User)-[r:FOLLOWS]->(u) RETURN m ORDER BY m.fullname LIMIT 6"; // Get 6 followers of current user
                                                        $followers = $client->sendCypherQuery($query)->getResult(); // Execute query

                                                        echo '<div class="users-thumb-list">';
                                                        foreach ($followers->getNodes() as $node) {
                                                            echo '
                                                            <a href="#" title="'.$node->getProperty('fullname').'" data-toggle="tooltip">
                                                                <img style="width: 40px; height: 40px" src="'.$node->getProperty('profileImageUrl').'">
                                                            </a>';
                                                        }
                                                        echo '</div>';
                                                        ?>
                                                    </div>
                                                    <div class="tab-pane fade" id="link2" >
                                                        <?php
                                                        $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                                            MATCH (u)-[r:FOLLOWS]->(m:User) RETURN count(m) as nf"; // Get the number of follows
                                                        $result = $client->sendCypherQuery($query)->getResult(); // Execute query
                                                        $numberOfFollows = $result->get('nf'); // Get the count of follows

                                                        echo '<span><i class="ti-heart"></i>'.$numberOfFollows.'</span>';

                                                        $query = "MATCH (u:User) WHERE u.id = ".$_COOKIE["user"]."\n 
                                                            MATCH (u)-[r:FOLLOWS]->(m:User) RETURN m ORDER BY m.fullname LIMIT 6"; // Get 6 follows of current user
                                                        $follows = $client->sendCypherQuery($query)->getResult(); // Execute query

                                                        echo '<div class="users-thumb-list">';
                                                        foreach ($follows->getNodes() as $node) {
                                                            echo '
                                                            <a href="#" title="'.$node->getProperty('fullname').'" data-toggle="tooltip">
                                                                <img style="width: 40px; height: 40px" src="'.$node->getProperty('profileImageUrl').'">
                                                            </a>';
                                                        }
                                                        echo '</div>';
                                                        ?>
                                                    </div>
												</div>
											</div>
										</div>
									</div><!-- user stats widget -->
								</aside>
							</div><!-- sidebar -->

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

	<script src="js/main.min.js"></script>
	<script src="js/script.js"></script>
	<script src="js/map-init.js"></script>

</body>	
</html>