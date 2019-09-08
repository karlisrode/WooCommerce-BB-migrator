# WooCommerce-BB-migrator
Allows exporting WooCommerce products with BB elements

## Have you ever tried migrating WooCommerce products with BeaverBuilder elements?
Then you probably know that the BB elements will magically disappear and everything will be crunched into one single textarea. The reason behind this is that [WooCommerce is not allowing serialized data in their exports/imports](https://github.com/woocommerce/woocommerce/issues/18379). Hence, the ```_fl_builder_data``` and ```_fl_builder_draft``` post meta where the BB code is stored will not be included in the migration.

## Potential solution
In order for this to work you will need to undertake two steps:
- Force the export to manually add your columns and fetch your data (**export.php**)
- Force the import to manually handle your data (**import.php**)

## How-to
1. Copy and paste the contents of export.php to your functions.php file in the source site.
2. Copy and paste the contents of import.php to your functions.php file in the target site.
3. Run the WooCommerce product export as you would normally do on your source site and save the dowloaded .csv file.
4. Run the WooCommerce product import as you would normaly do on your target site with the downloaded .csv file. The added fields of ```_fl_builder_data``` and ```_fl_builder_draft``` will automatically be added correctly as new meta data.
5. Check that everything looks OK.
6. Remove the code snippets.
7. Search/replace the old domain to the new domain in the database (preferably using this script since it handles serialized data well: https://interconnectit.com/products/search-and-replace-for-wordpress-databases/, just remember to remove when finished due to security reasons!)

## Inspiration
- Adding custom export/import columns: https://github.com/woocommerce/woocommerce/wiki/Product-CSV-Importer-&-Exporter
- Solving problem with **Error at offset** when unserializing: https://www.jackreichert.com/2014/02/handling-a-php-unserialize-offset-error/ and https://stackoverflow.com/questions/19469068/unserialize-function-unserialize-error-at-offset-49151-of-49151-bytes#answer-19469339

## Future improvements
- Implement as plugin
- Only run if WooCommerce and BB are active