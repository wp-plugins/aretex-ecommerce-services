<?php
/**
 * Plugin Name: AreteX&trade; eCommerce Services
 * Plugin URI: https://aretex.org
 * Description: Connect AreteX&trade; eCommerce Services to your WordPress site.  Receive credit card payments. Automate payouts to contributors and affiliates.  Track marketing. Automate digital delivery: Paid Content, Downloads, Membership and Subscription. Customer account management. Includes 30 Day Free AreteX(tm) "Sandbox" License. You can <a href="https://aretexsaas.com" target="_blank">click here for more information about AreteX&trade;</a>.
 * Version: 2.27.01
 * Author: 3B Alliance, LLC
 * Author URI: http://3balliance.com
 * License: GPL 2 or Later 
 */

/* Copyright 2013 3B Alliance, LLC (email : support@3balliance.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
*/


require_once( plugin_dir_path( __FILE__ ) . 'AreteX/AreteX_plugin.class.php' );
// error_log("Regsitering ... Activatation");
register_activation_hook( __FILE__, array( 'AreteX_plugin', 'install' ) );
register_deactivation_hook( __FILE__, array( 'AreteX_plugin', 'deactivate' ) );

//create plugin object
global $AreteX_plugin;
$AreteX_plugin = new AreteX_plugin();

function AreteXDocURL()
{
    $url = plugins_url( 'docs/' , __FILE__ );
    return $url;
}

?>
