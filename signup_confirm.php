<?php

	include_once "data/patterns/mysqli_connection.php";

	$firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
	$lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$description = mysqli_real_escape_string($conn, $_POST["description"]);
	$minwage = mysqli_real_escape_string($conn, $_POST["minwage"]);
	$maxwage = mysqli_real_escape_string($conn, $_POST["maxwage"]);
	$city = mysqli_real_escape_string($conn, $_POST["city"]);
	$state = mysqli_real_escape_string($conn, $_POST["state"]);

	if ($firstname != null) {
		$languages = array();
		if (isset($_POST["languages"])) {
			foreach($_POST["languages"] as $language) {
				array_push($languages, intval($language));
			};
		};
		$isEmployer = false;
		$isFreelancer = false;
		$metadata = null;
		if (isset($_POST["usertype"])) {
			foreach($_POST["usertype"] as $type) {
				if ($type == "employer") {
					$isEmployer = true;
					$metadata .= "employer";
				} else if ($type == "freelancer") {
					$isFreelancer = true;
					$metadata .= "freelancer";
				};
			};
		};
		$locationid = 0;
		$userid = null;
		$ext = null;
		$resourceid = null;
		$success = false;
		$hashedpass = password_hash($password, PASSWORD_DEFAULT);
		
		if (strrpos($_FILES["profile_pic"]["name"], ".jpg") != null || strrpos($_FILES["profile_pic"]["name"], ".jpeg") != null) {
			$ext = ".jpg";
		};
		if (strrpos($_FILES["profile_pic"]["name"], ".png") != null) {
			$ext = ".png";
		};

		$resourceid = uniqid(); // TODO: use uuid for resourceid to prevent overlap

		if ($ext != null) {
			$imagepath = __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR . "images" . DIRECTORY_SEPARATOR . $resourceid . $ext;
			if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $imagepath)) {
				$success = true;
			};
		} else {
			$success = true;
		};

		$pagepath = __DIR__ . DIRECTORY_SEPARATOR . "data" . DIRECTORY_SEPARATOR . "users" . DIRECTORY_SEPARATOR . "pages" . DIRECTORY_SEPARATOR . $resourceid . ".php";

		// Determines data to be shown on profile page
		$imageHTML = null;
		if ($ext != null) {
			$imageHTML = "../images/" . $resourceid . $ext;
		} else {
			$imageHTML = "../../../images/accounts.png";
		};
		$connectionsHTML = "";
		$teamsHTML = "";
		$partnershipsHTML = "";
		$projectsHTML = "";

		// TODO: Dynamically update connections, teams, partnerships, and projects

		// TODO: Produce profile pages dynamically onload (remove entire 'pages' folder)

		/*
		$pagecontent = "<?php
							session_start();
						?>
						<!DOCTYPE html>
						<html>
						<head>
							<title>" . $firstname . " " . $lastname . "'s Profile</title>
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
												<img src='" . $imageHTML . "' />
											</div>
											<div class='usercontainer'>
												<div class='name'>" . $firstname . " " . $lastname . "</div>
												<div class='description'>" . $description . "</div>
											</div>
											<div class='connect'>
												<a href='../../../connect.php?id=" . $resourceid . "'>
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
												<div class='action'><a href='../resumes/" . $resourceid . ".pdf' target='_blank'>View Resume</a></div>
											</div>
										</div>

										<div class='networks'>
											<div class='networksection'>
												<header class='networkheader'>Connections</header>
												<div class='networkcontent'>" . $connectionsHTML . "</div>
											</div>
											<div class='networksection'>
												<header class='networkheader'>Teams</header>
												<div class='networkcontent'>" . $teamsHTML . "</div>
											</div>
											<div class='networksection'>
												<header class='networkheader'>Partnerships</header>
												<div class='networkcontent'>" . $partnershipsHTML . "</div>
											</div>
											<div class='networksection'>
												<header class='networkheader'>Projects</header>
												<div class='networkcontent'>" . $projectsHTML . "</div>
											</div>
										</div>

									</div>

								</main>

							</div>

							<script src='../../../scripts/main.js'></script>

						</body>
						</html>";

		if (file_put_contents($pagepath, $pagecontent) !== false) {
	    	$success = true;
		} else {
	    	echo "Cannot create file";
	    	$success = false;
		}
		*/
		
		if ($success) {
			// Inserts location entry and retrieves locationid
			if ($city != null && $state != null) {
				$query = "INSERT INTO location (city, state) VALUES ('$city', '$state');";
				if (!mysqli_query($conn, $query)) {
					echo "Failed to insert location document";
					$success = false;
				} else {
					$query = "SELECT locationid FROM location WHERE location.city = '$city' AND location.state = '$state';";
					$result = mysqli_query($conn, $query);
					$rows = mysqli_num_rows($result);
					if ($rows > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							$locationid = $row["locationid"];
						}
					} else {
						$success = false;
						echo "An error occurred while retrieving locationid";
					};
				};
			};

			// Inserts user entry, retrieves userid, and sets session variables
			$query = "INSERT INTO user (firstname, lastname, email, password, resourceid, imageext, locationid) VALUES ('$firstname', '$lastname', '$email', '$hashedpass', '$resourceid', '$ext', '$locationid');";
			if (!mysqli_query($conn, $query)) {
				$success = false;
				echo "An error occurred while inserting the user document";
			} else {
				session_start();
				$_SESSION["id"] = session_create_id();
				$_SESSION["firstname"] = $firstname;
				$_SESSION["lastname"] = $lastname;
				$_SESSION["email"] = $email;
				$_SESSION["resourceid"] = $resourceid;
				$query = "SELECT userid FROM user WHERE user.resourceid = '$resourceid';";
				$result = mysqli_query($conn, $query);
				$rows = mysqli_num_rows($result);
				if ($rows > 0) {
					while ($row = mysqli_fetch_assoc($result)) {
						$userid = $row["userid"];
						$_SESSION["uid"] = $userid;
					}
				} else {
					$success = false;
					echo "An error occurred while retrieving the userid";
				};
				if ($ext != null) {
					$_SESSION["imagepath"] = "data/users/images/" . $resourceid . $ext;
				} else {
					unset($_SESSION["imagepath"]);
				};
			};

			// Inserts userdata entry
			$query = "INSERT INTO userdata (userid, description, isemployer, isfreelancer, minwage, maxwage, metadata) VALUES ('$userid', '$description', '$isEmployer', '$isFreelancer', '$minwage', '$maxwage', '$metadata');";
			if (!mysqli_query($conn, $query)) {
				$success = false;
				echo "An error occurred while inserting the userdata document";
			};

			// Maps user to selected languages
			foreach ($languages as $languageid) {
				$query = "INSERT INTO user_language (userid, languageid) VALUES ('$userid', '$languageid');";
				if (!mysqli_query($conn, $query)) {
					$success = false;
				};
			};
		};
	} else {
		$success = false;
	};

	// Redirects to homepage on success
	if ($success) {
		header("Location: ./index.php");
	};

?>

<head>
	<title>Signup Failed - The Lotus Network</title>
	<link rel="stylesheet" type="text/css" href="styles/login_signup.css" />
</head>
<body>
	<div class="container">
		<div class="item">
			<?php
				echo ("Account creation for $firstname failed");
			?>
			<a href="signup.html"><button style="font-size:24px; position: absolute; left: 0; bottom: -50px; color: red;">Return</button></a>
		</div>
	</div>
</body>