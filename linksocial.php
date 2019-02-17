<?php

	include_once "data/patterns/mysqli_connection.php";
	session_start();

	if (isset($_SESSION["uid"])) {
		if (isset($_POST["linkedinlink"]) && $_POST["linkedinlink"] != null) {
			$linkedinlink = $_POST["linkedinlink"];
			$sql = "UPDATE userdata SET linkedin = '" . $linkedinlink . "' WHERE userid = " . $_SESSION["uid"];
			if (!mysqli_query($conn, $sql)) {
				//echo "An error occurred while adding linkedin credential";
			} else {
				//echo "Successfully added linkedin credential";
			};
		};
		if (isset($_POST["facebooklink"]) && $_POST["facebooklink"] != null) {
			$facebooklink = $_POST["facebooklink"];
			$sql = "UPDATE userdata SET facebook = '" . $facebooklink . "' WHERE userid = " . $_SESSION["uid"];
			if (!mysqli_query($conn, $sql)) {
				//echo "An error occurred while adding facebook credential";
			} else {
				//echo "Successfully added facebook credential";
			};
		};
		if (isset($_POST["twitterlink"]) && $_POST["twitterlink"] != null) {
			$twitterlink = $_POST["twitterlink"];
			$sql = "UPDATE userdata SET twitter = '" . $twitterlink . "' WHERE userid = " . $_SESSION["uid"];
			if (!mysqli_query($conn, $sql)) {
				//echo "An error occurred while adding twitter credential";
			} else {
				//echo "Successfully added twitter credential";
			};
		};
		/*
		if (isset($_POST["othername"]) && isset($_POST["otherlink"])) {
			$othername = $_POST["othername"];
			$otherlink = $_POST["otherlink"];
		};
		*/
	};

	header("Location: ./index.php");

?>