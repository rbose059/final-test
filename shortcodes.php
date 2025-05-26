<?php
    if ( ! defined( 'ABSPATH' ) ) exit;
    
    // --- Indian currency formatting helper ---
    if (!function_exists('repm_format_indian_currency')) {
        function repm_format_indian_currency($number) {
            $number = preg_replace('/[^0-9]/', '', (string) $number); // Remove non-numeric
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
    
    add_shortcode('property_submission_form', function() {
        ob_start(); ?>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600&display=swap" rel="stylesheet">
        
        
        <style>
        .container, .repm-card, .form-label, .form-control, .form-select, .form-check-label, .btn, .invalid-feedback {
            font-family: 'Poppins', sans-serif !important;
            font-weight: 400;
        }
        .repm-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(0,0,0,.07);
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            margin-bottom: 1.5rem;
        }
        .repm-section-title {
            font-weight: 500;
            font-size: 1.25rem;
            border-left: 4px solid #006cff;
            padding-left: 12px;
            margin-bottom: 1.25rem;
            color: #222;
            font-family: 'Poppins', sans-serif !important;
        }
        .repm-step-indicator {
            display: flex;
            gap: 10px;
            margin-bottom: 1.5rem;
            justify-content: center;
        }
        .repm-step-indicator .circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #f0f4ff;
            color: #006cff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.97rem;
            border: 2px solid #d6e2fa;
            transition: background 0.2s, color 0.2s, border 0.2s;
            font-family: 'Poppins', sans-serif !important;
        }
        .repm-step-indicator .circle.active {
            background: #006cff;
            color: #fff;
            border: 2px solid #006cff;
            box-shadow: 0 2px 8px rgba(0,108,255,0.15);
        }
        .form-check-input[type="radio"] {
            opacity: 0;
            position: absolute;
        }
        .form-check-input[type="radio"] + .form-check-label {
            display: inline-block;
            background: #f7faff;
            color: #222;
            border: 2px solid #d0e2ff;
            padding: 4px 12px;
            margin-right: 8px;
            margin-bottom: 8px;
            border-radius: 20px;
            cursor: pointer;
            transition: background 0.18s, border 0.18s, color 0.18s;
            font-weight: 400;
            font-size: 0.75rem;
            min-width: 32px;
            text-align: center;
            position: relative;
            z-index: 1;
            font-family: 'Poppins', sans-serif !important;
        }
        .form-check-input[type="radio"]:checked + .form-check-label,
        .form-check-input[type="radio"]:focus + .form-check-label {
            background: #006cff;
            color: #fff;
            border: 2px solid #006cff;
            box-shadow: 0 2px 8px rgba(0,108,255,0.10);
        }
        .form-check-input[type="radio"]:focus + .form-check-label {
            outline: 2px solid #006cff;
            outline-offset: 2px;
        }
        .form-check-group {
            white-space: nowrap;
            display: block;
            overflow-x: auto;
            padding-bottom: 2px;
        }
        .form-check-inline {
            display: inline-block;
            margin-right: 8px;
            margin-bottom: 6px;
            min-width: 0;
        }
        @media (max-width: 576px) {
            .form-check-group {
                white-space: normal;
                overflow-x: visible;
            }
            .form-check-inline {
                display: inline-block;
                min-width: 0;
            }
        }
        .form-check-input[type="checkbox"] {
            width: 1.3em;
            height: 1.3em;
            border-radius: 6px;
            border: 2px solid #b0c4de;
            background: #f8f9fa;
            cursor: pointer;
            margin-top: 0;
            transition: border 0.2s;
            position: relative;
        }
        .form-check-input[type="checkbox"]:checked {
            background-color: #006cff;
            border-color: #006cff;
            box-shadow: 0 0 0 3px #e6f1ff;
        }
        .form-check-input[type="checkbox"]:focus {
            outline: none;
            box-shadow: 0 0 0 3px #e6f1ff;
            border-color: #006cff;
        }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1.5px solid #dde7f6;
            background: #f9fbff;
            font-size: 0.75rem;
            font-family: 'Poppins', sans-serif !important;
            font-weight: 400;
        }
        .form-control:focus, .form-select:focus {
            border-color: #006cff;
            background: #f8fbff;
            box-shadow: 0 0 0 2px #e6f1ff;
        }
        .invalid-feedback {
            color: #e74c3c;
            font-size: 0.70em;
            font-family: 'Poppins', sans-serif !important;
        }
        .repm-next-btn, .repm-prev-btn, .btn-success {
            border-radius: 8px;
            padding: 0.5em 1.7em;
            font-weight: 600;
            font-size: 0.75rem;
            letter-spacing: 0.01em;
            font-family: 'Poppins', sans-serif !important;
        }
        .repm-next-btn {
            background: #006cff;
            border: none;
            color: #fff;
        }
        .repm-next-btn:hover, .repm-next-btn:focus {
            background: #004baf;
        }
        .repm-prev-btn {
            background: #f0f4ff;
            color: #006cff;
            border: 1px solid #cdd8ef;
        }
        .repm-prev-btn:hover, .repm-prev-btn:focus {
            background: #e6f0ff;
            color: #004baf;
        }
        .btn-success {
            background: #23b26d;
            border: none;
        }
        .btn-success:hover {
            background: #1a9057;
        }
        .progress-bar {
            background: linear-gradient(90deg, #006cff 60%, #23b26d 100%);
            border-radius: 8px;
            height: 10px;
            transition: width .4s;
        }
        .progress {
            background: #eaf2fc;
            border-radius: 8px;
            height: 10px;
            margin-top: 12px;
        }
        </style>
        <div class="container my-4">
            <form id="repm-property-form" action="<?php echo admin_url('admin-ajax.php'); ?>" enctype="multipart/form-data" method="post" class="needs-validation" novalidate>
                <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('repm_nonce'); ?>">
                <div class="repm-step-indicator mb-3">
                    <span class="circle" id="step-ind-1">1</span>
                    <span class="circle" id="step-ind-2">2</span>
                    <span class="circle" id="step-ind-3">3</span>
                    <span class="circle" id="step-ind-4">4</span>
                </div>
                <div id="repm-steps">
<!-- Step 1: Key Details -->
                <div class="repm-step repm-card" data-step="1">
                    <div class="repm-section-title"><i class="fa fa-home text-primary"></i> Property Key Details</div>
                    <div class="mb-3">
                        <label class="form-label">For Sale or Rent</label>
                        <select name="for_sale_rent" class="form-select" required id="for_sale_rent">
                            <option value="">Select</option>
                            <option value="sale">For Sale</option>
                            <option value="rent">For Rent</option>
                        </select>
                        <div class="invalid-feedback">Please select sale or rent.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Type of Property</label>
                        <select name="type_of_property" class="form-select" required id="type_of_property">
                            <option value="">Select</option>
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                        </select>
                        <div class="invalid-feedback">Please select property type.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">City</label>
                        <input type="text" name="city" class="form-control" required>
                        <div class="invalid-feedback">Please provide a city.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line 1</label>
                        <input type="text" name="address_line_1" class="form-control" placeholder="Address Line 1" required>
                        <div class="invalid-feedback">Please provide Address Line 1.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address Line 2</label>
                        <input type="text" name="address_line_2" class="form-control" placeholder="Address Line 2">
                    </div>
                    <div class="mb-3" id="residential-type-wrap">
                        <label class="form-label">Type of Residential Property</label><br>
                        <div class="form-check-group">
                        <?php $res_types = ['Apartment','Villa','Independent House']; foreach($res_types as $i=>$type): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type_of_residential_property" id="res_type<?php echo $i; ?>" value="<?php echo $type; ?>">
                                <label class="form-check-label" for="res_type<?php echo $i; ?>"><?php echo $type; ?></label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="mb-3" id="commercial-type-wrap">
                        <label class="form-label">Type of Commercial Property</label><br>
                        <div class="form-check-group">
                        <?php $com_types = ['Shop','Office']; foreach($com_types as $i=>$type): ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="type_of_commercial_property" id="com_type<?php echo $i; ?>" value="<?php echo $type; ?>">
                                <label class="form-check-label" for="com_type<?php echo $i; ?>"><?php echo $type; ?></label>
                            </div>
                        <?php endforeach; ?>
                        </div>
                    </div>
                    <div id="residential-details-wrap">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. of Bedrooms</label><br>
                                <div class="form-check-group">
                                    <?php foreach ([1,2,3,4,5,'5+'] as $i=>$val): ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bedrooms" id="bedrooms<?php echo $i; ?>" value="<?php echo $val; ?>" required>
                                            <label class="form-check-label" for="bedrooms<?php echo $i; ?>"><?php echo $val; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="invalid-feedback">Please select number of bedrooms.</div>
                            </div>
                            <!-- Bathrooms -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. of Bathrooms</label><br>
                                <div class="form-check-group">
                                    <?php foreach ([1,2,3,4,5,'5+'] as $i=>$val): ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="bathrooms" id="bathrooms<?php echo $i; ?>" value="<?php echo $val; ?>" required>
                                            <label class="form-check-label" for="bathrooms<?php echo $i; ?>"><?php echo $val; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="invalid-feedback">Please select number of bathrooms.</div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Balconies</label><br>
                                <div class="form-check-group">
                                    <?php foreach ([0,1,2,3,4,'4+'] as $i=>$val): ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="balconies" id="balconies<?php echo $i; ?>" value="<?php echo $val; ?>">
                                            <label class="form-check-label" for="balconies<?php echo $i; ?>"><?php echo $val; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn repm-next-btn">Next <i class="fa fa-chevron-right"></i></button>
                    </div>
                    <div class="progress mt-4">
                        <div class="progress-bar" style="width: 25%"></div>
                    </div>
                </div>
                <!-- Step 2: Other Details -->
                <div class="repm-step repm-card" data-step="2" style="display:none;">
                    <div class="repm-section-title"><i class="fa fa-building text-primary"></i> Other Property Details</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Availability Status</label><br>
                            <div class="form-check-group">
                            <?php $opts = ['Ready to Move','Under Construction']; foreach($opts as $i=>$val): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="availability_status" id="avail_<?php echo $i; ?>" value="<?php echo $val; ?>" required>
                                    <label class="form-check-label" for="avail_<?php echo $i; ?>"><?php echo $val; ?></label>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="invalid-feedback">Please select availability status.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Carpet Area (sq ft)</label>
                            <input type="number" name="carpet_area" class="form-control" min="0" required>
                            <div class="invalid-feedback">Please enter carpet area.</div>
                        </div>
                        </div>
                        <div id="sale-fields-wrap">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Built-up Area (sq ft)</label>
                            <input type="number" name="builtup_area" class="form-control" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Super Built-up Area (sq ft)</label>
                            <input type="number" name="super_builtup_area" class="form-control" min="0">
                        </div>
                         </div>
                         </div>
                <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Floors</label>
                            <input type="number" name="total_floors" class="form-control" min="0" required>
                            <div class="invalid-feedback">Please enter total floors.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Property on Floor</label>
                            <input type="number" name="property_on_floor" class="form-control" min="0" required>
                            <div class="invalid-feedback">Please enter property on floor.</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Age of Property</label><br>
                            <div class="form-check-group">
                            <?php $ages = ['New','1-5 Years','5-10 Years','10+ Years']; foreach($ages as $i=>$val): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="age_of_property" id="age_<?php echo $i; ?>" value="<?php echo $val; ?>" required>
                                    <label class="form-check-label" for="age_<?php echo $i; ?>"><?php echo $val; ?></label>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="invalid-feedback">Please select age of property.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ownership</label><br>
                            <div class="form-check-group">
                            <?php $owns = ['Freehold','Leasehold']; foreach($owns as $i=>$val): ?>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ownership" id="own_<?php echo $i; ?>" value="<?php echo $val; ?>" required>
                                    <label class="form-check-label" for="own_<?php echo $i; ?>"><?php echo $val; ?></label>
                                </div>
                            <?php endforeach; ?>
                            </div>
                            <div class="invalid-feedback">Please select ownership.</div>
                        </div>
                        <div class="col-md-6 mb-3" id="leasehold-authority-wrap" style="display:none;">
                              <label class="form-label">Leasehold Authority</label>
                              <select name="leasehold_authority" class="form-select">
                                <option value="">Select Authority</option>
                                <option value="Noida Authority">Noida Authority</option>
                                <option value="Greater Noida Authority">Greater Noida Authority</option>
                                <option value="YEIDA Authority">YEIDA Authority</option>
                              </select>
                              <div class="invalid-feedback">Please select leasehold authority.</div>
                            </div>
                            </div>
                    <div class="mb-3">
                        <label class="form-label">Property Name</label>
                        <input type="text" name="property_name" class="form-control" required>
                        <div class="invalid-feedback">Please provide a property name.</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Property Description</label>
                        <textarea name="property_description" class="form-control" rows="3" required></textarea>
                        <div class="invalid-feedback">Please provide a description.</div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn repm-prev-btn"><i class="fa fa-chevron-left"></i> Previous</button>
                        <button type="button" class="btn repm-next-btn">Next <i class="fa fa-chevron-right"></i></button>
                    </div>
                    <div class="progress mt-4">
                        <div class="progress-bar" style="width: 50%"></div>
                    </div>
                </div>
                <!-- Step 3: Price & Features -->
                <div class="repm-step repm-card" data-step="3" style="display:none;">
    <div class="repm-section-title"><i class="fa fa-rupee-sign text-primary"></i> Price & Features</div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Price (₹)</label>
            <input type="text" name="price" class="form-control" min="0" required>
            <div class="invalid-feedback">Please enter the price.</div>
        </div>
        <div class="col-md-6" id="maintenance_dropdown_wrap" style="display:none;">
            <label class="form-label">Maintenance</label>
            <select name="maintenance_inclusion" id="maintenance_inclusion" class="form-select">
                <option value="">Select</option>
                <option value="including">Including Maintenance</option>
                <option value="excluding">Excluding Maintenance</option>
            </select>
            <div class="invalid-feedback">Please select maintenance option.</div>
        </div>
    </div>
    <div class="row mb-3" id="maintenance_amount_wrap" style="display:none;">
        <div class="col-md-6">
            <label class="form-label">Monthly Maintenance (₹)</label>
            <input type="text" name="monthly_maintenance" class="form-control" id="maintenance_amount_input">
            <div class="invalid-feedback">Please enter the monthly maintenance amount.</div>
        </div>
    </div>
    <div id="sale-price-options-wrap" class="mb-3">
        <label class="form-label">Price Options</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="all_inclusive_price" id="all_inclusive_price" value="1">
            <label class="form-check-label" for="all_inclusive_price">All inclusive Price</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="price_negotiable" id="price_negotiable" value="1">
            <label class="form-check-label" for="price_negotiable">Price Negotiable</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="checkbox" name="tax_excluded" id="tax_excluded" value="1">
            <label class="form-check-label" for="tax_excluded">Tax & Govt. charges excluded</label>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Furnishing</label><br>
        <div class="form-check-group">
        <?php $furns = ['Furnished','Semi-Furnished','Unfurnished']; foreach($furns as $i=>$val): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="furnishing" id="furn_<?php echo $i; ?>" value="<?php echo $val; ?>" required>
                <label class="form-check-label" for="furn_<?php echo $i; ?>"><?php echo $val; ?></label>
            </div>
        <?php endforeach; ?>
        </div>
        <div class="invalid-feedback">Please select furnishing.</div>
    </div>
    <div class="mb-3">
        <label class="form-label">Furnishing Details</label><br>
        <?php
        $furn_det = [
            'Wardrobe', 'Modular Kitchen', 'Exhaust Fan', 'Curtains', 'Fridge', 'Stove', 'Washing Machine', 'Sofa', 'Geyser',
            'Chimney', 'Dining Table', 'Water Purifier', 'Bed', 'TV', 'AC', 'Fan', 'Microwave'
        ];
        foreach($furn_det as $i=>$val): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="furnishing_details[]" id="fd_<?php echo $i; ?>" value="<?php echo $val; ?>">
                <label class="form-check-label" for="fd_<?php echo $i; ?>"><?php echo $val; ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Covered Parking</label><br>
            <div class="form-check-group">
            <?php $covs = ['Yes','No']; foreach($covs as $i=>$val): ?>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="covered_parking" id="covp_<?php echo $i; ?>" value="<?php echo $val; ?>">
                    <label class="form-check-label" for="covp_<?php echo $i; ?>"><?php echo $val; ?></label>
                </div>
            <?php endforeach; ?>
            </div>
        </div>
        <div class="col-md-6" id="covered-parking-count-wrap" style="display:none;">
            <label class="form-label">Number of Covered Parking</label>
            <select class="form-select" name="covered_parking_count" id="covered_parking_count">
                <option value="">Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            <div class="invalid-feedback">Please select number of covered parking.</div>
        </div>
    </div>
    <div class="col-md-6">
        <label class="form-label">Open Parking</label><br>
        <div class="form-check-group">
        <?php $opns = ['Yes','No']; foreach($opns as $i=>$val): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="open_parking" id="openp_<?php echo $i; ?>" value="<?php echo $val; ?>">
                <label class="form-check-label" for="openp_<?php echo $i; ?>"><?php echo $val; ?></label>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
    <!-- THE FIELDS BELOW WERE OUTSIDE THE STEP, NOW INSIDE -->
    <div class="mb-3">
        <label class="form-label">Upload Property Images <span class="text-danger">*</span></label>
        <input type="file" name="property_images[]" class="form-control" multiple required id="property_images_input">
        <div class="invalid-feedback">Please upload at least one property image.</div>
        <div id="property_images_preview" class="mt-2"></div>
        <input type="hidden" name="featured_image_index" id="featured_image_index" value="0">
    </div>
    <div class="mb-3">
        <label class="form-label">Amenities</label><br>
        <?php
        $amenities = [
            'Gym', 'Swimming Pool', 'Garden', 'Lift', 'Parking', 'CCTV', 'Security', 'Power Backup', 'Play Area', 'Club House', 'Internet', 'Fire Safety'
        ];
        foreach($amenities as $i=>$a): ?>
            <div class="form-check form-check-inline mb-1">
                <input class="form-check-input" type="checkbox" name="amenities[]" id="amenity_<?php echo $i; ?>" value="<?php echo esc_attr($a); ?>">
                <label class="form-check-label" for="amenity_<?php echo $i; ?>"><?php echo esc_html($a); ?></label>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="mb-3">
        <label class="form-label">Water Source</label><br>
        <div class="form-check-group">
        <?php $waters = ['Municipal','Borewell','Both']; foreach($waters as $i=>$val): ?>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="water_source" id="water_<?php echo $i; ?>" value="<?php echo $val; ?>" required>
                <label class="form-check-label" for="water_<?php echo $i; ?>"><?php echo $val; ?></label>
            </div>
        <?php endforeach; ?>
        </div>
        <div class="invalid-feedback">Please select water source.</div>
    </div>
    <!-- Step 3 BUTTONS AND PROGRESS BAR -->
    <div class="d-flex justify-content-between">
        <button type="button" class="btn repm-prev-btn"><i class="fa fa-chevron-left"></i> Previous</button>
        <button type="button" class="btn repm-next-btn">Next <i class="fa fa-chevron-right"></i></button>
    </div>
    <div class="progress mt-4">
        <div class="progress-bar" style="width: 75%"></div>
    </div>
</div>
                <!-- Step 4: Location Advantages -->
                <div class="repm-step repm-card" data-step="4" style="display:none;">
                    <div class="repm-section-title"><i class="fa fa-map-marker-alt text-primary"></i> Location Advantages</div>
                    <div class="mb-3">
                        <label class="form-label">Location Advantages</label><br>
                        <?php
                        $advantages = ['Near Metro', 'Near School', 'Near Hospital', 'Near Market', 'Near Park'];
                        foreach($advantages as $i=>$adv): ?>
                            <div class="form-check form-check-inline mb-1">
                                <input class="form-check-input" type="checkbox" name="location_advantages[]" id="adv_<?php echo $i; ?>" value="<?php echo esc_attr($adv); ?>">
                                <label class="form-check-label" for="adv_<?php echo $i; ?>"><?php echo esc_html($adv); ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mb-3">
                                <label class="form-label">Nearby Schools, Markets, etc.</label>
                                <textarea class="form-control" name="nearby_places" rows="2" placeholder="Describe nearby schools, markets, hospitals, etc."></textarea>
                            </div>
                    <button type="button" class="btn repm-prev-btn"><i class="fa fa-chevron-left"></i> Previous</button>
                    <button type="submit" class="btn btn-success">Submit Property</button>
                    <div class="progress mt-4">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            <div id="repm-form-alert" class="mt-3"></div>
        </form>
        <div id="repm-form-success" class="alert alert-success mt-4 d-none">
            <i class="fa fa-check-circle"></i> Your property has been submitted successfully!
        </div>
    </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
jQuery(function($){
    //Ajax Form property_submission
    $('#repm-property-form').on('submit', function(e){
        e.preventDefault();
        $('#repm-form-alert').html('<div class="alert alert-info">Submitting, please wait...</div>');
        var form = this;
        var formData = new FormData(form);
        formData.append('action', 'repm_submit_property');
        // REMOVE this line if nonce is already in the form field:
    // formData.append('nonce', '<?php echo wp_create_nonce("repm_nonce"); ?>'); 

        $.ajax({
            url: '<?php echo admin_url("admin-ajax.php"); ?>',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            success: function(resp){
                if(resp.success){
                    $('#repm-form-success').removeClass('d-none');
                    $('#repm-form-alert').html('');
                    $('#repm-property-form').hide();
                }else if(resp.data && resp.data.errors){
                    var out = '<div class="alert alert-danger mb-2">Please fix the errors below.</div>';
                    $.each(resp.data.errors, function(field, msg){
                        out += '<div class="alert alert-warning py-1 mb-1">'+msg+'</div>';
                        $('[name="'+field+'"]', form).addClass('is-invalid');
                    });
                    $('#repm-form-alert').html(out);
                }else{
                    $('#repm-form-alert').html('<div class="alert alert-danger">Submission failed. Try again.</div>');
                }
            },
            error: function(){
                $('#repm-form-alert').html('<div class="alert alert-danger">Submission failed due to a network error.</div>');
            }
        });
    });
    
    // Property type fields toggle
    function toggleSubtypeFields() {
        var selected = $('#type_of_property').val();
        if(selected === 'residential') {
            $('#residential-type-wrap').show();
            $('#commercial-type-wrap').hide();
            $('#residential-details-wrap').show();
            $('#commercial-type-wrap input[type=radio]').prop('checked', false);
            $('#residential-details-wrap input[name="bedrooms"], #residential-details-wrap input[name="bathrooms"]').attr('required', true);
        } else if(selected === 'commercial') {
            $('#commercial-type-wrap').show();
            $('#residential-type-wrap').hide();
            $('#residential-details-wrap').hide();
            $('#residential-type-wrap input[type=radio]').prop('checked', false);
            $('#residential-details-wrap input[name="bedrooms"], #residential-details-wrap input[name="bathrooms"]').removeAttr('required').prop('checked', false);
        } else {
            $('#residential-type-wrap, #commercial-type-wrap, #residential-details-wrap').hide();
            $('#residential-type-wrap input[type=radio], #commercial-type-wrap input[type=radio], #residential-details-wrap input[type=radio]').prop('checked', false);
            $('#residential-details-wrap input[name="bedrooms"], #residential-details-wrap input[name="bathrooms"]').removeAttr('required');
        }
    }
    toggleSubtypeFields();
    $('#type_of_property').on('change', toggleSubtypeFields);

    // Maintenance field logic
    function toggleMaintenanceFields() {
        var forRent = $('#for_sale_rent').val() === 'rent';
        var step3 = $('.repm-step[data-step="3"]');
        var $maintDropdown = $('#maintenance_dropdown_wrap', step3);
        var $maintDropdownSel = $('#maintenance_inclusion', step3);
        var $maintAmtWrap = $('#maintenance_amount_wrap', step3);
        var $maintAmtInput = $('#maintenance_amount_input', step3);
        if(forRent) {
            $maintDropdown.show();
            if($maintDropdownSel.val() === 'excluding') {
                $maintAmtWrap.show();
                $maintAmtInput.attr('required', true);
            } else {
                $maintAmtWrap.hide();
                $maintAmtInput.val('').removeAttr('required').removeClass('is-invalid');
                $maintAmtWrap.find('.invalid-feedback').hide();
            }
        } else {
            $maintDropdown.hide();
            $maintDropdownSel.val('');
            $maintAmtWrap.hide();
            $maintAmtInput.val('').removeAttr('required').removeClass('is-invalid');
            $maintAmtWrap.find('.invalid-feedback').hide();
        }
    }
    $('#for_sale_rent').on('change', toggleMaintenanceFields);
    $('#maintenance_inclusion').on('change', function(){
        var $maintAmtWrap = $('#maintenance_amount_wrap');
        var $maintAmtInput = $('#maintenance_amount_input');
        if($(this).val() === 'excluding') {
            $maintAmtWrap.show();
            $maintAmtInput.attr('required', true);
        } else {
            $maintAmtWrap.hide();
            $maintAmtInput.val('').removeAttr('required').removeClass('is-invalid');
            $maintAmtWrap.find('.invalid-feedback').hide();
        }
    });

   // Sale-only field logic: make Built-up Area, Super Built-up Area required for Sale; Leasehold Authority required for Sale+Leasehold
function toggleSaleFields() {
    if ($('#for_sale_rent').val() === 'sale') {
        // Show and require Built-up Area and Super Built-up Area
        $('#sale-fields-wrap').show();
        $('#sale-fields-wrap input[name="builtup_area"], #sale-fields-wrap input[name="super_builtup_area"]').attr('required', true);

        // Show Price Options
        $('#sale-price-options-wrap').show();

        // Handle Leasehold Authority requirement/display
        conditionalLeaseholdAuthority();

    } else {
        // Hide and clear Built-up Area and Super Built-up Area, remove required
        $('#sale-fields-wrap').hide();
        $('#sale-fields-wrap input[name="builtup_area"], #sale-fields-wrap input[name="super_builtup_area"]')
            .removeAttr('required')
            .val('')
            .removeClass('is-invalid');

        // Hide and uncheck all Price Options
        $('#sale-price-options-wrap').hide().find('input[type=checkbox]').prop('checked', false);

        // Hide and clear Leasehold Authority
        $('#leasehold-authority-wrap').hide().find('select').val('').removeClass('is-invalid').removeAttr('required');
    }
}

// Show/hide Leasehold Authority and set required attribute only for Sale + Leasehold
function conditionalLeaseholdAuthority() {
    if (
        $('#for_sale_rent').val() === 'sale' &&
        $('input[name="ownership"]:checked').val() === 'Leasehold'
    ) {
        $('#leasehold-authority-wrap').show();
        $('#leasehold-authority-wrap select').attr('required', true);
    } else {
        $('#leasehold-authority-wrap').hide();
        $('#leasehold-authority-wrap select').val('').removeAttr('required').removeClass('is-invalid');
    }
}

// Attach events
$('#for_sale_rent').on('change', toggleSaleFields);
$('input[name="ownership"]').on('change', conditionalLeaseholdAuthority);

// On page load
toggleSaleFields();
conditionalLeaseholdAuthority();

// Covered Parking count show/hide logic
$('input[name="covered_parking"]').on('change', function(){
    if ($(this).val() === 'Yes') {
        $('#covered-parking-count-wrap').show();
        $('#covered_parking_count').attr('required', true);
    } else {
        $('#covered-parking-count-wrap').hide();
        $('#covered_parking_count').val('').removeAttr('required').removeClass('is-invalid');
        $('#covered-parking-count-wrap .invalid-feedback').hide();
    }
});
// On page load, in case of pre-filled value
if ($('input[name="covered_parking"]:checked').val() === 'Yes') {
    $('#covered-parking-count-wrap').show();
    $('#covered_parking_count').attr('required', true);
} else {
    $('#covered-parking-count-wrap').hide();
    $('#covered_parking_count').val('').removeAttr('required').removeClass('is-invalid');
    $('#covered-parking-count-wrap .invalid-feedback').hide();
}

// Indian number formatting for price & maintenance input
    $('input[name="price"], #maintenance_amount_input').on('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        if (value === '') { this.value = ''; return; }
        let last3 = value.substring(value.length-3);
        let other = value.substring(0, value.length-3);
        if(other !== '') last3 = ',' + last3;
        let formatted = other.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + last3;
        this.value = formatted;
    }).on('keypress', function(e) {
        let charCode = typeof e.which == "undefined" ? e.keyCode : e.which;
        if ([8,9,13,37,39,46].indexOf(charCode) > -1) return;
        let charStr = String.fromCharCode(charCode);
        if (!charStr.match(/^[0-9]$/)) e.preventDefault();
    }).on('paste', function(e) {
        let pasted = e.originalEvent.clipboardData.getData('Text');
        if (!/^[0-9,]+$/.test(pasted)) e.preventDefault();
    });

    // Step logic
    var step = 1;
    function highlightStep(n) {
        $('.repm-step-indicator .circle').removeClass('active');
        $('#step-ind-'+n).addClass('active');
    }
    function showStep(n) {
        $('.repm-step').hide();
        var $currentStep = $('.repm-step[data-step="' + n + '"]');
        $currentStep.show();
        highlightStep(n);
        $('.progress-bar').css('width', (n / 4 * 100) + '%');
        $('#repm-property-form').find('input, select, textarea').removeClass('is-invalid');
        $('#repm-property-form').find('.invalid-feedback').hide();
        $('#repm-property-form').removeClass('was-validated');
        if(n == 3) { toggleMaintenanceFields(); }
    }
    window.showStep = showStep;

    // Radio group validation
    function isRadioGroupValid($step) {
        var valid = true;
        var checkedNames = [];
        $step.find('input[type=radio][required]').each(function(){
            var name = $(this).attr('name');
            if (checkedNames.indexOf(name) !== -1) return;
            checkedNames.push(name);
            var $radios = $step.find('input[type=radio][name="'+name+'"]');
            if ($radios.filter(':checked').length === 0) {
                $radios.addClass('is-invalid');
                $radios.closest('.mb-3, .col-md-4').find('.invalid-feedback').show();
                valid = false;
            } else {
                $radios.removeClass('is-invalid');
                $radios.closest('.mb-3, .col-md-4').find('.invalid-feedback').hide();
            }
        });
        return valid;
    }

    $(document).on('click', '.repm-next-btn', function(e){
        e.preventDefault();
        var $curStep = $('.repm-step[data-step="'+step+'"]');
        var html5valid = true;
        $curStep.find('[required]').each(function(){
            if (this.type === 'radio') return;
            if (!this.checkValidity()) {
                $(this).addClass('is-invalid');
                $(this).closest('.mb-3, .col-md-4').find('.invalid-feedback').show();
                html5valid = false;
            } else {
                $(this).removeClass('is-invalid');
                $(this).closest('.mb-3, .col-md-4').find('.invalid-feedback').hide();
            }
        });
        var radiosValid = isRadioGroupValid($curStep);
        
        // Validate file input for step 3 (property images required)
        if (step === 3) {
            var $imgInput = $curStep.find('input[type="file"][name="property_images[]"]');
            if ($imgInput.length && (!$imgInput[0].files || !$imgInput[0].files.length)) {
                $imgInput.addClass('is-invalid');
                $imgInput.closest('.mb-3').find('.invalid-feedback').show();
                html5valid = false;
            } else {
                $imgInput.removeClass('is-invalid');
                $imgInput.closest('.mb-3').find('.invalid-feedback').hide();
            }
        }
        if (html5valid && radiosValid) {
            step++;
            showStep(step);
            $('html, body').animate({
                scrollTop: $('#repm-property-form').offset().top - 30
            }, 400);
        } else {
            $('#repm-property-form').addClass('was-validated');
            var $firstInvalid = $curStep.find('.is-invalid:first');
            if ($firstInvalid.length) {
                $('html, body').animate({
            scrollTop: $firstInvalid.offset().top - 100
            }, 400);
            $firstInvalid.focus();
            } else {
                $curStep.find('input[type=radio][required]').each(function(){
                    var name = $(this).attr('name');
                    if ($curStep.find('input[type=radio][name="'+name+'"]:checked').length === 0) {
                        $(this).focus();
                        return false;
                    }
                });
            }
        }
    });

    $(document).on('click', '.repm-prev-btn', function(e){
        e.preventDefault();
        if (step > 1) { step--; showStep(step);}
        $('html, body').animate({
            scrollTop: $('#repm-property-form').offset().top - 30
        }, 400);
    });

    // Live error clearing
    $('#repm-property-form').on('input change', 'input, select, textarea', function() {
        var $el = $(this);
        if ($el.is(':radio')) {
            var name = $el.attr('name');
            var $group = $('input[type=radio][name="'+name+'"]');
            if ($group.filter(':checked').length) {
                $group.removeClass('is-invalid');
                $group.closest('.mb-3, .col-md-4').find('.invalid-feedback').hide();
            }
        } else if ($el.is(':file')) {
            if (this.files && this.files.length > 0) {
                $el.removeClass('is-invalid');
                $el.closest('.mb-3').find('.invalid-feedback').hide();
            }
        } else {
            if (this.checkValidity()) {
                $el.removeClass('is-invalid');
                $el.closest('.mb-3, .col-md-4').find('.invalid-feedback').hide();
            }
        }
    });

    showStep(step);

    // Image preview/featured logic
    $('#property_images_input').on('change', function(e) {
        var files = this.files;
        var preview = $('#property_images_preview');
        preview.empty();
        if (!files.length) return;
        for (let i = 0; i < files.length; i++) {
            let file = files[i];
            let reader = new FileReader();
            reader.onload = function(e2) {
                let radio = $('<input type="radio" name="featured_radio" />')
                    .val(i)
                    .prop('checked', i===0)
                    .on('change', function() {
                        $('#featured_image_index').val(i);
                    });
                let label = $('<label class="me-3 mb-2" style="display:inline-block;vertical-align:top"></label>')
                    .append(radio)
                    .append('<span class="ms-1 badge bg-info text-dark" style="font-size:0.75em;">Featured</span>')
                    .append('<br>')
                    .append($('<img>').attr('src', e2.target.result).css({width: '80px', height: '80px', objectFit: 'cover', borderRadius: '8px', marginTop: '3px', border: '1px solid #ccc'}));
                preview.append(label);
            };
            reader.readAsDataURL(file);
        }
        $('#featured_image_index').val(0);
    });
});
</script>
        <?php return ob_get_clean();
    });
    
    //Search From for Homepage
    add_shortcode('property_search_carousel', function() {
        wp_enqueue_script('jquery');
        wp_enqueue_style('fa', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css');
        wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css');
        wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js', [], null, true);
    
        $ajax_url = admin_url('admin-ajax.php');
    
        ob_start();
        ?>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
        body, html { font-family: 'Poppins', Arial, sans-serif; font-weight: 400;}
        h1, h2, h3, h4, h5, h6 { font-family: 'Poppins', Arial, sans-serif; font-weight: 500;}
        .repm-property-title { font-family: 'Poppins', Arial, sans-serif; font-weight: 500;}
        .repm-property-excerpt, .repm-property-location, .repm-property-price, .repm-meta-box, .repm-meta-box-label, .repm-meta-box-value {
            font-family: 'Poppins', Arial, sans-serif; font-weight: 400;
        }
        #repm-listing-filter {
            background: #fff;
            border: 1px solid #e2e6ea;
            border-radius: 18px;
            box-shadow: 0 4px 28px rgba(18, 52, 102, 0.07);
            padding: 22px 18px 10px 18px;
            margin-bottom: 36px;
            display: flex;
            flex-wrap: wrap;
            gap: 14px 0;
        }
        #repm-listing-filter .form-control, #repm-listing-filter .form-select {
            border-radius: 8px;
            border: 1.5px solid #bfc7d1;
            font-size: 0.70rem;
            min-height: 48px;
            box-shadow: none;
            margin-bottom: 0;
            background: #f6f8fa;
            transition: border-color 0.2s;
            font-family: 'Poppins', Arial, sans-serif;
            font-weight: 400;
        }
        #repm-listing-filter .form-control:focus, #repm-listing-filter .form-select:focus {
            border-color: #4e73df;
            background: #fff;
        }
        #repm-listing-filter .btn-primary {
            border-radius: 30px;
            font-size: 0.75rem;
            padding: 12px 36px;
            font-weight: 500;
            background: linear-gradient(90deg, #4e73df 0%, #2e59d9 100%);
            border: none;
            box-shadow: 0 2px 6px 0 rgba(44, 62, 80,0.07);
            transition: background 0.2s;
            font-family: 'Poppins', Arial, sans-serif;
        }
        #repm-listing-filter .btn-primary:hover {
            background: linear-gradient(90deg, #2e59d9 0%, #224abe 100%);
        }
        #repm-listing-filter .btn-toggle-filters {
            display: none;
            font-family: 'Poppins', Arial, sans-serif;
            font-weight: 500;
        }
        @media (max-width: 575.98px) {
            #repm-listing-filter {
                margin-left: 30px;
                margin-right: 30px;
            }
            #repm-listing-filter .col-12,
            #repm-listing-filter .col-sm-6,
            #repm-listing-filter .col-md-2 {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                box-sizing: border-box;
                padding-right: 0 !important;
                padding-left: 0 !important;
                margin-right: 0 !important;
                margin-left: 0 !important;
            }
            #repm-listing-filter .form-control,
            #repm-listing-filter .form-select {
                width: 100% !important;
                max-width: 100% !important;
                min-width: 0 !important;
                box-sizing: border-box;
            }
            #repm-listing-filter .btn-primary, 
            #repm-listing-filter .btn-toggle-filters {
                width: 100%;
            }
        }
        @media (max-width: 991.98px) {
            #repm-listing-filter {
                padding: 15px;
            }
        }
        @media (max-width: 767.98px) {
            #repm-listing-filter {
                flex-direction: column;
                gap: 10px 0;
                border: 1px 1px 1px 1px;
                border-color: #2e59d9;
            }
            #repm-listing-filter .filter-group {
                display: none;
            }
            #repm-listing-filter .filter-city {
                width: 100%;
                flex: 1 0 100%;
                max-width: 100%;
            }
            #repm-listing-filter .btn-toggle-filters {
                display: inline-block;
                width: 100%;
                margin-top: 1px;
                border-radius: 30px;
                font-size: 0.75rem;
                padding: 12px 36px;
            }
            #repm-listing-filter.filters-expanded .filter-group {
                display: block;
                margin-top: 10px;
            }
            #repm-listing-filter.filters-expanded .btn-toggle-filters span::before {
                content: "▲ ";
            }
            #repm-listing-filter .btn-toggle-filters span::before {
                content: "▼ ";
            }
        }
        #repm-listing-filter .col-12,
        #repm-listing-filter .col-sm-6,
        #repm-listing-filter .col-md-2 {
            margin-bottom: 0;
            padding-right: 10px;
            padding-left: 10px;
        }
        .repm-property-card {
            background: #fafdff;
            border: 1.5px solid #e2e6ea;
            border-radius: 18px;
            box-shadow: 0 2px 16px rgba(18, 52, 102, 0.05);
            padding: 26px 22px 20px 22px;
            display: flex;
            flex-direction: column;
            transition: box-shadow 0.24s, border-color 0.18s;
            height: 100%;
            position: relative;
            overflow: hidden;
            font-family: 'Poppins', Arial, sans-serif;
            margin-left: 10px;
            margin-right: 10px;
        }
        .repm-property-card:hover {
            box-shadow: 0 6px 32px rgba(44, 62, 80,0.13);
            border-color: #4e73df;
        }
        .repm-property-title {
            font-size: 1.15rem;
            font-weight: 500;
            margin-bottom: 8px;
            color: #253858;
            line-height: 1.25;
        }
        .repm-property-location, .repm-property-price {
            font-size: 0.95rem;
            margin-bottom: 4px;
        }
        .repm-property-location i,
        .repm-property-price i {
            color: #4e73df;
            margin-right: 5px;
        }
        .repm-property-price {
            color: #087c5a;
            font-weight: 600;
            font-size: 0.95rem;
        }
        .repm-property-excerpt {
            color: #6c7893;
            font-size: 0.70rem;
            margin-bottom: 14px;
            min-height: 2.2em;
        }
        .repm-meta-box {
            display: flex;
            flex-direction: row !important;
            flex-wrap: nowrap !important;
            gap: 18px !important;
            margin-bottom: 0;
        }
        .repm-meta-box-item {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #e6efff;
            border-radius: 7px;
            padding: 7px 10px;
            font-size: 0.85em;
            margin-bottom: 0 !important;
            color: #253858;
        }
        .repm-meta-box-item i { color: #4e73df; }
        .repm-meta-box-label { display: none; }
        .repm-meta-box-value { color: #2e4a7a; font-weight: 600; }
        .repm-property-card .btn-outline-primary {
            border-radius: 6px;
            font-size: 0.75rem;
            padding: 7px 18px;
            margin-top: 13px;
            margin-bottom: 0;
            border-width: 1.5px;
            color: #ffffff;
            border-color: #4e73df;
            font-weight: 500;
            background: #4e73df;
            transition: background 0.16s, color 0.16s;
            font-family: 'Poppins', Arial, sans-serif;
        }
        .repm-property-card .btn-outline-primary:hover {
            background: #4e73df;
            color: #fff;
            border-color: #4e73df;
        }
        .property-swiper .swiper-slide { height: auto; display: flex; justify-content: center; }
        .property-swiper .repm-property-card { width: 100%; max-width: 350px; margin: 0 auto; }
        </style>
        
        <form id="repm-listing-filter" class="row g-3 mb-4 align-items-end justify-content-center" autocomplete="off">
                <div class="col-12 col-sm-6 col-md-2 filter-city">
                    <input type="text" class="form-control" name="city" placeholder="City">
                </div>
                <!-- Toggle for more filters (mobile only) -->
                <div class="col-12 d-md-none">
                    <button type="button" class="btn btn-outline-secondary btn-toggle-filters">
                        <span>More Filters</span>
                    </button>
                </div>
                <div class="col-12 col-sm-6 col-md-2 filter-group">
                    <select class="form-select" name="type" id="property_type_filter">
                        <option value="">Type</option>
                        <option value="residential">Residential</option>
                        <option value="commercial">Commercial</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-2 filter-group" id="residential-subtype-filter" style="display:none;">
                    <select class="form-select" name="type_of_residential_property">
                        <option value="">Residential Subtype</option>
                        <option value="Apartment">Apartment</option>
                        <option value="Villa">Villa</option>
                        <option value="Independent House">Independent House</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-2 filter-group" id="commercial-subtype-filter" style="display:none;">
                    <select class="form-select" name="type_of_commercial_property">
                        <option value="">Commercial Subtype</option>
                        <option value="Shop">Shop</option>
                        <option value="Office">Office</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-2 filter-group">
                    <input type="text" class="form-control" name="min_price" placeholder="Min Price">
                </div>
                <div class="col-12 col-sm-6 col-md-2 filter-group">
                    <input type="text" class="form-control" name="max_price" placeholder="Max Price">
                </div>
                <div class="col-12 col-sm-6 col-md-2 filter-group" id="bedrooms-filter" style="display:none;">
                    <select class="form-select" name="bedrooms">
                        <option value="">Bedrooms</option>
                        <option value="1">1+</option>
                        <option value="2">2+</option>
                        <option value="3">3+</option>
                        <option value="4">4+</option>
                        <option value="5">5+</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-2 filter-group">
                    <select class="form-select" name="sort">
                        <option value="date_desc">Newest</option>
                        <option value="date_asc">Oldest</option>
                        <option value="price_asc">Price (Low-High)</option>
                        <option value="price_desc">Price (High-Low)</option>
                    </select>
                </div>
                <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-primary px-4">Filter</button>
                </div>
            </form>
    
        <div id="repm-listing-results">
            <div class="swiper property-swiper">
                <div class="swiper-wrapper">
                    <?php
                    $args = [
                        'post_type' => 'property',
                        'posts_per_page' => 12,
                    ];
                    $props = new WP_Query($args);
                    if ($props->have_posts()) :
                        while ($props->have_posts()): $props->the_post(); ?>
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
                                    <div class="repm-property-location"><i class="fa fa-map-marker-alt"></i> <?php echo esc_html(get_post_meta(get_the_ID(), '_city', true)); ?></div>
                                    <div class="repm-property-price"><i class="fa fa-tag"></i> <?php
                                        $price = get_post_meta(get_the_ID(), '_price', true);
                                        echo esc_html($price ? '₹' . (function_exists('repm_format_indian_currency') ? repm_format_indian_currency($price) : number_format($price)) : 'Price on Request');
                                    ?></div>
                                    <div class="repm-property-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 18); ?></div>
                                    <div class="repm-meta-box mb-2 mt-auto">
                                        <div class="repm-meta-box-item" title="Bedrooms">
                                            <i class="fa fa-bed"></i>
                                            <span class="repm-meta-box-value"><?php echo esc_html(get_post_meta(get_the_ID(), '_bedrooms', true)); ?></span>
                                        </div>
                                        <div class="repm-meta-box-item" title="Bathrooms">
                                            <i class="fa fa-bath"></i>
                                            <span class="repm-meta-box-value"><?php echo esc_html(get_post_meta(get_the_ID(), '_bathrooms', true)); ?></span>
                                        </div>
                                        <div class="repm-meta-box-item" title="Area">
                                            <i class="fa fa-expand"></i>
                                            <span class="repm-meta-box-value"><?php echo esc_html(get_post_meta(get_the_ID(), '_carpet_area', true)); ?> sq ft</span>
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
        </div>
    
        <script>
    jQuery(function($){
        // Subtype and bedroom conditional logic
    function updateFilterFields() {
        var type = $('#property_type_filter').val();
        if(type === "residential") {
            $('#bedrooms-filter').show();
            $('#residential-subtype-filter').show();
            $('#commercial-subtype-filter').hide().find('select').val('');
        } else if(type === "commercial") {
            $('#bedrooms-filter').hide().find('select').val('');
            $('#residential-subtype-filter').hide().find('select').val('');
            $('#commercial-subtype-filter').show();
        } else {
            $('#bedrooms-filter').hide().find('select').val('');
            $('#residential-subtype-filter').hide().find('select').val('');
            $('#commercial-subtype-filter').hide().find('select').val('');
        }
    }
    updateFilterFields();
    $('#property_type_filter').on('change', updateFilterFields);
        
        // More Filters toggle (delegated)
        $(document).on('click', '.btn-toggle-filters', function(e){
          e.preventDefault();
          var $form = $('#repm-listing-filter');
          $form.toggleClass('filters-expanded');
          var expanded = $form.hasClass('filters-expanded');
          $(this).find('span').text(expanded ? 'Less Filters' : 'More Filters');
      });
    
      // Price formatting for min/max
      $('input[name="min_price"], input[name="max_price"]').on('input', function(){
          let value = this.value.replace(/[^0-9]/g, '');
          if (value === '') {
              this.value = '';
              return;
          }
          let last3 = value.substring(value.length-3);
          let other = value.substring(0, value.length-3);
          if(other !== '')
              last3 = ',' + last3;
          let formatted = other.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + last3;
          this.value = '₹' + formatted;
      });
    
      // Delegated submit event (robust!)
      $(document).on('submit', '#repm-listing-filter', function(e){
          e.preventDefault();
          var $form = $(this);
          $form.removeClass('filters-expanded');
          $form.find('.btn-toggle-filters span').text('More Filters');
          $form.find('input[name="min_price"], input[name="max_price"]').each(function(){
              this.value = this.value.replace(/[^0-9]/g, '');
          });
          var data = $form.serialize();
          $('#repm-listing-results').html('<div class="text-center my-5"><i class="fa fa-spinner fa-spin fa-2x"></i></div>');
          $.get('<?php echo esc_js(admin_url('admin-ajax.php')); ?>', data+'&action=repm_filter_properties', function(resp){
              $('#repm-listing-results').html(resp);
              if (typeof Swiper !== "undefined" && $('.property-swiper').length) {
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
          });
      });
    
      // Swiper on page load
      if (typeof Swiper !== "undefined" && $('.property-swiper').length) {
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
    });
    </script>
        <?php
        return ob_get_clean();
    });
    
    // Property Listing Shortcode
    add_shortcode('property_listing', function($atts) {
        $atts = shortcode_atts([
            'posts_per_page' => 12,
        ], $atts, 'property_listing');
    
        ob_start();
    
        // Build WP_Query args (supports filters via GET)
        $args = [
            'post_type' => 'property',
            'posts_per_page' => $atts['posts_per_page'],
            'meta_query' => [],
            'tax_query' => [],
            'orderby' => 'date',
            'order' => 'DESC'
        ];
    
        // Filtering
        if (!empty($_GET['city'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'property_city',
                'field' => 'name',
                'terms' => sanitize_text_field($_GET['city'])
            ];
        }
        if (!empty($_GET['type'])) {
            $args['tax_query'][] = [
                'taxonomy' => 'property_type',
                'field' => 'slug',
                'terms' => sanitize_text_field($_GET['type'])
            ];
        }
        if (!empty($_GET['min_price'])) {
            $args['meta_query'][] = [
                'key' => '_price',
                'value' => floatval($_GET['min_price']),
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        }
        if (!empty($_GET['max_price'])) {
            $args['meta_query'][] = [
                'key' => '_price',
                'value' => floatval($_GET['max_price']),
                'type' => 'NUMERIC',
                'compare' => '<='
            ];
        }
        if (!empty($_GET['bedrooms'])) {
            $args['meta_query'][] = [
                'key' => '_bedrooms',
                'value' => intval($_GET['bedrooms']),
                'type' => 'NUMERIC',
                'compare' => '>='
            ];
        }
        // Sorting
        if (!empty($_GET['sort'])) {
            switch ($_GET['sort']) {
                case 'price_asc': $args['orderby'] = 'meta_value_num'; $args['meta_key'] = '_price'; $args['order'] = 'ASC'; break;
                case 'price_desc': $args['orderby'] = 'meta_value_num'; $args['meta_key'] = '_price'; $args['order'] = 'DESC'; break;
                case 'date_asc': $args['order'] = 'ASC'; break;
                case 'date_desc': $args['order'] = 'DESC'; break;
            }
        }
    
        $props = new WP_Query($args);
        if ($props->have_posts()) :
            while ($props->have_posts()): $props->the_post(); ?>
                <div class="card mb-3" style="max-width: 540px;">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <?php the_post_thumbnail('medium', ['class'=>'img-fluid rounded-start']); ?>
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <p class="card-text">₹<?php echo esc_html(repm_format_indian_currency(get_post_meta(get_the_ID(), '_price', true))); ?></p>
                                <p class="card-text"><small class="text-muted"><?php echo esc_html(join(', ', wp_get_post_terms(get_the_ID(), 'property_city', ['fields'=>'names']))); ?></small></p>
                                <div>
                                    <?php
                                    $amenities = wp_get_post_terms(get_the_ID(), 'property_amenities', ['fields'=>'names']);
                                    if (!function_exists('repm_amenity_icon')) { function repm_amenity_icon($a) { return 'fa-solid fa-circle-check'; } }
                                    foreach ($amenities as $amenity) {
                                        echo '<span class="me-2 text-primary"><i class="'.repm_amenity_icon($amenity).'"></i> '.esc_html($amenity).'</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; wp_reset_postdata();
        else:
            echo '<div class="alert alert-warning">No properties found with current filters.</div>';
        endif;
    
        return ob_get_clean();
    });
    
    add_shortcode('featured_properties_grid', function($atts) {
        $atts = shortcode_atts(['count' => 3], $atts, 'featured_properties_grid');
        $args = [
            'post_type' => 'property',
            'posts_per_page' => $atts['count'],
            'meta_query' => [
                [
                    'key' => '_is_featured',
                    'value' => '1'
                ]
            ]
        ];
        $query = new WP_Query($args);
    
        ob_start();
        if ($query->have_posts()) :
            echo '<div class="repm-listing-grid">';
            while ($query->have_posts()) : $query->the_post();
                $price = get_post_meta(get_the_ID(), '_price', true);
                $city = get_post_meta(get_the_ID(), '_city', true);
                $bedrooms = get_post_meta(get_the_ID(), '_bedrooms', true);
                $bathrooms = get_post_meta(get_the_ID(), '_bathrooms', true);
                $area = get_post_meta(get_the_ID(), '_carpet_area', true);
                $ownership = get_post_meta(get_the_ID(), '_ownership', true);
                ?>
                <div class="repm-property-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <div style="margin-bottom:12px;">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium', [
                                    'class'=>'img-fluid rounded',
                                    'style'=>'width:100%;height:300px;object-fit:cover;'
                                ]); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                    <div class="repm-property-title"><?php the_title(); ?></div>
                    <div class="repm-property-location"><i class="fa fa-map-marker-alt"></i> <?php echo esc_html($city); ?></div>
                    <div class="repm-property-price"><i class="fa fa-tag"></i> <?php echo esc_html($price ? '₹' . repm_format_indian_currency($price) : 'Price on Request'); ?></div>
                    <div class="repm-meta-box mb-2 mt-auto">
                        <div class="repm-meta-box-item">
                            <i class="fa fa-bed"></i>
                            <span class="repm-meta-box-label">Bedrooms:</span>
                            <span class="repm-meta-box-value"><?php echo esc_html($bedrooms); ?></span>
                        </div>
                        <div class="repm-meta-box-item">
                            <i class="fa fa-bath"></i>
                            <span class="repm-meta-box-label">Bathrooms:</span>
                            <span class="repm-meta-box-value"><?php echo esc_html($bathrooms); ?></span>
                        </div>
                        <div class="repm-meta-box-item">
                            <i class="fa fa-expand"></i>
                            <span class="repm-meta-box-label">Area:</span>
                            <span class="repm-meta-box-value"><?php echo esc_html($area); ?> sq ft</span>
                        </div>
                        <div class="repm-meta-box-item">
                            <i class="fa fa-user-shield"></i>
                            <span class="repm-meta-box-label">Ownership:</span>
                            <span class="repm-meta-box-value"><?php echo esc_html($ownership); ?></span>
                        </div>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="btn btn-outline-primary btn-sm align-self-start">View Details</a>
                </div>
                <?php
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<div class="alert alert-info">No featured properties found.</div>';
        endif;
        return ob_get_clean();
    });