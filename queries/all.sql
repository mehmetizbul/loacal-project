//all_images.csv
SELECT post_id,meta_value
FROM `wpdi_postmeta`
WHERE `meta_key` LIKE '_wp_attached_file'

//experience_thumbnails.csv
SELECT
        ID,postmeta.meta_value
        FROM wpdi_term_relationships
          LEFT JOIN wpdi_posts as product ON wpdi_term_relationships.object_id = product.ID
          LEFT JOIN wpdi_postmeta as postmeta ON postmeta.post_id = product.ID
          LEFT JOIN wpdi_postmeta as images ON images.post_id = postmeta.meta_value
        WHERE post_type = 'product' AND (postmeta.meta_key = "_thumbnail_id") AND postmeta.meta_value IS NOT NULL AND postmeta.meta_value != ""
GROUP BY ID

//experience_images.csv
SELECT
        ID,postmeta.meta_value
        FROM wpdi_term_relationships
          LEFT JOIN wpdi_posts as product ON wpdi_term_relationships.object_id = product.ID
          LEFT JOIN wpdi_postmeta as postmeta ON postmeta.post_id = product.ID
          LEFT JOIN wpdi_postmeta as images ON images.post_id = postmeta.meta_value
        WHERE post_type = 'product' AND (postmeta.meta_key = "_product_image_gallery") AND postmeta.meta_value IS NOT NULL AND postmeta.meta_value != ""
GROUP BY ID

//users.csv
SELECT
  ID as id,
  display_name as name,
  user_nicename as slug,
  user_email as email,
  user_registered as created_at,
  admin.meta_value as capabilities
FROM `wpdi_users`
  LEFT JOIN (
              SELECT meta_value, user_id
              FROM wpdi_usermeta
              WHERE meta_key = "wpdi_capabilities"
            ) as admin ON admin.user_id = ID


//resources.csv
SELECT
  wpdi_posts.ID as id,
  post_title as title,
  -- MAX(IF(meta_key = '_wc_booking_availability', meta_value, "a:0:{}")) AS _wc_booking_availability,
  post_date as created_at,
  post_modified as updated_at
FROM wpdi_posts
WHERE post_type ="bookable_resource"

//experiences.csv
SELECT
  product.ID as id,
  product.post_author as author,
  product.post_title as title,
  product.post_excerpt as description,
  product.post_status as status,
  product.post_name as slug,
  product.menu_order,
  product.post_date as created_at,
  product.post_modified as updated_at
FROM wpdi_term_relationships
  LEFT JOIN wpdi_posts as product ON wpdi_term_relationships.object_id = product.ID
  LEFT JOIN wpdi_term_taxonomy ON wpdi_term_taxonomy.term_taxonomy_id = wpdi_term_relationships.term_taxonomy_id
  LEFT JOIN wpdi_terms ON wpdi_terms.term_id = wpdi_term_relationships.term_taxonomy_id
WHERE post_type = 'product'
GROUP BY id


//experience_vendors.csv
SELECT
wpdi_term_relationships.object_id as id,
wpdi_termmeta.meta_value as vendor_data
FROM `wpdi_term_taxonomy`
LEFT JOIN wpdi_term_relationships ON wpdi_term_taxonomy.term_taxonomy_id = wpdi_term_relationships.term_taxonomy_id
LEFT JOIN wpdi_posts ON wpdi_posts.ID = wpdi_term_relationships.object_id
LEFT JOIN wpdi_termmeta ON wpdi_term_taxonomy.term_id = wpdi_termmeta.term_id
WHERE taxonomy LIKE "wcpv_product_vendors" AND id IS NOT NULL ORDER BY id ASC


//experience_friendlies.csv
SELECT
	object_id,
    wpdi_terms.term_id
FROM `wpdi_term_relationships`
LEFT JOIN wpdi_term_taxonomy ON wpdi_term_relationships.term_taxonomy_id = wpdi_term_taxonomy.term_taxonomy_id
LEFT JOIN wpdi_terms ON wpdi_terms.term_id = wpdi_term_taxonomy.term_id
WHERE taxonomy = "pa_friendly"

//experience_country_and_languages.csv
SELECT
	object_id,
    taxonomy,
    wpdi_terms.term_id,
    name
