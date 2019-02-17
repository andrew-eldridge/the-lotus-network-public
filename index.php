<?php
	session_start();
?>

<!DOCTYPE html>
<html>

<head>

	<title>The Lotus Network</title>
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/main.css" />
	<link rel="stylesheet" type="text/css" href="styles/homepage.css" id="stylesheet" />
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
				include "data/patterns/page-contents/home/maindata.php";
			?>

		</main>

	</div>

	<script src="scripts/main.js"></script>

</body>

</html>
