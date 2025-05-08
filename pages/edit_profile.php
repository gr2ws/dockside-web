<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit();
}

// setting data taken from process_login.php
$id = $_SESSION['id'];
$fname = $_SESSION['fname'];
$lname = $_SESSION['lname'];
$email = $_SESSION['email'];
$address = $_SESSION['address'];
$phone = $_SESSION['phone'];
$birth = $_SESSION['birth'];
$pass = $_SESSION['password'];

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

        <?php handleEdit($id) ?>

        <div id="content" class="row w-75 py-4">
            <section class="d-none d-md-block col-md-5 bg-danger"></section>

            <section class="col-12 w-sm-100 col-md-7">
                <!-- sign up form -->
                <!-- Profile Section -->
                <div class="content-section d-block" id="profile-content">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h2 class="card-title border-bottom pb-2">My Profile</h2>
                            <form method="POST" id="profileForm" class="mt-4">
                                <!-- <div class="mb-4">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="< ?php echo htmlspecialchars($userData['profile_photo'] ?? 'images/default-avatar.png'); ?>"
                                            alt="Profile" class="rounded-circle" width="80" height="80">
                                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="document.getElementById('profilePhoto').click()">
                                            <i class="bi bi-upload"></i> Change Photo
                                        </button>
                                        <input type="file" id="profilePhoto" name="profile_photo" class="d-none" accept="image/*">
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="fname">First Name</label>
                                        <input type="text" class="form-control" name="fname"
                                            value="<?php echo $fname; ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label" for="lname">Last Name</label>
                                        <input type="text" class="form-control" name="lname"
                                            value="<?php echo $lname; ?>" required>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="birth">Birthday</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="birth"
                                        name="birth"
                                        required
                                        value="<?php echo $birth; ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input
                                        type="tel"
                                        class="form-control"
                                        id="phone"
                                        name="phone"
                                        pattern="[0-9]{4}-[0-9]{3}-[0-9]{4}"
                                        value="<?php echo $phone; ?>"
                                        required />
                                    <small><i class="text-muted">Format: 0912-345-6789</i></small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea class="form-control" name="address" rows="3"><?php echo $address; ?></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-lg"></i> Save Changes
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <?php placeFooter() ?>
</body>

</html>