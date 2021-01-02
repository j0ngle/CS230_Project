<?php

/************************************************
 * profile.php displays the user's profile page
 * when they are logged in. It includes basic info
 * about the user and allows them to update and
 * change it.
 ************************************************/

require "includes/header.php";
require 'includes/dbhandler.php';
?>

<main>

	<?php

	//checks to make sure there is a session set
	if (isset($_SESSION['uid'])) {

		//stores username from session variable
		$prof_user = $_SESSION['username'];

		//SQL statements to select information from profile and users
		//tables from the database based on the user logged in
		$sqlpro = "SELECT * FROM profile WHERE uname='$prof_user';";
		$sqluser = "SELECT * FROM users WHERE uname='$prof_user';";
		$res = mysqli_query($conn, $sqlpro);
		$info = mysqli_query($conn, $sqluser);
		$row = mysqli_fetch_array($res);
		$user = mysqli_fetch_array($info);
		$photo = $row['picpath'];
	?>


		<style>
			.center-me {
				display: flex;
				justify-content: center;
				padding: 40px;
				text-align: "center";
			}

			#prof-display {
				display: block;
				width: 150px;
				margin: 10px auto;
				border-radius: 50%;
			}

			#uname-style {
				font-size: 20px;
				font-family: "Lucida Console", Courier, monospace;
				font-weight: bold;
			}
		</style>

		<script>
			function triggered() {
				document.querySelector("#prof-image").click();
			}
			
			//shows the new profile picture as a preview before actually
			//uploading it to the database
			function preview(e) {
				if (e.files[0]) {
					var reader = new FileReader();

					reader.onload = function(e) {
						document.querySelector('#prof-display').setAttribute('src', e.target.result);
					}
					reader.readAsDataURL(e.files[0]);

				}
			}
		</script>
		<div class="container" style="margin-top: 50px;">
			<div class="main-body">

				<div class="row gutters-sm">
					<div class="col-md-4 mb-3">
						<div class="card">
							<div class="card-body">
								<div class="d-flex flex-column align-items-center text-center">
									<div class="mt-3">
										<form action="includes/upload-helper.php" method="POST" enctype="multipart/form-data">
											<!-- displays the user's profile picture and allows it to be changed -->
											<img src="<?php echo $photo; ?>" onclick="triggered();" id="prof-display">
											<input type="file" name="prof-image" id="prof-image" onchange="preview(this);" class="form-control" style="display: none;">

											<div class="form-group">
												<textarea name="bio" id="bio" cols="25" rows="10" placeholder="bio..." style="text-align: center;"></textarea>
											</div>
											<div class="form-group">
												<button type="submit" name="prof-submit" class="btn btn-outline-success btn-lg btn-block">upload</button>
											</div>
										</form>
										<!-- displays user's profile information (username, bio, etc) -->
										<h4><label for="prof-image" id="uname-style"><?php echo $prof_user; ?></label></h4>
										<p class="text-secondary mb-1"><?php echo $row['bio'] ?></p>
										<p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p>
									</div>
								</div>
							</div>
						</div>
						<div class="card mt-3">
							
						</div>
					</div>
					<div class="col-md-8">
						<div class="card mb-3">

							<!-- uses the row from SQL statement stored in $user to output profile information -->
							<div class="card-body">
								<div class="row">
									<div class="col-sm-3">
										<h6 class="mb-0">Full Name</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<?php echo $user['fname'] . ' ' . $user['lname'] ?>
										
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<h6 class="mb-0">Email</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<?php echo $user['email'] ?>
										
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-sm-3">
										<h6 class="mb-0">Phone</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<?php echo $row['phone']; ?>
										
									</div>
								</div>
								<hr>

								<div class="row">
									<div class="col-sm-3">
										<h6 class="mb-0">Favorite Genre</h6>
									</div>
									<div class="col-sm-9 text-secondary">
										<?php echo $row['fav_genre']; ?>
										
									</div>
								</div>
							</div>
						</div>
						<div class="row gutters-sm">
							<div class="my-auto center-me card mt-3">
								<ul class="list-group list-group-flush">
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline">
												<circle cx="12" cy="12" r="10"></circle>
												<line x1="2" y1="12" x2="22" y2="12"></line>
												<path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
											</svg>Website</h6>
										<span class="text-secondary">https://gamrfax.com</span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
												<path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
											</svg>Github</h6>
										<span class="text-secondary">gamrfax</span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
												<path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
											</svg>Twitter</h6>
										<span class="text-secondary">@gamrfax</span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
												<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
												<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
												<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
											</svg>Instagram</h6>
										<span class="text-secondary">gamrfax</span>
									</li>
									<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
										<h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
												<path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
											</svg>Facebook</h6>
										<span class="text-secondary">gamrfax</span>
									</li>
								</ul>

							</div>

						</div>
					</div>
				</div>
			</div>
		</div>


	<?php
	} else {
		header("Location: ../login.php");
		exit();
	}
	?>

</main>