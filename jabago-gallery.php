<?php

/**
 * @package JabagoGallery
 */

/**
 * 
 * Plugin Name: Jabago Gallery.
 * Description: Fancy and customizable Gallery.
 * Version:     1.0.0
 * Author:      Javier Barroso
 * Author URI:  https://profiles.wordpress.org/javierbarroso/
 */

/*
Jabago Gallery is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

Jabago Gallery is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Jabago Gallery. If not, see https://www.gnu.org/licenses/gpl-3.0.html.
*/

// If this file is called directly, abort.


defined('ABSPATH') or die('You can\t access this file.');


if(file_exists(dirname(__FILE__) . '/vendor/autoload.php')){
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

use JabagoG_Inc\JabagoGalleryInit;
use JabagoG_Inc\Base\JabagoGalleryActivate;
use JabagoG_Inc\Base\JabagoGalleryDeactivate;


/** define constants */

if (!defined('JABAGO_GALLERY_NAME')) {
    define('JABAGO_GALLERY_NAME', plugin_basename(__FILE__));
}
if (!defined('JABAGO_GALLERY_URL')) {
    define('JABAGO_GALLERY_URL', plugin_dir_url(__FILE__));
}
if (!defined('JABAGO_GALLERY_PATH')) {
    define('JABAGO_GALLERY_PATH', plugin_dir_path(__FILE__));
}

global $wpdb;
if (!defined('JABAGO_GALLERY_TABLE')) {
    define('JABAGO_GALLERY_TABLE', $wpdb->prefix . 'jabago_gallery');
}
if (!defined('JABAGO_GALLERY_IMAGES_TABLE')) {
    define('JABAGO_GALLERY_IMAGES_TABLE', $wpdb->prefix . 'jabago_gallery_images');
}
if (!defined('JABAGO_GALLERY_THEMES_TABLE')) {
    define('JABAGO_GALLERY_THEMES_TABLE', $wpdb->prefix . 'jabago_gallery_themes');
}

// /** activation and deactivation */

function jabagoGalleryActivate()
{
    JabagoGalleryActivate::activate();
}
register_activation_hook(__FILE__, 'jabagoGalleryActivate');

function jabagoalleryDeactivate()
{
    JabagoGalleryDeactivate::deactivate();
}
register_deactivation_hook(__FILE__, 'jabagoalleryDeactivate');



if(class_exists('JabagoG_Inc\\JabagoGalleryInit')){
    JabagoGalleryInit::registerServices();
}




