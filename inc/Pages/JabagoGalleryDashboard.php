<?php

/**
 * @package JabagoGallery
 */
namespace JabagoG_Inc\Pages;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

use JabagoG_Inc\Api\Callbacks\JabagoGalleryAdminCallbacks;
use JabagoG_Inc\Api\JabagoGallerySettingsApi;
use JabagoGalleryShortcode;

class JabagoGalleryDashboard
{
    public $settings;

    public $pages = array();

    public $sub_pages = array();

    public $callbacks;

    public function register()
    {
        $this->settings = new JabagoGallerySettingsApi();

        $this->callbacks = new JabagoGalleryAdminCallbacks();

        $this->setPages();

        $this->setSubpages();

        $this->settings->addPages($this->pages)->withSubPages('Galleries')->addSubPages($this->sub_pages)->register();

        add_shortcode( 'JABAGO-GALLERY', array($this, 'printGallery') );
    }

    function printGallery($atts)
    {
        ob_start();
        require_once JABAGO_GALLERY_PATH . '/templates/jabago-frontend-gallery.php';
        $shortcode = new JabagoGalleryShortcode();
        $shortcode->jabagoSetGallery($atts['id']);
        return ob_get_clean();
    } 

    public function setPages()
    {
        $this->pages = [
            [
                'page_title' => 'Galleries',
                'menu_title' => 'Jabago Gallery',
                'capability' => 'manage_options',
                'menu_slug' => 'jabago-gallery',
                'callback' => array( $this->callbacks, 'jabagoGalleryGalleryPage' ),
                'icon_url' => 'dashicons-edit-page',
                'position' => '20'
            ]
        ];
    }

    public function setSubpages()
    {
        $this->sub_pages = [
            [
                'parent_slug' => 'jabago-gallery',
                'page_title' => 'Themes',
                'menu_title' => 'Themes',
                'capability' => 'manage_options',
                'menu_slug' => 'jabago-gallery-theme',
                'callback' => array( $this->callbacks, 'jabagoGalleryGalleryThemePage' )
            ]
        ];
    }
}