<?php
/* 
Plugin Name: Whatsapp Site Chat
Description: Simple and light whatsapp chat on your site
Version: 0.1
Author: Mauro De Falco
Author URI: maurodefalco.it
Text Domain: wsc
Domain Path: /languages
*/

if(! defined('ABSPATH')){
    exit ;
}


function wsc_enqueue_style(){
    wp_enqueue_style('wsc', plugins_url( 'style.css', __FILE__ ));
}
add_action('wp_enqueue_scripts', 'wsc_enqueue_style');

function wsc_stamp_w(){
    echo '<a class="wsc_btn" target="_blank" href="https://wa.me/' . get_option('wsc_number') .'">' . get_option('wsc_text') .'</a>';
}

add_action('wp_footer', 'wsc_stamp_w');

// create custom plugin settings menu
add_action('admin_menu', 'wsc_menu_page');

function wsc_menu_page() {

	//create new top-level menu
	add_menu_page('Whatsapp Site Chat', 'Whatsapp Setting', 'administrator', __FILE__, 'wsc_setting_page' , plugins_url('whatsapp.svg', __FILE__) );

	//call register settings function
	add_action( 'admin_init', 'wsc_plugin_settings' );
}


function wsc_plugin_settings() {
	//register our settings
	register_setting( 'wsc-plugin-settings-group', 'wsc_number' );
    register_setting( 'wsc-plugin-settings-group', 'wsc_text' );
    register_setting( 'wsc-plugin-settings-group', 'wsc_color' );
    register_setting( 'wsc-plugin-settings-group', 'wsc_text_color' );
    register_setting( 'wsc-plugin-settings-group', 'wsc_hover_color' );
    register_setting( 'wsc-plugin-settings-group', 'wsc_hover_text_color' );
}

function wsc_setting_page() {
?>
<div class="wrap">
<h1>Whatsapp Site Chat</h1>

<form method="post" action="options.php">
    <?php settings_fields( 'wsc-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'wsc-plugin-settings-group' ); ?>
    <table class="form-table">
        <tr valign="top">
        <th scope="row">Telephone number</th>
        <td><input type="text" name="wsc_number" value="<?php echo esc_attr( get_option('wsc_number', 111111111) ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Button text</th>
        <td><input type="text" name="wsc_text" value="<?php echo esc_attr( get_option('wsc_text', 'Scrivici su whatsapp') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Button background color</th>
        <td><input type="color" name="wsc_color" value="<?php echo esc_attr( get_option('wsc_color', '#008000') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Button text color</th>
        <td><input type="color" name="wsc_text_color" value="<?php echo esc_attr( get_option('wsc_text_color', '#ffffff') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Button Hover background color</th>
        <td><input type="color" name="wsc_hover_color" value="<?php echo esc_attr( get_option('wsc_hover_color', '#026202') ); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">Button Hover text color</th>
        <td><input type="color" name="wsc_hover_text_color" value="<?php echo esc_attr( get_option('wsc_hover_text_color', '#ffffff') ); ?>" /></td>
        </tr>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>
<?php } 

function update_css(){
    echo '
    <style>
    .wsc_btn {
        background:' . esc_attr( get_option('wsc_color')) . ';
        color:' . esc_attr( get_option('wsc_text_color')) . ';
    }

    .wsc_btn:hover {
        background:' . esc_attr( get_option('wsc_hover_color')) . ';
        color:' . esc_attr( get_option('wsc_hover_text_color')) . ';
    }
    </style>';
}
add_action('wp_head', 'update_css');

?>