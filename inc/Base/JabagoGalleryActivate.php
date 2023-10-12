<?php

/**
 * @package JabagoGallery
 */

namespace JabagoG_Inc\Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class JabagoGalleryActivate
{
    static public function activate()
    {
        global $wpdb;

        $query_1 = "CREATE TABLE IF NOT EXISTS `" . JABAGO_GALLERY_TABLE . "`(
            `ID` INT NOT NULL AUTO_INCREMENT , 
            `name` TEXT NULL , 
            `image_click` TEXT NULL DEFAULT 'lightbox', 
            `gallery_layout` TEXT NULL DEFAULT 'square', 
            `theme_id` INT NULL DEFAULT '1', 
            `short_code` TEXT NULL , 
            PRIMARY KEY (`Id`));";
        $wpdb->query($wpdb->prepare($query_1));

        $query_2 = "CREATE TABLE IF NOT EXISTS `" . JABAGO_GALLERY_IMAGES_TABLE . "`(
            `ID` INT NOT NULL AUTO_INCREMENT, 
            `gallery_id` INT NOT NULL ,  
            `url` TEXT NOT NULL ,  
            `title` TEXT NULL ,  
            `alt_text` TEXT NULL ,  
            `description` TEXT NULL ,  
            `redirect_url` TEXT NULL ,  
            PRIMARY KEY (`ID`),
            FOREIGN KEY (gallery_id) REFERENCES " . JABAGO_GALLERY_TABLE . "(ID)
        );";
        $wpdb->query($wpdb->prepare($query_2));

        $query_3 = "CREATE TABLE IF NOT EXISTS `" . JABAGO_GALLERY_THEMES_TABLE . "`(
            `ID` INT NOT NULL AUTO_INCREMENT, 
            `name` TEXT NOT NULL ,   
            `options` TEXT NOT NULL ,  
            PRIMARY KEY (`ID`)
        );";
        $wpdb->query($wpdb->prepare($query_3));

        $query_4 = "SELECT * FROM " . JABAGO_GALLERY_THEMES_TABLE;

        if(empty($wpdb->get_results($wpdb->prepare($query_4)))){
            
            $default_theme = [
                'ID' => null,
                'name' => 'default',
                'options' => '{"hover_animation_style":"zoom-1","show_gallery_title":"yes","gallery_title_color":"#12121c","gallery_title_size":"25","gallery_background_color":"transparent","gallery_gap":"10","picture_border_width":"10","picture_border_style":"solid","picture_border_radius":"0","picture_border_color":"#fafafa","gallery_padding":"20"}'
            ];
    
            $wpdb->insert(JABAGO_GALLERY_THEMES_TABLE, $default_theme);
        }


        // flush_rewrite_rules();
    }
} 