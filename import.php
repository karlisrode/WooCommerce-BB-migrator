<?php

/**
 * Register the columns in the importer.
 *
 * @param array $options
 * @return array $options
 */
function mytheme_add_column_to_importer( $options ) {

	$options['fl_builder_data'] = 'Meta: _fl_builder_data';
	$options['fl_builder_draft'] = 'Meta: _fl_builder_draft';

	return $options;
}
add_filter( 'woocommerce_csv_product_import_mapping_options', 'mytheme_add_column_to_importer' );


/**
 * Add automatic mapping support for the columns.
 * This will automatically select the correct mapping for the columns.
 *
 * @param array $columns
 * @return array $columns
 */
function mytheme_add_column_to_mapping_screen( $columns ) {

	$columns['Meta: _fl_builder_data'] = 'fl_builder_data';
	$columns['Meta: _fl_builder_draft'] = 'fl_builder_draft';

	return $columns;
}
add_filter( 'woocommerce_csv_product_import_mapping_default_columns', 'mytheme_add_column_to_mapping_screen' );


/**
 * Process the data read from the CSV file.
 * This is where we do the unserializing. We also decode the base64 encoding previously made.
 *
 * @param WC_Product $object - Product being imported or updated.
 * @param array $data - CSV data for the product.
 * @return WC_Product $object
 */
function mytheme_process_import( $object, $data ) {

	if ( ! empty( $data['fl_builder_data'] ) ) {
		$object->update_meta_data( '_fl_builder_data', unserialize( base64_decode ( $data['fl_builder_data'] ) ) );
	}

	if ( ! empty( $data['fl_builder_draft'] ) ) {
		$object->update_meta_data( '_fl_builder_draft', unserialize( base64_decode ( $data['fl_builder_draft'] ) ) );
	}

	return $object;
}
add_filter( 'woocommerce_product_import_pre_insert_product_object', 'mytheme_process_import', 10, 2 );
