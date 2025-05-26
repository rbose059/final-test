<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Register Property post type
add_action('init', function() {
    $labels = [
        'name' => 'Properties',
        'singular_name' => 'Property',
        'add_new' => 'Add Property',
        'add_new_item' => 'Add New Property',
        'edit_item' => 'Edit Property',
        'new_item' => 'New Property',
        'all_items' => 'All Properties',
        'view_item' => 'View Property',
        'search_items' => 'Search Properties',
        'not_found' =>  'No properties found',
        'menu_name' => 'Properties'
    ];
    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'rewrite' => ['slug' => 'properties'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'menu_icon' => 'dashicons-building',
    ];
    register_post_type('property', $args);
});

// Register taxonomies
add_action('init', function() {
    register_taxonomy(
        'property_city', 'property',
        [
            'label' => 'City',
            'rewrite' => ['slug' => 'property-city'],
            'hierarchical' => false,
            'show_in_rest' => true,
        ]
    );
    register_taxonomy(
        'property_type', 'property',
        [
            'label' => 'Type of Property',
            'rewrite' => ['slug' => 'property-type'],
            'hierarchical' => true,
            'show_in_rest' => true,
        ]
    );
    register_taxonomy(
        'property_amenities', 'property',
        [
            'label' => 'Amenities',
            'rewrite' => ['slug' => 'property-amenity'],
            'hierarchical' => false,
            'show_in_rest' => true,
        ]
    );
    // Add more taxonomies if desired
});