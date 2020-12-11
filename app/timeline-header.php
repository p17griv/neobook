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
							<figure>
								<img src="images/resources/user-avatar.jpg" alt="">
								<!-- <img src="{userprofileimageurl}" alt=""> -->
							</figure>
						</div>
					</div>
					<div class="col-lg-10 col-sm-9">
						<div class="timeline-info">
							<ul>
								<li class="admin-name">
								  <h5>{userfullname}</h5>
								  <span>{usercity, usercountry}</span>
								</li>';
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