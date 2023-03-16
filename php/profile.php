<!DOCTYPE html>

<?php
	// Start the session
	session_start();

	// Check if the user is logged in
	if (!isset($_SESSION['username'])) {
		// If not, redirect to the login page
		header('location: login.php');
		exit();
	}

	// Retrieve the username from the session
	$username = $_SESSION['username'];
	?>