<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Meta fields array for easy access
function repm_fields() {
    return [
        'for_sale_rent', 'type_of_property', 'type_of_residential_property', 'type_of_commercial_property',
        'bedrooms', 'bathrooms', 'balconies', 'availability_status', 'carpet_area',
        'builtup_area', 'super_builtup_area',
        'total_floors', 'property_on_floor',
        'age_of_property', 'ownership',
        'leasehold_authority',
        'price',
        'all_inclusive_price', 'price_negotiable', 'tax_excluded',
        'furnishing', 'furnishing_details', 'covered_parking', 'covered_parking_count', 'open_parking',
        'water_source', 'location_advantages', 'nearby_places',
        'address_line_1', 'address_line_2',
        'maintenance_inclusion', 'monthly_maintenance'
    ];
}

// Add meta boxes
add_action('add_meta_boxes', function() {
    add_meta_box('repm_details', 'Property Details', 'repm_meta_box_cb', 'property', 'normal', 'high');
});
function repm_meta_box_cb($post) {
    $fields = repm_fields();
    foreach ($fields as $field) {
        $val = get_post_meta($post->ID, "_$field", true);
        // Render checkboxes for boolean fields
        if (in_array($field, ['all_inclusive_price', 'price_negotiable', 'tax_excluded'])) {
            echo "<p><label style='width:160px;display:inline-block'>".ucwords(str_replace('_',' ', $field))."</label>";
            echo "<input type='checkbox' name='$field' value='1' ".checked($val, '1', false)." /></p>";
        }
        // Render dropdown for leasehold authority
        elseif ($field === 'leasehold_authority') {
            echo "<p><label style='width:160px;display:inline-block'>Leasehold Authority</label>";
            echo "<select name='leasehold_authority'>
                    <option value=''>Select Authority</option>
                    <option value='Noida Authority' ".selected($val, 'Noida Authority', false).">Noida Authority</option>
                    <option value='Greater Noida Authority' ".selected($val, 'Greater Noida Authority', false).">Greater Noida Authority</option>
                    <option value='YEIDA Authority' ".selected($val, 'YEIDA Authority', false).">YEIDA Authority</option>
                  </select></p>";
        }
        // Render dropdown for covered_parking_count
        elseif ($field === 'covered_parking_count') {
            echo "<p><label style='width:160px;display:inline-block'>Number of Covered Parking</label>";
            echo "<select name='covered_parking_count'>
                    <option value=''>Select</option>
                    <option value='1' ".selected($val, '1', false).">1</option>
                    <option value='2' ".selected($val, '2', false).">2</option>
                  </select></p>";
        }
        // Render textarea for nearby_places
        elseif ($field === 'nearby_places') {
            echo "<p><label style='width:160px;display:inline-block'>Nearby Schools, Markets, etc.</label>";
            echo "<textarea name='nearby_places' rows='2' cols='30'>".esc_textarea($val)."</textarea></p>";
        }
        // Render textarea for location_advantages
        elseif ($field === 'location_advantages') {
            echo "<p><label style='width:160px;display:inline-block'>Location Advantages</label>";
            echo "<textarea name='location_advantages' rows='2' cols='30'>".esc_textarea($val)."</textarea></p>";
        }
        // Render furnishing_details as comma-separated
        elseif ($field === 'furnishing_details') {
            echo "<p><label style='width:160px;display:inline-block'>Furnishing Details</label>";
            echo "<input type='text' name='furnishing_details' value='".esc_attr($val)."' size='30' placeholder='Comma separated'/></p>";
        }
        else {
            echo "<p><label style='width:160px;display:inline-block'>".ucwords(str_replace('_',' ', $field))."</label>";
            echo "<input type='text' name='$field' value='".esc_attr($val)."' size='30'/></p>";
        }
    }
}

// Save meta
add_action('save_post_property', function($post_id) {
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;
    foreach (repm_fields() as $field) {
        if (isset($_POST[$field]))
            update_post_meta($post_id, "_$field", sanitize_text_field($_POST[$field]));
    }
});

// Add this to your meta-boxes.php file
add_action('add_meta_boxes', function() {
    add_meta_box('repm_featured', 'Featured Property', function($post) {
        $is_featured = get_post_meta($post->ID, '_is_featured', true);
        echo '<label><input type="checkbox" name="is_featured" value="1" '.checked($is_featured, '1', false).' /> Mark as Featured</label>';
    }, 'property', 'side', 'high');
});

// Save meta
add_action('save_post_property', function($post_id) {
    if (isset($_POST['is_featured']))
        update_post_meta($post_id, '_is_featured', '1');
    else
        delete_post_meta($post_id, '_is_featured');
});