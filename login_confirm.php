<?php

	include_once "data/patterns/mysqli_connection.php"; 

	$email = mysqli_real_escape_string($conn, $_POST["email"]);
	$password = mysqli_real_escape_string($conn, $_POST["password"]);
	$found = False;

	$query = "SELECT * FROM user WHERE email = '$email';";
	$result = mysqli_query($conn, $query);
	$rows = mysqli_num_rows($result);
	if ($rows > 0) {
		while($row = mysqli_fetch_assoc($result)) {
			if (password_verify($password, $row['password'])) {
				session_start();
				$_SESSION["id"] = session_create_id();
				$_SESSION["uid"] = $row['userid'];
				$_SESSION["firstname"] = $row['firstname'];
				$_SESSION["lastname"] = $row['lastname'];
				$_SESSION["email"] = $row['email'];
				$_SESSION["resourceid"] = $row['resourceid'];
				if (isset($row["imageext"])) {
					$_SESSION["imagepath"] =  "data/users/images/" . $row["resourceid"] . $row["imageext"];
				} else {
					unset($_SESSION["imagepath"]);
				};
				$found = True;
			};
		};
	};

	if ($found) {
		header("Location: ./index.php");
	};

?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php if ($found) {
			echo("Login Successful - The Lotus Network");
		} else {
			echo("Login Failed - The Lotus Network");
		} ?></title>
		<link rel="stylesheet" type="text/css" href="styles/login_signup.css" />
	</head>
	<body>
		<div class="container">
			<div class="item">
				<?php if ($found) {
					$firstname = null;
					$query = "SELECT firstname FROM user WHERE email = '$email';";
					$result = mysqli_query($conn, $query);
					while($row = mysqli_fetch_assoc($result)) {
						$firstname = $row['firstname'];
					};
					header("Location: ./index.php");
				} else {
					echo("Login attempt for " . $email . " failed, please try again");
				}; ?>
				<a href="login.html"><button style="font-size:24px; position: absolute; left: 0; bottom: -50px; color: red;">Return</button></a>
			</div>
		</div>
	</body>
</html>