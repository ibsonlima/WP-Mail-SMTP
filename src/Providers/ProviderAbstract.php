<?php

namespace WPMailSMTP\Providers;

use WPMailSMTP\Options;

/**
 * Abstract Class ProviderAbstract to contain common providers functionality.
 */
abstract class ProviderAbstract implements ProviderInterface {

	/**
	 * @var string
	 */
	private $logo_url = '';
	/**
	 * @var string
	 */
	private $slug = '';
	/**
	 * @var string
	 */
	private $title = '';
	/**
	 * @var string
	 */
	private $description = '';

	/**
	 * ProviderAbstract constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param array $params
	 */
	public function __construct( $params ) {

		if (
			empty( $params['slug'] ) ||
			empty( $params['title'] )
		) {
			return;
		}

		$this->slug  = sanitize_key( $params['slug'] );
		$this->title = sanitize_text_field( $params['title'] );

		if ( ! empty( $params['logo_url'] ) ) {
			$this->logo_url = esc_url_raw( $params['logo_url'] );
		}

		if ( ! empty( $params['description'] ) ) {
			$this->description = $params['description'];
		}
	}

	/**
	 * @inheritdoc
	 */
	public function get_logo_url() {
		return apply_filters( 'wp_mail_smtp_providers_provider_get_logo_url', $this->logo_url, $this );
	}

	/**
	 * @inheritdoc
	 */
	public function get_slug() {
		return apply_filters( 'wp_mail_smtp_providers_provider_get_slug', $this->slug, $this );
	}

	/**
	 * @inheritdoc
	 */
	public function get_title() {
		return apply_filters( 'wp_mail_smtp_providers_provider_get_title', $this->title, $this );
	}

	/**
	 * @inheritdoc
	 */
	public function get_description() {
		return apply_filters( 'wp_mail_smtp_providers_provider_get_description', $this->description, $this );
	}

	/**
	 * @inheritdoc
	 */
	public function display_options() {

		$options = new Options();
		?>

		<table class="form-table">

			<!-- SMTP Host -->
			<tr>
				<th scope="row">
					<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-host"><?php esc_html_e( 'SMTP Host', 'wp-mail-smtp' ); ?></label>
				</th>
				<td>
					<input name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][host]" type="text"
						value="<?php echo esc_attr( $options->get( $this->get_slug(), 'host' ) ); ?>"
						<?php echo $options->is_const_defined( $this->get_slug(), 'host' ) ? 'disabled' : ''; ?>
						id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-host" class="regular-text" spellcheck="false"
					/>
				</td>
			</tr>

