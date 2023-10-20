<?php

/**
 * @package JabagoGallery
 */

use JabagoG_Inc\Api\Callbacks\JabagoGalleryAdminCallbacks;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly


$callback = new JabagoGalleryAdminCallbacks();

$gallery_data = null;
$images_data = null;
$themes_data = $callback::jabagoGalleryGetThemes();
$id = null;
$images_count = 0;

$delete_jabago_image = 'admin.php?page=jabago-gallery&action=delete-image&image=';

if (isset($_GET['gallery'])) {
    $title = 'Edit Gallery';
    $id = sanitize_text_field( $_GET['gallery'] );
    $gallery_data = $callback::jabagoGalleryGetGallery( sanitize_text_field( $_GET['gallery'] ) );
    $images_data = $callback::jabagoGalleryGetGalleryImages( sanitize_text_field( $_GET['gallery'] ) );
    $images_count = count($images_data);
    ?>
    <script>selected_images = <?php echo esc_attr( $images_count ); ?></script>
    <?php
} else {
    $title = 'Add Gallery';
}

$nonce = wp_create_nonce( 'add_gallery' );


if (isset($_POST['save-gallery']) && isset($_POST['url']) && wp_verify_nonce( sanitize_text_field( wp_unslash(  $_POST['nonce_field'] ) ), 'add_gallery' )) {

    $data = array(
        'name' => $_POST['name'],
        'image_click' => $_POST['image_click'],
        'gallery_layout' => $_POST['gallery_layout'],
        'theme_id' => $_POST['theme_id'],
        'url' => $_POST['url'],
        'title' => $_POST['title'],
        'alt-text' => $_POST['alt-text'],
        'description' => $_POST['description'],
        'redirect_url' => $_POST['redirect_url']
    );
    if ($id) {
        $callback::jabagoGalleryStoreGallery($_POST, $id);
        ?>
        <script>window.location.href="admin.php?page=jabago-gallery&action=edit&gallery=<?php echo esc_html( $_GET['gallery'] )?>"</script>
        <?php
    } else {
        $callback::jabagoGalleryStoreGallery($data);
        ?>
            <script>window.location.href="admin.php?page=jabago-gallery"</script>
        <?php
    }
    
}

if (!did_action('wp_enqueue_media')) {
    wp_enqueue_media();
}

?>


