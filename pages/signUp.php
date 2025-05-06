<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Luxury Hotel | Sign Up</title>
	<link rel="stylesheet" href="../styles/signUp.css" />

	<?php require 'common.php'; ?>
</head>

<body>
	<?php require '../components/header.php'; ?>
	<div id="signup-page" class="px-0 px-md-3 flex-col-center">
		<div id="content" class="row w-75 py-4">
			<section id="side-thumbnail" class="d-none d-md-block col-md-5"></section>

			<section class="col-12 w-sm-100 col-md-7">
				<!-- sign up form -->
				<form
					method="POST"
					id="create-acc-form"
					class="d-flex flex-column justify-content-center align-items-start border border-secondary gap-2 w-sm-50 w-md-25 p-1 p-lg-3">
					<h1 class="fw-bolder align-self-center pt-3">Sign Up</h1>
					<div class="form-group flex-col-center container">
						<label for="fname">First Name:</label>
						<input
							type="text"
							class="form-control"
							id="fname"
							name="fname"
							aria-describedby="emailHelp"
							placeholder="Enter your First Name"
							maxlength="40"
							value="<?php echo isset($_POST['fname']) ? $_POST['fname'] : ''; ?>"
							required />
						<!-- php code in ternary form used to refill values in case of thrown
						sqli error. -->
					</div>
					<div class="form-group flex-col-center container">
						<label for="lname">Last Name:</label>
						<input
							type="text"
							class="form-control"
							id="lname"
							name="lname"
							aria-describedby="emailHelp"
							placeholder="Enter your Last Name"
							maxlength="40"
							value="<?php echo isset($_POST['lname']) ? $_POST['lname'] : ''; ?>"
							required />
						<!-- php code in ternary form used to refill values in case of thrown
						sqli error. -->
					</div>
					<div class="form-group flex-col-center container">
						<label for="email">Email:</label>
						<input
							type="email"
							class="form-control"
							id="email"
							name="email"
							aria-describedby="emailHelp"
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

					<?php
					if ($_SERVER["REQUEST_METHOD"] == "POST") {

						$fname = $_POST['fname'];
						$lname = $_POST['lname'];
						$email = $_POST['email'];
						$pass = $_POST['password'];

						$servername = "127.0.0.1:3307";
						//$servername = "localhost";
						$username = "root";
						$password = "";
						$dbname = "docksidedb";

						// create DB command

						if ((isset($_POST['fname'])) && (isset($_POST['lname'])) && (isset($_POST['email'])) && (isset($_POST['password']))) {
							$conn = new mysqli($servername, $username, $password, $dbname);

							// Check connection
							if ($conn->connect_error) {
								die("Connection failed: " . $conn->connect_error);
							}

							$fname = $_POST['fname'];
							$lname = $_POST['lname'];
							$pass = $_POST['password'];

							// read table to check if there's no instance of the given email yet:
							$email = $_POST['email'];
							$exec_SQLCommand = $conn->query("SELECT COUNT(*) AS instanceCount FROM $dbname.`person` WHERE pers_email = '$email'");
							$doesExist = $exec_SQLCommand->fetch_assoc(); // prints non-zero value if email exists already.

							// if email instance already exists in database, output error message.
							if ($doesExist['instanceCount'] != 0) {
								echo "<p class='text-danger m-auto'>Email already exists. Please use another.</p>";
							} else {
								$result = $conn->query("SELECT MAX(pers_id) AS max_id FROM person");
								// we need fetch_assoc() since we're expecting a hard number value to be returned from the query.
								$row = $result->fetch_assoc();
								$nextId = $row['max_id'] + 1;
								$conn->query("ALTER TABLE person AUTO_INCREMENT = $nextId");

								// the code above adjusts the next ID number of new records in situations like:
								//
								// (1) INSERT ROWS ID = 10000, ID = 10001
								// (2) DELETE ROW ID = 10001 			
								// (3) INSERT NEW ROW 					
								//
								// (new row will have ID 10001  
								// instead of straight to 10002, 
								// allowing for logical idnum increment)

								$SQLcommand = "INSERT INTO $dbname.`person` (pers_fname, pers_lname, pers_email, pers_pass) 
										VALUES ('$fname', '$lname', '$email', '$pass')";

								if ($conn->query($SQLcommand) === TRUE) {
									echo "<p class='text-success m-auto'>Account created successfully!</p>";
								} else {
									echo "<p class='text-danger text-center'>Error: " . $conn->error . "</p>";
								}
							}
						}
					}
					?>

					<i class=" align-self-center text-center px-5 my-1">
						<small id="emailHelp" class="form-text text-muted">Have an account?</small>
						<u class="text-muted">Log in here!</u></i>
					<i class="align-self-center text-center px-5 mt-1 mb-3">
						<small id="emailHelp" class="form-text text-muted">To proceed, you must read the
							<button
								type="button"
								id="show-terms"
								onclick="showTerms()"
								class="text-muted">
								<i><u>Terms and Conditions</u></i>
							</button>
							of the website.</small></i>
				</form>
			</section>
		</div>

		<div id="terms-and-cond">
			<!-- Area surrounding the terms container -->
			<!-- The terms container itself -->
			<section id="terms-section" class="mx-auto bg-white border border-dark">
				<div
					class="d-flex justify-content-end align-items-center bg-white mb-2"
					style="margin-top: -8px">
					<svg
						id="x-terms"
						xmlns="http://www.w3.org/2000/svg"
						width="28"
						height="28"
						viewBox="0 0 24 24"
						fill="none"
						stroke="currentColor"
						stroke-width="2"
						stroke-linecap="round"
						stroke-linejoin="round"
						class="lucide lucide-x-icon lucide-x"
						style="cursor: pointer"
						onclick="hideTerms()">
						<path d="M18 6 6 18" />
						<path d="m6 6 12 12" />
					</svg>
				</div>

				<h2 class="py-3 bg-secondary text-white text-center">
					Terms and Conditions for Hotel Accommodations
				</h2>
				<ul id="articles">
					<li class="lead">ARTICLE 1: General Guidelines</li>
					<hr />
					<p>
						By booking and staying at Luxury Hotel, guests agree to the
						following terms and conditions, which are governed by the laws of
						the Republic of the Philippines. These are designed to ensure a
						safe, pleasant, and legally compliant experience for all guests and
						staff.
					</p>

					<li class="lead">ARTICLE 2: Reservations and Check-In</li>
					<hr />
					<ul>
						<li>
							Standard check-in time is <strong>2:00 PM</strong>, and check-out
							time is <strong>12:00 NN</strong> (Philippine Time).
						</li>
						<li>
							Early check-in or late check-out is subject to availability and
							may incur additional charges.
						</li>
						<li>
							All guests must present a
							<strong>valid government-issued ID</strong> and a
							<strong>credit/debit card or cash deposit</strong> upon check-in.
						</li>
					</ul>

					<li class="lead">
						ARTICLE 3: Booking, Cancellation, and No-Show Policy
					</li>
					<hr />
					<ul>
						<li>
							Cancellations made at least <strong>48 hours</strong> before
							check-in are free of charge.
						</li>
						<li>
							Late cancellations or no-shows will be charged
							<strong>one (1) night's stay</strong>.
						</li>
						<li>
							Non-refundable or promotional bookings cannot be changed or
							refunded.
						</li>
					</ul>

					<li class="lead">ARTICLE 4: Payment Policy</li>
					<hr />
					<ul>
						<li>
							We accept <strong>cash (PHP only)</strong>, credit/debit cards,
							GCash/PayMaya, or bank transfer.
						</li>
						<li>
							Full payment may be required upon check-in unless already
							pre-paid.
						</li>
						<li>
							A security deposit may be collected and refunded upon check-out
							after inspection.
						</li>
					</ul>

					<li class="lead">ARTICLE 5: Child and Extra Bed Policy</li>
					<hr />
					<ul>
						<li>
							Children aged <strong>0-6 years old</strong> are eligible for a
							free stay given at least one (1) paying adult.
						</li>
						<li>
							Extra beds are available on request, subject to availability and
							additional charge.
						</li>
					</ul>

					<li class="lead">ARTICLE 6: Guest Conduct and Hotel Policies</li>
					<hr />
					<ul>
						<li>
							Guests must act respectfully at all times and avoid disturbing
							other patrons.
						</li>
						<li>
							Performing illegal activities and engaging in disruptive behavior
							may lead to
							<strong>eviction without refund and/or legal repercussion.</strong>
						</li>
						<li>
							Damage to hotel property will be charged to the customer upon
							checkout.
						</li>
						<li>
							Dangerous or illegal items such as drugs and firearms are strictly
							prohibited within the premises.
						</li>
					</ul>

					<li class="lead">ARTICLE 7: Smoking and Alcohol</li>
					<hr />
					<ul>
						<li>
							This is a <strong>non-smoking hotel</strong> except in designated
							areas (per RA 9211).
						</li>
						<li>
							A <strong>PHP 500</strong> cleaning fee applies for violations.
						</li>
						<li>
							Alcohol is allowed in private rooms only unless otherwise
							permitted.
						</li>
					</ul>

					<li class="lead">ARTICLE 8: Pets</li>
					<hr />
					<ul>
						<li>
							Pets are allowed with prior notice and an additional pet
							accommodation fee of
							<strong>8% the highest-charged guest</strong>, per pet.
						</li>
						<li>
							Owners are expected to be responsible for their pets at all times.
							Luxury Hotel cannot be held responsible for any untoward accidents
							involving a guest's pet/s.
						</li>
					</ul>

					<li class="lead">ARTICLE 9: Liability and Loss of Property</li>
					<hr />
					<ul>
						<li>The hotel is not liable for lost, stolen, or damaged items.</li>
						<li>
							Please use in-room safes or deposit valuables at the front desk.
						</li>
						<li>
							Guests may be charged for missing items provided by the hotel upon
							check-in.
						</li>
					</ul>

					<li class="lead">ARTICLE 10: Force Majeure</li>
					<hr />
					<p>
						The hotel is not liable for events beyond its control such as
						natural disasters, power failures, or government regulations.
					</p>

					<li class="lead">ARTICLE 11: Privacy and Data Protection</li>
					<hr />
					<p>
						We comply with the
						<strong>Data Privacy Act of 2012 (RA 10173)</strong>. Guest data is
						kept confidential and shared only as required by law.
					</p>

					<li class="lead">ARTICLE 12: Governing Law</li>
					<hr />
					<p>
						These terms are governed by Philippine laws. Legal disputes shall be
						settled in the courts of <strong>Dumaguete City</strong>.
					</p>
				</ul>

				<div>
					<button
						id="hide-terms"
						onclick="hideTerms()"
						class="d-flex align-items-center justify-content-center gap-2">
						<svg
							xmlns="http://www.w3.org/2000/svg"
							width="24"
							height="24"
							viewBox="0 0 24 24"
							fill="none"
							stroke="currentColor"
							stroke-width="2"
							stroke-linecap="round"
							stroke-linejoin="round"
							class="lucide lucide-arrow-left-icon lucide-arrow-left">
							<path d="m12 19-7-7 7-7" />
							<path d="M19 12H5" />
						</svg>
						<span class="fs-5"> Back </span>
					</button>
				</div>
			</section>
		</div>
</body>
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
<script
	src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
	integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
	crossorigin="anonymous"></script>

</html>