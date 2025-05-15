<?php
session_start();

require '../scripts/handle_newacc.php';

// Check if there's a pending booking that needs authentication
$hasBookingDetails = isset($_SESSION['pending_booking_details']) &&
	$_SESSION['pending_booking_details']['requires_auth'] === true;
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dockside Hotel© | Sign Up</title>
	<link rel="stylesheet" href="../styles/signup.css" />
	<?php require 'common.php'; ?>
</head>

<body>
	<?php placeHeader() ?>
	<div id="signup-page" class="px-0 px-md-3 flex-col-center">

		<?php handleNewAcc(); ?>
		<div id="content" class="row w-75 py-4">
			<section id="side-thumbnail" class="d-none d-md-block col-md-5"></section>

			<section class="col-12 w-sm-100 col-md-7"> <!-- sign up form -->
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
							type="text"
							class="form-control flatpickr-date"
							id="birth"
							name="birth"
							placeholder="Select your date of birth"
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
							minlength="8"
							maxlength="30"
							required />
					</div> <button id="signup-btn" type="submit" class="btn align-self-center my-2">
						Sign Up
					</button> <i class=" align-self-center text-center px-5 my-1">
						<small id="emailHelp" class="form-text text-muted">Have an account?</small>
						<a href="login.php" class="text-muted">Log in here!</a></i>
					<i class="align-self-center text-center px-5 mt-1 mb-3">
						<small id="emailHelp" class="form-text text-muted">To proceed, you must read the
							<a
								type="button"
								id="show-terms"
								href="../terms.php"
								class="text-muted">
								<i><u>Terms and Conditions</u></i>
							</a>
							of the website.</small></i>
				</form>
			</section>
		</div>
	</div> <?php placeFooter() ?>

	<!-- Flatpickr JavaScript -->
	<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			// Initialize birthday date picker with max date of today
			flatpickr("#birth", {
				maxDate: "today",
				altInput: true,
				altFormat: "F j, Y",
				dateFormat: "Y-m-d"
			});
		});
	</script>
</body>

</html>