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
    include('nav-bar.php');
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
											<li>
												<figure><img src="images/resources/friend-avatar2.jpg" alt=""></figure>
												<div class="friend-meta">
													<h4><a href="time-line.html" title="">Kelly Bill</a></h4>
													<a href="#" title="" class="underline">Add Friend</a>
												</div>
											</li>
											<li>
												<figure><img src="images/resources/friend-avatar4.jpg" alt=""></figure>
												<div class="friend-meta">
													<h4><a href="time-line.html" title="">Issabel</a></h4>
													<a href="#" title="" class="underline">Add Friend</a>
												</div>
											</li>
											<li>
												<figure><img src="images/resources/friend-avatar6.jpg" alt=""></figure>
												<div class="friend-meta">
													<h4><a href="time-line.html" title="">Andrew</a></h4>
													<a href="#" title="" class="underline">Add Friend</a>
												</div>
											</li>
											<li>
												<figure><img src="images/resources/friend-avatar8.jpg" alt=""></figure>
												<div class="friend-meta">
													<h4><a href="time-line.html" title="">Sophia</a></h4>
													<a href="#" title="" class="underline">Add Friend</a>
												</div>
											</li>
											<li>
												<figure><img src="images/resources/friend-avatar3.jpg" alt=""></figure>
												<div class="friend-meta">
													<h4><a href="time-line.html" title="">Allen</a></h4>
													<a href="#" title="" class="underline">Add Friend</a>
												</div>
											</li>
										</ul>
									</div><!-- who's following -->
								</aside>
							</div><!-- sidebar -->

                            <div class="col-lg-6">
								<div class="central-meta">
									<div class="new-postbox">
										<figure>
											<img src="images/resources/admin2.jpg" alt="">
                                            <!-- <img src="{userprofileimageurl}" alt=""> -->
										</figure>
										<div class="newpst-input">
											<form method="post">
												<textarea rows="2" placeholder="Share your thoughts . . ."></textarea>
												<div class="attachments">
													<ul>
														<li>
															<i class="fa fa-image"></i>
															<label class="fileContainer">
																<input type="file">
															</label>
														</li>
														<li>
															<i class="fa fa-camera"></i>
															<label class="fileContainer">
																<input type="file">
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
								</div><!-- add post new box -->

                                <div class="central-meta item">
                                    <div class="user-post">
                                        <div class="friend-info">
                                            <figure>
                                                <img src="images/resources/friend-avatar10.jpg" alt="">
                                                <!-- <img src="{userprofileimageurl}" alt=""> -->
                                            </figure>
                                            <div class="friend-name">
                                                <a href="time-line.php?id='{postuserid}'" title="">{postuserfullname}</a>
                                                <span>published: {posttimestamp}</span>

                                            </div>
                                            <div class="post-meta">
                                                <div class="description">
                                                    <p>
                                                        {posttext}
                                                    </p>
                                                </div>
                                                <img src="images/resources/user-post.jpg" alt="">
                                                <!-- <img src="{postimageurl}" alt=""> -->
                                                <div class="we-video-info">
                                                    <ul>
                                                        <li>Likes: </li>
                                                        <li>
															<span class="like" data-toggle="tooltip" title="like">
																<i class="ti-heart"></i>
																<ins>{postlikescounter}</ins>
															</span>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div><!-- centerl meta -->

							<div class="col-lg-3">
								<aside class="sidebar static right">
									<div class="widget stick-widget">
										<h4 class="widget-title">Your stats</h4>
										<div class="your-page">
											<div class="page-meta">
												<a href="time-line.php" class="underline">{fullname}</a>
												<span>Total Posts <em>{totalposts}</em></span>
												<span>Total Photos <em>{totalphotos}</em></span>
											</div>
											<div class="page-likes">
												<ul class="nav nav-tabs likes-btn">
													<li class="nav-item"><a class="active" href="#link1" data-toggle="tab">followers</a></li>
													 <li class="nav-item"><a class="" href="#link2" data-toggle="tab">follows</a></li>
												</ul>
												<!-- Tab panes -->
												<div class="tab-content">
												  <div class="tab-pane active fade show " id="link1" >
													<span><i class="ti-heart"></i>{followerscount}</span>
													  <div class="users-thumb-list">
														<a href="#" title="frank" data-toggle="tooltip">
															<img src="images/resources/userlist-2.jpg" alt="">  
														</a>
														<a href="#" title="Sara" data-toggle="tooltip">
															<img src="images/resources/userlist-3.jpg" alt="">  
														</a>
                                                        <a href="#" title="{followerfullname}" data-toggle="tooltip">
                                                            <img src="{followerprofileimageurl}" alt="">
                                                        </a>
													  </div>
												  </div>
												  <div class="tab-pane fade" id="link2" >
													  <span><i class="ti-eye"></i>{followscount}</span>
													  <div class="users-thumb-list">
														<a href="#" title="Anderw" data-toggle="tooltip">
															<img src="images/resources/userlist-1.jpg" alt="">  
														</a>
														<a href="#" title="frank" data-toggle="tooltip">
															<img src="images/resources/userlist-2.jpg" alt="">  
														</a>
														<a href="#" title="{followfullname}" data-toggle="tooltip">
															<img src="{followprofileimageurl}" alt="">
														</a>
													  </div>
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