<?php
// create custom plugin settings menu
add_action( 'admin_menu', 'selzy_create_menu' );

function selzy_create_menu() {

	add_submenu_page( 'wpselzy',
		__( 'Настройки Selzy', 'selzy' ),
		__( 'Настройки', 'selzy' ),
		'wpselzy_manage_options',
		'wpselzy-settings',
		'selzy_settings_page'
	);

	//call register settings function
	add_action( 'admin_init', 'register_selzy_settings' );
}


function register_selzy_settings() {
	//register our settings
	register_setting( 'selzy-settings-group', 'wpselzy_api_key' );
}

function selzy_settings_page() {
	?>
    <div class="wrap">
        <h1><?php echo __( 'Настройки Selzy', 'selzy' ) ?></h1>

        <form method="post" action="options.php">
			<?php settings_fields( 'selzy-settings-group' ); ?>
			<?php do_settings_sections( 'selzy-settings-group' ); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">API key</th>
                    <td>
                        <input type="text" name="wpselzy_api_key"
                               value="<?php echo esc_attr( get_option( 'wpselzy_api_key' ) ); ?>" class="large-text"/>
                        <a href="https://selzy.com/ua/support/api/common/api-key/" target="_blank"
                           style="display: inline-block; margin-top: 10px;">Где взять API-ключ Selzy</a>
                    </td>
                </tr>
            </table>

			<?php submit_button(); ?>

        </form>
    </div>
<?php } ?>