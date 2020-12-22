displayPrice is a simple hook for the osC CE Phoenix adminside. It adds a yes/no field into the Product Specific table.
With a corresponding template it's usable to hide the price and display something else on the shopside.
The needed databasechanges has to be done by hand. Something like:

ALTER TABLE `products` ADD `products_dp` TINYINT(1) NOT NULL AFTER `products_gtin`;

in phpMyAdmin.
