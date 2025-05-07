<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dockside Hotel © | Sign Up</title>
	<link rel="stylesheet" href="../styles/signup.css" />
	<?php require 'common.php'; ?>
</head>

<body>
	<?php placeHeader() ?>

	<div id="signup-page" class="px-0 px-md-3 flex-col-center">

		<?php
		// Handle form submission
		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			// initializing variables for conditional form population
			$fname = $_POST['fname'];
			$lname = $_POST['lname'];
			$address = $_POST['address'];
			$phone = $_POST['phone'];
			$birthday = $_POST['birth'];
			$email = $_POST['email'];
			$pass = $_POST['password'];

			$servername = "127.0.0.1:3307";
			//$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "docksidedb";

			// double-check form population by user (though, 'required' is already set in HTML)
			if ((isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['address'])) && (isset($_POST['phone']))
				&& (isset($_POST['birth'])) && (isset($_POST['email'])) && (isset($_POST['password']))
			) {
				$conn = new mysqli($servername, $username, $password, $dbname);

				if ($conn->connect_error) {
					die("Connection failed: " . $conn->connect_error);
				}

				// Check if email already exists
				$email = $_POST['email'];
				$exec_SQLCommand = $conn->query("SELECT COUNT(*) AS instanceCount FROM $dbname.`person` WHERE pers_email = '$email'");
				$doesExist = $exec_SQLCommand->fetch_assoc();

				if ($doesExist['instanceCount'] != 0) {
					// Email already exists, clear email and password fields only
					unset($_POST['email']);
					unset($_POST['password']);
					echo     '<div class="alert alert-danger d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>	
								<div class = "ms-3">
									Email already in use. Please try another.
								</div>
							</div>'; //error message
				} else {
					// Email does not exist, create account
					$result = $conn->query("SELECT MAX(pers_id) AS max_id FROM person");
					$row = $result->fetch_assoc(); // get hard integer value from executing SQL query above
					$nextId = $row['max_id'] + 1;
					$conn->query("ALTER TABLE person AUTO_INCREMENT = $nextId");

					$SQLcommand = "INSERT INTO $dbname.`person` 
								(pers_fname, pers_lname, pers_address, pers_number, pers_birthdate, pers_email, pers_pass) VALUES
								('$fname', '$lname', '$address', '$phone', '$birthday', '$email', '$pass')";


					if ($conn->query($SQLcommand) === TRUE) {
						// Account created successfully, clear all fields
						unset($_POST['fname']);
						unset($_POST['lname']);
						unset($_POST['email']);
						unset($_POST['password']);
						unset($_POST['address']);
						unset($_POST['phone']);
						unset($_POST['birth']);
						echo     '<div class="alert alert-success d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-round-check-icon lucide-user-round-check"><path d="M2 21a8 8 0 0 1 13.292-6"/><circle cx="10" cy="8" r="5"/><path d="m16 19 2 2 4-4"/></svg>									
									<div class = "ms-3">	
										User account created successfully!
									</div>
								</div>';
					} else {
						echo '<div class="alert alert-danger d-flex align-items-center mt-4 mb-n2 w-50" role="alert">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>	
								<div class = "ms-3">'
							. $conn->error .
							'</div>
							</div>';
					}
				}
			}
		}
		?>

		<div id="content" class="row w-75 py-4">
			<section id="side-thumbnail" class="d-none d-md-block col-md-5"></section>

			<section class="col-12 w-sm-100 col-md-7">
				<!-- sign up form -->
				<form
					method="POST"
					id="create-acc-form"
					class="d-flex flex-column justify-content-center align-items-start border border-secondary gap-2 w-sm-50 w-md-25 p-1 p-lg-3">
					<h1 class="fw-bolder align-self-center pt-3 global-heading">Sign Up</h1>
					<div class="form-group flex-col-center container">
						<label for="fname">First Name:</label>
						<input
							type="text"
							class="form-control"
							id="fname"
							name="fname"
							placeholder="Enter your First Name"
							maxlength="40"
							value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>"
							required />
						<!-- php code in ternary form used to refill values in case of thrown sqli error. -->
					</div>
					<div class="form-group flex-col-center container">
						<label for="lname">Last Name:</label>
						<input
							type="text"
							class="form-control"
							id="lname"
							name="lname"
							placeholder="Enter your Last Name"
							maxlength="40"
							value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>"
							required />
						<!-- php code in ternary form used to refill values in case of thrown sqli error. -->
					</div>
					<div class="form-group flex-col-center container">
						<label for="address">Address:</label>
						<input
							type="text"
							class="form-control"
							id="address"
							name="address"
							placeholder="Enter your Address"
							maxlength="255"
							required />
						<!-- php code in ternary form used to refill values in case of thrown sqli error. -->
					</div>
					<div class="form-group flex-col-center container">
						<label for="phone">Enter your phone number:</label>
						<input
							type="tel"
							class="form-control"
							id="phone"
							name="phone"
							placeholder="Phone Number"
							pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}"
							required />
						<small><i class="text-muted">Format: 0912-345-6789</i></small>
					</div>
					<div class="form-group flex-col-center container">
						<label for="birth">Birthday:</label>
						<input
							type="date"
							class="form-control"
							id="birth"
							name="birth"
							required />
					</div>
					<div class="form-group flex-col-center container">
						<label for="email">Email:</label>
						<input
							type="email"
							class="form-control"
							id="email"
							name="email"
							placeholder="Enter email"
							maxlength="255"
							required />
					</div>
					<div class="form-group flex-col-center container">
						<label for="password">Password:</label>
						<input
							type="password"
							class="form-control"
							id="password"
							name="password"
							placeholder="Password"
							maxlength="30"
							required />
					</div>
					<button id="signup-btn" type="submit" class="btn align-self-center my-2">
						Sign Up
					</button>

					<i class=" align-self-center text-center px-5 my-1">
						<small id="emailHelp" class="form-text text-muted">Have an account?</small>
						<a href="./LogIn.html" class="text-muted">Log in here!</a></i>
					<i class="align-self-center text-center px-5 mt-1 mb-3">
						<small id="emailHelp" class="form-text text-muted">To proceed, you must read the
							<a
								type="button"
								id="show-terms"
								href="./terms.php"
								class="text-muted">
								<i><u>Terms and Conditions</u></i>
							</a>
							of the website.</small></i>
				</form>
			</section>
		</div>
	</div>

	<script>
		// javascript logic for conditional rendering

		function showTerms() {
			const termsContainer = document.getElementById("terms-section");
			const termsBackground = document.getElementById("terms-and-cond");

			termsContainer.style.display = "block";
			termsBackground.style.display = "flex";
		}

		function hideTerms() {
			const termsContainer = document.getElementById("terms-section");
			const termsBackground = document.getElementById("terms-and-cond");

			termsContainer.style.display = "none";
			termsBackground.style.display = "none";
		}
	</script>
	<?php placeFooter() ?>
</body>

</html>