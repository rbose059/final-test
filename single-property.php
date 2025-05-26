<?php get_header(); global $post; ?>

<!-- Google Fonts: Poppins -->
<link href="https://fonts.googleapis.com/css?family=Poppins:400,500&display=swap" rel="stylesheet">
<!-- Swiper CSS for Modern Carousel -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<!-- PhotoSwipe CSS for fullscreen gallery -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.min.css">

<style>
body, .repm-single-property {
    font-family: 'Poppins', sans-serif;
}
.repm-single-property {
    max-width: 1100px;
    margin:  5px auto;
    background: #f7fafc;
    padding: 22px 10px 10px 10px;
    border-radius: 18px;
    box-shadow: 0 8px 40px 0 #bfc7d1;
    border: 2px solid #e0e6ed;
    margin-top: 10px;
    margin-bottom: 10px;
}
.repm-single-property h1 {
    font-size: 1.4rem;
    font-weight: 500;
    color: #1c3c7b;
    letter-spacing: 0.02em;
    margin-bottom: 0.4em;
}
.repm-carousel-box {
    border-radius: 18px;
    background: #fff;
    padding: 0;
    border: 2px solid #e0e6ed;
    margin-bottom: 20px;
    box-shadow: 0 6px 30px 0 #d2e0f5;
    position: relative;
    overflow: hidden;
}

.swiper {
    width: 100%;
    height: 370px;
    border-radius: 16px;
    margin: 0;
    padding: 0;
}
.swiper-slide {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f8fbff;
    border-radius: 0;
    margin: 0;
    padding: 0;
    height: 370px;
}

.repm-carousel-img {
    width: 100%;
    height: 370px;
    object-fit: cover;
    border-radius: 0;
    box-shadow: none;
    border: none;
    cursor: pointer;
    background: #fff;
    margin: 0;
    padding: 0;
    display: block;
    transition: box-shadow 0.18s;
}

@media (max-width:700px) {
    .swiper, .swiper-slide, .repm-carousel-img { height: 270px; }
}

.swiper-pagination-bullets {
    bottom: 11px !important;
    left: 0;
    width: 100%;
    text-align: center;
    padding: 0;
    margin: 0;
}
.swiper-pagination-bullet {
    background: #c9dafc !important;
    opacity: 1;
    width: 8px;
    height: 8px;
    margin: 0 2.5px !important;
    border: 1.5px solid #b3d0fa;
    transition: background 0.2s, border 0.2s;
    box-shadow: none;
}
.swiper-pagination-bullet-active {
    background: #3976e3 !important;
    border-color: #3976e3;
}
.swiper-button-next, .swiper-button-prev {
    display: none !important;
}
/* ... rest of your previous styles ... */

