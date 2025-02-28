<?php
// Define variables needed before we call the header to support redirect logic
$building        = $args['building'];
$building_fields = json_decode( wp_json_encode( $building->fields ), true );

$building_classrooms = isset( $args['building_classrooms'] ) && ! empty( $args['building_classrooms'] ) ? $args['building_classrooms'] : array();

// Get the total number of classrooms before slicing for pagination
$total_classrooms = count( $building_classrooms );

// Define the number of items per page
$classrooms_per_page = 12;

if ( isset( $args['all_classroom'] ) && $args['all_classroom'] ) {
	$classrooms_per_page = 100;
}

// Calculate the total number of pages and cast to integer
$max_pages = (int) ceil( $total_classrooms / $classrooms_per_page );

// Get the current page from the URL parameter and ensure it's within bounds
$classrooms_page = isset( $_GET['page'] ) ? absint( $_GET['page'] ) : 1;

// Prep for the redirect logic
// Strip the fragment (anything after #) from the URL
$current_url = get_bloginfo( 'url' ) . $_SERVER['REQUEST_URI'];
$parsed_url  = wp_parse_url( $current_url );

// Rebuild the URL without the fragment
$base_url = $parsed_url['scheme'] . '://' . $parsed_url['host'] . $parsed_url['path'];
$query    = isset( $parsed_url['query'] ) ? '?' . $parsed_url['query'] : '';

// Calculate the last page URL and apply the page parameter
$last_page_url = add_query_arg( 'page', $max_pages, $base_url . $query );

// Perform the redirect if the current page is greater than the max
if ( $classrooms_page > $max_pages ) {
	wp_safe_redirect( $last_page_url );
	exit;
}

get_header();

// set up the rest of our variables
$building_name_original = $building_fields['Building Name'][0] ?? null;
$building_name_override = $building_fields['Building Name (override)'] ?? null;
$building_name          = $building_name_override ?? $building_name_original;
$building_code          = $building_fields['Building Code'][0] ?? null;
$building_name_w_code   = $building_name && $building_code ? $building_name . ' - ' . $building_code : $building_name;

$building_slug = $building_fields['Slug'] ?? null;
$building_url  = $building_slug ? get_bloginfo( 'url' ) . '/buildings/' . $building_slug : null;

$breadcrumb_home         = get_bloginfo( 'url' );
$breadcrumb_find_a_space = get_page_by_path( 'find-a-space' ) !== null ? get_permalink( get_page_by_path( 'find-a-space' ) ) : null;
$breadcrumb              = '<a href="' . $breadcrumb_home . '" class="d-inline-block" title="' . get_bloginfo( 'name' ) . '" rel="bookmark">' . get_bloginfo( 'name' ) . '</a>';
$breadcrumb             .= $breadcrumb_find_a_space ? '<i class="fas fa-chevron-right mx-4"></i><a href="' . $breadcrumb_find_a_space . '" class="d-inline-block vpfo-return-to-lsf">' . __( 'Find a Space', 'ubc-vpfo-spaces-pages' ) . '</a>' : '';
$breadcrumb             .= $building_name_w_code ? '<i class="fas fa-chevron-right mx-4"></i><span class="d-inline-block current-page">' . $building_name_w_code . '</span>' : '';

$alert_message = $building_fields['Alert Message'] ?? null;
if ( trim( $alert_message ) === '' ) {
	$alert_message = null;
}

$building_address_original = $building_fields['Formatted Building Address'][0] ?? null;
$building_address_override = $building_fields['Building Address (override)'] ?? null;
$building_address          = $building_address_override ?? $building_address_original;

// commented out because client wants campus removed from front-end template; leaving code here in case they change their mind
// $building_campus_code = $building_fields['Campus Code'][0] ?? null;
// if ( 'UBCV' === $building_campus_code ) {
// $building_campus = 'Vancouver';
// } elseif ( 'UBCO' === $building_campus_code ) {
// $building_campus = 'Okanagan';
// } else {
// $building_campus = null;
// }

