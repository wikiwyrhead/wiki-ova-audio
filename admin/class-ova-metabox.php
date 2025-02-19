<?php if ( !defined( 'ABSPATH' ) ) exit();

add_action( 'cmb2_init', 'ovau_metaboxes' );
function ovau_metaboxes() {

    // Start with an underscore to hide fields from custom fields list
    $prefix      = 'ovau_';
    $host_prefix = 'ovau_host_';
    
    /* Audio Settings */
    $ovau_settings = new_cmb2_box( array(
        'id'            => 'ovau_settings',
        'title'         => esc_html__( 'Settings', 'ovau' ),
        'object_types'  => array( 'ova_audio'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true,
    ) );

    $ovau_settings->add_field( array(
        'name'             => esc_html__( 'Template', 'ovau' ),
        'id'               => $prefix . 'single_template',
        'type'             => 'select',
        'default'          => '',
        'show_option_none' => true,
        'options'          => array(
            'template_1'   => esc_html__( 'Single Template 1', 'ovau' ),
            'template_2'   => esc_html__( 'Single Template 2', 'ovau' ),
        ),
    ) );

    $ovau_settings->add_field( array(
        'name'             => esc_html__( 'Type', 'ovau' ),
        'id'               => $prefix . 'type',
        'type'             => 'select',
        'default'          => 'upload_file',
        'show_option_none' => true,
        'options'          => array(
            'upload_file'   => esc_html__( 'Upload File', 'ovau' ),
            'oembed'        => esc_html__( 'oEmbed', 'ovau' ),
            'iframe'        => esc_html__( '<iframe> HTML', 'ovau' ),
        ),
    ) );

    $ovau_settings->add_field( array(
        'name'    => esc_html__( 'Media', 'ovau' ),
        'id'      => $prefix . 'media',
        'type'    => 'radio_inline',
        'options' => array(
            'audio' => esc_html__( 'Audio', 'ovau' ),
            'video' => esc_html__( 'Video', 'ovau' ),
        ),
        'default' => 'audio',
    ) );

    $ovau_settings->add_field( array(
        'name'      => esc_html__( 'Choose a Media', 'ovau' ),
        'id'        => $prefix . 'audio_url',
        'type'      => 'file',
        'options'   => array(
            'url'   => false,
        ),
        'text'      => array(
            'add_upload_file_text' => esc_html__( 'Add a Media', 'ovau' ),
        ),
        'query_args' => array(
            'type' => ['audio', 'video'],
        ),
    ) );

    $ovau_settings->add_field( array(
        'name'  => esc_html__( 'oEmbed', 'ovau' ),
        'id'    => $prefix . 'audio_oembed',
        'type'  => 'oembed',
        'desc'  => esc_html__( 'Insert Audio URL', 'ovau' ),
    ) );

    $ovau_settings->add_field( array(
        'name'  => esc_html__( 'Iframe', 'ovau' ),
        'id'    => $prefix . 'audio_iframe',
        'type'  => 'textarea',
        'desc'  => esc_html__( 'Insert <iframe> HTML', 'ovau' ),
        'sanitization_cb' => 'ovau_sanitization_cb_iframe',
    ) );

    $ovau_settings->add_field( array(
        'name'      => esc_html__( 'Episode', 'ovau' ),
        'id'        => $prefix . 'episode',
        'type'    	=> 'text',
        'default' 	=> '',
        'desc'      => esc_html__( 'Automatically insert Episode if empty', 'ovau' ),
    ) );

    $ovau_settings->add_field( array(
        'name'             => esc_html__( 'Hosts', 'ovau' ),
        'desc'             => esc_html__( 'Choose a host', 'ovau' ),
        'id'               => $prefix . 'host_id',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => ovau_get_hosts(),
    ) );

    // Episode timeline
    $episode_timeline = $ovau_settings->add_field( array(
        'id'          => $prefix . 'episode_timeline',
        'type'        => 'group',
        'options'     => array(
            'group_title'       => esc_html__( 'Episode Timeline', 'ovau' ), 
            'add_button'        => esc_html__( 'Add', 'ovau' ),
            'remove_button'     => esc_html__( 'Remove', 'ovau' ),
            'sortable'          => true,
           
        ),
    ) );

    $ovau_settings->add_group_field( $episode_timeline, array(
        'name' => esc_html__( 'Seconds', 'ovau' ),
        'id'   => $prefix . 'seconds',
        'type' => 'text',
    ) );

    $ovau_settings->add_group_field( $episode_timeline, array(
        'name' => esc_html__( 'Descriptions', 'ovau' ),
        'id'   => $prefix . 'descriptions',
        'type' => 'text',
    ) );

    // Donations
    $ovau_settings->add_field( array(
        'name'             => esc_html__( 'Choose Donation', 'ovau' ),
        'desc'             => esc_html__( 'Choose a form donation', 'ovau' ),
        'id'               => $prefix . 'give_forms',
        'type'             => 'select',
        'show_option_none' => true,
        'options'          => ovau_get_form_donations(),
    ) );

    // Featured Audio
    $ovau_settings->add_field( array(
        'name' => 'Featured Audio',
        'desc' => esc_html__( 'This is a featured audio', 'ovau' ),
        'id'   => $prefix . 'featured',
        'type' => 'checkbox',
    ) );

    $ovau_settings->add_field( array(
        'name'      => esc_html__( 'Sort Order', 'ovau' ),
        'id'        => $prefix . 'order',
        'type'      => 'text',
        'default'   => '',
        'desc'      => esc_html__( 'Automatically insert Sort Order if empty', 'ovau' )
    ) );



    /* Audio Hosts Settings */
    $ovau_host_settings = new_cmb2_box( array(
        'id'            => 'ovau_host_settings',
        'title'         => esc_html__( 'Settings', 'ovau' ),
        'object_types'  => array( 'ova_audio_host'), // Post type
        'context'       => 'normal',
        'priority'      => 'high',
        'show_names'    => true,
        
    ) );

    // Slogans
    $ovau_host_settings->add_field( array(
        'name' => esc_html__( 'Slogans', 'ovau' ),
        'id'   => $host_prefix . 'slogans',
        'type' => 'wysiwyg',
    ) );

    $ovau_host_settings->add_field( array(
        'name'      => esc_html__( 'Job', 'ovau' ),
        'id'        => $host_prefix . 'job',
        'type'      => 'text',
    ) );

    // Social
    $group_icon = $ovau_host_settings->add_field( array(
        'id'        => $host_prefix . 'group_icon',
        'type'      => 'group',
        'desc'      => esc_html__( 'List Social', 'ovau' ),
        'options'   => array(
            'group_title'       => esc_html__( 'Social', 'ovau' ), 
            'add_button'        => esc_html__( 'Add Social', 'ovau' ),
            'remove_button'     => esc_html__( 'Remove', 'ovau' ),
            'sortable'          => true,
           
        ),
    ) );

    $ovau_host_settings->add_group_field( $group_icon, array(
        'name' => esc_html__( 'Class icon social', 'ovau' ),
        'id'   => $host_prefix . 'class_icon_social',
        'type' => 'text',
    ) );

    $ovau_host_settings->add_group_field( $group_icon, array(
        'name' => esc_html__( 'Link social', 'ovau' ),
        'id'   => $host_prefix . 'link_social',
        'type' => 'text_url',
    ) );

    $ovau_host_settings->add_field( array(
        'name'      => esc_html__( 'Sort Order', 'ovau' ),
        'id'        => $host_prefix . 'order',
        'type'      => 'text',
        'default'   => '',
        'desc'      => esc_html__( 'Automatically insert Sort Order if empty', 'ovau' )
    ) );
}

add_action( 'save_post', 'ovau_save_meta_box', 20, 3 );
function ovau_save_meta_box( $id, $post, $update ) {

    $prefix         = 'ovau_';
    $host_prefix    = 'ovau_host_';

    if ( isset( $_POST ) && !empty( $_POST ) && ( 'ova_audio' === $post->post_type || 'ova_audio_host' === $post->post_type ) && ( isset( $_POST[$prefix.'episode'] ) || isset( $_POST[$prefix.'order'] ) || isset( $_POST[$host_prefix.'order'] ) ) ) {
        // Episode
        $audio_metabox[$prefix.'episode'] = isset( $_POST[$prefix.'episode'] ) && $_POST[$prefix.'episode'] ? $_POST[$prefix.'episode'] : ovau_get_episode();

        // Sort Order Audio
        $audio_metabox[$prefix.'order'] = isset( $_POST[$prefix.'order'] ) && $_POST[$prefix.'order'] ? $_POST[$prefix.'order'] : ovau_get_sort_order_audio();

        // Sort Order Host
        $audio_metabox[$host_prefix.'order'] = isset( $_POST[$host_prefix.'order'] ) && $_POST[$host_prefix.'order'] ? $_POST[$host_prefix.'order'] : ovau_get_sort_order_host();

        foreach ( $audio_metabox as $key => $value ) {
            update_post_meta( $id, $key, $value );

            if ( get_post_meta( $id, $key, FALSE ) ) { 
                update_post_meta( $id, $key, $value );
            } else {
                add_post_meta( $id, $key, $value );
            }
        }
    }
}

// Category
add_action( 'category_audio_add_form_fields', 'OVAU_taxonomy_add_new_meta_field' );
add_action( 'category_audio_edit_form_fields', 'OVAU_taxonomy_edit_meta_field' );
add_action( 'edited_category_audio', 'OVAU_taxonomy_save_meta_field' );
add_action( 'create_category_audio', 'OVAU_taxonomy_save_meta_field' );

function OVAU_taxonomy_add_new_meta_field( $array ) {
    ?>
    <div class="form-field ovau-image-class-wrap term-thumbnail-wrap">
        <label><?php esc_html_e( 'Thumbnail', 'ovau' ); ?></label>
        <div id="audio_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo OVAU_PLUGIN_URL . 'assets/img/woocommerce-placeholder-100x100.png'; ?>" width="60px" height="60px" style="object-fit: cover;"></div>
        <div style="line-height: 60px;">
            <input type="hidden" id="audio_cat_thumbnail_id" name="audio_cat_thumbnail_id">
            <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'ovau' ); ?></button>
            <button type="button" class="remove_image_button button" style="display: none;"><?php esc_html_e( 'Remove image', 'ovau' ); ?></button>
        </div>
        <script type="text/javascript">

            // Only show the "remove image" button when needed
            if ( ! jQuery( '#audio_cat_thumbnail_id' ).val() ) {
                jQuery( '.remove_image_button' ).hide();
            }

            // Uploading files
            var file_frame;

            jQuery( document ).on( 'click', '.upload_image_button', function( audio ) {

                audio.preventDefault();

                // If the media frame already exists, reopen it.
                if ( file_frame ) {
                    file_frame.open();
                    return;
                }

                // Create the media frame.
                file_frame = wp.media.frames.downloadable_file = wp.media({
                    title: 'Choose an image',
                    button: {
                        text: 'Use image'
                    },
                    multiple: false
                });

                // When an image is selected, run a callback.
                file_frame.on( 'select', function() {
                    var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
                    var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                    jQuery( '#audio_cat_thumbnail_id' ).val( attachment.id );
                    jQuery( '#audio_cat_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
                    jQuery( '.remove_image_button' ).show();
                });

                // Finally, open the modal.
                file_frame.open();
            });

            jQuery( document ).on( 'click', '.remove_image_button', function() {
                jQuery( '#audio_cat_thumbnail' ).find( 'img' ).attr( 'src', '' );
                jQuery( '#audio_cat_thumbnail_id' ).val( '' );
                jQuery( '.remove_image_button' ).hide();
                return false;
            });

            jQuery( document ).ajaxComplete( function( audio, request, options ) {
                if ( request && 4 === request.readyState && 200 === request.status
                    && options.data && 0 <= options.data.indexOf( 'action=add-tag' ) ) {

                    var res = wpAjax.parseAjaxResponse( request.responseXML, 'ajax-response' );
                    if ( ! res || res.errors ) {
                        return;
                    }
                    // Clear Thumbnail fields on submit
                    jQuery( '#audio_cat_thumbnail' ).find( 'img' ).attr( 'src', '' );
                    jQuery( '#audio_cat_thumbnail_id' ).val( '' );
                    jQuery( '.remove_image_button' ).hide();
                    // Clear Display type field on submit
                    jQuery( '#display_type' ).val( '' );
                    return;
                }
            } );

        </script>
        <div class="clear"></div>
    </div>
    <?php
}

function OVAU_taxonomy_edit_meta_field( $term ) {
    $term_id = $term->term_id;
    $placeholder_image_url = OVAU_PLUGIN_URL . 'assets/img/woocommerce-placeholder-100x100.png';

    $audio_cat_thumbnail_id = get_term_meta( $term_id, 'audio_cat_thumbnail_id', true );

    $image_url = wp_get_attachment_image_url( $audio_cat_thumbnail_id, 'thumbnail' );
    if ( !$image_url ) {
        $image_url = $placeholder_image_url;
    }

    ?>
    <tr class="form-field ovau-image-class-wrap term-thumbnail-wrap">
        <th scope="row" valign="top"><label><?php esc_html_e( 'Thumbnail', 'ovau' ); ?></label></th>
        <td>
            <div id="audio_cat_thumbnail" style="float: left; margin-right: 10px;"><img src="<?php echo esc_url( $image_url ); ?>" width="60px" height="60px" style="object-fit: cover;"></div>
            <div style="line-height: 60px;">
                <input type="hidden" id="audio_cat_thumbnail_id" name="audio_cat_thumbnail_id" value="<?php echo esc_attr( $audio_cat_thumbnail_id ); ?>">
                <button type="button" class="upload_image_button button"><?php esc_html_e( 'Upload/Add image', 'ovau' ); ?></button>
                <button type="button" class="remove_image_button button" style="display: none;"><?php esc_html_e( 'Remove image', 'ovau' ); ?></button>
            </div>
            <script type="text/javascript">

                // Only show the "remove image" button when needed
                if ( '0' === jQuery( '#audio_cat_thumbnail_id' ).val() ) {
                    jQuery( '.remove_image_button' ).hide();
                }

                // Uploading files
                var file_frame;

                jQuery( document ).on( 'click', '.upload_image_button', function( audio ) {

                    audio.preventDefault();

                    // If the media frame already exists, reopen it.
                    if ( file_frame ) {
                        file_frame.open();
                        return;
                    }

                    // Create the media frame.
                    file_frame = wp.media.frames.downloadable_file = wp.media({
                        title: 'Choose an image',
                        button: {
                            text: 'Use image'
                        },
                        multiple: false
                    });

                    // When an image is selected, run a callback.
                    file_frame.on( 'select', function() {
                        var attachment           = file_frame.state().get( 'selection' ).first().toJSON();
                        var attachment_thumbnail = attachment.sizes.thumbnail || attachment.sizes.full;

                        jQuery( '#audio_cat_thumbnail_id' ).val( attachment.id );
                        jQuery( '#audio_cat_thumbnail' ).find( 'img' ).attr( 'src', attachment_thumbnail.url );
                        jQuery( '.remove_image_button' ).show();
                    });

                    // Finally, open the modal.
                    file_frame.open();
                });

                jQuery( document ).on( 'click', '.remove_image_button', function() {
                    jQuery( '#audio_cat_thumbnail' ).find( 'img' ).attr( 'src', '' );
                    jQuery( '#audio_cat_thumbnail_id' ).val( '' );
                    jQuery( '.remove_image_button' ).hide();
                    return false;
                });

            </script>
            <div class="clear"></div>
        </td>
    </tr>
    <?php
}

function OVAU_taxonomy_save_meta_field( $term_id ) {
    $audio_cat_thumbnail_id = isset( $_REQUEST['audio_cat_thumbnail_id'] ) ? $_REQUEST['audio_cat_thumbnail_id'] : '';

    update_term_meta( $term_id, 'audio_cat_thumbnail_id', $audio_cat_thumbnail_id );
}