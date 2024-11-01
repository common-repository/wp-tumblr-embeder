<?php
/*
Plugin Name: WP Tumblr
Plugin URI: http://wordpress-gr.org/#
Description: This plugin easily embeds your tumblr account on your WordPress blog.
Author: The Greek WordPress Comunity
Version: 1.0.0
Author URI: http;//www.wordpress-gr.org
License: GPLv3
*/

$plugin_dir = basename(dirname(__FILE__));

/* Load language files */
load_plugin_textdomain('wp-tumblr', null, $plugin_dir . "/languages/");

function showTumblr()
{
    $username = get_option('wp-tumblr-username');
    
    if(!empty($username))
    {
        ?>
        <script type="text/javascript" src="http://<?php echo $username; ?>.tumblr.com/js"></script>
        <?php
    }
}

add_shortcode('wptumblr', 'showTumblr');

function wp_tumblr_admin()
{
    add_menu_page(
        "WP Tumblr",
        "WP Tumblr",
        "administrator",
        basename(__FILE__),
        "admin_page"
    );
}

add_action('admin_menu', 'wp_tumblr_admin');

function admin_page()
{
    if($_POST['wp-tumbler-hidden'] == 'Y')
    {
        $username = $_POST['wp-tumblr-username'];  
        update_option('wp-tumblr-username', $username);
    }
    
    $username = get_option('wp-tumblr-username');
?>
    <div class="wrap">
        <h2>WP Tumblr</h2>
        <form name="wp-tumbler-config-form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
            <input type="hidden" name="wp-tumbler-hidden" value="Y" />
            <h4>
                <?php echo __('Plugin configuration', 'wp-tumblr'); ?>
            </h4>
            <table class="form-table">
                <tbody>
                    <tr valign="top">
                        <th scope="row">
                            <label for="wp-tumblr-username">
                                <?php
                                    echo __("Tumblr username: ", 'wp-tumblr'); 
                                ?>
                            </label>
                        </th>
                        <td>
                            <input type="text" id="wp-tumblr-username" name="wp-tumblr-username" value="<?php echo $username; ?>" size="20" />
                            <br />
                            <em><?php echo __("Please enter your tumblr username.<br />ex.: <strong>myusername</strong>.tumblr.com", 'wp-tumblr'); ?></em>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit">  
                <input type="submit" name="Submit" value="<?php echo __('Update Options', 'wp-tumblr'); ?>" /> 
            </p> 
        </form>
    </div>
<?php
}

function add_head_style()
{
    if(!is_admin())
    {
        wp_enqueue_style('WP_Tumblr_Style', plugin_dir_url( __FILE__ ) . 'style.css');
    }
}

add_action('init', 'add_head_style');

?>