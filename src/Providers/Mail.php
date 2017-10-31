<?php

namespace WPMailSMTP\Providers;

/**
 * Class Mail
 */
class Mail extends ProviderAbstract {

	/**
	 * Mail constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		parent::__construct(
			array(
				'logo_url' => wp_mail_smtp()->plugin_url . '/assets/images/php.png',
				'slug'     => 'mail',
				'title'    => esc_html__( 'Default (none)', 'wp-mail-smtp' ),
			)
		);
	}

	/**
	 * @inheritdoc
	 */
	public function display_options() {
		?>

		<blockquote>
			<?php esc_html_e( 'You currently have the native WordPress option selected. Please select an SMTP above to begin setup.', 'wp-mail-smtp' ); ?>
		</blockquote>

		<?php
	}
}
