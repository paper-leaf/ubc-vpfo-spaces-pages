<?php get_header();

$classroom        = $args['classroom'];
$classroom_fields = json_decode( wp_json_encode( $classroom->fields ), true );

$classroom_name = $classroom_fields['Name'] ?? null;

$classroom_building_name   = $classroom_fields['Building Name'] ?? null;
$classroom_building_code   = $classroom_fields['Building Code'] ?? null;
$classroom_building_title  = $classroom_building_name ?? '';
$classroom_building_title .= $classroom_building_code ? ' - ' . $classroom_building_code : '';
$classroom_building_slug   = $args['classroom_building_slug'] ?? null;
$classroom_building_url    = $classroom_building_slug ? get_bloginfo( 'url' ) . '/buildings/' . $classroom_building_slug : null;

$breadcrumb_home         = get_bloginfo( 'url' );
$breadcrumb_find_a_space = get_page_by_path( 'find-a-space' ) !== null ? get_permalink( get_page_by_path( 'find-a-space' ) ) : null;
$breadcrumb_building     = $classroom_building_url ? '<a href="' . $classroom_building_url . '" class="d-inline-block" title="' . $classroom_building_title . '" rel="bookmark">' . $classroom_building_title . '</a>' : null;
$breadcrumb              = '<a href="' . $breadcrumb_home . '" class="d-inline-block" title="' . get_bloginfo( 'name' ) . '" rel="bookmark">' . get_bloginfo( 'name' ) . '</a>';
$breadcrumb             .= $breadcrumb_find_a_space ? '<i class="fas fa-chevron-right mx-4"></i><a href="' . $breadcrumb_find_a_space . '" class="d-inline-block">' . __( 'Find a Space', 'ubc-vpfo-spaces-pages' ) . '</a>' : '';
$breadcrumb             .= $breadcrumb_building ? '<i class="fas fa-chevron-right mx-4"></i>' . $breadcrumb_building : '';
$breadcrumb             .= $classroom_name ? '<i class="fas fa-chevron-right mx-4"></i><span class="d-inline-block current-page">' . $classroom_name . '</span>' : '';

$classroom_workday_room_code_original = $classroom_fields['Workday Room Code'] ?? null;
$classroom_workday_room_code_override = $classroom_fields['Workday Room Code (override)'] ?? null;
$classroom_workday_room_code          = $classroom_workday_room_code_override ?? $classroom_workday_room_code_original;

$classroom_alert_message         = $classroom_fields['Alert Message'] ?? null;
$classroom_image_gallery         = $classroom_fields['Image Gallery'] ?? array();
$classroom_layout_image          = $classroom_fields['Classroom Layout'][0] ?? array();
$classroom_capacity              = $classroom_fields['Capacity'] ?? null;
$classroom_hours                 = $classroom_fields['Hours (override)'] ?? null;
$classroom_overview              = $classroom_fields['Space Overview'] ?? null;
$classroom_360_view              = $classroom_fields['360 View'] ?? null;
$classroom_av_guide              = $classroom_fields['AV Guide'] ?? null;
$classroom_ap_helpdesk           = '#'; // TODO - get real data
$classroom_layout_type           = $classroom_fields['Formatted_Room_Layout_Type'] ?? null;
$classsroom_furniture            = $classroom_fields['Formatted_Furniture'] ?? null;
$classroom_accessibility         = $classroom_fields['Filter_Accessibility'] ?? null;
$classroom_accessibility_content = $classroom_fields['Accessibility Content'] ?? null;
$classroom_features              = $classroom_fields['Formatted_IS_Amenities'] ?? null;
$classroom_presentation_displays = $classroom_fields['Formatted_Amenities_Presentation_Displays'] ?? null;
$classroom_presentation_sources  = $classroom_fields['Formatted_Amenities_Presentation_Sources'] ?? null;
$classroom_audio                 = $classroom_fields['Formatted_Amenities_Audio'] ?? null;
$classroom_other_av              = $classroom_fields['Formatted_Amenities_Other_AV_Features'] ?? null;
$classroom_building_map          = $classroom_building_code ? 'https://maps.ubc.ca/?code=' . $classroom_building_code : null;
?>

