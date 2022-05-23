<?php
/*
Plugin Name: Fact Bid Custom Password Reset
Plugin URI: #
Description: Custom Plugin for Password Reset
Version: 1.0
Author: Abacies
Author URI: #
*/
// Create the custom pages at plugin activation
register_activation_hook( __FILE__, 'dgm_plugin_activated' );
function dgm_plugin_activated() {
	// Information needed for creating the plugin's pages
	$page_definitions = array(
		'member-password-lost' => array(
			'title' => __( 'Forgot Your Password?', 'personalize-login' ),
			'content' => '[custom-password-lost-form]'
		),
		'member-password-reset' => array(
			'title' => __( 'Pick a New Password', 'personalize-login' ),
			'content' => '[custom-password-reset-form]'
		)
	);

	foreach ( $page_definitions as $slug => $page ) {
		// Check that the page doesn't exist already
		$query = new WP_Query( 'pagename=' . $slug );
		if ( ! $query->have_posts() ) {
			// Add the page using the data from the array above
			wp_insert_post(
				array(
					'post_content'   => $page['content'],
					'post_name'      => $slug,
					'post_title'     => $page['title'],
					'post_status'    => 'publish',
					'post_type'      => 'page',
					'ping_status'    => 'closed',
					'comment_status' => 'closed',
				)
			);
		}
	}
}

add_action('login_form_lostpassword', 'redirect_to_custom_lostpassword');
function redirect_to_custom_lostpassword() {
	if ('GET' == $_SERVER['REQUEST_METHOD']) {
		if (is_user_logged_in()) {
			$this->redirect_logged_in_user();
			exit;
		}
		wp_redirect(home_url('member-password-lost'));//page slug where reset shortcode will be use
		exit;
	}
}

add_shortcode('custom-password-lost-form', 'render_password_lost_form');
function render_password_lost_form($attributes, $content = null) {
	// Parse shortcode attributes
	$default_attributes = array('show_title' => false);
	$attributes = shortcode_atts($default_attributes, $attributes);


	if (is_user_logged_in()) {
		return __('You are already signed in.', 'personalize-login');
	} else {
		if ( isset( $_REQUEST['errors'] ) ) {
			switch($_REQUEST['errors']){
				case 'empty_username':
					_e( 'You need to enter your email address to continue.', 'personalize-login' );
				case 'invalid_email':
				case 'invalidcombo':
					_e( 'There are no users registered with this email address.', 'personalize-login' );
			}
		}
		if ( isset( $_REQUEST['checkemail'] ) ) {
			switch($_REQUEST['checkemail']){
				case 'confirm':
					_e( 'Password reset email has been sent.', 'personalize-login' );
			}
//			return;
		}
		if ( isset( $_POST['user_login'] ) ) {
			var_dump($_POST['user_login']);
		}
//		$link = get_the_permalink();
		//var_dump($link);
		?>
		<div id="password-lost-form" class="widecolumn">
			<?php if ($attributes['show_title']) : ?>
				<h3><?php _e('Forgot Your Password?', 'personalize-login'); ?></h3>
			<?php endif; ?>

			<p>
				<?php
				_e(
					"Lost your password? Please enter your username or email address. You will receive a link to create a new password via email.",
					'personalize_login'
				);
				?>
			</p>

			<form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
				<p class="form-row">
					<label for="user_login"><?php _e('Email', 'personalize-login'); ?>
						<input type="text" name="user_login" id="user_login" class="text form-control">
				</p>

				<p class="lostpassword-submit">
					<input type="submit" name="submit" class="lostpassword-button btn btn-primary"
					       value="<?php _e('Reset Password', 'personalize-login'); ?>"/>
				</p>
                <?php // echo apply_filters( 'cptch_display', '', 'lostpassword' ); ?>
			</form>
		</div>
		<?php
	}
}

add_action('login_form_lostpassword', 'do_password_lost');
function do_password_lost() {
	if ('POST' == $_SERVER['REQUEST_METHOD']) {
		$errors = retrieve_password();
		if (is_wp_error($errors)) {
			// Errors found
			$redirect_url = home_url('member-password-lost');//page slug where reset shortcode will be use
			$redirect_url = add_query_arg('errors', join(',', $errors->get_error_codes()), $redirect_url);
		} else {
			// Email sent
//			$link = get_the_permalink();
//			var_dump($link);
//			$redirect_url = home_url('signin');
			$redirect_url = home_url('member-password-lost');//page slug where reset shortcode will be use
			$redirect_url = add_query_arg('checkemail', 'confirm', $redirect_url);
		}

		wp_redirect($redirect_url);
		exit;
	}
}

