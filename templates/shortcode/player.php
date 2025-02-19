<?php
/**
 * @package    OVA Audio by ovatheme
 * @author     Ovatheme
 * @copyright  Copyright (C) 2022 Ovatheme All Rights Reserved.
 * @license    GNU/GPL v2 or later http://www.gnu.org/licenses/gpl-2.0.html
 */
if ( !defined( 'ABSPATH' ) ) exit();

?>
<div class="ovau-player-container ova-player-hide">
    <a class="ova-player-toggle" href="javascript:void(0);">
        <span class="ova-player-collapse-text"><i class="ovapf ovapf-minimize"></i></span>
        <span class="ova-player-show-text"><i class="ovapf ovapf-maximize"></i></span>
    </a>
    <div class="ova-player-wrapper ova-player-wrapper-bg">
        <div class="ova-player-left">
            <div class="ova-player-title"><?php echo esc_html__( 'Title', 'ovau' ); ?></div>
            <div class="ova-player-info">
                <span class="ova-player-host"></span>
                <span class="ova-player-episode"></span>
                <span class="separator"><?php echo esc_html__( '.', 'ovau' ); ?></span>
                <span class="ova-player-categories"></span> 
            </div>
        </div>
        <div class="ova-player-right">
            <div id="ova-player" class="ova-player"></div>
        </div>
        <div id="ova-loading">
            <div class="ova-spinner"></div>
        </div>
    </div>
</div>