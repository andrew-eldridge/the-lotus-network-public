<div id="searchbar">
	<form action="./search.php" method="GET">
		<input id="searchbaritem" type="text" name="search" size="20" placeholder="Search a skill" />
		<input id="search" type="image" src="images/search.png" border="0" alt="Submit" />
	</form>
</div>

<div class="section">

	<?php

		if ($query["search"] != null) {
			if (isset($query["connection_type"])) {
				echo ("<span style='font-size: 24px; margin-bottom: 20px;'>Showing results for \"" . $query["search"] . "\" from " . $query["connection_type"] . "s</span>");
			} else {
				echo ("<span style='font-size: 24px; margin-bottom: 20px;'>Showing results for \"" . $query["search"] . "\"</span>");
			};
		} else {
			if (isset($query["connection_type"])) {
				echo ("<span style='font-size: 24px; margin-bottom: 20px;'>Showing results for universal search from " . $query["connection_type"] . "s</span>");
			} else {
				echo ("<span style='font-size: 24px; margin-bottom: 20px;'>Showing results for universal search</span>");
			};
		};

		foreach($users as $user) {
			$languagelist = "";
			$imagepath = "";
			$locationinfo = "";
			$skillinfo = "";

			if ($user->location != null) {
				$locationinfo = "<div class='location'><img src='images/location.svg' /><div>" . $user->location . "</div></div>";
			};

			if ($user->imageext != null) {
				$imagepath = 'data/users/images/' . $user->resourceid . $user->imageext;
			} else {
				$imagepath = 'images/accounts.png';
			};

			foreach($user->languages as $language) {
				if ($languagelist != "") {
					$languagelist .= ", " . $language;
				} else {
					$languagelist .= " " . $language;
				};
			};

			if ($languagelist != null) {
				$skillinfo = "<div class='languages'><b>Skilled in:</b>" . $languagelist . "</div>";
			};

			if ($user->isEmployer && $user->isFreelancer) {
				echo("	<div class='subsection'>
							<div class='imagecontainer'>
								<img src= '" . $imagepath . "' />
							</div>
							<div class='credentials'>
								<div class='name'>" . $user->name . "</div>
								<div class='usertype'>Employer, Freelancer</div>
								<div class='wagerate'>Hourly Rate: " . $user->wagerate . "</div>"
								. $locationinfo .
								$skillinfo .
							"</div>
							<div class='actions'>
								<div class='action'><a href='data/users/pages/" . $user->resourceid . ".php'>View profile</a></div>
								<div class='action'><a href='./connect.php?id=" . $user->resourceid . "'>Make Connection</a></div>
							</div>
						</div>");
			} else if ($user->isEmployer) {
				echo("	<div class='subsection'>
							<div class='imagecontainer'>
								<img src= '" . $imagepath . "' />
							</div>
							<div class='credentials'>
								<div class='name'>" . $user->name . "</div>
								<div class='usertype'>Employer</div>"
								. $locationinfo .
								$skillinfo .
							"</div>
							<div class='actions'>
								<div class='action'><a href='data/users/pages/" . $user->resourceid . ".php'>View profile</a></div>
								<div class='action'><a href='./connect.php?id=" . $user->resourceid . "'>Make Connection</a></div>
							</div>
						</div>");
			} else if ($user->isFreelancer) {
				echo("	<div class='subsection'>
							<div class='imagecontainer'>
								<img src= '" . $imagepath . "' />
							</div>
							<div class='credentials'>
								<div class='name'>" . $user->name . "</div>
								<div class='usertype'>Freelancer</div>
								<div class='wagerate'>Hourly Rate: " . $user->wagerate . "</div>"
								. $locationinfo .
								$skillinfo .
							"</div>
							<div class='actions'>
								<div class='action'><a href='data/users/pages/" . $user->resourceid . ".php'>View profile</a></div>
								<div class='action'><a href='./connect.php?id=" . $user->resourceid . "'>Make Connection</a></div>
							</div>
						</div>");
			} else {
				echo("	<div class='subsection'>
							<div class='imagecontainer'>
								<img src= '" . $imagepath . "' />
							</div>
							<div class='credentials'>
								<div class='name'>" . $user->name . "</div>"
								. $locationinfo .
								$skillinfo .
							"</div>
							<div class='actions'>
								<div class='action'><a href='data/users/pages/" . $user->resourceid . ".php'>View profile</a></div>
								<div class='action'><a href='./connect.php?id=" . $user->resourceid . "'>Make Connection</a></div>
							</div>
						</div>");
			}
		}
	?>

</div>
