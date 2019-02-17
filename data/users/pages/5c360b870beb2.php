<?php
							session_start();
						?>
						<!DOCTYPE html>
						<html>
						<head>
							<title>Thomas the Train's Profile</title>
							<link rel='stylesheet' type='text/css' href='../../../styles/main.css' />
							<link rel='stylesheet' type='text/css' href='../../../styles/profilepage.css' />
							<link rel='shortcut icon' href='../../../images/favicon.ico' />
						</head>
						<body  onresize = 'updateUI()' onload='updateUI()'>

							<div id='wrapper'>

								<?php
									include '../../patterns/page-contents/profilebanner.php';
									include '../../patterns/page-contents/profilenavigation.php';
									include '../../patterns/page-contents/profiledropdowncontent.php';
								?>

								<main>

									<div class='section'>

										<div class='headerinfo'>
											<div class='imagecontainer'>
												<img src='../images/5c360b870beb2.jpg' />
											</div>
											<div class='usercontainer'>
												<div class='name'>Thomas the Train</div>
												<div class='description'>I am a train choo choo</div>
											</div>
											<div class='connect'>
												<a href='../../../connect.php?id=5c360b870beb2'
													<img src='../../../images/network.png' />
													<div class='connectlabel'>Connect</div>
												</a>
											</div>
										</div>

										<div class='credentialinfo'>
											<div class='socialnetworkinglinks'>
												<div>
													<img src='../../../images/linkedinicon.png' />
													<a href='linkedin.com'>linkedin.com</a>
												</div>
												<div>
													<img src='../../../images/facebookicon.png' />
													<a href='facebook.com'>facebook.com</a>
												</div>
												<div>
													<img src='../../../images/twittericon.png' />
													<a href='twitter.com'>twitter.com</a>
												</div>
											</div>
											<div class='actions'>
												<div class='action'><a href='../resumes/5c360b870beb2.pdf' target='_blank'>View Resume</a></div>
											</div>
										</div>

										<div class='networks'>
											<div class='networksection'>
												<header class='networkheader'>Connections</header>
												<div class='networkcontent'></div>
											</div>
											<div class='networksection'>
												<header class='networkheader'>Teams</header>
												<div class='networkcontent'></div>
											</div>
											<div class='networksection'>
												<header class='networkheader'>Partnerships</header>
												<div class='networkcontent'></div>
											</div>
											<div class='networksection'>
												<header class='networkheader'>Projects</header>
												<div class='networkcontent'></div>
											</div>
										</div>

									</div>

								</main>

							</div>

							<script src='../../../scripts/main.js'></script>

						</body>
						</html>