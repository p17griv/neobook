<?php

echo '<section>
		<div class="feature-photo">
			<figure><img src="images/resources/timeline-1.jpg" alt=""></figure>
			<div class="add-btn">
				<span>{followerscount} followers</span>
				<a href="#" title="" data-ripple="">Follow</a>
			</div>
			<div class="container-fluid">
				<div class="row merged">
					<div class="col-lg-2 col-sm-3">
						<div class="user-avatar">
							<figure>';

if (isset($_Get['user'])) {
    $query = "MATCH (u:User) WHERE u.id = " . $_Get["user"] . " RETURN u.profileImageUrl"; // Get current user's profile image url
    $result = $client->sendCypherQuery($query)->getResult(); // Execute query
    $profileImageUrl = $result->get('u.profileImageUrl'); // Get the image url

    echo "<img style='width: 100%; height: 200px' src='" . $profileImageUrl . "'>";
}
else {
    $query = "MATCH (u:User) WHERE u.id = " . $_COOKIE["user"] . " RETURN u.profileImageUrl,u.fullname, u.city, u.country"; // Get current user's profile image url
    $result = $client->sendCypherQuery($query)->getResult(); // Execute query

    echo "
                                <img style='width: 100%; height: 200px' src='".$result->get('u.profileImageUrl'). "'>
                            </figure>
                            </div>
                        </div>
                        <div class='col-lg-10 col-sm-9'>
                            <div class='timeline-info'>
                                <ul>
                                    <li class='admin-name'>
                                      <h5>".$result->get('u.fullname')."</h5>
                                      <span>".str_replace('"', '', $result->get('u.city')).", ".str_replace('"','',$result->get('u.country'))."</span>
                                    </li>";
}

    if(str_contains($_SERVER['REQUEST_URI'], 'time-line.php'))
    {
        echo '<li>
                <a class="active" href="time-line.php" title="" data-ripple="">time line</a>
                <a class="" href="timeline-photos.php" title="" data-ripple="">Photos</a>
                <a class="" href="timeline-friends.php" title="" data-ripple="">Followers</a>
                <a class="" href="about.php" title="" data-ripple="">Info</a>
            </li>';
    }
    elseif (str_contains($_SERVER['REQUEST_URI'], 'timeline-photos.php'))
    {
        echo '<li>
                <a class="" href="time-line.php" title="" data-ripple="">time line</a>
                <a class="active" href="timeline-photos.php" title="" data-ripple="">Photos</a>
                <a class="" href="timeline-friends.php" title="" data-ripple="">Followers</a>
                <a class="" href="about.php" title="" data-ripple="">Info</a>
            </li>';
    }
    elseif (str_contains($_SERVER['REQUEST_URI'], 'timeline-friends.php'))
    {
        echo '<li>
                <a class="" href="time-line.php" title="" data-ripple="">time line</a>
                <a class="" href="timeline-photos.php" title="" data-ripple="">Photos</a>
                <a class="active" href="timeline-friends.php" title="" data-ripple="">Followers</a>
                <a class="" href="about.php" title="" data-ripple="">Info</a>
            </li>';
    }
    elseif (str_contains($_SERVER['REQUEST_URI'], 'about.php'))
    {
        echo '<li>
                <a class="" href="time-line.php" title="" data-ripple="">time line</a>
                <a class="" href="timeline-photos.php" title="" data-ripple="">Photos</a>
                <a class="" href="timeline-friends.php" title="" data-ripple="">Followers</a>
                <a class="active" href="about.php" title="" data-ripple="">Info</a>
            </li>';
    }
    else
    {
        echo '<li>
                <a class="" href="time-line.php" title="" data-ripple="">time line</a>
                <a class="" href="timeline-photos.php" title="" data-ripple="">Photos</a>
                <a class="" href="timeline-friends.php" title="" data-ripple="">Followers</a>
                <a class="" href="about.php" title="" data-ripple="">Info</a>
                <a class="active" href="#" title="" data-ripple="">More</a>
            </li>';
    }

echo '</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section><!-- top area -->';