			<!-- SMTP Port -->
			<tr>
				<th scope="row">
					<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-port"><?php esc_html_e( 'SMTP Port', 'wp-mail-smtp' ); ?></label>
				</th>
				<td>
					<input name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][port]" type="number"
						value="<?php echo esc_attr( $options->get( $this->get_slug(), 'port' ) ); ?>"
						<?php echo $options->is_const_defined( $this->get_slug(), 'port' ) ? 'disabled' : ''; ?>
						id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-port" class="small-text" spellcheck="false"
					/>
				</td>
			</tr>

			<!-- SMTP Encryption -->
			<tr>
				<th scope="row">
					<label><?php esc_html_e( 'Encryption', 'wp-mail-smtp' ); ?></label>
				</th>
				<td>
					<div class="wp-mail-smtp-inline-radios">
						<input type="radio" id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-enc-none"
							name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][encryption]" value="none"
							<?php echo $options->is_const_defined( $this->get_slug(), 'encryption' ) ? 'disabled' : ''; ?>
							<?php checked( 'none', $options->get( $this->get_slug(), 'encryption' ) ); ?>
						/>
						<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-enc-none"><?php esc_html_e( 'None', 'wp-mail-smtp' ); ?></label>

						<input type="radio" id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-enc-ssl"
							name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][encryption]" value="ssl"
							<?php echo $options->is_const_defined( $this->get_slug(), 'encryption' ) ? 'disabled' : ''; ?>
							<?php checked( 'ssl', $options->get( $this->get_slug(), 'encryption' ) ); ?>
						/>
						<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-enc-ssl"><?php esc_html_e( 'SSL', 'wp-mail-smtp' ); ?></label>

						<input type="radio" id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-enc-tls"
							name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][encryption]" value="tls"
							<?php echo $options->is_const_defined( $this->get_slug(), 'encryption' ) ? 'disabled' : ''; ?>
							<?php checked( 'tls', $options->get( $this->get_slug(), 'encryption' ) ); ?>
						/>
						<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-enc-tls"><?php esc_html_e( 'TLS', 'wp-mail-smtp' ); ?></label>
					</div>

					<p class="description">
						<?php esc_html_e( 'TLS is not the same as STARTTLS. For most servers SSL is the recommended option.', 'wp-mail-smtp' ); ?>
					</p>
				</td>
			</tr>

			<!-- SMTP Authentication -->
			<tr>
				<th scope="row">
					<label><?php esc_html_e( 'Authentication', 'wp-mail-smtp' ); ?></label>
				</th>
				<td>
					<div class="wp-mail-smtp-inline-radios">
						<input type="radio" id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-auth-no"
							name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][auth]" value="no"
							<?php echo $options->is_const_defined( $this->get_slug(), 'auth' ) ? 'disabled' : ''; ?>
							<?php checked( false, $options->get( $this->get_slug(), 'auth' ) ); ?>
						/>
						<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-auth-no"><?php esc_html_e( 'No', 'wp-mail-smtp' ); ?></label>

						<input type="radio" id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-auth-yes"
							name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][auth]" value="yes"
							<?php echo $options->is_const_defined( $this->get_slug(), 'auth' ) ? 'disabled' : ''; ?>
							<?php checked( true, $options->get( $this->get_slug(), 'auth' ) ); ?>
						/>
						<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-auth-yes"><?php esc_html_e( 'Yes', 'wp-mail-smtp' ); ?></label>
					</div>
				</td>
			</tr>

			<!-- SMTP Username -->
			<tr>
				<th scope="row">
					<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-user"><?php esc_html_e( 'SMTP Username', 'wp-mail-smtp' ); ?></label>
				</th>
				<td>
					<input name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][user]" type="text"
						value="<?php echo esc_attr( $options->get( $this->get_slug(), 'user' ) ); ?>"
						<?php echo $options->is_const_defined( $this->get_slug(), 'user' ) ? 'disabled' : ''; ?>
						id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-user" class="regular-text" spellcheck="false"
					/>
				</td>
			</tr>

			<!-- SMTP Password -->
			<tr>
				<th scope="row">
					<label for="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-pass"><?php esc_html_e( 'SMTP Password', 'wp-mail-smtp' ); ?></label>
				</th>
				<td>
					<?php if ( $options->is_const_defined( $this->get_slug(), 'pass' ) ) : ?>
						<input type="text" value="*************" disabled id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-pass"
							class="regular-text"/>
					<?php else : ?>
						<input name="wp-mail-smtp[<?php echo esc_attr( $this->get_slug() ); ?>][pass]" type="text"
							value="<?php echo esc_attr( $options->get( $this->get_slug(), 'pass' ) ); ?>"
							id="wp-mail-smtp-setting-<?php echo esc_attr( $this->get_slug() ); ?>-pass" class="regular-text" spellcheck="false"
						/>

						<?php $this->display_helper_icon(); ?>

						<p class="description">
							<?php esc_html_e( 'The password is stored in plain text. For information on how to securely setup your password, please click a dropdown icon above.', 'wp-mail-smtp' ); ?>
						</p>

						<div class="wp-mail-smtp-code-helper-text">
							<?php $this->display_helper_text(); ?>
							<pre>
								define( 'WPMS_ON', true );
								define( 'WPMS_SMTP_PASS', 'your_password' );
							</pre>
						</div>

					<?php endif; ?>
				</td>
			</tr>
		</table>

		<?php
	}

	/**
	 * Helper icon to open or close code section.
	 */
	protected function display_helper_icon() {
		?>

		<span class="wp-mail-smtp-code-helper js-wp-mail-smtp-code-helper">
			<span class="dashicons dashicons-arrow-down-alt2"></span>
		</span>

		<?php
	}

	/**
	 * Helper generic text, that is the same for all fields.
	 */
	protected function display_helper_text() {
		?>

		<p>
			<?php
			printf(
				/* translators: %s - wp-config.php. */
				esc_html__( 'To redefine this value in %s use this code:', 'wp-mail-smtp' ),
				'<code>wp-config.php</code>'
			);
			?>
		</p>

		<?php
	}
}
