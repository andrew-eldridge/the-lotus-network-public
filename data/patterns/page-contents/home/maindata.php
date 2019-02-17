<div class="section">

	<div id="searchbar">
		<form action="./search.php" method="GET">
			<input id="searchbaritem" type="text" name="search" size="20" placeholder="Search a skill" />
			<input id="search" type="image" src="images/search.png" border="0" alt="Submit" />
		</form>
	</div>

	<div class="sectioncontentleft">

		<div class="sectionheader">
			Improve your profile
		</div>

		<div class="subsection activitiessubsection">
			<span class="subheader" style="color:white;">Seach for...</span><br>
			<div class="formcontainer">
				<form action="./search.php" method="GET">
					<input type="hidden" name="connection_type" value="employer" />
					<input type="hidden" name="search" value="" />
					<input type="submit" value="Employers" />
				</form>
				<form action="./search.php" method="GET">
					<input type="hidden" name="connection_type" value="freelancer" />
					<input type="hidden" name="search" value="" />
					<input type="submit" value="Freelancers" />
				</form>
				<form action="./search.php" method="GET">
					<input type="hidden" name="connection_type" value="team" />
					<input type="hidden" name="search" value="" />
					<input type="submit" value="Teams" />
				</form>
				<form action="./search.php" method="GET">
					<input type="hidden" name="connection_type" value="partnership" />
					<input type="hidden" name="search" value="" />
					<input type="submit" value="Business Partners" />
				</form>
			</div>
		</div>

		<div class="subsection activitiessubsection">
			<span style="color:white;">Upload or build a resume</span>
			<div class="formcontainer">
				<form action="./resumeupload.php">
					<input type="submit" value="Upload a Resume" />
				</form>
				<form action="./resumebuilder.php">
					<input type="submit" value="Build a Resume" />
				</form>
			</div>
		</div>

		<div class="subsection activitiessubsection">
			<span style="color:white;">Link your social networking pages</span><br>
			<div class="formcontainer" style="display: block;">
				<form class="socialform">
					<div onclick="showSocialInput('linkedin')">
						<input type="checkbox" id="linkedin" />
						<label for="linkedin">LinkedIn</label>
					</div>
					<div onclick="showSocialInput('facebook')">
						<input type="checkbox" id="facebook" />
						<label for="facebook">Facebook</label>
					</div>
					<div onclick="showSocialInput('twitter')">
						<input type="checkbox" id="twitter" />
						<label for="twitter">Twitter</label>
					</div><br>
					<!--<div onclick="showSocialInput('other')">
						<input type="checkbox" id="other" />
						<label for="other">Other</label>
					</div><br>-->
				</form>
				<form class="socialinputform" action="./linksocial.php" method="post">
					<span class="socialinput" style="display: none;" id="linkedininput">Link to LinkedIn: <input type="text" name="linkedinlink" /></span>
					<span class="socialinput" style="display: none;" id="facebookinput">Link to Facebook: <input type="text" name="facebooklink" /></span>
					<span class="socialinput" style="display: none;" id="twitterinput">Link to Twitter: <input type="text" name="twitterlink" /></span>
					<!--<span class="socialinput" style="display: none;" id="othername">Name of site: <input type="text" name="othername" /></span>
					<span class="socialinput" style="display: none;" id="otherinput">Link to site: <input type="text" name="otherlink" /></span><br>-->
					<span class="socialinput" style="display: none;" id="submitinput"><br><input type="submit" value="Link Accounts" /></span>
				</form>
			</div>
		</div>

		<div class="sectionheader">
			Updates
		</div>

		<div class="subsection updatessubsection">
			There is nothing to see right now.
		</div>

	</div>

	<?php

		include_once "data/patterns/mysqli_connection.php"; 

		$connectionContents = "<div class='subsection' style='background-color: black;'>
									<a href='./search.php?search='>Make a connection</a>
								</div>";
		$teamContents = "<div class='subsection' style='background-color: black;'>
							<a onclick='incompleteMessage()'>Start a team</a>
						</div>";
		$partnershipContents = "<div class='subsection' style='background-color: black;'>
									<a onclick='incompleteMessage()'>Advertise a partnership</a>
								</div>";
		$projectContents = "<div class='subsection' style='background-color: black;'>
								<a onclick='incompleteMessage()'>Upload a project</a>
							</div>";

		if (isset($_SESSION["uid"])) {
			// Acquire user's connections based on their userid (stored as session variable)
			$query = "SELECT * FROM connection WHERE connection.userid1 = " . $_SESSION['uid'] . " OR connection.userid2 = " . $_SESSION['uid'] . ";";
			$result = mysqli_query($conn, $query);
			$rows = mysqli_num_rows($result);
			if ($rows > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					if ($row["userid1"] == $_SESSION["uid"]) {
						$query = "SELECT firstname, lastname, resourceid FROM user WHERE user.userid = " . $row['userid2'] . ";";
					} else {
						$query = "SELECT firstname, lastname, resourceid FROM user WHERE user.userid = " . $row['userid1'] . ";";
					};
					$result = mysqli_query($conn, $query);
					$rows = mysqli_num_rows($result);
					if ($rows > 0) {
						while ($connectionrow = mysqli_fetch_assoc($result)) {
							$connectionContents .= "<div class='subsection connection'>
														<a href='./data/users/pages/" . $connectionrow["resourceid"] . ".php'>" . $connectionrow["firstname"] . " " . $connectionrow["lastname"] . "</a>
														<a href='./connect.php?delete=1&id=" . $connectionrow["resourceid"] . "'><img src='images/delete.png' /></a>
													</div>";
						};
					};
				};
			};

			// Acquire user's teams
			$query = "SELECT team.name, team.resourceid FROM team_connection LEFT JOIN team ON team_connection.teamid = team.teamid WHERE team_connection.userid = " . $_SESSION['uid'] . ";";
			$result = mysqli_query($conn, $query);
			$rows = mysqli_num_rows($result);
			if ($rows > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$teamContents .= "<div class='subsection'>
											<a href='./data/networks/teams/" . $row["resourceid"] . ".php'>" . $row["name"] . "</a>
										</div>";
				};
			};

			////////////////////////////////////////////////
			// TODO: Acquire user's business partnerships //
			////////////////////////////////////////////////

			// Acquire user's projects
			$query = "SELECT project.name, project.resourceid FROM user_project LEFT JOIN project ON project.projectid = user_project.projectid WHERE user_project.userid = " . $_SESSION['uid'] . ";";
			$result = mysqli_query($conn, $query);
			$rows = mysqli_num_rows($result);
			if ($rows > 0) {
				while ($row = mysqli_fetch_assoc($result)) {
					$projectContents .= "<div class='subsection'>
											<a href='./data/projects/" . $row["resourceid"] . ".php'>" . $row["name"] . "</a>
										</div>";
				};
			};
		};

	?>

	<div class="sectioncontentright">

		<div class="sectionheader">
			Connections
			<img src="images/network.png" />
		</div>

		<?php
			echo "$connectionContents";
		?>

		<div class="sectionheader">
			Teams
			<img src="images/team.png" />
		</div>

		<?php
			echo "$teamContents";
		?>

		<div class="sectionheader">
			Partnerships
			<img src="images/business.png" />
		</div>

		<?php
			echo "$partnershipContents";
		?>

		<div class="sectionheader">
			Projects
			<img src="images/share.png" />
		</div>

		<?php
			echo "$projectContents";
		?>

	</div>

</div>