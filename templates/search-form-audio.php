<?php if ( !defined( 'ABSPATH' ) ) exit(); 

$search_cat    = isset($args['category']) ? $args['category'] : 'all';
$search_season = isset($args['season'])   ? $args['season']   : 'all' ;

$start_date    = isset($args['start_date']) ? $args['start_date'] : '';
$end_date 	   = isset($args['end_date'])   ? $args['end_date']   : '';

$lang 		 = apply_filters('ovau_audio_search_language','en');
$date_format = apply_filters('ovau_audio_search_date_format','m/d/Y');

?>

<div class="search_form_audio">

	<form action="" method="POST" name="search_audio" autocomplete="off">

		<div class="ovau_form_select ovau_episode_search">
			<?php ovau_select_audio_season( $search_season ); ?>
			<i class="arrow_carrot-down"></i>
		</div>

		<div class="ovau_form_select ovau_cat_search">
			<?php ovau_select_audio_cat( $search_cat ); ?>
			<i class="arrow_carrot-down"></i>
		</div>
		
		<div class="start_date">
			<input type="text" 
				id="ovau_start_date_search" 
				class="ovau_start_date_search" 
				data-lang="<?php echo esc_attr($lang); ?>" 
				data-date="<?php echo esc_attr($date_format); ?>" 
				placeholder="<?php echo esc_attr__( 'From...', 'ovau' ); ?>" 
				name="ovau_start_date_search" 
				value="<?php echo esc_attr($start_date); ?>"
			/>
		</div>
		<div class="end_date">
			<input 
				type="text" 
				id="ovau_end_date_search" 
				class="ovau_end_date_search" 
				data-lang="<?php echo esc_attr($lang); ?>" 
				data-date="<?php echo esc_attr($date_format); ?>" 
				placeholder="<?php echo esc_attr__( 'to...', 'ovau' ); ?>" 
				name="ovau_end_date_search" 
				value="<?php echo esc_attr($end_date ); ?>" 
			/>
		</div>
		
	</form>
</div>