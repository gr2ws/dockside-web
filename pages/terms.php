<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Dockside Hotel © | Terms and Conditions</title>
	<link rel="stylesheet" href="../styles/terms.css" />
	<?php require 'common.php'; ?>
</head>

<body>
	<?php placeHeader() ?>

	<div id="terms-page" class="container-fluid">

		<a id="redirect" href="./sign_up.php" class="back-btn d-flex flex-row justify-content-start align-items-center gap-2 pt-4 ps-5">
			<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-move-left-icon lucide-move-left">
				<path d="M6 8L2 12L6 16" />
				<path d="M2 12H22" />
			</svg>
			<p style="margin-bottom: 0 !important;">Back to Sign Up</p>
		</a>

		<!-- The terms container itself -->
		<section id="terms-section" class="bg-white">
			<h2 class="text-center global-subheading">
				Terms and Conditions for Hotel Accommodations
			</h2>
			<ul id="articles">
				<li class="lead">ARTICLE 1: General Guidelines</li>
				<hr />
				<p class="body-text">
					By booking and staying at Luxury Hotel, guests agree to the
					following terms and conditions, which are governed by the laws of
					the Republic of the Philippines. These are designed to ensure a
					safe, pleasant, and legally compliant experience for all guests and
					staff.
				</p>

				<li class="lead">ARTICLE 2: Reservations and Check-In</li>
				<hr />
				<ul class="enum">
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
				<ul class="enum">
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
				<ul class="enum">
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
				<ul class="enum">
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
				<ul class="enum">
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
				<ul class="enum">
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
				<ul class="enum">
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
				<ul class="enum">
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
				<p class="body-text">
					The hotel is not liable for events beyond its control such as
					natural disasters, power failures, or government regulations.
				</p>

				<li class="lead">ARTICLE 11: Privacy and Data Protection</li>
				<hr />
				<p class="body-text">
					We comply with the
					<strong>Data Privacy Act of 2012 (RA 10173)</strong>. Guest data is
					kept confidential and shared only as required by law.
				</p>

				<li class="lead">ARTICLE 12: Governing Law</li>
				<hr />
				<p class="body-text">
					These terms are governed by Philippine laws. Legal disputes shall be
					settled in the courts of <strong>Dumaguete City</strong>.
				</p>
			</ul>
		</section>
	</div>

	<?php placeFooter() ?>

</body>

</html>