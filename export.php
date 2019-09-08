<?php

/**
 * Add the BB columns to the exporter and the exporter column menu.
 *
 * @param array $columns
 * @return array $columns
 */
function mytheme_add_export_column( $columns ) {

	$columns['fl_builder_data'] = 'Meta: _fl_builder_data';
	$columns['fl_builder_draft'] = 'Meta: _fl_builder_draft';

	return $columns;
}
add_filter( 'woocommerce_product_export_column_names', 'mytheme_add_export_column' );
add_filter( 'woocommerce_product_export_product_default_columns', 'mytheme_add_export_column' );

/**
 * Process the data being sent to the CSV file.
 * This is where we do the serializing. We also do a base64 encoding so that we are not affected by different encodings.
 *
 * @param mixed $value (default: '')
 * @param WC_Product $product
 * @return mixed $value - Should be in a format that can be output into a text file (string, numeric, etc).
 */
function mytheme_add_fl_builder_data( $value, $product ) {

	$value = $product->get_meta( '_fl_builder_data', true );
	return ( empty( $value ) ) ? '' : base64_encode( serialize( $value ) );
}

function mytheme_add_fl_builder_draft( $value, $product ) {

	$value = $product->get_meta( '_fl_builder_draft', true );
	return ( empty( $value ) ) ? '' : base64_encode( serialize( $value ) );
}
// Naming convention for the filters we want to hook into: 'woocommerce_product_export_product_column_{$column_slug}'.
add_filter( 'woocommerce_product_export_product_column_fl_builder_data', 'mytheme_add_fl_builder_data', 10, 2 );
add_filter( 'woocommerce_product_export_product_column_fl_builder_draft', 'mytheme_add_fl_builder_draft', 10, 2 );
