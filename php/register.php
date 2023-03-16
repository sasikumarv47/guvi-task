<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<style>
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
		}
		
		h1 {
			text-align: center;
			margin-top: 50px;
			margin-bottom: 30px;
		}
		
		form {
			width: 50%;
			margin: 0 auto;
			background-color: #fff;
			padding: 20px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
			border-radius: 5px;
		}
		
		label {
			display: block;
			margin-bottom: 10px;
			font-weight: bold;
		}
		
		input[type="text"], input[type="email"], input[type="password"] {
			display: block;
			width: 100%;
			padding: 10px;
			margin-bottom: 20px;
			border: 1px solid #ccc;
			border-radius: 3px;
			box-sizing: border-box;
			font-size: 16px;
		}
		
		button[type="submit"] {
			background-color: #4CAF50;
			color: #fff;
			padding: 10px 20px;
			border: none;
			border-radius: 3px;
			font-size: 16px;
			cursor: pointer;
		}
		
		button[type="submit"]:hover {
			background-color: #3e8e41;
		}
	</style>
</head>
<body>
	<h1>Register</h1>
	<?php
		$errors = array();
		
		// Connect to the database
		$db = mysqli_connect('sql7.freemysqlhosting.net', 'sql7606042', 'b19R39rwMM', 'sql7606042');
		
		// Handle form submission
		if (isset($_POST['submit'])) {
			// Get form data
			$username = mysqli_real_escape_string($db, $_POST['username']);
			$email = mysqli_real_escape_string($db, $_POST['email']);
			$password = mysqli_real_escape_string($db, $_POST['password']);
			
			// Validate form data
			if (empty($username)) {
				array_push($errors, "Username is required");
			}
			if (empty($email)) {
				array_push($errors, "Email is required");
			}
			if (empty($password)) {
				array_push($errors, "Password is required");
			}
			
			// Check if username or email already exists in the database
			$user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
			$result = mysqli_query($db, $user_check_query);
			$user = mysqli_fetch_assoc($result);
			
			if ($user) {
				if ($user['username'] === $username) {
					array_push($errors, "Username already exists");
				}
				if ($user['email'] === $email) {
					array_push($errors, "Email already exists");
				}
			}
			
			// If no errors, insert user into database
			if (count($errors) == 0) {
				$password = md5($password); // encrypt password before storing in database
				$query = "INSERT INTO users (username, email, password) VALUES('$username', '$email','$password')";
				mysqli_query($db, $query);
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: profile.php');
			}
		}
	?>
	
	<form method="post" action="">
		<?php if (count($errors) > 0): ?>
			<div>
				<?php foreach ($errors as $error): ?>   
					<p><?php echo $error; ?></p>
				<?php endforeach ?>
			</div>
		<?php endif ?>
		
		<label>Username</label>
		<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Enter your username">
		
		<label>Email</label>
		<input type="email" name="email" value="<?php echo $email; ?>" placeholder="Enter your email">
		
		<label>Password</label>
		<input type="password" name="password" placeholder="Enter your password">
		
		<button type="submit" name="submit">Register</button>
	</form>
	
</body>
</html>