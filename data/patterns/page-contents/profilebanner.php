<div id="banner">

	<div id="logowrapper">
		<a href="../../../index.php">
			<img src="../../../images/logo_v2.jpg" id="logo" />
		</a>
	</div>

	<div id="titlewrapper">
		The Lotus Network <span style="font-size: 16px;">Beta</span>
	</div>

	<div id="subtitle">
		Networking for programmers
	</div>

	<div id="namedisplay">
		<?php
			if (isset($_SESSION["firstname"])) {
				echo ($_SESSION["firstname"] . " " . $_SESSION["lastname"]);
			}
		?>
	</div>
	
	<div id="accountwrapper" onmouseover="updateNav(-2, true)" onmouseout="updateNav(-2, false)" onclick="toggleDropdown(-1)">
		<img src=<?php
			if (isset($_SESSION["imagepath"])) {
				echo ("../../../" . $_SESSION["imagepath"]);
			} else {
				echo ("../../../images/accounts.png");
			};
		?> />
	</div>
	
	<div id="accountdropdown">
		<div class="header dropdownheader">
			Account
		</div>
		<div class="subcontent">
			<?php
				$resumeOption = "Upload";
				if (isset($_SESSION["resumeid"])) {
					$resumeOption = "Update";
				};
				if (!isset($_SESSION["email"])) {
					echo ("<ul>
							<li>
								<img src='../../../images/login.png' />
								<a href='../../../login.html'>Login</a>
							</li>
							<li>
								<img src='../../../images/signup.png' />
								<a href='../../../login.html'>Sign up</a>
							</li>
							</ul>
							<p>Login or sign up to access additional features</p>");
				} else {
					echo ("<ul>
							<li>
								<img src='../../../images/login.png' />
								<a href='./" . $_SESSION["resourceid"] . ".php'>My Profile</a>
							</li>
							<li>
								<img src='../../../images/resume.png' />
								<a href='../../../resumeupload.php'>{$resumeOption} Resume</a>
							</li>
							<li>
								<img src='../../../images/team.png' />
								<a href='../../../search.php?search='>Make Connections</a>
							</li>
							<li>
								<img src='../../../images/signout.png' />
								<a href='../../../signout.php'>Sign Out</a>
							</li>
							</ul>");
				};
			?>
		</div>
	</div>

</div>