<section class="vpfo-spaces-page">
	<div class="container-fluid px-0">

		<section class="classroom-header mt-9">
			<?php if ( $breadcrumb && ! empty( $breadcrumb ) ) { ?>
				<div class="breadcrumb d-flex flex-wrap align-items-center px-0 mb-9 text-uppercase">
					<?php echo wp_kses_post( $breadcrumb ); ?>
				</div>
			<?php } ?>

			<div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-start mb-9">
				<div class="classroom-title">
					<h1 class="text-uppercase fw-bold mb-9 mb-md-0">
						<?php
						if ( $classroom_name ) {
							echo wp_kses_post( $classroom_name );
						} else {
							esc_html_e( 'Learning Spaces', 'ubc-vpfo-spaces-pages' );
						}
						?>
					</h1>
					
					<?php
					if ( $classroom_building_title ) {
						?>
						<div class="building-title text-uppercase fw-bold"><?php echo wp_kses_post( $classroom_building_title ); ?></div>
						<?php
					}
					?>

					<?php if ( $classroom_workday_room_code ) { ?>
						<div class="workday-room-code text-uppercase"><?php echo wp_kses_post( $classroom_workday_room_code ); ?></div>
					<?php } ?>
					
				</div>
				<a href="<?php echo wp_kses_post( $breadcrumb_find_a_space ); ?>" class="btn btn-secondary btn-border-thick me-auto me-md-0 ms-md-auto  d-flex align-items-center"><i class="fas fa-chevron-left me-3"></i><?php esc_html_e( 'Return to Find a Space', 'ubc-vpfo-spaces-pages' ); ?></a>
			</div>

			<?php if ( $classroom_alert_message ) { ?>
				<div class="alert-message d-flex align-items-top align-items-lg-center p-5 mb-5">
					<i class="fa-solid fa-circle-info pt-1"></i>
					<span><?php echo wp_kses_post( $classroom_alert_message ); ?></span>
				</div>
			<?php } ?>
		</section>

		<?php
		if ( ! empty( $classroom_image_gallery ) ) {
			?>
			<section class="classroom-image-gallery">
				<div class="glider-contain position-relative">
					<div class="glider">
						<?php
						$image_full_counter = 0;
						foreach ( $classroom_image_gallery as $image ) {
							++$image_full_counter;
							$image_full_thumbnails = $image['thumbnails'] ?? array();
							$image_full            = $image_full_thumbnails['full'] ?? array();
							$image_full_url        = $image_full['url'] ?? null;
							$image_full_width      = $image_full['width'] ?? null;
							$image_full_height     = $image_full['height'] ?? null;
							$image_full_alt        = $classroom_name . ' - Image Gallery ' . $image_full_counter;
							$image_full_element    = '';
							$image_full_element   .= $image_full_url ? '<img src="' . $image_full_url . '"' : '';
							$image_full_element   .= $image_full_width ? ' width="' . $image_full_width . '"' : '';
							$image_full_element   .= $image_full_height ? ' height="' . $image_full_height . '"' : '';
							$image_full_element   .= $image_full_alt ? ' alt="' . $image_full_alt . '"' : '';
							$image_full_element   .= $image_full_url ? '>' : '';

							if ( $image_full_element ) {
								?>
								<div class="glider-slide">
									<?php echo wp_kses_post( $image_full_element ); ?>
								</div>
								<?php
							}
						}
						?>
					</div>

					<div class="glider-thumbnails d-flex justify-content-center align-items-center position-absolute p-1 p-md-3 p-lg-5 w-100">
						<?php
						$image_thumb_count   = count( $classroom_image_gallery );
						$image_thumb_counter = 0;
						foreach ( $classroom_image_gallery as $image ) {
							++$image_thumb_counter;
							$image_thumb_thumbnails = $image['thumbnails'] ?? array();
							$image_thumb            = $image_thumb_thumbnails['large'] ?? array();
							$image_thumb_url        = $image_thumb['url'] ?? null;
							$image_thumb_width      = $image_thumb['width'] ?? null;
							$image_thumb_height     = $image_thumb['height'] ?? null;
							$image_thumb_alt        = $classroom_name . ' - Image Gallery ' . $image_thumb_counter;
							$image_thumb_element    = '';
							$image_thumb_element   .= $image_thumb_url ? '<img src="' . $image_thumb_url . '" data-index"' . $image_thumb_counter . '"' : '';
							$image_thumb_element   .= $image_thumb_width ? ' width="' . $image_thumb_width . '"' : '';
							$image_thumb_element   .= $image_thumb_height ? ' height="' . $image_thumb_height . '"' : '';
							$image_thumb_element   .= $image_thumb_alt ? ' alt="' . $image_thumb_alt . '"' : '';
							$image_thumb_element   .= $image_thumb_url ? '>' : '';

							if ( $image_full_element ) {
								?>
								<div class="glider-thumbnail thumbs-<?php echo absint( $image_thumb_count ); ?>" tabindex="0" role="button" aria-label="Image <?php echo absint( $image_thumb_counter ); ?>">
									<?php
									echo wp_kses_post( $image_thumb_element );
									?>
								</div>
								<?php
							}
						}
						?>
					</div>

					<div class="glider-nav">
						<button aria-label="Previous" class="glider-prev"><i class="fas fa-chevron-left"></i></button>
						<button aria-label="Next" class="glider-next"><i class="fas fa-chevron-right"></i></button>
					</div>
				</div>
			</section>
			<?php
		}
		?>

	</div>
</section>

<?php get_footer(); ?>