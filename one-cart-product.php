<?php
/**
 * Plugin Name:       One Cart Product
 * Plugin URI:        https://woocopilot.com/plugins/one-cart-product/
 * Description:       "One Cart Product" for WooCommerce limits customers to one product per cart, simplifying the shopping process for exclusive or niche products. Boost conversions and streamline checkout with this focused purchasing experience."
 * Version:           1.0.0
 * Requires at least: 6.5
 * Requires PHP:      7.2
 * Author:            WooCopilot
 * Author URI:        https://woocopilot.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       one-cart-product
 * Domain Path:       /languages
 */


/**
    One Cart Product is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 2 of the License, or
    any later version.

    One Cart Product is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with One Cart Product. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
 */

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/includes/class-one-cart-product.php';
require_once __DIR__ . '/includes/class-admin-one-cart-product.php';

/**
 * Initializing plugin.
 *
 * @since 1.0.0
 * @return object Plugin object.
 */
function One_Cart_Product() {
    return new One_Cart_Product(__FILE__, '1.0.0');
}
One_Cart_Product();
