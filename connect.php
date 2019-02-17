<?php

	session_start();
	include_once "data/patterns/mysqli_connection.php";

	$url = $_SERVER["REQUEST_URI"];
	$parts = parse_url($url);
	parse_str($parts["query"], $query);

	$userid = null;
	$connectedid = null;

	// Set connectedid and userid variables
	if (isset($query["id"])) {
		$sql = "SELECT userid FROM user WHERE user.resourceid = '" . $query['id'] . "';";
		$result = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($result);
		if ($rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$connectedid = $row["userid"];
			};
		} else {
			//echo "Failed to locate target user";
			header("Location: ./index.php");
		};

		$sql = "SELECT userid FROM user WHERE user.resourceid = '" . $_SESSION['resourceid'] . "';";
		$result = mysqli_query($conn, $sql);
		$rows = mysqli_num_rows($result);
		if ($rows > 0) {
			while ($row = mysqli_fetch_assoc($result)) {
				$userid = $row["userid"];
			};
		} else {
			echo "Could not locate your user document";
		};
	} else {
		header("Location: ./index.php");
	};

	// Make insert/delete query depending on specified action
	if (isset($query["delete"])) {
		$sql = "DELETE FROM connection WHERE (connection.userid1 = " . $userid .  " AND connection.userid2 = " . $connectedid . ") OR (connection.userid1 = " . $connectedid . " AND connection.userid2 = " . $userid . ");";
		if (!mysqli_query($conn, $sql)) {
			echo "An error occurred while removing connection";
		} else {
			header("Location: ./index.php");
		};
	} else {
		if ($query["id"] == $_SESSION["resourceid"]) {
			//echo "Cannot add yourself as connection";
			header("Location: ./index.php");
		} else {
			$sql = "INSERT INTO connection (userid1, userid2) VALUES (" . $userid . ", " . $connectedid . ");";
			if (!mysqli_query($conn, $sql)) {
				//echo "An error occurred while making connection";
				header("Location: ./index.php");
			} else {
				//echo "Connection successfully made";
				header("Location: ./index.php");
			};
		};
	};

?>