//After send Email
add_action('login_form_rp', 'redirect_to_custom_password_reset');
add_action('login_form_resetpass', 'redirect_to_custom_password_reset');
function redirect_to_custom_password_reset() {
	if ('GET' == $_SERVER['REQUEST_METHOD']) {
		// Verify key / login combo
		$user = check_password_reset_key($_REQUEST['key'], $_REQUEST['login']);
		if (!$user || is_wp_error($user)) {
			if ($user && $user->get_error_code() === 'expired_key') {
				wp_redirect(home_url('member-login?login=expiredkey'));
			} else {
				wp_redirect(home_url('member-login?login=invalidkey'));
			}
			exit;
		}

		$redirect_url = home_url('member-password-reset');
		$redirect_url = add_query_arg('login', esc_attr($_REQUEST['login']), $redirect_url);
		$redirect_url = add_query_arg('key', esc_attr($_REQUEST['key']), $redirect_url);

		wp_redirect($redirect_url);
		exit;
	}
}


add_shortcode('custom-password-reset-form', 'render_password_reset_form');
function render_password_reset_form($attributes, $content = null) {
	// Parse shortcode attributes
	$default_attributes = array('show_title' => false);
	$attributes = shortcode_atts($default_attributes, $attributes);

	if (is_user_logged_in()) {
		return __('You are already signed in.', 'personalize-login');
	} else {
		if (isset($_REQUEST['login']) && isset($_REQUEST['key'])) {
			$attributes['login'] = $_REQUEST['login'];
			$attributes['key'] = $_REQUEST['key'];

			// Error messages
			$errors = array();
			if (isset($_REQUEST['error'])) {
				$error_codes = explode(',', $_REQUEST['error']);

				foreach ($error_codes as $code) {
					$errors [] = $this->get_error_message($code);
				}
			}
			$attributes['errors'] = $errors;
			?>
			<div id="password-reset-form" class="widecolumn">
				<?php if ($attributes['show_title']) : ?>
					<h3><?php _e('Pick a New Password', 'personalize-login'); ?></h3>
				<?php endif; ?>

				<form name="resetpassform" id="resetpassform"
				      action="<?php echo site_url('wp-login.php?action=resetpass'); ?>" method="post" autocomplete="off">
					<input type="hidden" id="user_login" name="rp_login"
					       value="<?php echo esc_attr($attributes['login']); ?>" autocomplete="off"/>
					<input type="hidden" name="rp_key" value="<?php echo esc_attr($attributes['key']); ?>"/>

					<?php if (count($attributes['errors']) > 0) : ?>
						<?php foreach ($attributes['errors'] as $error) : ?>
							<p>
								<?php echo $error; ?>
							</p>
						<?php endforeach; ?>
					<?php endif; ?>

					<p>
						<label for="pass1"><?php _e('New password', 'personalize-login') ?></label>
						<input type="password" name="pass1" id="pass1" class="input" size="20" value="" autocomplete="off"/>
					</p>
					<p>
						<label for="pass2"><?php _e('Repeat new password', 'personalize-login') ?></label>
						<input type="password" name="pass2" id="pass2" class="input" size="20" value="" autocomplete="off"/>
					</p>

					<p class="description"><?php echo wp_get_password_hint(); ?></p>

					<p class="resetpass-submit">
						<input type="submit" name="submit" id="resetpass-button"
						       class="button btn btn-primary" value="<?php _e('Reset Password', 'personalize-login'); ?>"/>
					</p>
				</form>
			</div>
			<?php
		} else {
			return __('Invalid password reset link.', 'personalize-login');
		}
	}
}

add_action('login_form_rp', 'do_password_reset');
add_action('login_form_resetpass', 'do_password_reset');
function do_password_reset() {
	if ('POST' == $_SERVER['REQUEST_METHOD']) {
		$rp_key = $_REQUEST['rp_key'];
		$rp_login = $_REQUEST['rp_login'];

		$user = check_password_reset_key($rp_key, $rp_login);

		if (!$user || is_wp_error($user)) {
			if ($user && $user->get_error_code() === 'expired_key') {
				wp_redirect(home_url('signin?login=expiredkey'));
			} else {
				wp_redirect(home_url('signin?login=invalidkey'));
			}
			exit;
		}

		if (isset($_POST['pass1'])) {
			if ($_POST['pass1'] != $_POST['pass2']) {
				// Passwords don't match
				$redirect_url = home_url('member-password-reset');

				$redirect_url = add_query_arg('key', $rp_key, $redirect_url);
				$redirect_url = add_query_arg('login', $rp_login, $redirect_url);
				$redirect_url = add_query_arg('error', 'password_reset_mismatch', $redirect_url);

				wp_redirect($redirect_url);
				exit;
			}

			if (empty($_POST['pass1'])) {
				// Password is empty
				$redirect_url = home_url('member-password-reset');//page slug where reset shortcode will be use

				$redirect_url = add_query_arg('key', $rp_key, $redirect_url);
				$redirect_url = add_query_arg('login', $rp_login, $redirect_url);
				$redirect_url = add_query_arg('error', 'password_reset_empty', $redirect_url);

				wp_redirect($redirect_url);
				exit;
			}

			// Parameter checks OK, reset password
			reset_password($user, $_POST['pass1']);
			wp_redirect(home_url('sign-in?password=changed'));//page slug where signin shortcode will be use
		} else {
			echo "Invalid request.";
		}

		exit;
	}
}