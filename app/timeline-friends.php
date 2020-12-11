<!DOCTYPE html>
<html lang="en">


<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Followers | NeoBook</title>
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
									<div class="frnds">
										<ul class="nav nav-tabs">
											 <li class="nav-item"><a class="active" href="#frends" data-toggle="tab">Followers</a> <span>{followerscont}</span></li>
											 <li class="nav-item"><a class="" href="#frends-req" data-toggle="tab">Follows</a><span>{followscount}</span></li>
										</ul>

										<!-- Tab panes -->
										<div class="tab-content">
										  <div class="tab-pane active fade show " id="frends" >
											<ul class="nearby-contct">
											<li>
												<div class="nearly-pepls">
													<figure>
														<a href="time-line.html" title=""><img src="images/resources/friend-avatar9.jpg" alt=""></a>
                                                        <!-- <a href="time-line.html" title=""><img src="userprofileimageurl" alt=""></a> -->
													</figure>
													<div class="pepl-info">
														<h4><a href="time-line.html" title="">{userfullname}</a></h4>
														<span>{usercity, usercountry}</span>
														<a href="#" title="" class="add-butn more-action" data-ripple="">unfollow</a>
														<a href="#" title="" class="add-butn" data-ripple="">follow</a>
													</div>
												</div>
											</li>
											<li>
												<div class="nearly-pepls">
													<figure>
														<a href="time-line.html" title=""><img src="images/resources/nearly1.jpg" alt=""></a>
													</figure>
													<div class="pepl-info">
														<h4><a href="time-line.html" title="">sophia Gate</a></h4>
														<span>tv actresses</span>
                                                        <a href="#" title="" class="add-butn more-action" data-ripple="">unfollow</a>
                                                        <a href="#" title="" class="add-butn" data-ripple="">follow</a>
													</div>
												</div>
											</li>
										</ul>
										  </div>
										  <div class="tab-pane fade" id="frends-req" >
											<ul class="nearby-contct">
                                                <li>
                                                    <div class="nearly-pepls">
                                                        <figure>
                                                            <a href="time-line.html" title=""><img src="images/resources/friend-avatar9.jpg" alt=""></a>
                                                            <!-- <a href="time-line.html" title=""><img src="userprofileimageurl" alt=""></a> -->
                                                        </figure>
                                                        <div class="pepl-info">
                                                            <h4><a href="time-line.html" title="">{userfullname}</a></h4>
                                                            <span>{usercity, usercountry}</span>
                                                            <a href="#" title="" class="add-butn more-action" data-ripple="">unfollow</a>
                                                            <a href="#" title="" class="add-butn" data-ripple="">follow</a>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="nearly-pepls">
                                                        <figure>
                                                            <a href="time-line.html" title=""><img src="images/resources/nearly1.jpg" alt=""></a>
                                                        </figure>
                                                        <div class="pepl-info">
                                                            <h4><a href="time-line.html" title="">sophia Gate</a></h4>
                                                            <span>tv actresses</span>
                                                            <a href="#" title="" class="add-butn more-action" data-ripple="">unfollow</a>
                                                            <a href="#" title="" class="add-butn" data-ripple="">follow</a>
                                                        </div>
                                                    </div>
                                                </li>
										</ul>
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
    include('footer.php')
    ?>

</div>
	
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="js/main.min.js"></script>
	<script src="js/script.js"></script>
	<script src="js/map-init.js"></script>

</body>	


</html>