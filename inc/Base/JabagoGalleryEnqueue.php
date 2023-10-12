<?php

/**
 * @package JabagoGallery
 */
namespace JabagoG_Inc\Base;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class JabagoGalleryEnqueue
{
    public function register(){
        add_action( 'admin_enqueue_scripts', array($this, 'enqueue') );
        add_action( 'wp_enqueue_scripts', array($this, 'enqueue_frontend') );
    }

    function enqueue(){
        wp_enqueue_style( 'jabago-gallery-admin-style', JABAGO_GALLERY_URL . '/assets/css/jabago-gallery-admin.css' );
        wp_enqueue_script( 'jabago-gallery-admin-script', JABAGO_GALLERY_URL . '/assets/js/jabago-gallery-admin.js', true );
    }
    
    function enqueue_frontend()
    {
        wp_enqueue_style( 'jabago-gallery-style', JABAGO_GALLERY_URL . '/assets/css/jabago-gallery-public.css' );
        wp_enqueue_script( 'jabago-gallery-script', JABAGO_GALLERY_URL . '/assets/js/jabago-gallery-public.js', [], false, true );
    }
}