.repm-meta-box {
    display: flex;
    flex-wrap: wrap;
    gap: 10px 18px;
    background: #ffffff;
    border: 2px solid #e0e6ed;
    border-radius: 15px;
    box-shadow: 0 2px 12px #e6eaf7;
    padding: 12px 8px;
    margin-bottom: 17px;
    align-items: center;
    justify-content: flex-start;
}
.repm-meta-box-item {
    flex: 0 0 48%;
    display: flex;
    align-items: center;
    min-width: 120px;
    gap: 7px;
    font-size: 0.95em;
    color: #2450a8;
    margin-bottom: 3px;
    background: #f4f8fd;
    border-radius: 11px;
    padding: 7px 12px;
}
.repm-meta-box-item .fa {
    font-size: 1.2em;
    color: #e84a4a;
    margin-right: 6px;
}
.repm-meta-box-label {
    font-weight: 400;
    color: #5a6a7c;
    font-size: 0.85em;
}
.repm-meta-box-value {
    font-weight: 500;
    color: #1c3c7b;
    font-size: 1em;
}
@media (max-width: 600px) {
    .repm-meta-box-item { flex: 0 0 98%; font-size: 0.93em; }
    .repm-meta-box { gap: 5px 9px; }
}
.repm-tab-section {
    margin-bottom: 22px;
}
.repm-tabs {
    display: flex;
    border-bottom: 0;
    gap: 0.5em;
    margin-bottom: 0;
}
.repm-tabs .repm-tab-btn {
    border: 2px solid #e0e6ed;
    border-bottom: none;
    border-radius: 10px 10px 0 0;
    background: #f0f6fc;
    font-weight: 500;
    color: #2947b6;
    font-family: 'Poppins',sans-serif;
    font-size: 0.98rem;
    box-shadow: 0 1px 4px #e6eaf7;
    padding: 8px 18px;
    cursor: pointer;
    transition: background 0.15s, color 0.15s;
    outline: none;
}
.repm-tabs .repm-tab-btn.active, .repm-tabs .repm-tab-btn:focus, .repm-tabs .repm-tab-btn:hover {
    background: #2947b6;
    color: #fff !important;
    border-bottom: 2px solid #fff;
    box-shadow: 0 2px 14px #c3d8f2;
}
.repm-tabs-content {
    border: 2px solid #e0e6ed;
    border-radius: 0 0 14px 14px;
    background: linear-gradient(135deg, #f8fafd 85%, #f0f6fc 100%);
    box-shadow: 0 2px 10px #e8eef8;
    padding: 14px 24px 10px 24px;
    min-height: 120px;
    margin-top: 0;
}
@media (max-width:767px) {
    .repm-tabs .repm-tab-btn { font-size: 0.92rem; padding: 7px 10px;}
    .repm-tabs-content { padding: 8px 10px 7px 10px;}
}
.repm-list-no-bullet,
.repm-tabs-content ul,
.repm-tabs-content .list-group,
.repm-tabs-content .list-group-item {
    list-style: none !important;
    padding-left: 0 !important;
    margin-left: 0;
}
.repm-list-no-bullet .list-group-item {
    border: none !important;
    border-bottom: 1px solid #e8eaf6 !important;
    background: transparent !important;
    font-size: 0.78rem !important;
    padding: 5px 5px !important;
}
.repm-amenity-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
.badge.bg-primary, .repm-amenity-icon {
    background: transparent;
    box-shadow: none;
    border: none;
    font-size: 1em;
    color: #457b9d;
    padding: 0;
    margin-right: 5px;
    vertical-align: middle;
}
.section-bg {
    background: linear-gradient(135deg, #e9f4fc 70%, #f5fafe 100%);
    border-radius: 13px;
    box-shadow: 0 2px 12px #e1eaf7;
    padding: 11px 8px 8px 24px;
    margin-bottom: 17px;
    min-height: 90px;
}
.section-bg h5 {
    margin-top: 0;
    margin-bottom: .5em;
    color: #3577c3;
    font-size: 1em;
}
@media (max-width:767px) {
    .section-bg {
        padding: 7px 2px 5px 16px;
        margin-bottom: 10px;
    }
}

/* --- Modern Similar Properties Grid --- */
.similar-properties-modern-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(290px, 1fr));
    gap: 32px;
    margin-top: 24px;
    margin-bottom: 24px;
}
.similar-property-modern-card {
    background: #fff;
    border-radius: 20px;
    border: 1.5px solid #e4e8f0;
    box-shadow: 0 6px 32px 0 rgba(44,94,188,0.14), 0 1.5px 6px rgba(44,94,188,0.07);
    display: flex;
    flex-direction: column;
    overflow: hidden;
    margin-bottom: 0;
    transition: box-shadow 0.19s, border-color 0.18s;
    min-height: 410px;
    position: relative;
}
.similar-property-modern-card:hover {
    box-shadow: 0 12px 40px 0 rgba(18, 52, 102, 0.13);
    border-color: #3976e3;
}
.similar-property-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 18px 18px 0 0;
    background: #f3f7fa;
    border-bottom: 1.5px solid #e4e8f0;
}
.similar-property-body {
    flex: 1;
    display: flex;
    flex-direction: column;
    padding: 18px 18px 14px 18px;
}
.similar-property-title {
    font-size: 1.05rem;
    font-weight: 600;
    color: #22305f;
    margin-bottom: 0.2em;
    line-height: 1.2;
    margin-top: 0;
    min-height: 2.3em;
}
.similar-property-location {
    font-size: 0.89rem;
    color: #4677c7;
    margin-bottom: 6px;
}
.similar-property-location i {
    color: #3976e3;
    margin-right: 5px;
}
.similar-property-price {
    font-size: 1rem;
    font-weight: 600;
    color: #1ba672;
    margin-bottom: 6px;
    margin-top: 2px;
}
.similar-property-price i {
    color: #1ba672;
    margin-right: 5px;
}
.similar-property-excerpt {
    color: #5b5d6b;
    font-size: 0.98em;
    margin-bottom: 14px;
    min-height: 2.3em;
}
.similar-property-meta-row {
    display: flex;
    gap: 15px;
    margin-bottom: 8px;
}
.similar-property-meta-item {
    display: flex;
    align-items: center;
    gap: 5px;
    background: #f0f4fa;
    border-radius: 8px;
    padding: 7px 13px;
    font-size: 0.92em;
    color: #274a81;
    font-weight: 500;
}
.similar-property-meta-item i {
    color: #3976e3;
    margin-right: 2px;
}
.similar-property-btn {
    border-radius: 7px;
    font-size: 0.98em;
    padding: 10px 0;
    min-width: 80px;
    font-weight: 600;
    color: #3976e3;
    border: 2px solid #3976e3;
    background: #f8fcff;
    margin-top: auto;
    transition: background .17s, color .17s;
    text-align: center;
    margin-bottom: 0;
    margin-top: 13px;
    display: block;
    text-decoration: none;
}
.similar-property-btn:hover {
    background: #3976e3;
    color: #fff;
    border-color: #3976e3;
    text-decoration: none;
}
@media (max-width:991.98px) {
    .similar-properties-modern-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
}
@media (max-width: 575.98px) {
    .similar-properties-modern-grid {
        grid-template-columns: 1fr;
        gap: 14px;
        margin-left: 10px;
        margin-right: 10px;
    }
    .similar-property-modern-card {
        min-height: 340px;
        margin-top: 10px;
        margin-bottom: 10px;
        }
    .similar-property-image { height: 165px; }
    .similar-property-body { padding: 13px 8px 9px 10px; }
}
</style>

