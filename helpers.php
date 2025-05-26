<?php
if (!defined('ABSPATH')) exit;

// Complete amenity/feature to icon mapping (FontAwesome 6+)
function repm_amenity_icon($amenity) {
    $icons = [
        'Gym' => 'fa-dumbbell',
        'Swimming Pool' => 'fa-person-swimming',
        'Garden' => 'fa-tree',
        'Wardrobe' => 'fa-vest',
        'Modular Kitchen' => 'fa-utensils',
        'Lift' => 'fa-elevator',
        'Parking' => 'fa-car',
        'CCTV' => 'fa-video',
        'Security' => 'fa-shield-halved',
        'Power Backup' => 'fa-bolt',
        'Play Area' => 'fa-children',
        'Club House' => 'fa-building-columns',
        'Near Metro' => 'fa-train-subway',
        'Near School' => 'fa-school',
        'Near Hospital' => 'fa-hospital',
        'Internet' => 'fa-wifi',
        'Fire Safety' => 'fa-fire-extinguisher',
        // Add all amenities/features here...
    ];
    return 'fa-solid ' . ($icons[$amenity] ?? 'fa-circle-check');
}

// Recommended properties utility function
function repm_get_recommended_properties($property_id, $limit = 4) {
    $city = get_post_meta($property_id, '_city', true);
    $type = get_post_meta($property_id, '_type_of_property', true);
    $bedrooms = get_post_meta($property_id, '_bedrooms', true);
    $price = get_post_meta($property_id, '_price', true);

    $meta_query = [
        'relation' => 'AND',
        [
            'key' => '_city',
            'value' => $city,
            'compare' => '='
        ],
        [
            'key' => '_type_of_property',
            'value' => $type,
            'compare' => '='
        ]
    ];
    if ($bedrooms) {
        $meta_query[] = [
            'key' => '_bedrooms',
            'value' => $bedrooms,
            'compare' => '='
        ];
    }
    if ($price) {
        $meta_query[] = [
            'key' => '_price',
            'value' => [$price * 0.9, $price * 1.1],
            'type' => 'NUMERIC',
            'compare' => 'BETWEEN'
        ];
    }

    $args = [
        'post_type' => 'property',
        'posts_per_page' => $limit,
        'post__not_in' => [$property_id],
        'meta_query' => $meta_query,
        'orderby' => 'rand'
    ];

    return new WP_Query($args);
}