FROM `wpdi_term_relationships`
LEFT JOIN wpdi_term_taxonomy ON wpdi_term_relationships.term_taxonomy_id = wpdi_term_taxonomy.term_taxonomy_id
LEFT JOIN wpdi_terms ON wpdi_terms.term_id = wpdi_term_taxonomy.term_id
WHERE taxonomy = "pa_languages" OR taxonomy = "pa_country"

--experience_pricing.csv
SELECT
  productmeta.post_id,
  MAX(IF(meta_key = '_price', meta_value, 0)) AS price,
  MAX(IF(meta_key = '_wc_booking_cost', meta_value, 0)) AS cost,
  MAX(IF(meta_key = '_wc_display_cost', meta_value, 0)) AS display_cost,
  MAX(IF(meta_key = '_wc_booking_duration', meta_value, 1)) AS duration,
  MAX(IF(meta_key = '_wc_booking_duration_unit', meta_value, "hour")) AS duration_unit,
  MAX(IF(meta_key = '_wc_booking_min_persons_group', meta_value, 1)) AS "min",
  MAX(IF(meta_key = '_wc_booking_max_persons_group', meta_value, 0)) AS "max",
  MAX(IF(meta_key = '_purchase_note', meta_value, "a:0:{}")) AS purchase_note,
  MAX(IF(meta_key = '_wc_booking_pricing', meta_value, NULL)) AS price_models,
  MAX(IF(meta_key = '_resource_base_costs', meta_value, "a:0:{}")) AS resources
FROM wpdi_posts as product
  INNER JOIN wpdi_postmeta as productmeta ON product.ID = productmeta.post_id
WHERE
  (product.post_type = 'product' OR product.post_type = 'product_variation')
  AND meta_value IS NOT NULL
  AND meta_value != ""
GROUP BY post_id

//experience_categories.csv
SELECT
	id,
    GROUP_CONCAT(wpdi_terms.term_id SEPARATOR ', ') as categories
FROM wpdi_term_relationships
  LEFT JOIN wpdi_posts as product ON wpdi_term_relationships.object_id = product.ID
  LEFT JOIN wpdi_term_taxonomy ON wpdi_term_taxonomy.term_taxonomy_id = wpdi_term_relationships.term_taxonomy_id
  LEFT JOIN wpdi_terms ON wpdi_terms.term_id = wpdi_term_relationships.term_taxonomy_id
WHERE post_type = 'product' AND taxonomy = 'product_cat'
AND id IN (
            SELECT
          product.ID as id
        FROM wpdi_term_relationships
          LEFT JOIN wpdi_posts as product ON wpdi_term_relationships.object_id = product.ID
          LEFT JOIN wpdi_term_taxonomy ON wpdi_term_taxonomy.term_taxonomy_id = wpdi_term_relationships.term_taxonomy_id
          LEFT JOIN wpdi_terms ON wpdi_terms.term_id = wpdi_term_relationships.term_taxonomy_id
        WHERE post_type = 'product'
        GROUP BY id
    )
GROUP BY id

//categories.csv
SELECT wpdi_terms.term_id,name,slug,parent
FROM wpdi_terms
  LEFT JOIN wpdi_term_taxonomy ON wpdi_term_taxonomy.term_id = wpdi_terms.term_id
WHERE
  taxonomy='product_cat'
ORDER BY name ASC

//experience_transportation.csv
SELECT
	object_id,
    wpdi_terms.term_id
FROM `wpdi_term_relationships`
LEFT JOIN wpdi_term_taxonomy ON wpdi_term_relationships.term_taxonomy_id = wpdi_term_taxonomy.term_taxonomy_id
LEFT JOIN wpdi_terms ON wpdi_terms.term_id = wpdi_term_taxonomy.term_id
WHERE taxonomy = "pa_transportation"

//experience_accommodation.csv
SELECT
	object_id,
    wpdi_terms.term_id
FROM `wpdi_term_relationships`
LEFT JOIN wpdi_term_taxonomy ON wpdi_term_relationships.term_taxonomy_id = wpdi_term_taxonomy.term_taxonomy_id
LEFT JOIN wpdi_terms ON wpdi_terms.term_id = wpdi_term_taxonomy.term_id
WHERE taxonomy = "pa_accomodation"

//experience_availability.csv
SELECT post_id,meta_value FROM `wpdi_postmeta` WHERE meta_key LIKE "_wc_booking_availability" AND meta_value NOT LIKE "a:0:{}"