<main class="container py-4 repm-single-property">
    <!-- 1. Modern Swiper Carousel -->
    <div class="repm-carousel-box">
        <?php
        $main_img_id = get_post_thumbnail_id($post->ID);
        $imgs = get_post_meta($post->ID, '_property_image_id');
        $carousel_imgs = [];
        if ($main_img_id) $carousel_imgs[] = $main_img_id;
        if ($imgs) {
            foreach ($imgs as $img_id) {
                if ($img_id != $main_img_id) $carousel_imgs[] = $img_id;
            }
        }
        // Build PhotoSwipe items
        $pswp_items = [];
        foreach ($carousel_imgs as $img_id) {
            $src = wp_get_attachment_image_url($img_id, 'full');
            $meta = wp_get_attachment_metadata($img_id);
            $width = isset($meta['width']) ? $meta['width'] : 1200;
            $height = isset($meta['height']) ? $meta['height'] : 900;
            $pswp_items[] = [
                'src' => $src,
                'w' => $width,
                'h' => $height
            ];
        }
        ?>
        <?php if (!empty($carousel_imgs)) : ?>
            <div class="swiper repm-swiper-carousel">
                <div class="swiper-wrapper">
                <?php foreach ($carousel_imgs as $idx => $img_id): ?>
                    <div class="swiper-slide">
                        <img
                            src="<?php echo esc_url(wp_get_attachment_image_url($img_id, 'large')); ?>"
                            data-img-index="<?php echo $idx; ?>"
                            class="repm-carousel-img"
                            alt="Property Image"
                            loading="lazy"
                        />
                    </div>
                <?php endforeach; ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
        <?php endif; ?>
    </div>

    <!-- 2. Meta Box -->
    <div class="repm-meta-box mb-2">
        <div class="repm-meta-box-item">
            <i class="fa fa-bed"></i>
            <span class="repm-meta-box-label">Bedrooms:</span>
            <span class="repm-meta-box-value"><?php echo esc_html(get_post_meta($post->ID, '_bedrooms', true)); ?></span>
        </div>
        <div class="repm-meta-box-item">
            <i class="fa fa-bath"></i>
            <span class="repm-meta-box-label">Bathrooms:</span>
            <span class="repm-meta-box-value"><?php echo esc_html(get_post_meta($post->ID, '_bathrooms', true)); ?></span>
        </div>
        <div class="repm-meta-box-item">
            <i class="fa fa-expand"></i>
            <span class="repm-meta-box-label">Area:</span>
            <span class="repm-meta-box-value"><?php echo esc_html(get_post_meta($post->ID, '_carpet_area', true)); ?> sq ft</span>
        </div>
        <div class="repm-meta-box-item">
            <i class="fa fa-user-shield"></i>
            <span class="repm-meta-box-label">Ownership:</span>
            <span class="repm-meta-box-value"><?php echo esc_html(get_post_meta($post->ID, '_ownership', true)); ?></span>
        </div>
    </div>

    <!-- 3. Property Name and Price -->
    <h1><?php the_title(); ?></h1>
    <div style="font-size:1.18em;font-weight:600;color:#1ba672;margin-bottom:18px;">
        <?php
            $price = get_post_meta($post->ID, '_price', true);
            echo $price ? '₹' . repm_format_indian_currency($price) : 'Price on Request';
        ?>
    </div>

    <!-- 4. Tabs for Overview and Amenities -->
   <div class="repm-tab-section">
    <div class="repm-tabs">
        <button type="button" class="repm-tab-btn active" data-target="repm-overview">Overview</button>
        <button type="button" class="repm-tab-btn" data-target="repm-amenities">Amenities</button>
    </div>
    <div class="repm-tabs-content">
        <div class="repm-tab-pane" id="repm-overview" style="display:block">
            <div class="row" style="gap:10px;">
                <div class="col-md-12 repm-list-no-bullet">
                    <h5>Property Details</h5>
                    <ul class="list-group mb-2">
                        <?php
                        $for_sale_rent = strtolower(get_post_meta($post->ID, '_for_sale_rent', true));
                        $ownership = get_post_meta($post->ID, '_ownership', true);
                        $type_of_property = strtolower(get_post_meta($post->ID, '_type_of_property', true));
                        ?>
                        <li class="list-group-item"><strong>Property Name:</strong> <?php the_title(); ?></li>
                        <li class="list-group-item"><strong>For Sale/Rent:</strong> <?php echo esc_html(ucwords($for_sale_rent)); ?></li>
                        <li class="list-group-item"><strong>Type of Property:</strong> <?php echo esc_html(ucwords($type_of_property)); ?></li>
                        <?php if ($type_of_property === 'residential'): ?>
                            <li class="list-group-item"><strong>Type of Residential Property:</strong> <?php echo esc_html(get_post_meta($post->ID, '_type_of_residential_property', true)); ?></li>
                        <?php endif; ?>
                        <?php if ($type_of_property === 'commercial'): ?>
                            <li class="list-group-item"><strong>Type of Commercial Property:</strong> <?php echo esc_html(get_post_meta($post->ID, '_type_of_commercial_property', true)); ?></li>
                        <?php endif; ?>
                        <?php if ($for_sale_rent === 'sale'): ?>
                            <li class="list-group-item"><strong>Bedrooms:</strong> <?php echo esc_html(get_post_meta($post->ID, '_bedrooms', true)); ?></li>
                            <li class="list-group-item"><strong>Bathrooms:</strong> <?php echo esc_html(get_post_meta($post->ID, '_bathrooms', true)); ?></li>
                            <li class="list-group-item"><strong>Balconies:</strong> <?php echo esc_html(get_post_meta($post->ID, '_balconies', true)); ?></li>
                        <?php endif; ?>
                        <li class="list-group-item"><strong>Carpet Area (sq ft):</strong> <?php echo esc_html(get_post_meta($post->ID, '_carpet_area', true)); ?></li>
                        <?php if ($for_sale_rent === 'sale'): ?>
                            <li class="list-group-item"><strong>Built-up Area (sq ft):</strong> <?php echo esc_html(get_post_meta($post->ID, '_builtup_area', true)); ?></li>
                            <li class="list-group-item"><strong>Super Built-up Area (sq ft):</strong> <?php echo esc_html(get_post_meta($post->ID, '_super_builtup_area', true)); ?></li>
                        <?php endif; ?>
                        <li class="list-group-item"><strong>Total Floors:</strong> <?php echo esc_html(get_post_meta($post->ID, '_total_floors', true)); ?></li>
                        <li class="list-group-item"><strong>Property on Floor:</strong> <?php echo esc_html(get_post_meta($post->ID, '_property_on_floor', true)); ?></li>
                        <li class="list-group-item"><strong>Availability Status:</strong> <?php echo esc_html(get_post_meta($post->ID, '_availability_status', true)); ?></li>
                        <li class="list-group-item"><strong>Age of Property:</strong> <?php echo esc_html(get_post_meta($post->ID, '_age_of_property', true)); ?></li>
                        <li class="list-group-item"><strong>Ownership:</strong> <?php echo esc_html($ownership); ?></li>
                        <?php if ($for_sale_rent === 'sale' && strtolower($ownership) === 'leasehold'): ?>
                            <li class="list-group-item"><strong>Leasehold Authority:</strong> <?php echo esc_html(get_post_meta($post->ID, '_leasehold_authority', true)); ?></li>
                        <?php endif; ?>
                        <li class="list-group-item"><strong>Furnishing:</strong> <?php echo esc_html(get_post_meta($post->ID, '_furnishing', true)); ?></li>
                        <li class="list-group-item"><strong>Furnishing Details:</strong>
                            <?php
                            $details = get_post_meta($post->ID, '_furnishing_details', true);
                            if ($details && is_array($details)) echo esc_html(implode(', ', $details));
                            elseif ($details) echo esc_html($details);
                            ?>
                        </li>
                        <li class="list-group-item"><strong>Covered Parking:</strong> <?php echo esc_html(get_post_meta($post->ID, '_covered_parking', true)); ?></li>
                        <li class="list-group-item"><strong>Number of Covered Parking:</strong> <?php echo esc_html(get_post_meta($post->ID, '_covered_parking_count', true)); ?></li>
                        <li class="list-group-item"><strong>Open Parking:</strong> <?php echo esc_html(get_post_meta($post->ID, '_open_parking', true)); ?></li>
                        <li class="list-group-item"><strong>Water Source:</strong> <?php echo esc_html(get_post_meta($post->ID, '_water_source', true)); ?></li>
                        <li class="list-group-item"><strong>Price:</strong> ₹<?php echo repm_format_indian_currency(esc_html(get_post_meta($post->ID, '_price', true))); ?></li>
                        <?php if ($for_sale_rent === 'sale'): ?>
                            <li class="list-group-item"><strong>All inclusive Price:</strong>
                                <?php echo get_post_meta($post->ID, '_all_inclusive_price', true) == '1' ? 'Yes' : 'No'; ?>
                            </li>
                            <li class="list-group-item"><strong>Price Negotiable:</strong>
                                <?php echo get_post_meta($post->ID, '_price_negotiable', true) == '1' ? 'Yes' : 'No'; ?>
                            </li>
                            <li class="list-group-item"><strong>Tax & Govt. charges excluded:</strong>
                                <?php echo get_post_meta($post->ID, '_tax_excluded', true) == '1' ? 'Yes' : 'No'; ?>
                            </li>
                        <?php endif; ?>
                        <?php if ($for_sale_rent === 'rent') : ?>
                            <?php
                            $maintenance_inclusion = get_post_meta($post->ID, '_maintenance_inclusion', true);
                            $monthly_maintenance = get_post_meta($post->ID, '_monthly_maintenance', true);
                            ?>
                            <li class="list-group-item">
                                <strong>Maintenance:</strong>
                                <?php
                                if ($maintenance_inclusion === 'including') {
                                    echo "Including Maintenance";
                                } elseif ($maintenance_inclusion === 'excluding') {
                                    echo "Excluding Maintenance";
                                    if ($monthly_maintenance) {
                                        echo " (₹" . repm_format_indian_currency($monthly_maintenance) . " / month)";
                                    }
                                } else {
                                    echo "-";
                                }
                                ?>
                            </li>
                        <?php endif; ?>
                        <li class="list-group-item"><strong>City:</strong> <?php echo esc_html(join(', ', wp_get_post_terms($post->ID, 'property_city', ['fields'=>'names']))); ?></li>
                        <li class="list-group-item"><strong>Address:</strong>
                            <?php
                            $addr1 = get_post_meta($post->ID, '_address_line_1', true);
                            $addr2 = get_post_meta($post->ID, '_address_line_2', true);
                            if ($addr1) echo esc_html($addr1);
                            if ($addr2) echo ', ' . esc_html($addr2);
                            ?>
                        </li>
                        <li class="list-group-item"><strong>Location Advantages:</strong>
                            <?php
                            $advantages = get_post_meta($post->ID, '_location_advantages', true);
                            if ($advantages && is_array($advantages)) echo esc_html(implode(', ', $advantages));
                            elseif ($advantages) echo esc_html($advantages);
                            ?>
                        </li>
                        <li class="list-group-item"><strong>Nearby Schools, Markets, etc.:</strong>
                            <?php echo esc_html(get_post_meta($post->ID, '_nearby_places', true)); ?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
            <div class="repm-tab-pane" id="repm-amenities" style="display:none">
                <div class="section-bg">
                    <h5>Amenities</h5>
                    <div class="repm-amenity-list">
                        <?php
                        $amenities = wp_get_post_terms($post->ID, 'property_amenities', ['fields'=>'names']);
                        $icon_map = [
                            'Gym' => 'fa-dumbbell',
                            'Swimming Pool' => 'fa-swimming-pool',
                            'Garden' => 'fa-seedling',
                            'Lift' => 'fa-elevator',
                            'Parking' => 'fa-square-parking',
                            'CCTV' => 'fa-video',
                            'Security' => 'fa-shield-halved',
                            'Power Backup' => 'fa-bolt',
                            'Play Area' => 'fa-child',
                            'Club House' => 'fa-chess-rook',
                            'Internet' => 'fa-wifi',
                            'Fire Safety' => 'fa-fire-extinguisher'
                        ];
                        if ($amenities) foreach ($amenities as $amenity) {
                            $icon = isset($icon_map[$amenity]) ? $icon_map[$amenity] : 'fa-circle';
                            echo '<span class="badge bg-primary m-1 repm-amenity-icon"><i class="fa '.$icon.'" title="'.esc_attr($amenity).'"></i> '.esc_html($amenity).'</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 5. Description -->
    <div class="section-bg mt-1">
        <h5>Description</h5>
        <?php the_content(); ?>
    </div>

    <!-- 6. Location -->
    <div class="section-bg mt-1">
        <h5>Location</h5>
        <?php
            $addr1 = get_post_meta($post->ID, '_address_line_1', true);
            $addr2 = get_post_meta($post->ID, '_address_line_2', true);
            if ($addr1) echo esc_html($addr1);
            if ($addr2) echo ', ' . esc_html($addr2);
        ?>
    </div>

    <!-- 7. Map -->
    <div class="section-bg mt-1">
        <h5>Map View</h5>
        <?php
        $map_address = '';
        $addr1 = get_post_meta($post->ID, '_address_line_1', true);
        $addr2 = get_post_meta($post->ID, '_address_line_2', true);
        if ($map_address = trim($addr1 . ', ' . $addr2, ', ')):
        ?>
        <div class="ratio ratio-16x9">
            <iframe 
                src="https://www.google.com/maps?q=<?php echo urlencode($map_address); ?>&output=embed"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
            </iframe>
        </div>
        <?php else: ?>
            <p class="text-muted">No address provided for map view.</p>
        <?php endif; ?>
    </div>
    
    <!-- --- Fluent Forms Section (ID=3) --- -->
    <div class="section-bg mt-4" style="margin-bottom:36px; margin-top: 10px;">
        <?php {
            echo do_shortcode('[fluentform id="3"]');
        }
        ?>
    </div>
    
    <?php
    // --- Modern Similar Properties Grid ---
    $city = get_post_meta($post->ID, '_city', true);
    $type = get_post_meta($post->ID, '_type_of_property', true);
    $args = [
        'post_type' => 'property',
        'posts_per_page' => 3,
        'post__not_in' => [$post->ID],
        'meta_query' => [
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
        ]
    ];
    $recommended = new WP_Query($args);
    if ($recommended->have_posts()) :
    ?>
    <h4 style="font-family:'Poppins',Arial,sans-serif;margin-top:36px;font-weight:500;color:#253858;">Similar Properties</h4>
    <div class="similar-properties-modern-grid">
        <?php
        while ($recommended->have_posts()): $recommended->the_post();
            $price = get_post_meta(get_the_ID(), '_price', true);
            $city = get_post_meta(get_the_ID(), '_city', true);
            $bedrooms = get_post_meta(get_the_ID(), '_bedrooms', true);
            $bathrooms = get_post_meta(get_the_ID(), '_bathrooms', true);
            $area = get_post_meta(get_the_ID(), '_carpet_area', true);
        ?>
        <div class="similar-property-modern-card">
            <?php if (has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(),'medium_large')); ?>" class="similar-property-image" alt="<?php the_title_attribute(); ?>" loading="lazy"/>
                </a>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>">
                    <div class="similar-property-image" style="background:#f6f6fa;display:flex;align-items:center;justify-content:center;color:#b8bfc9;font-size:2em;">
                        <i class="fa fa-image"></i>
                    </div>
                </a>
            <?php endif; ?>
            <div class="similar-property-body">
                <div class="similar-property-title"><?php the_title(); ?></div>
                <div class="similar-property-location"><i class="fa fa-map-marker-alt"></i> <?php echo esc_html($city); ?></div>
                <div class="similar-property-price"><i class="fa fa-tag"></i> <?php echo esc_html($price ? '₹' . repm_format_indian_currency($price) : 'Price on Request'); ?></div>
                <div class="similar-property-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></div>
                <div class="similar-property-meta-row">
                    <div class="similar-property-meta-item" title="Bedrooms">
                        <i class="fa fa-bed"></i> <?php echo esc_html($bedrooms); ?>
                    </div>
                    <div class="similar-property-meta-item" title="Bathrooms">
                        <i class="fa fa-bath"></i> <?php echo esc_html($bathrooms); ?>
                    </div>
                    <div class="similar-property-meta-item" title="Area">
                        <i class="fa fa-expand"></i> <?php echo esc_html($area); ?> sq ft
                    </div>
                </div>
                <a href="<?php the_permalink(); ?>" class="similar-property-btn">View Details</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    <?php
        wp_reset_postdata();
    endif;
    ?>

