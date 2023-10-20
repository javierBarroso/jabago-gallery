<?php

/**
 * @package JabagoGallery
 */

use JabagoG_Inc\Api\Callbacks\JabagoGalleryAdminCallbacks;

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

$themes = JabagoGalleryAdminCallbacks::jabagoGalleryGetThemes();


$add_theme = 'admin.php?page=jabago-gallery-theme&action=add';
$edit_theme = 'admin.php?page=jabago-gallery-theme&action=edit&theme=';
$delete_theme = 'admin.php?page=jabago-gallery-theme&action=delete&theme=';
$delete_theme_message = 'Are you sure you want to delete this theme?';

if(isset($_GET['action']) && $_GET['action'] == 'delete')
{
    ?>
        <script>window.location.href="admin.php?page=jabago-gallery-theme"</script>
    <?php
}

?>



<div class="wrap">
    <h2><?php echo esc_html('Theme') ?></h2>
    <div class="group">
        <br>
        <a id="btn_nuevo" class="button button-primary" href="<?php echo esc_attr($add_theme) ?>"><?php echo esc_html('Add New') ?></a>
        <br>
        <br>
        <table class="wp-list-table widefat fixed striped posts">
            <thead>
                <tr>
                    <th scope="col" id="name" class="manage-column">
                        <?php echo esc_html('Name') ?>
                    </th>

                </tr>
            </thead>
            <tbody id="the-list">
                <?php
                
                foreach ($themes as $key => $theme) {

                    ?>
                    
                    <tr>
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="name"><?php echo esc_html($theme->name) ?> 
                            <div class="row-actions">
                                <span class="edit"><a href="<?php echo esc_attr($edit_theme . $theme->ID) ?>" aria-label="Edit “Post #1”">Edit</a></span>
                                    <?php
                                    if(count($themes) > 1){
                                        ?>
                                        <span class="trash"> | <a href="<?php echo esc_attr('javascript:httpGet("' . $delete_theme . $theme->ID . '")') ?>" class="submitdelete" aria-label="Move “Post #1” to the Trash">Delete</a>
                                        <?php
                                    }
                                    ?>
                                
                            </div>
                        </td>
                    </tr>

                    <?php
                }
                ?>
            <tfoot>
                <tr>
                    <th scope="col" id="name" class="manage-column">
                        <?php echo esc_html('Name') ?>
                    </th>

                </tr>
            </tfoot>
            </tbody>
        </table>
    </div>
</div>