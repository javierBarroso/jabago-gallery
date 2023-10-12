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
                $html = '';
                foreach ($themes as $key => $theme) {
                    
                    $html .= '<tr>
                        <td class="title column-title has-row-actions column-primary page-title" data-colname="name">' . esc_html($theme->name) . ' 
                            <div class="row-actions">
                                <span class="edit"><a href="' . esc_attr($edit_theme . $theme->ID) . '" aria-label="Edit “Post #1”">Edit</a></span>';
                                
                                    if(count($themes) > 1){
                                        $html .= '<span class="trash"> | <a href="' . esc_attr('javascript:httpGet("' . $delete_theme . $theme->ID . '")') . '" class="submitdelete" aria-label="Move “Post #1” to the Trash">Delete</a>';
                                    }
                                
                    $html .= '</div>
                        </td>
                    </tr>';
                }

                $html_tags = array(
                    'tr'=>array(
                        'class'=>array(),
                        'type'=>array(),
                        'href'=>array(),
                        'name'=>array(),
                        'id'=>array(),
                        'value'=>array(),
                    ),
                    'td'=>array(
                        'class'=>array(),
                        'type'=>array(),
                        'href'=>array(),
                        'name'=>array(),
                        'id'=>array(),
                        'value'=>array(),
                    ),
                    'div'=>array(
                        'class'=>array(),
                        'type'=>array(),
                        'href'=>array(),
                        'name'=>array(),
                        'id'=>array(),
                        'value'=>array(),
                    ),
                    'span'=>array(
                        'class'=>array(),
                        'type'=>array(),
                        'href'=>array(),
                        'name'=>array(),
                        'id'=>array(),
                        'value'=>array(),
                    ),
                    'a'=>array(
                        'class'=>array(),
                        'type'=>array(),
                        'href'=>array(),
                        'name'=>array(),
                        'id'=>array(),
                        'value'=>array(),
                    ),
                );

                echo wp_kses($html, $html_tags);
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