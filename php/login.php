<?php
	// Start a new session
	session_start();

	// Check if the login form has been submitted
	if (isset($_POST['login'])) {
		// Retrieve the username and password submitted by the user
		$username = $_POST['username'];
		$password = $_POST['password'];

		// Connect to the MySQL database
		$servername = "sql7.freemysqlhosting.net";
		$dbusername = "sql7606042";
		$dbpassword = "b19R39rwMM";
		$dbname = "sql7606042";
		$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

		// Check if the connection was successful
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}

		// Query the database for the user with the specified username and password
		$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
		$result = $conn->query($sql);

		// Check if a matching user was found
		if ($result->num_rows == 1) {
			// Save the username in the session and redirect to the profile page
			$_SESSION['username'] = $username;
			header('location: /profile.php');
			exit();
		} else {
			// Display an error message if no matching user was found
			echo '<div class="error">Invalid username or password.</div>';
		}

		// Close the database connection
		$conn->close();
	}
	?>