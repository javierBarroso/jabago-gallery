<?php

/**
 * @package JabagoGallery
 */

use JabagoG_Inc\Api\Callbacks\JabagoGalleryAdminCallbacks;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$jabago_gallery_admin = new JabagoGalleryAdminCallbacks();
$options = null;

if(isset($_GET['theme'])){
    $theme = $jabago_gallery_admin::jabagoGalleryGetTheme($_GET['theme']);
    $options = json_decode($theme->options);
}else{
    $theme = $jabago_gallery_admin::jabagoGalleryGetTheme(1);
    $options = json_decode($theme->options);
}

$nonce = wp_create_nonce( 'add_theme' );


if(isset($_POST['save-theme'])){
    $theme_data = array(
        'show_gallery_title' => $_POST['show-gallery-title'],

        'name' => $_POST['theme-name'],
        
        'gallery_title_color' => sanitize_hex_color( $_POST['gallery-title-color'] ),
    
        'gallery_title_size' => $_POST['gallery-title-size'],
        
        'gallery_gap' => $_POST['gallery-gap'],
        
        'picture_border_width' => $_POST['picture-border-width'],
        
        'picture_border_radius' => $_POST['picture-border-radius'],
        
        'picture_border_style' => $_POST['picture-border-style'],
        
        'picture_border_color' => sanitize_hex_color( $_POST['picture-border-color'] ),
        
        'gallery_padding' => $_POST['gallery-padding'],
    
        'hover_animation_style' => $_POST['hover-animation-style']
    );


    
    $jabago_gallery_admin::jabagoGalleryStoreTheme($theme_data, isset($_GET['theme']) ? $_GET['theme'] : null);
}
?>

