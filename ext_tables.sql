#
# Table structure for table 'tx_colormanager_domain_model_color'
#
CREATE TABLE tx_colormanager_domain_model_color (
	name varchar(255) DEFAULT '' NOT NULL,
	color varchar(255) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_colormanager_color_uid varchar(255) DEFAULT '' NOT NULL,
	tx_colormanager_color varchar(255) DEFAULT '' NOT NULL,
);