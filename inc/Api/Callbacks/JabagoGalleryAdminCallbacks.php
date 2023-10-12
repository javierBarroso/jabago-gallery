<?php

/**
 * @package JabagoGallery
 */
namespace JabagoG_Inc\Api\Callbacks;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class JabagoGalleryAdminCallbacks
{
    public function jabagoGalleryGalleryPage()
    {

        $action = isset($_GET['action']) ? sanitize_text_field( $_GET['action'] ) : '';
    
        switch ($action)
        {
            case 'add':
            case 'edit':
                require_once JABAGO_GALLERY_PATH . './templates/jabago-gallery-add.php';
                break;
            case 'delete':
                $this->jabagoGalleryDeleteGallery(sanitize_text_field($_GET['gallery']));
                break;
            default:
                require_once JABAGO_GALLERY_PATH . './templates/jabago-galleries-list.php';
                break;
        }
        
    }

    public function jabagoGalleryGalleryThemePage()
    {
        $action = isset($_GET['action']) ? sanitize_text_field( $_GET['action'] ) : '';
    
        switch ($action)
        {
            case 'edit':
            case 'add':
                require_once JABAGO_GALLERY_PATH . './templates/jabago-gallery-theme-add.php';
                break;
            case 'delete':
                $this->jabagoGalleryDeleteTheme(sanitize_text_field($_GET['theme']));
                break;
            default:
                require_once JABAGO_GALLERY_PATH . './templates/jabago-gallery-themes.php';
                break;
        }

    }

    static public function jabagoGalleryGetGalleries()
    {

        global $wpdb;

        $query = 'SELECT * FROM ' . JABAGO_GALLERY_TABLE;

        $galleries = $wpdb->get_results( $wpdb->prepare( $query ) );

        if( empty( $galleries ) )
        {
            $galleries = array();
        }
        return $galleries;

    }

    static public function jabagoGalleryGetGallery($id)
    {
        global $wpdb;

        $query = "SELECT * FROM " . JABAGO_GALLERY_TABLE . " WHERE ID = " . $id;

        $gallery = $wpdb->get_results( $wpdb->prepare( $query ) );

        if (empty($gallery)) {
            $gallery = array();
        }

        return $gallery[0];
    }

    static public function jabagoGalleryGetGalleryImages($id)
    {
        global $wpdb;

        $query = "SELECT * FROM " . JABAGO_GALLERY_IMAGES_TABLE . " WHERE gallery_id = " . $id;

        $images = $wpdb->get_results( $wpdb->prepare( $query ) );

        if (empty($images)) {
            $images = array();
        }

        return $images;
    }

    static public function jabagoGalleryStoreGallery($data, $id = null)
    {
        
        if( empty( $data['url'] ) )
        {
            return false;
        }

        global $wpdb;

        $edit = false;

        $gallery_data = array(
            'ID' => $id,
            'name' => sanitize_text_field( $data['name'] ),
            'image_click' => sanitize_text_field( $data['image_click'] ),
            'gallery_layout' => sanitize_text_field( $data['gallery_layout'] ),
            'theme_id' => $data['theme_id'],
        );

        if($id)
        {
            $edit = true;
            $gallery_data['short_code'] = "[JABAGO-GALLERY id='$id']";
            $wpdb->update(JABAGO_GALLERY_TABLE, $gallery_data, array('ID' => $id));
            $wpdb->delete(JABAGO_GALLERY_IMAGES_TABLE, array('gallery_id' => $id));
        }
        else
        {
            $wpdb->insert(JABAGO_GALLERY_TABLE, $gallery_data);
            
            $query = "SELECT ID FROM " . JABAGO_GALLERY_TABLE . " ORDER BY ID DESC limit 1";
            $gallery_id = $wpdb->get_results( $wpdb->prepare( $query ) );
            $id = $gallery_id[0]->ID;
            $shortcode = "[JABAGO-GALLERY id='$id']";
    
            $wpdb->update(JABAGO_GALLERY_TABLE, array('short_code' => $shortcode), array('ID' => $id));
        }



        foreach ($data['url'] as $key => $value) {

            $image_data = [
                'ID' => null,
                'gallery_id' => $id,
                'url' => sanitize_url( $value ),
                'title' => sanitize_text_field( $data['title'][$key] ? $data['title'][$key] : '' ),
                'alt_text' => sanitize_text_field( $data['alt-text'][$key] ? $data['alt-text'][$key] : '' ),
                'description' => sanitize_text_field( $data['description'][$key] ? $data['description'][$key] : '' ),
                'redirect_url' => sanitize_url( $data['redirect_url'] ? $data['redirect_url'][$key] : '' ),
            ];

            $wpdb->insert(JABAGO_GALLERY_IMAGES_TABLE, $image_data);
            
        }
        $edit ? wp_redirect( admin_url( 'admin.php?page=jabago-gallery&action=edit&gallery=' . $id ) ) : wp_redirect( admin_url( 'admin.php?page=jabago-gallery' ) );
       

    }

    private function jabagoGalleryDeleteGallery($id)
    {
        global $wpdb;

        $wpdb->delete(JABAGO_GALLERY_IMAGES_TABLE, array('gallery_id' => $id));
        $wpdb->delete(JABAGO_GALLERY_TABLE, array('ID' => $id));

        wp_redirect( admin_url( 'admin.php?page=jabago-gallery' ) );
    }

    static public function jabagoGalleryGetThemes()
    {
        global $wpdb;

        $query = 'SELECT * FROM ' . JABAGO_GALLERY_THEMES_TABLE;

        $themes = $wpdb->get_results( $wpdb->prepare( $query ) );

        if( empty( $themes ) )
        {
            $themes = array();
        }

        return $themes;
    } 

    static public function jabagoGalleryGetTheme($id)
    {
        global $wpdb;

        $query = "SELECT * FROM " . JABAGO_GALLERY_THEMES_TABLE . " WHERE ID = " . $id;

        $theme = $wpdb->get_results($query);

        if (empty($theme)) {
            $theme = array();
        }
        return $theme[0];
    }

    static public function jabagoGalleryStoreTheme($data, $id = null)
    {
        
        if( wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['nonce_field'] ) ), 'add_theme' ) )
        {
            global $wpdb;

            $current_theme = null;

            if($id)
            {

                $query = "SELECT * FROM " . JABAGO_GALLERY_THEMES_TABLE . " WHERE ID = " . $id;
        
                $current_theme = $wpdb->get_results( $wpdb->prepare( $query ) )[0];

            }



            $theme_options = json_encode($data);

            $theme_data = [
                'ID' => $id ? $id : null,
                'name' => $data['name'],
                'options' => $theme_options
            ];



            $current_theme ? $wpdb->update(JABAGO_GALLERY_THEMES_TABLE, $theme_data, array('ID' => $current_theme->ID)) : $wpdb->insert(JABAGO_GALLERY_THEMES_TABLE, $theme_data);

            $id ? wp_redirect( admin_url( 'admin.php?page=jabago-gallery-theme&action=edit&theme=' . $id ) ) : wp_redirect( admin_url( 'admin.php?page=jabago-gallery-theme' ) );

        }
    }

    private function jabagoGalleryDeleteTheme($id)
    {
        global $wpdb;

        $wpdb->delete(JABAGO_GALLERY_THEMES_TABLE, array('ID' => $id));
        
        wp_redirect( admin_url( 'admin.php?page=jabago-gallery-theme' ) );
    }

}