<div class="wrap">
    <h2><?php echo esc_html( "Theme Settings" ) ?></h2>
    <br><br>
    <form method="post">
        <input type="hidden" name="nonce_field" value="<?php echo esc_attr( $nonce ); ?>">
        <input class="button button-primary" type="submit" value="Save Theme" name="save-theme">
        <br>
        <br>
        <div class="theme-settings">
            <div style="display:flex; padding:10px 20px; gap:10px;">

                <h3><?php echo esc_html('Theme name:') ?></h3>
                <input style="height: 30px; margin:auto 0" name="theme-name" type="text" id="theme-name" value="<?php echo esc_attr( isset($_GET['theme']) ? $theme->name : '' ) ?>">
            </div>
            <table>
                <!-- show title -->
                <tr>
                    <td class="label">
                        <label><?php echo esc_html( "Show gallery title:" ) ?></label>
                    </td>
                    <td class="input">
                        <label for="show-gallery-title"><?php echo esc_html( "Yes" ) ?></label>
                        <input name="show-gallery-title" type="radio" id="show-gallery-title" value="yes" <?php echo esc_attr( $options ? ($options->show_gallery_title == 'yes' ? 'checked' : '') : '' ) ?>>
                        <label for="hide-gallery-title"><?php echo esc_html( "No" ) ?></label>
                        <input name="show-gallery-title" type="radio" id="hide-gallery-title" value="no" <?php echo esc_attr( $options ? ($options->show_gallery_title == 'no' ? 'checked' : '') : '' ) ?>>
                    </td>
                </tr>
                <!-- title text color -->
                <tr>
                    <td class="label">
                        <label for="gallery-title-color"><?php echo esc_html( "Gallery title color:" ) ?></label>
                    </td>
                    <td class="input">
                        <input name="gallery-title-color" type="color" id="gallery-title-color" value="<?php echo esc_attr( $options ? $options->gallery_title_color : '#ffffff' ) ?>">
                    </td>
                </tr>
                <!-- title font size -->
                <tr>
                    <td class="label">
                        <label for="gallery-title-size"><?php echo esc_html( "Gallery title font size:" ) ?></label>
                    </td>
                    <td class="input">
                        <input name="gallery-title-size" type="number" id="gallery-title-size" value="<?php echo esc_attr( $options ? $options->gallery_title_size : '25' ) ?>"><span>px</span>
                    </td>
                </tr>
                <!-- pictures gap -->
                <tr>
                    <td class="label">
                        <label for="gallery-gap"><?php echo esc_html( "Gap between pictures:" ) ?></label>
                    </td>
                    <td class="input">
                        <input name="gallery-gap" type="number" id="gallery-gap" value="<?php echo esc_attr( $options ? $options->gallery_gap : '10' ) ?>"><span>px</span>
                    </td>
                </tr>
                <!-- gallery padding -->
                <tr>
                    <td class="label">
                        <label for="gallery-padding"><?php echo esc_html( "Gallery padding:" ) ?></label>
                    </td>
                    <td class="input">
                        <input name="gallery-padding" type="number" id="gallery-padding" value="<?php echo esc_attr( $options ? $options->gallery_padding : '20' ) ?>"><span>px</span>
                    </td>
                </tr>
                <tr>
                    <th>
                        <h3><?php echo esc_html( 'Border Settings' ) ?></h3>
                    </th>
                </tr>
                <!-- pictures border width -->
                <tr>
                    <td class="label">
                        <label for="picture-border-width"><?php echo esc_html( "Border width:" ) ?></label>
                    </td>
                    <td class="input">
                        <input name="picture-border-width" type="number" id="picture-border-width" value="<?php echo esc_attr( $options ? $options->picture_border_width : '10' ) ?>"><span>px</span>
                    </td>
                </tr>
                <!-- pictures border style -->
                <tr>
                    <td class="label">
                        <label for="picture-border-style"><?php echo esc_html( "Border style:" ) ?></label>
                    </td>
                    <td class="input">
                        <select name="picture-border-style" id="picture-border-style">
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'none' ? 'selected' : '') : '' )?> value="none">None</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'solid' ? 'selected' : '') : '' )?> value="solid">Solid</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'dashed' ? 'selected' : '') : '' )?> value="dashed">Dashed</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'dotted' ? 'selected' : '') : '' )?> value="dotted">Dotted</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'double' ? 'selected' : '') : '' )?> value="double">Double</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'groove' ? 'selected' : '') : '' )?> value="groove">Groove</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'ridge' ? 'selected' : '') : '' )?> value="ridge">Ridge</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'inset' ? 'selected' : '') : '' )?> value="inset">Inset</option>
                            <option <?php echo esc_attr( $options ? ( $options->picture_border_style == 'outset' ? 'selected' : '') : '' )?> value="outset">Outset</option>
                        </select>
                    </td>
                </tr>
                <!-- border radius -->
                <tr>
                    <td class="label">
                        <label for="picture-border-radius"><?php echo esc_html( "Border radius:" ) ?></label>
                    </td>
                    <td class="input">
                        <input name="picture-border-radius" type="number" id="picture-border-radius" value="<?php echo esc_attr( $options ? $options->picture_border_radius : '0' ) ?>"><span>px</span>
                    </td>
                </tr>
                <!-- pictures border color -->
                <tr>
                    <td class="label">
                        <label for="picture-border-color"><?php echo esc_html( "Border color:" ) ?></label>
                    </td>
                    <td class="input">
                        <input name="picture-border-color" type="color" id="picture-border-color" value="<?php echo esc_attr( $options ? $options->picture_border_color : '#ffffff' ) ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <h3><?php echo esc_html( 'On Hover Settings' ) ?></h3>
                    </th>
                </tr>
                <!-- pictures border style -->
                <tr>
                    <td class="label">
                        <label for="hover-animation-style"><?php echo esc_html( "Animation style:" ) ?></label>
                    </td>
                    <td class="input">
                        <select name="hover-animation-style" id="hover-animation-style">
                            <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'none' ? 'selected' : '') : '' )?> value="">None</option>
                            <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'zoom-in' ? 'selected' : '') : '' )?> value="zoom-in">Zoom in</option>
                            <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'zoom-out' ? 'selected' : '') : '' )?> value="zoom-out">Zoom out</option>
                            <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'rotate' ? 'selected' : '') : '' )?> value="rotate">Rotate</option>
                            <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'shine3d' ? 'selected' : '') : '' )?> value="shine3d">3d Shine</option>
                            <!-- <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'flip' ? 'selected' : '') : '' )?> value="flip">Flip</option>
                            <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'focus' ? 'selected' : '') : '' )?> value="focus">Focus <span style="color: red; font-weight:500; font-style:italic; ">pro</span> </option>
                            <option <?php echo esc_attr( $options ? ( $options->hover_animation_style == 'parallax' ? 'selected' : '') : '' )?> value="parallax">Parallax <span style="color: red; font-weight:500; font-style:italic; ">pro</span> </option> -->
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <br>
        <input class="button button-primary" type="submit" value="Save Theme" name="save-theme">
    </form>
</div>