$building_hours_original = $building_fields['Hours'][0] ?? null;
$building_hours_override = $building_fields['Hours (override)'] ?? null;
$building_hours          = $building_hours_override ?? $building_hours_original;
$building_hours          = $building_hours ? array_map( 'trim', explode( ';', $building_hours ) ) : array();

$building_notes = isset( $building_fields['Building Notes'] ) && ( trim( $building_fields['Building Notes'] ) !== '\n' && trim( $building_fields['Building Notes'] ) !== '' ) ? nl2br( $building_fields['Building Notes'] ) : null;

$building_floor_plan = $building_fields['Floor Plans'][0]['url'] ?? null;

$building_image_gallery = $building_fields['Building Image'] ?? array();

$building_map = isset( $building_fields['Map Link'] ) ? $building_fields['Map Link'] : null;

$building_options_links                     = $args['building_options_links'] ?? array();
$building_options_inclusive_washrooms       = $building_options_links['LINK_INCLUSIVE_WASHROOMS'] ?? null;
$building_options_accessibility_shuttle_map = $building_options_links['LINK_ACCESSIBILITY_SHUTTLE_MAP'] ?? null;
$building_options_blue_phones_map           = $building_options_links['LINK_BLUE_PHONES_MAP'] ?? null;
$building_options_aed_naloxone_map          = $building_options_links['LINK_AED_NALOXONE_MAP'] ?? null;
?>

