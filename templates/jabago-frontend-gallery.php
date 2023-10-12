<?php

/**
 * @package JabagoGallery
 */

use JabagoG_Inc\Api\Callbacks\JabagoGalleryAdminCallbacks;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


class JabagoGalleryShortcode
{

    public function jabagoSetGallery($id)
    {
        $gallery = JabagoGalleryAdminCallbacks::jabagoGalleryGetGallery($id);
        $theme_options = json_decode(JabagoGalleryAdminCallbacks::jabagoGalleryGetTheme($gallery->theme_id)->options);
        $images = JabagoGalleryAdminCallbacks::jabagoGalleryGetGalleryImages($id);

        
        $html = "<div class='jabago-gallery-container' style='
            --gallery-title-color: " .  esc_attr( $theme_options->gallery_title_color ? $theme_options->gallery_title_color : '#000000' ) . ";
            --gallery_title_size: " .  esc_attr( $theme_options->gallery_title_size ? $theme_options->gallery_title_size . 'px' : '25px' ) . ";
            --gallery-gap: " . esc_attr( $theme_options->gallery_gap ? $theme_options->gallery_gap . 'px' : '10px' ) . ";
            --image-border-width: " .  esc_attr( $theme_options->picture_border_width ? $theme_options->picture_border_width . 'px' : '10px' ) . ";
            --image-border-style: " .  esc_attr( $theme_options->picture_border_style ? $theme_options->picture_border_style : 'solid' ) . ";
            --image-border-radius: " .  esc_attr( $theme_options->picture_border_radius ? $theme_options->picture_border_radius . 'px' : '0px' ) . ";
            --image-border-color: " .  esc_attr( $theme_options->picture_border_color ? $theme_options->picture_border_color : '#ffffff' ) . ";
            --masonry-offset: -" .  esc_attr( $theme_options->picture_border_width ? $theme_options->picture_border_width . 'px' : '10px' ) . ";
            --gallery-padding: " .  esc_attr( $theme_options->gallery_padding ? $theme_options->gallery_padding . 'px' : '20px' ) . ";
        '>";
        

        if($theme_options->show_gallery_title == 'yes'){

            
            $html .= "<h2 id='jabago_gallery_title'>" . esc_html( $gallery->name ) . "</h2>";
            
        }
        
        $html .= "<div class='gallery " . esc_html( $gallery->gallery_layout ) . " " . esc_attr( $theme_options->hover_animation_style ) . "'>";
        
        
        foreach ($images as $key => $image) {
            if($gallery->image_click == 'lightbox'){
                
                $html .= "<div class='image " . esc_attr( $theme_options->hover_animation_style ) . "' data-img='" . esc_attr( $image->url ) . "'><img alt='" . esc_attr( $image->alt_text ) . "' src='" . esc_attr( $image->url ) . "'><div class='info'><h4 class='jabago-img-title'>" . esc_html( $image->title ) . "</h4><p class='jabago-img-description'>" . esc_html( $image->description ) . "</p></div></div>";
                
            }else{
                
                $html .= "<a href='" . esc_attr( $image->redirect_url ) . "' target='blank' class='image' data-img='" . esc_attr( $image->url ) . "'><img alt='" . esc_attr( $image->alt_text ) . "' src='" . esc_attr( $image->url ) . "'><div class='info'><h4>" . esc_html( $image->title ) . "</h4><p>" . esc_html( $image->description ) . "</p></div></a>";
                
            }
        }

        $html .= '</div>';

        if($gallery->gallery_layout == 'slider'){
            
            $html .= '<div class="slider-nav"><a href="#prev-slider"></a><a href="#next-slider"></a></div>';
            
        }
        
        $html .= '</div>';

        if($gallery->image_click == 'lightbox'){
            
            $html .= '<div class="lightbox">
                        <div class="lightbox-container">
                            <img src="" alt="" class="lightbox-img">
                            <div class="info">
                                <a class="close-btn"></a>
                                <h4 id="lightbox-title">' . esc_html( $image->title ) . '</h4>
                                <p id="lightbox-description">' . esc_html( $image->description ) . '</p>
                            </div>
                        </div>
                    </div>';
            
        }
       

            
        echo wp_kses_post( $html );

        
    }
}

?>

<div class="lightbox2">
    <div class="lightbox-container">
        <img src="" width="300" alt="">
        <div class="info">
            <h4>Image 1</h4>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam eligendi exercitationem reiciendis nemo molestiae distinctio quos quis atque commodi inventore.</p>
        </div>
    </div>
</div>