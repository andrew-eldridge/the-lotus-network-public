<?php

	session_start();
	include_once "data/patterns/mysqli_connection.php";

	$url = $_SERVER["REQUEST_URI"];
	$sql = "";
	$param = null;
	$isfreelancer = false;
	class User {
		public $name = null;
		public $resourceid = null;
		public $imageext = null;
		public $email = null;
		public $location = null;
		public $description = null;
		public $education = null;
		public $isEmployer = null;
		public $isFreelancer = null;
		public $languages = array();
		public $wagerate = null;
	};
	$users = array();

	$parts = parse_url($url);
	parse_str($parts["query"], $query);
	if (isset($query["search"])) {
		$param = $query["search"];

		if (isset($query["connection_type"])) {
			if ($query["connection_type"] == "freelancer") {
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
						WHERE (firstname LIKE '%{$param}%' OR lastname LIKE '%{$param}%' OR email LIKE '%{$param}%' OR city LIKE '%{$param}%' OR state LIKE '%{$param}%' OR description LIKE '%{$param}%' OR education LIKE '%{$param}%' OR minwage LIKE '%{$param}%' OR maxwage LIKE '%{$param}%' OR name LIKE '%{$param}%') AND (userdata.isfreelancer = true);";
			} else if ($query["connection_type"] == "employer") {
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
						WHERE (firstname LIKE '%{$param}%' OR lastname LIKE '%{$param}%' OR email LIKE '%{$param}%' OR city LIKE '%{$param}%' OR state LIKE '%{$param}%' OR description LIKE '%{$param}%' OR education LIKE '%{$param}%' OR minwage LIKE '%{$param}%' OR maxwage LIKE '%{$param}%' OR name LIKE '%{$param}%') AND (userdata.isemployer = true);";
			};
		} else {
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
						userdata.metadata,
						language.name
					FROM user
					LEFT JOIN location ON user.locationid = location.locationid
					LEFT JOIN userdata ON user.userid = userdata.userid
					LEFT JOIN user_language ON user_language.userid = user.userid
					LEFT JOIN language ON language.languageid = user_language.languageid
					WHERE firstname LIKE '%{$param}%' OR lastname LIKE '%{$param}%' OR email LIKE '%{$param}%' OR city LIKE '%{$param}%' OR state LIKE '%{$param}%' OR description LIKE '%{$param}%' OR education LIKE '%{$param}%' OR minwage LIKE '%{$param}%' OR maxwage LIKE '%{$param}%' OR name LIKE '%{$param}%' OR metadata LIKE '%{$param}%';";
		};
		$result = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($result);
		if ($rows > 0) {
			while($row = mysqli_fetch_assoc($result)) {
				// Checks if user in current row has already had user object created
				// If already created, adds language to array and continues
				foreach($users as $user) {
					if ($user->email == $row["email"]) {
						array_push($user->languages, $row["name"]);
						continue 2;
					}
				}
				$user = new User();
				$user->name = $row["firstname"] . " " . $row["lastname"];
				$user->resourceid = $row["resourceid"];
				$user->imageext = $row["imageext"];
				$user->email = $row["email"];
				if ($row["city"] != null && $row["state"] != null) {
					$user->location = $row["city"] . ", " . $row["state"];
				};
				$user->description = $row["description"];
				$user->education = $row["education"];
				$user->isEmployer = $row["isemployer"];
				$user->isFreelancer = $row["isfreelancer"];
				if ($row["name"] != null) {
					array_push($user->languages, $row["name"]);
				};
				if ($row["minwage"] != 0 && $row["maxwage"] != 0) {
					$user->wagerate = "$" . $row["minwage"] . " - $" . $row["maxwage"];
				} else if ($row["minwage"] != 0) {
					$user->wagerate = "$" . $row["minwage"] . " - N/A";
				} else if ($row["maxwage"] != 0) {
					$user->wagerate = "N/A" . " - $" . $row["maxwage"];
				} else {
					$user->wagerate = "N/A";
				};
				array_push($users, $user);
			}
		}
	};

?>

<!DOCTYPE html>
<html>
<head>

	<title>Search - The Lotus Network</title>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
	<link rel="stylesheet" type="text/css" href="styles/search.css" />
	<link rel="shortcut icon" href="images/favicon.ico" id="favicon" />

</head>
<body onresize = "updateUI()" onload="updateUI()">

	<div id="wrapper">

		<?php
			include "data/patterns/page-contents/banner.php";
			include "data/patterns/page-contents/navigation.php";
			include "data/patterns/page-contents/dropdowncontent.php";
		?>

		<main>

			<?php
				include "data/patterns/page-contents/search/maindata.php";
			?>

		</main>

	</div>

	<script src="scripts/main.js"></script>

</body>
</html>