</main>

<!-- Swiper JS for Modern Carousel -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<!-- jQuery (for backward compatibility, can be removed if not needed elsewhere) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- FontAwesome CDN (for amenities icons) -->
<script src="https://kit.fontawesome.com/3d8c52a4b8.js" crossorigin="anonymous"></script>
<!-- PhotoSwipe JS -->
<script src="https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe-lightbox.umd.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Swiper for modern carousel
    const swiper = new Swiper('.repm-swiper-carousel', {
        slidesPerView: 1,
        spaceBetween: 0,
        loop: true,
        centeredSlides: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        effect: "slide"
    });

    // PhotoSwipe for fullscreen images
    <?php if (!empty($carousel_imgs)): ?>
    var pswpItems = <?php echo json_encode($pswp_items); ?>;
    let lightbox = null;
    document.querySelectorAll('.repm-carousel-img').forEach(function(img, idx){
        img.addEventListener('click', function(){
            if (typeof PhotoSwipeLightbox === "function" && pswpItems.length) {
                if (!lightbox) {
                    lightbox = new PhotoSwipeLightbox({
                        dataSource: pswpItems,
                        pswpModule: () => import('https://cdn.jsdelivr.net/npm/photoswipe@5/dist/photoswipe.esm.min.js')
                    });
                    lightbox.init();
                }
                lightbox.loadAndOpen(idx);
            }
        });
    });
    <?php endif; ?>

    // Custom Tabs
    document.querySelectorAll('.repm-tab-btn').forEach(function(btn){
        btn.addEventListener('click', function() {
            document.querySelectorAll('.repm-tab-btn').forEach(function(b){ b.classList.remove('active'); });
            this.classList.add('active');
            var target = this.getAttribute('data-target');
            document.querySelectorAll('.repm-tab-pane').forEach(function(pane){ pane.style.display = "none"; });
            document.getElementById(target).style.display = "block";
        });
    });
    // Ensure only first tab pane is shown at load
    document.querySelectorAll('.repm-tab-pane').forEach(function(pane){ pane.style.display = "none"; });
    var firstTab = document.getElementById("repm-overview");
    if(firstTab) firstTab.style.display = "block";
});
</script>

<?php get_footer(); ?>