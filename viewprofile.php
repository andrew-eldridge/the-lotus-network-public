<?php
	session_start();

	$url = $_SERVER["REQUEST_URI"];
	$parts = parse_url($url);
	parse_str($parts["query"], $query);

	if isset($query["id"]) {
		$sql = "SELECT
							user.firstname,
							user.lastname,
							user.resourceid,
							user.imageext,
							user.email,
							location.city,
							location.state,
							userdata.description,
							userdata.education,
							userdata.isemployer,
							userdata.isfreelancer,
							userdata.minwage,
							userdata.maxwage,
							language.name
						FROM user
						LEFT JOIN location ON user.locationid = location.locationid
						LEFT JOIN userdata ON user.userid = userdata.userid
						LEFT JOIN user_language ON user_language.userid = user.userid
						LEFT JOIN language ON language.languageid = user_language.languageid
						WHERE user.userid ="
	} else {
		header("Location: ./index.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo("$firstname ${lastname}'s Profile"); ?></title>
	<link rel='stylesheet' type='text/css' href='styles/main.css' />
	<link rel='stylesheet' type='text/css' href='styles/profilepage.css' />
	<link rel='shortcut icon' href='images/favicon.ico' />
</head>
<body  onresize = 'updateUI()' onload='updateUI()'>

	<div id='wrapper'>

		<?php
			include 'data/patterns/page-contents/banner.php';
			include 'data/patterns/page-contents/navigation.php';
			include 'data/patterns/page-contents/dropdowncontent.php';
		?>

		<main>

			<div class='section'>

				<div class='headerinfo'>
					<div class='imagecontainer'>
						<img src=<?php echo("'${imageHTML}'"); ?> />
					</div>
					<div class='usercontainer'>
						<div class='name'><?php echo ("$firstname $lastname"); ?></div>
						<div class='description'>" . $description . "</div>
					</div>
					<div class='connect'>
						<a href='connect.php?id=" . $resourceid . "'>
							<img src='images/network.png' />
							<div class='connectlabel'>Connect</div>
						</a>
					</div>
				</div>

				<div class='credentialinfo'>
					<div class='socialnetworkinglinks'>
						<div>
							<img src='images/linkedinicon.png' />
							<a href='linkedin.com'><?php echo($linkedinlink); ?></a>
						</div>
						<div>
							<img src='images/facebookicon.png' />
							<a href='facebook.com'><?php echo($facebooklink); ?></a>
						</div>
						<div>
							<img src='images/twittericon.png' />
							<a href='twitter.com'>t<?php echo($twitterlink); ?></a>
						</div>
					</div>
					<div class='actions'>
						<div class='action'><a href=<?php echo("'data/users/resumes/${resourceid}.pdf'"); ?> target='_blank'>View Resume</a></div>
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

	<script src='scripts/main.js'></script>

</body>
</html>