<?php

defined( 'ABSPATH' ) || exit;

class One_Cart_Product_Admin {

    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );

        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
//        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
        add_action( 'woocommerce_before_calculate_totals', array( $this, 'limit_cart_product' ) );
        add_filter('wc_add_to_cart_message_html', array($this, 'filter_add_to_cart_message'), 10, 2);

    }

    public function enqueue_admin_assets() {
        wp_enqueue_style('ocp_admin_style', OCP_PLUGIN_URL . 'assets/css/admin.css', array(), OCP_VERSION);
        wp_enqueue_script('ocp_admin_scripts', OCP_PLUGIN_URL . 'assets/js/admin.js', array(), OCP_VERSION, true);

    }

    public function admin_menu() {
        add_menu_page(
            'One-Cart Product',
            'One-Cart Product',
            'manage_options',
            'one-cart-product',
            array( $this, 'admin_menu_page' ),
            'dashicons-cart',
            '56'
        );
    }

    public function admin_menu_page() {

        if (isset($_POST['ocp_enable_submit'])) {
            $enable = isset($_POST['ocp_enable']) ? 1 : 0;
            update_option('one_cart_enable', $enable);
//            echo '<div class="notice"><p>Settings saved.</p></div>';
        }
        $custom_message = isset($_POST['ocp_custom_message']) ? sanitize_text_field($_POST['ocp_custom_message']) : '';
        update_option('one_cart_custom_message', $custom_message);

        $enable = get_option('one_cart_enable', 0);
        $custom_message = get_option('one_cart_custom_message', '');


        echo '<div class="wrap">';
        echo '<h1 class=" ">One Cart Product</h1>';
        echo '<form method="post" class="form">';
        echo '<label class="top">';
        echo ' Enable One Cart Product';
        echo '<input id="check" type="checkbox" name="ocp_enable" value="1" ' . checked(1, $enable, false) . ' />';
        echo '</label>';
        echo '<br> <br>';
        echo '<label  for="ocp_custom_message">Custom Cart Limit Message:</label>';
        echo '<input type="text" id="ocp_custom_message" name="ocp_custom_message" value="' . esc_attr($custom_message) . '" size="80" />';
        echo '<br><br>';
        submit_button('Save Settings', 'primary', 'ocp_enable_submit');
        echo '</form>';
        echo '</div>';

    }

    /**
     * Limits the number of products in the cart to one.
     *
     * If the option 'ocp_is_enable' is enabled, this function checks the current
     * cart contents count. If there are more than one product in the cart,
     * it empties the cart and displays a custom error message.
     *
     * @return void
     */
    public function limit_cart_product() {
        $custom_message = get_option( 'ocp_example_field', 'You can only add one product to the cart' );

        // Only proceed if the plugin is enabled.
        if ( 'yes' !== get_option( 'ocp_is_enable', 'yes' ) ) {
            return; // Plugin is disabled, so no functionality should run.
        }

        // Only proceed if the functionality is enabled.
        if ( 'yes' !== get_option( 'ocp_is_enable_functionality', 'yes' ) ) {
            return; // Functionality not allowed.
        }

        // Get the cart contents.
        $cart_contents = WC()->cart->get_cart();

        // Flag to check if we modified any quantities.
        $modified = false;

        // Loop through the cart items.
        foreach ( $cart_contents as $cart_item_key => $cart_item ) {
            // If the quantity is greater than 1, remove the excess quantity.
            if ( $cart_item['quantity'] > 1 ) {
                // Set the quantity to 1.
                WC()->cart->set_quantity( $cart_item_key, '1' ); // Set quantity to 1.
                $modified = true; // Mark as modified.
            }
        }

        // If any modifications were made, add a notice.
        if ( $modified ) {
            wc_add_notice( $custom_message, 'error' ); // Add the custom error message.
        }
    }

    /**
     * Filters the add-to-cart message to suppress it if there are error notices.
     *
     * If there are error notices present, this function returns an empty string,
     * effectively preventing the default add-to-cart message from being displayed.
     *
     * @param string $message The default add-to-cart message.
     * @param int    $product_id The ID of the product being added to the cart.
     * @return string The modified message.
     */
    public function filter_add_to_cart_message( $message, $product_id ) {
        // Check if the plugin is enabled.
        if ( 'yes' !== get_option( 'ocp_is_enable', 'yes' ) ) {
            return $message; // Return the default message if the plugin is disabled.
        }

        // Check if functionality is enabled.
        if ( 'yes' !== get_option( 'ocp_is_enable_functionality', 'yes' ) ) {
            return $message; // Return the default message if functionality is disabled.
        }

        // If there are error messages in WooCommerce, suppress the add-to-cart message.
        $error_messages = wc_get_notices( 'error' );
        if ( ! empty( $error_messages ) ) {
            return ''; // Return empty string to suppress the message.
        }

        // Return the default message if no errors exist.
        return $message;
    }


}
