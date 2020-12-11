<?php

echo '<div class="topbar stick">
		<div class="logo">
			<a title="" href="index.php"><img src="images/logo.png" alt=""></a>
		</div>
		
		<div class="top-area">
			<div class="top-search">
				<form method="post" class="">
					<input type="text" placeholder="Find People">
					<button data-ripple><i class="ti-search"></i></button>
				</form>
			</div>
			<ul class="setting-area">
				<li>
                    <a href="index.php" title="Home" data-ripple="">
                        <i class="ti-home"></i>
                    </a>
                </li>
				<li>
					<a href="#" title="Notification" data-ripple="">
						<i class="ti-bell"></i><span>20</span>
					</a>
				</li>
			</ul>
			<div class="user-img">
                <img src="images/resources/admin.jpg" alt="">
                <!-- <img src="{userimageurl}" alt=""> -->
				<div class="user-setting">
					<a href="time-line.php"><i class="ti-user"></i> view profile</a>
					<a href="edit-profile-basic.php" title=""><i class="ti-pencil-alt"></i>edit profile</a>
					<a href="setting.php" title=""><i class="ti-settings"></i>account setting</a>
					<a href="#" title=""><i class="ti-power-off"></i>log out</a>
				</div>
			</div>
			<ul class="setting-area"><li></li></ul>
		</div>
	</div><!-- topbar -->';