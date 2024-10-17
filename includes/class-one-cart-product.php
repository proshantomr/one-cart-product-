<?php

defined( 'ABSPATH' ) || exit;

class One_Cart_Product {

    public string $file;
    public string $version;

    public function __construct($file, $version = "1.0.0") {
        $this->file = $file;
        $this->version = $version;
        $this->define_constants();
        $this->init_hooks();

        register_activation_hook( $this->file, array( $this, 'activation_hook' ) );
        register_deactivation_hook( $this->file, array( $this, 'deactivation_hook' ) );
    }

    public function define_constants() {
        define( 'OCP_VERSION', $this->version );
        define( 'OCP_FILE', $this->file );
        define( 'OCP_PLUGIN_DIR', plugin_dir_path( $this->file ) );
        define( 'OCP_PLUGIN_URL', plugin_dir_url( $this->file ) );
        define( 'OCP_PLUGIN_BASENAME', plugin_basename( $this->file ) );
    }

    public function init() {
        new One_Cart_Product_Admin();
    }

    public function activation_hook() {
        // Add activation logic here
    }

    public function deactivation_hook() {
        // Add deactivation logic here
    }

    public function init_hooks() {
        add_action('plugins_loaded', array($this, 'load_plugin_textdomain'));
        add_action('init', array($this, 'init')); // Hook init method properly
    }

    public function load_plugin_textdomain() {
        load_plugin_textdomain('one-cart-product', false, basename(dirname(__FILE__)) . '/languages/'); // Correct text domain
    }
}
