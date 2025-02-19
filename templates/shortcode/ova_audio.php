<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

extract( $args );

$id         = rand(1,1000000000000000000);
$content    = '';
if ( $button_title && $title ) {
    $content.= $button_title . esc_html__( ' - ', 'ovau' ) . $title;
} elseif ( $button_title ) {
    $content.= $button_title;
} elseif ( $title ) {
    $content.= $title;
} else {
    $content.= esc_html__( ' Play - Audio ', 'ovau' );
}

?>

<div class="ova-audio" 
    data-id="<?php echo esc_attr( $id ); ?>" 
    data-title="<?php echo esc_attr( $title ); ?>" 
    data-src="<?php echo esc_url( $src ); ?>">
    <?php if ( $content ): ?>
        <a href="javascript:void(0);"><?php echo esc_html( $content ); ?></a>
    <?php endif; ?>
    <div class="ova-hide">
        <audio id="id_<?php echo esc_attr( $id ); ?>" controls="" src="<?php echo esc_url( $src ); ?>" ></audio>
    </div>
</div>

