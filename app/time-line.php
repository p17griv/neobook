<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{userfullname} | NeoBook</title>
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
    include('timeline-header.php')
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