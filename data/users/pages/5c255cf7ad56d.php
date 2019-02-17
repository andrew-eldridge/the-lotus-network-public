<?php
						session_start();
					?>
					<!DOCTYPE html>
					<html>
					<head>
						<title>Mister Usable's Profile</title>
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



								</div>

							</main>

						</div>

						<script src='../../../scripts/main.js'></script>

					</body>
					</html>