<div class="wrap" style="display: block; position:relative;">

    <h2><?php echo esc_html($title) ?></h2>
    <form method="post">
        <input type="hidden" name="nonce_field" value="<?php echo esc_attr( $nonce ); ?>">
        <input class="button button-primary" type="submit" value="Save Gallery" name="save-gallery">
        <br>    
        <br>    
        <div class="gallery-settings">
            <div class="options">
                <h3> <?php echo esc_html('Gallery Title') ?> </h3>
                <input required type="text" name="name" id="gallery-name" value="<?php echo esc_attr( $gallery_data ? $gallery_data->name : '' ) ?>">
            </div>
            <div class="options">
                <h3><?php echo esc_html("Select Theme:") ?></h3>
                <select name="theme_id" id="theme-selector">
                    <?php
                    foreach ($themes_data as $key => $theme) {
                        
                        echo '<option value="' . esc_attr($theme->ID) . '">' . esc_html($theme->name) . '</option>';
                        
                    }
                    ?>
                </select>
            </div>
            <div class="options">
                <h3><?php echo esc_html('Image click action') ?></h3>
                <div class="jabago-radio-input">
                    <label>
                        <input checked type="radio" name="image_click" id="lightbox" value="lightbox">
                        <span><?php echo esc_html("Lightbox") ?></span>
                    </label>
                    <label>
                        <input <?php echo esc_attr( $gallery_data ? ($gallery_data->image_click == 'url_redirect' ? 'checked' : '') : '' ) ?> type="radio" name="image_click" id="url_redirect" value="url_redirect">
                        <span><?php echo esc_html("Url redirect") ?></span>
                    </label>
                </div>
            </div>
            <div class="options">
                <h3><?php echo esc_html('Gallery Layout') ?></h3>
                <div class="jabago-radio-input">
                    <label>
                        <input checked type="radio" name="gallery_layout" id="square" value="square">
                        <span><?php echo esc_html("Square") ?></span>
                    </label>
                    <label>
                        <input <?php echo esc_attr( $gallery_data ? ($gallery_data->gallery_layout == 'tiles' ? 'checked' : '') : '' ) ?> type="radio" name="gallery_layout" id="tiles" value="tiles">
                        <span><?php echo esc_html("Tiles") ?></span>
                    </label>
                    <label>
                        <input <?php echo esc_attr( $gallery_data ? ($gallery_data->gallery_layout == 'masonry' ? 'checked' : '') : '' ) ?> type="radio" name="gallery_layout" id="masonry" value="masonry">
                        <span><?php echo esc_html("Masonry") ?></span>
                    </label>
                    <label>
                        <input <?php echo esc_attr( $gallery_data ? ($gallery_data->gallery_layout == 'justify' ? 'checked' : '') : '' ) ?> type="radio" name="gallery_layout" id="justify" value="justify">
                        <span><?php echo esc_html("Justify") ?></span>
                    </label>
                </div>
            </div>
        </div>
        <br>
        <div class="gallery-images">
            <h3><?php echo esc_html('Gallery Images') ?></h3>
            <div class="images" id="images">
                <?php
                if (!empty($images_data)) {
                    $html = '';
                    foreach ($images_data as $key => $image) {
                        
                        $html .= '<div class="image" id="image-' . esc_html( $key ) . '"><img src="' . esc_html($image->url) . '" width="100px" height="100px" id="image-' . esc_html($key) . '" >
                                    <input type="hidden" id="image-url-' . esc_html($key) . '" value="' . esc_html($image->url) . '" name="url[]">
                                    <div class="image-info">
                                        <label for="title">' . esc_html('Title') . '</label>
                                        <input type="text" name="title[]" id="title" value="' . $image->title . '" >
                                        <label for="alt-text">' . esc_html('Alt Text') . '</label>
                                        <input type="text" name="alt-text[]" id="alt-text" value="' . esc_html($image->alt_text) . '" >
                                        <label for="redirect_url">' . esc_html('Redirect Url') . '</label>
                                        <input type="text" name="redirect_url[]" id="redirect_url" value="' . esc_html($image->redirect_url) . '">
                                        <label for="description">' . esc_html('Description') . '</label>
                                        <textarea name="description[]" id="description" cols="10" rows="2">' . esc_html($image->description) . '</textarea>
                                    </div>
                                    <div class="image-actions">
                                        <a onclick="remove_image(\'image-' . esc_html($key) . '\')" class="button">' . esc_html('Delete') . '</a>
                                    </div></div>';
                    }
                    $alowed_tags = array(
                        'div' => array(
                            'class'=>array(),
                            'type'=>array(),
                            'href'=>array(),
                            'name'=>array(),
                            'id'=>array(),
                            'value'=>array(),
                        ),
                        'input' => array(
                            'class'=>array(),
                            'type'=>array(),
                            'href'=>array(),
                            'name'=>array(),
                            'id'=>array(),
                            'value'=>array(),
                        ),
                        'label' => array(
                            'class'=>array(),
                            'type'=>array(),
                            'href'=>array(),
                            'name'=>array(),
                            'id'=>array(),
                            'value'=>array(),
                        ),
                        'textarea' => array(
                            'class'=>array(),
                            'type'=>array(),
                            'href'=>array(),
                            'name'=>array(),
                            'id'=>array(),
                            'value'=>array(),
                        ),
                        'a' => array(
                            'class'=>array(),
                            'type'=>array(),
                            'href'=>array(),
                            'name'=>array(),
                            'id'=>array(),
                            'value'=>array(),
                            'onclick'=>array(),
                            'style'=>array(),
                        ),
                        'img' => array(
                            'class'=>array(),
                            'type'=>array(),
                            'href'=>array(),
                            'name'=>array(),
                            'id'=>array(),
                            'src'=>array(),
                        ),
                        
                    );
                   
                    echo wp_kses( $html, $alowed_tags );
                    
                }
                ?>
            </div>
            
            <a class="upload_image_button button button-secondary" onclick="select_images( ['<?php echo esc_html('Title') ?>', '<?php echo esc_html('Alt Text') ?>', '<?php echo esc_html('Redirect Url') ?>', '<?php echo esc_html('Description') ?>', '<?php echo esc_html('Delete') ?>'] );"><?php echo esc_html('Add image to gallery') ?></a>
        </div>
        <br>
        <input class="button button-primary" type="submit" value="Save Gallery" name="save-gallery">
    </form>
</div>