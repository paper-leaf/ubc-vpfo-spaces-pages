<?php get_header();

$classroom = $args['classroom'];
$classroom_fields = json_decode( wp_json_encode( $classroom->fields ), true );

$classroom_name = $classroom_fields['Name'] ?? null;

$classroom_building_name   = $classroom_fields['Building Name'] ?? null;
$classroom_building_code   = $classroom_fields['Building Code'] ?? null;
$classroom_building_title  = $classroom_building_name ?? '';
$classroom_building_title .= $classroom_building_code ? ' - ' . $classroom_building_code : '';

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

//dd ( $classroom_fields );
?>

<div class="vpfo-spaces-page">
	
</div>

<?php get_footer(); ?>