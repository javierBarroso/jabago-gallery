<?php

/**
 * @package JabagoGallery
 */
use JabagoG_Inc\Api\Callbacks\JabagoGalleryAdminCallbacks;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$galleries = JabagoGalleryAdminCallbacks::jabagoGalleryGetGalleries();


$add_gallery = 'admin.php?page=jabago-gallery&action=add';
$edit_jabago_gallery = 'admin.php?page=jabago-gallery&action=edit&gallery=';
$theme_gallery = 'admin.php?page=jabago-gallery&action=theme&gallery=';
$delete_jabago_gallery = 'admin.php?page=jabago-gallery&action=delete&gallery=';
$delete_jabago_gallery_message = 'Are you sure you want to delete this gallery?';
if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
    ?>
        <script>window.location.href="admin.php?page=jabago-gallery"</script>
    <?php
}

?>



<div class="wrap">
    <h2><?php echo esc_html('Galleries') ?></h2>
    <div class="group">
        <br>
        <a id="btn_nuevo" class="button button-primary" href="<?php echo esc_attr($add_gallery) ?>"><?php echo esc_html('Add New') ?></a>
        <br>
        <br>
        <table class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                    <th scope="col" id="name" class="manage-column">
                        <?php echo esc_html('Name') ?>
                    </th>
                    <th scope="col" id="short-code" class="manage-column">
                        <?php echo esc_html('Shortcode') ?>
                    </th>
                </tr>
            </thead>
            <tbody id="the-list">
                <?php
                foreach ($galleries as $key => $gallery) {
                    ?>
                    <tr>
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="name"><?php echo esc_html($gallery->name) ?>
                            <div class="row-actions">
                                <span class="edit"><a href="<?php echo esc_attr( $edit_jabago_gallery . $gallery->ID ) ?>" aria-label="Edit “Post #1”"><?php echo esc_html('Edit') ?></a> | </span>
                                <span class="trash"><a href="<?php echo esc_html( "javascript:httpGet('" . $delete_jabago_gallery . $gallery->ID . "')") ?>" class="submitdelete" aria-label="Move “Post #1” to the Trash"><?php echo esc_html('Delete') ?></a>
                            </div>
                        </td>
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="shortcode"><?php echo esc_html($gallery->short_code) ?></td>
                    </tr>
                    <?php
                   
                }
                
                ?>
            <tfoot>
                <tr>
                    <th scope="col" id="name" class="manage-column">
                        <?php echo esc_html('Name') ?>
                    </th>
                    <th scope="col" id="short-code" class="manage-column">
                        <?php echo esc_html('Shortcode') ?>
                    </th>
                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
</div>