<section class="vpfo-spaces-page">
	<div class="container-lg px-lg-0">

		<section class="building-header mt-9">
			<?php if ( $breadcrumb && ! empty( $breadcrumb ) ) { ?>
				<div class="breadcrumb d-flex flex-wrap align-items-center px-0 mb-9 text-uppercase">
					<?php echo wp_kses_post( $breadcrumb ); ?>
				</div>
			<?php } ?>

			<div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center mb-13">
				<div class="d-flex flex-column flex-wrap mb-9 mb-md-0">
					<h1 class="text-uppercase fw-bold mb-0">
						<?php
						if ( $building_name_w_code ) {
							echo wp_kses_post( $building_name_w_code );
						} elseif ( $building_name ) {
							echo wp_kses_post( $building_name );
						} else {
							esc_html_e( 'Learning Spaces', 'ubc-vpfo-spaces-pages' );
						}
						?>

					</h1>

					<?php
					if ( $building_url ) {
						?>
						<div class="clippy text-uppercase mt-3" data-clipboard-text="<?php echo esc_url( $building_url ); ?>">
							<svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.28613 1.78405C8.71426 1.21217 7.78613 1.21217 7.21426 1.78405L2.90176 6.09654C1.91504 7.08326 1.91504 8.6817 2.90176 9.66842C3.88848 10.6551 5.48691 10.6551 6.47363 9.66842L10.0361 6.10592C10.2916 5.85045 10.7088 5.85045 10.9643 6.10592C11.2197 6.36139 11.2197 6.77858 10.9643 7.03404L7.40176 10.5965C5.90176 12.0965 3.47363 12.0965 1.97363 10.5965C0.473633 9.09654 0.473633 6.66842 1.97363 5.16842L6.28613 0.85592C7.37129 -0.229236 9.1291 -0.229236 10.2143 0.85592C11.2994 1.94108 11.2994 3.69889 10.2143 4.78405L6.08926 8.90904C5.41895 9.57936 4.33145 9.57936 3.66113 8.90904C2.99082 8.23873 2.99082 7.15123 3.66113 6.48092L7.03613 3.10592C7.2916 2.85045 7.70879 2.85045 7.96426 3.10592C8.21973 3.36139 8.21973 3.77858 7.96426 4.03405L4.58926 7.40904C4.43223 7.56608 4.43223 7.82389 4.58926 7.98092C4.74629 8.13795 5.0041 8.13795 5.16113 7.98092L9.28613 3.85592C9.85801 3.28405 9.85801 2.35592 9.28613 1.78405Z" fill="#0055B7"/>
							</svg>
							Copy permalink
						</div>
						<?php
					}
					?>
				</div>
				<a href="<?php echo wp_kses_post( $breadcrumb_find_a_space ); ?>" class="btn btn-secondary btn-border-thick me-auto me-md-0 ms-md-auto d-flex align-items-center align-self-md-end vpfo-return-to-lsf"><i class="fas fa-chevron-left me-3"></i><?php esc_html_e( 'Return to Find a Space', 'ubc-vpfo-spaces-pages' ); ?></a>
			</div>

			<?php if ( $alert_message ) { ?>
				<div class="alert-message d-flex flex-column flex-sm-row align-items-sm-top p-5 mb-5">
					<i class="fa-solid fa-circle-info pt-1"></i>
					<span><?php echo wp_kses_post( $alert_message ); ?></span>
				</div>
			<?php } ?>
		</section>

		<section class="building-details mt-13 mt-md-9">
			<div class="row">
				<div class="col-lg-6 pe-lg-5 order-2 order-lg-1">
					<div class="building-info px-5 py-7">
						<?php if ( $building_address ) { ?>
							<div class="building-address">
								<h2 class="text-uppercase"><?php esc_html_e( 'Address', 'ubc-vpfo-spaces-pages' ); ?></h2>
								<p><?php echo wp_kses_post( $building_address ); ?></p>
							</div>
						<?php } ?>

						<?php if ( ! empty( $building_hours ) ) { ?>
							<div class="building-hours">
								<h2 class="text-uppercase"><?php esc_html_e( 'Hours', 'ubc-vpfo-spaces-pages' ); ?></h2>
								<?php foreach ( $building_hours as $building_hours_set ) { ?>
									<p><?php echo wp_kses_post( $building_hours_set ); ?></p>
								<?php } ?>
							</div>
						<?php } ?>

						<?php if ( $building_notes ) { ?>
							<div class="building-notes">
								<h2 class="text-uppercase"><?php esc_html_e( 'Building Notes', 'ubc-vpfo-spaces-pages' ); ?></h2>
								<p><?php echo wp_kses_post( $building_notes ); ?></p>
							</div>
						<?php } ?>

						<?php // TODO - figure out real dynamic data and labelling for this whole section ?>
						<div class="building-resources">
							<h2 class="text-uppercase"><?php esc_html_e( 'Resources', 'ubc-vpfo-spaces-pages' ); ?></h2>

							<div class="building-resources-links d-flex flex-column flex-sm-row flex-lg-column flex-xl-row flex-sm-wrap w-100">
								<?php
								if ( $building_options_inclusive_washrooms ) {
									?>
									<div class="btn-wrapper">
										<a href="<?php echo esc_url( $building_options_inclusive_washrooms ); ?>" class="btn btn-secondary d-block" target="_blank">
											<?php esc_html_e( 'Inclusive Washrooms', 'ubc-vpfo-spaces-pages' ); ?>
											<i class="fa-solid fa-users ms-3"></i>
										</a>
									</div>
									<?php
								}

								if ( $building_floor_plan ) {
									?>
									<div class="btn-wrapper">
										<a href="<?php echo esc_url( $building_floor_plan ); ?>" class="btn btn-secondary d-block" target="_blank">
											<?php esc_html_e( 'Floor Plan', 'ubc-vpfo-spaces-pages' ); ?>
											<i class="fa-regular fa-file-pdf ms-3"></i>
										</a>
									</div>
									<?php
								}

								if ( $building_options_blue_phones_map ) {
									?>
									<div class="btn-wrapper">
										<a href="<?php echo esc_url( $building_options_blue_phones_map ); ?>" class="btn btn-secondary d-block" target="_blank">
											<?php esc_html_e( 'Blue Phones Map', 'ubc-vpfo-spaces-pages' ); ?>
											<i class="fa-solid fa-phone ms-3"></i>
										</a>
									</div>
									<?php
								}

								if ( $building_options_accessibility_shuttle_map ) {
									?>
									<div class="btn-wrapper">
										<a href="<?php echo esc_url( $building_options_accessibility_shuttle_map ); ?>" class="btn btn-secondary d-block"  target="_blank">
											<?php esc_html_e( 'Accessibility Shuttle Map', 'ubc-vpfo-spaces-pages' ); ?>
											<i class="fa-solid fa-van-shuttle ms-3"></i>
										</a>
									</div>
									<?php
								}

								if ( $building_options_aed_naloxone_map ) {
									?>
									<div class="btn-wrapper">
										<a href="<?php echo esc_url( $building_options_aed_naloxone_map ); ?>" class="btn btn-secondary d-block"  target="_blank">
											<?php esc_html_e( 'AED &amp; Naloxone Map', 'ubc-vpfo-spaces-pages' ); ?>
											<i class="fa-solid fa-heart-pulse ms-3"></i>
										</a>
									</div>
									<?php
								}
								?>
							</div>
						</div>

						<?php if ( $building_map ) { ?>
							<div class="building-wayfinding">
								<h2 class="text-uppercase"><?php esc_html_e( 'Wayfinding', 'ubc-vpfo-spaces-pages' ); ?></h2>
								<div class="building-map-link">
									<a href="<?php echo esc_url( $building_map ); ?>" class="btn btn-secondary d-block" target="_blank">
										<?php esc_html_e( 'Open Full Screen Map', 'ubc-vpfo-spaces-pages' ); ?>
										<i class="fa-solid fa-map-location-dot"></i>
									</a>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>

				<div class="col-lg-6 ps-lg-5 order-1 order-lg-2">
					<?php if ( $building_map ) { ?>
						<div class="row">
							<?php if ( $building_map ) { ?>
								<div class="col col-md-6 col-lg-12">
									<div class="building-map ratio mb-5 mb-lg-5">
										<iframe src="<?php echo esc_url( $building_map ); ?>" title="Wayfinding Map"></iframe>
									</div>
								</div>
							<?php } ?>

							<?php
							if ( ! empty( $building_image_gallery ) ) {
								?>
								<div class="col col-md-6 col-lg-12 image-gallery">
									<?php
									if ( count( $building_image_gallery ) === 1 ) {
										?>
										<div class="classroom-image">
											<?php
											$image_thumbnails    = $building_image_gallery[0]['thumbnails'] ?? array();
											$image_full          = $image_thumbnails['full'] ?? array();
											$image_full_url      = $image_full['url'] ?? null;
											$image_full_width    = $image_full['width'] ?? null;
											$image_full_height   = $image_full['height'] ?? null;
											$image_full_element  = '';
											$image_full_element .= $image_full_url ? '<img src="' . $image_full_url . '"' : '';
											$image_full_element .= $image_full_width ? ' width="' . $image_full_width . '"' : '';
											$image_full_element .= $image_full_height ? ' height="' . $image_full_height . '"' : '';
											$image_full_element .= ' alt=""'; // Mark this image as decorational, as we do not have accurate alt text.
											$image_full_element .= $image_full_url ? '>' : '';

											if ( $image_full_element ) {
												echo wp_kses_post( $image_full_element );
											}
											?>
										</div>
										<?php
									} else {
										?>
										<div class="glider-contain position-relative">
											<div class="glider">
												<?php
												$image_full_counter = 0;
												foreach ( $building_image_gallery as $image ) {
													++$image_full_counter;
													$image_thumbnails    = $image['thumbnails'] ?? array();
													$image_full          = $image_thumbnails['full'] ?? array();
													$image_full_url      = $image_full['url'] ?? null;
													$image_full_width    = $image_full['width'] ?? null;
													$image_full_height   = $image_full['height'] ?? null;
													$image_full_element  = '';
													$image_full_element .= $image_full_url ? '<img src="' . $image_full_url . '"' : '';
													$image_full_element .= $image_full_width ? ' width="' . $image_full_width . '"' : '';
													$image_full_element .= $image_full_height ? ' height="' . $image_full_height . '"' : '';
													$image_full_element .= ' alt=""'; // Mark this image as decorational, as we do not have accurate alt text.
													$image_full_element .= $image_full_url ? '>' : '';

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

											<div class="glider-thumbnails d-none d-md-flex justify-content-md-center align-items-md-center position-absolute p-1 p-md-3 p-lg-5 w-100">
												<?php
												$image_thumb_count   = count( $building_image_gallery );
												$image_thumb_counter = 0;
												foreach ( $building_image_gallery as $image ) {
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

											<div class="glider-dots d-md-none position-absolute pb-5 w-100"></div>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							}
							?>
						</div>
					<?php } ?>
				</div>
			</div>
		</section>

		<?php
		if ( ! empty( $building_classrooms ) ) {
			// Get the sorted and paginated classrooms - see includes/helpers.php
			$paginated_classrooms = get_sorted_and_paginated_classrooms( $building_classrooms, $classrooms_page, $classrooms_per_page );
			?>

			<section class="building-classrooms mt-9">
				<h2 class="text-uppercase"><?php esc_html_e( 'Classrooms', 'ubc-vpfo-spaces-pages' ); ?><?php echo ' — ' . wp_kses_post( $building_name ); ?></h2>

				<div class="classroom-list" id="classroom-list">
					<?php
					foreach ( $paginated_classrooms as $classroom ) {
						load_template( plugin_dir_path( __DIR__ ) . 'templates/partials/classroom-card.php', false, array( 'classroom' => $classroom['fields'] ) );
					}
					?>
				</div>

				<?php if ( count( $building_classrooms ) >= $classrooms_per_page ) { ?>

					<div class="classroom-list-nav d-flex mt-9">
						<!-- Prev Page Link -->
						<a href="
						<?php
						// If $classrooms_page is 2 or less, remove the 'page' query arg and append '#classroom-list'
						if ( $classrooms_page <= 2 ) {
							// Remove 'page' query arg and append '#classroom-list'
							echo esc_url( remove_query_arg( 'page' ) . '#classroom-list' );
						} else {
							// Otherwise, link to the previous page with '#classroom-list'
							echo esc_url( add_query_arg( 'page', $classrooms_page - 1 ) . '#classroom-list' );
						}
						?>
						" class="btn btn-primary me-3" 
						<?php
						echo $classrooms_page <= 1 ? 'disabled' : '';
						?>
						>
							<i class="fas fa-chevron-left me-2"></i>
						<?php
						esc_html_e( 'Prev Page', 'ubc-vpfo-spaces-pages' );
						?>
						</a>

						<!-- Next Page Link -->
						<a href="
						<?php
						// If $classrooms_page is the last page, keep the query arg for the last page with '#classroom-list'
						if ( $classrooms_page === $max_pages ) {
							echo esc_url( add_query_arg( 'page', $max_pages ) . '#classroom-list' );
						} else {
							// Otherwise, link to the next page with '#classroom-list'
							echo esc_url( add_query_arg( 'page', $classrooms_page + 1 ) . '#classroom-list' );
						}
						?>
						" class="btn btn-primary" 
						<?php
						echo count( $paginated_classrooms ) < 12 || $classrooms_page === $max_pages ? 'disabled' : '';
						?>
						>
						<?php
						esc_html_e( 'Next Page', 'ubc-vpfo-spaces-pages' );
						?>
							<i class="fas fa-chevron-right ms-2"></i>
						</a>
					</div>
				<?php } ?>

			</section>
			<?php
		}
		?>

		<div class="pattern-slice position-relative mt-9">
			<div class="pattern-slice-gradient position-absolute h-100 w-100"></div>
		</div>
		
	</div>
</section>

<?php get_footer(); ?>