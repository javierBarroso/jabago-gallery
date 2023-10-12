<?php

/**
 * @package JabagoGallery
 */
namespace JabagoG_Inc\Api;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class JabagoGallerySettingsApi
{

    public $admin_pages = array();
    public $admin_sub_pages = array();
    public $settings = array();
    public $sections = array();
    public $fields = array();

    public function register()
    {

        if(!empty($this->admin_pages) || !empty($this->admin_sub_pages)){
            add_action( 'admin_menu', array($this, 'addAdminMenu') );
        }
    }

    public function addPages( array $pages )
    {

        $this->admin_pages = $pages;

        return $this;

    }

    public function withSubPages( string $title = null )
    {
        if(empty($this->admin_pages)){
            return $this;
        }

        $admin_page = $this->admin_pages[0];

        $sub_page = array(
            [
                'parent_slug' => $admin_page['menu_slug'],
                'page_title' => $admin_page['page_title'],
                'menu_title' => ( $title ) ? $title : $admin_page['menu_title'],
                'capability' => $admin_page['capability'],
                'menu_slug' => $admin_page['menu_slug'],
                'callback' => null
            ]
        );

        $this->admin_sub_pages = $sub_page;

        return $this;
    }

    public function addSubPages( array $sub_pages)
    {
        $this->admin_sub_pages = array_merge($this->admin_sub_pages, $sub_pages);

        return $this;
    }

    public function addAdminMenu()
    {

        foreach ($this->admin_pages as $page) {
            add_menu_page( 
                $page['page_title'], 
                $page['menu_title'], 
                $page['capability'], 
                $page['menu_slug'], 
                $page['callback'], 
                $page['icon_url'], 
                $page['position'] 
            );
        }
        foreach ($this->admin_sub_pages as $sub_page) {
            add_submenu_page( 
                $sub_page['parent_slug'], 
                $sub_page['page_title'], 
                $sub_page['menu_title'], 
                $sub_page['capability'], 
                $sub_page['menu_slug'], 
                $sub_page['callback']
            );
        }
    }

    

}