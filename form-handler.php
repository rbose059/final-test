<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// Helper function for Indian number formatting
if (!function_exists('repm_format_indian_currency')) {
    function repm_format_indian_currency($number) {
        $number = preg_replace('/[^0-9]/', '', (string) $number); // Remove any non-numeric characters
        $len = strlen($number);
        if($len > 3) {
            $last3 = substr($number, -3);
            $restUnits = substr($number, 0, -3);
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            return $restUnits . "," . $last3;
        } else {
            return $number;
        }
    }
}

// Property submission (AJAX)
add_action('wp_ajax_repm_submit_property', 'repm_submit_property');
add_action('wp_ajax_nopriv_repm_submit_property', 'repm_submit_property');
function repm_submit_property() {
    check_ajax_referer('repm_nonce', 'nonce');
    $data = $_POST;
    $errors = [];

    // Required fields (base)
    $required = [
        'property_name' => 'Property name is required.',
        'property_description' => 'Description is required.',
        'city' => 'City is required.',
        'address_line_1' => 'Address Line 1 is required.',
        'for_sale_rent' => 'Please select sale or rent.',
        'type_of_property' => 'Please select property type.',
        'availability_status' => 'Please select availability status.',
        'carpet_area' => 'Please enter carpet area.',
        'total_floors' => 'Please enter total floors.',
        'property_on_floor' => 'Please enter property on floor.',
        'age_of_property' => 'Please select age of property.',
        'ownership' => 'Please select ownership.',
        'price' => 'Please enter the price.',
        'furnishing' => 'Please select furnishing.',
        'water_source' => 'Please select water source.',
        // new: make this required if you want
        // 'nearby_places' => 'Please provide information about nearby schools, markets, etc.',
    ];

    // Sale-specific fields (only validate if sale is selected)
    if (!empty($data['for_sale_rent']) && $data['for_sale_rent'] === 'sale') {
        if (!empty($data['type_of_property']) && $data['type_of_property'] === 'residential') {
            $required['bedrooms'] = 'Please select number of bedrooms.';
            $required['bathrooms'] = 'Please select number of bathrooms.';
        }
        // Now builtup_area & super_builtup_area are required for Sale
        $required['builtup_area'] = 'Please enter built-up area.';
        $required['super_builtup_area'] = 'Please enter super built-up area.';
        // Leasehold Authority required only if Sale + Leasehold
        if (!empty($data['ownership']) && strtolower($data['ownership']) === 'leasehold') {
            $required['leasehold_authority'] = 'Please select leasehold authority.';
        }
    }

    // Built-up areas: must be numeric if present
    if (!empty($data['builtup_area']) && !is_numeric(str_replace(',', '', $data['builtup_area']))) {
        $errors['builtup_area'] = 'Built-up Area must be numeric.';
    }
    if (!empty($data['super_builtup_area']) && !is_numeric(str_replace(',', '', $data['super_builtup_area']))) {
        $errors['super_builtup_area'] = 'Super Built-up Area must be numeric.';
    }

    // Maintenance validation (only for Rent)
    if (!empty($data['for_sale_rent']) && $data['for_sale_rent'] === 'rent') {
        $required['maintenance_inclusion'] = 'Please select maintenance option.';
        if (
            !empty($data['maintenance_inclusion']) &&
            $data['maintenance_inclusion'] === 'excluding'
        ) {
            $required['monthly_maintenance'] = 'Please enter the monthly maintenance amount.';
        }
    }

    // Covered Parking: if Yes, covered_parking_count required
    if (!empty($data['covered_parking']) && $data['covered_parking'] === 'Yes') {
        $required['covered_parking_count'] = 'Please select number of covered parking.';
    }

    foreach ($required as $field => $error) {
        if (empty($data[$field])) {
            $errors[$field] = $error;
        }
    }

    if (!empty($errors)) {
        wp_send_json_error(['errors' => $errors]);
    }

    $post_id = wp_insert_post([
        'post_title'   => sanitize_text_field($data['property_name']),
        'post_content' => sanitize_textarea_field($data['property_description']),
        'post_type'    => 'property',
        'post_status'  => 'publish',
    ]);
    if (is_wp_error($post_id) || !$post_id) {
        wp_send_json_error(['errors'=>['main'=>'Unable to create property.']]);
    }

    // If Rent is selected, clear all sale-only fields to avoid stale data
    if (!empty($data['for_sale_rent']) && $data['for_sale_rent'] === 'rent') {
        $data['builtup_area'] = '';
        $data['super_builtup_area'] = '';
        $data['leasehold_authority'] = '';
        $data['all_inclusive_price'] = '';
        $data['price_negotiable'] = '';
        $data['tax_excluded'] = '';
    }

    // Save meta fields, handle price/monthly_maintenance/built-up areas as numbers
    foreach ($data as $key => $val) {
        if (is_array($val)) $val = implode(',', array_map('sanitize_text_field', (array)$val));
        if (in_array($key, ['price', 'monthly_maintenance', 'builtup_area', 'super_builtup_area'])) $val = str_replace(',', '', $val);
        update_post_meta($post_id, '_' . $key, sanitize_text_field($val));
    }
    // Save price option checkboxes (as 1 or 0)
    $checkboxes = ['all_inclusive_price', 'price_negotiable', 'tax_excluded'];
    foreach ($checkboxes as $cb) {
        update_post_meta($post_id, '_' . $cb, !empty($data[$cb]) ? '1' : '0');
    }

    // Set taxonomies
    wp_set_post_terms($post_id, [$data['city']], 'property_city');

    // Properly assign property_type by slug for compatibility with filters
    $type_slug = sanitize_title($data['type_of_property']);
    $type_term = get_term_by('slug', $type_slug, 'property_type');
    if ($type_term && !is_wp_error($type_term)) {
        wp_set_post_terms($post_id, [$type_term->term_id], 'property_type');
    } else {
        // fallback: try by name (legacy)
        wp_set_post_terms($post_id, [$data['type_of_property']], 'property_type');
    }

    if (!empty($data['amenities'])) {
        wp_set_post_terms($post_id, array_map('sanitize_text_field', (array)$data['amenities']), 'property_amenities');
    }

    // Handle images with featured selection
    $featured_index = isset($_POST['featured_image_index']) ? intval($_POST['featured_image_index']) : 0;
    if (!empty($_FILES['property_images'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $files = $_FILES['property_images'];
        $n = count($files['name']);
        for ($i=0; $i<$n; $i++) {
            if ($files['name'][$i]) {
                $file = [
                    'name'     => $files['name'][$i],
                    'type'     => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error'    => $files['error'][$i],
                    'size'     => $files['size'][$i]
                ];
                $upload = media_handle_sideload($file, $post_id);
                if (is_wp_error($upload)) continue;
                add_post_meta($post_id, '_property_image_id', $upload);
                if ($i == $featured_index) set_post_thumbnail($post_id, $upload);
            }
        }
    }

    wp_send_json_success(['message' => 'Property submitted!', 'post_id' => $post_id]);
}

// Advanced property filtering (AJAX + archive)
add_action('wp_ajax_repm_filter_properties', 'repm_filter_properties');
add_action('wp_ajax_nopriv_repm_filter_properties', 'repm_filter_properties');
function repm_filter_properties() {
    $args = [
        'post_type' => 'property',
        'posts_per_page' => 12,
        'orderby' => 'date',
        'order' => 'DESC'
    ];

    $meta_query = [];
    $tax_query = [];

    // City (taxonomy)
    if (!empty($_GET['city'])) {
        $tax_query[] = [
            'taxonomy' => 'property_city',
            'field' => 'name',
            'terms' => sanitize_text_field($_GET['city'])
        ];
    }

    // Type (taxonomy) - improved: force slug, and fallback to name if needed
    if (!empty($_GET['type'])) {
        $type_slug = sanitize_title($_GET['type']);
        $type_term = get_term_by('slug', $type_slug, 'property_type');
        if ($type_term && !is_wp_error($type_term)) {
            $tax_query[] = [
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => $type_slug
            ];
        } else {
            // fallback: try by name
            $tax_query[] = [
                'taxonomy' => 'property_type',
                'field' => 'name',
                'terms' => sanitize_text_field($_GET['type'])
            ];
        }
        // Property subtype filter (meta query) - only apply correct subtype for selected type
        if ($_GET['type'] === 'residential' && !empty($_GET['type_of_residential_property'])) {
            $meta_query[] = [
                'key' => '_type_of_residential_property',
                'value' => sanitize_text_field($_GET['type_of_residential_property']),
                'compare' => '='
            ];
        }
        if ($_GET['type'] === 'commercial' && !empty($_GET['type_of_commercial_property'])) {
            $meta_query[] = [
                'key' => '_type_of_commercial_property',
                'value' => sanitize_text_field($_GET['type_of_commercial_property']),
                'compare' => '='
            ];
        }
    }

    // Price range (meta query)
    if (!empty($_GET['min_price'])) {
        $meta_query[] = [
            'key' => '_price',
            'value' => floatval(str_replace(',', '', $_GET['min_price'])),
            'type' => 'NUMERIC',
            'compare' => '>='
        ];
    }
    if (!empty($_GET['max_price'])) {
        $meta_query[] = [
            'key' => '_price',
            'value' => floatval(str_replace(',', '', $_GET['max_price'])),
            'type' => 'NUMERIC',
            'compare' => '<='
        ];
    }
    // Bedrooms (meta query) - support "5+"
    if (!empty($_GET['bedrooms'])) {
        if ($_GET['bedrooms'] === '5+') {
            $meta_query[] = [
                'key' => '_bedrooms',
                'value' => 5,
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        } else {
            $meta_query[] = [
                'key' => '_bedrooms',
                'value' => intval($_GET['bedrooms']),
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        }
    }
    // Bathrooms (meta query) - support "5+"
    if (!empty($_GET['bathrooms'])) {
        if ($_GET['bathrooms'] === '5+') {
            $meta_query[] = [
                'key' => '_bathrooms',
                'value' => 5,
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        } else {
            $meta_query[] = [
                'key' => '_bathrooms',
                'value' => intval($_GET['bathrooms']),
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        }
    }
    // Balconies (meta query) - support "4+"
    if (!empty($_GET['balconies'])) {
        if ($_GET['balconies'] === '4+') {
            $meta_query[] = [
                'key' => '_balconies',
                'value' => 4,
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        } else {
            $meta_query[] = [
                'key' => '_balconies',
                'value' => intval($_GET['balconies']),
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        }
    }
    // Sorting
    if (!empty($_GET['sort'])) {
        switch ($_GET['sort']) {
            case 'price_asc':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'ASC';
                break;
            case 'price_desc':
                $args['orderby'] = 'meta_value_num';
                $args['meta_key'] = '_price';
                $args['order'] = 'DESC';
                break;
            case 'date_asc':
                $args['orderby'] = 'date';
                $args['order'] = 'ASC';
                break;
            case 'date_desc':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
        }
    }

    if (!empty($meta_query)) {
        if (count($meta_query) > 1) $meta_query['relation'] = 'AND';
        $args['meta_query'] = $meta_query;
    }
    if (!empty($tax_query)) {
        if (count($tax_query) > 1) $tax_query['relation'] = 'AND';
        $args['tax_query'] = $tax_query;
    }

    $props = new WP_Query($args);
    ob_start();
    ?>
    <div class="swiper property-swiper">
        <div class="swiper-wrapper">
            <?php
            if ($props->have_posts()) :
                while ($props->have_posts()): $props->the_post();
                    $price = get_post_meta(get_the_ID(), '_price', true);
                    $city = get_post_meta(get_the_ID(), '_city', true);
                    $bedrooms = get_post_meta(get_the_ID(), '_bedrooms', true);
                    $bathrooms = get_post_meta(get_the_ID(), '_bathrooms', true);
                    $area = get_post_meta(get_the_ID(), '_carpet_area', true);
                    ?>
                    <div class="swiper-slide">
                        <div class="repm-property-card">
                            <?php if (has_post_thumbnail()) : ?>
                                <div style="margin-bottom:12px;">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', [
                                            'class'=>'img-fluid rounded',
                                            'style'=>'width:100%;height:200px;object-fit:cover;'
                                        ]); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <div class="repm-property-title"><?php the_title(); ?></div>
                            <div class="repm-property-location"><i class="fa fa-map-marker-alt"></i> <?php echo esc_html($city); ?></div>
                            <div class="repm-property-price"><i class="fa fa-tag"></i> <?php echo esc_html($price ? '₹' . repm_format_indian_currency($price) : 'Price on Request'); ?></div>
                            <div class="repm-property-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></div>
                            <div class="repm-meta-box mb-2 mt-auto">
                                <div class="repm-meta-box-item" title="Bedrooms">
                                    <i class="fa fa-bed"></i>
                                    <span class="repm-meta-box-value"><?php echo esc_html($bedrooms); ?></span>
                                </div>
                                <div class="repm-meta-box-item" title="Bathrooms">
                                    <i class="fa fa-bath"></i>
                                    <span class="repm-meta-box-value"><?php echo esc_html($bathrooms); ?></span>
                                </div>
                                <div class="repm-meta-box-item" title="Area">
                                    <i class="fa fa-expand"></i>
                                    <span class="repm-meta-box-value"><?php echo esc_html($area); ?> sq ft</span>
                                </div>
                            </div>
                            <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm align-self-start">View Details</a>
                        </div>
                    </div>
                <?php endwhile;
                wp_reset_postdata();
            else:
                echo '<div class="swiper-slide"><div class="alert alert-info">No properties found.</div></div>';
            endif;
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
    <script>
    if (typeof Swiper !== "undefined" && document.querySelector('.property-swiper')) {
        new Swiper('.property-swiper', {
            slidesPerView: 3,
            spaceBetween: 30,
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            breakpoints: {
                0: { slidesPerView: 1 },
                768: { slidesPerView: 2 },
                992: { slidesPerView: 3 }
            }
        });
    }
    </script>
    <?php
    echo ob_get_clean();
    wp_die();
}