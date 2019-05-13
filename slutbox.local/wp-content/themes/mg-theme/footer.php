
		</main>
		<footer>
			<div class="container">
				<h1>Get the Latest</h1>
				<div class="row">
					<div class="col-md-6">
						<p>Need all of the latest scoop <br> straight from the source? <br><br>Sign up.</p>
					</div>
					<div class="col-md-6">
						<form action="" method="POST">
							<input type="email" placeholder="Enter Your e-mail adress" required>
							<input type="submit" value="Get Updates">
						</form>
					</div>
				</div>
				<small>© 2019 MUVA LUVA, LLC. Slutbox by Amber Rose. All Rights Reserved. See our <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></small>
			</div>
		</footer>

		<script>
			var getUrl = window.location;
			var baseUrl = getUrl.protocol + "//" + getUrl.host + "/" + getUrl.pathname.split('/')[1];
		</script>
		<script src="https://www.paypalobjects.com/api/checkout.js"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/main.js'"></script>
		<script src="<?php echo get_template_directory_uri(); ?>/js/scripts.js'"></script>
			<?php wp_footer(); ?>
	</body>
</html>