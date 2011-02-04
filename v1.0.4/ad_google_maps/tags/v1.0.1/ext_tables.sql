#
# Table structure for table 'tx_adgooglemaps_domain_model_map'
#
CREATE TABLE tx_adgooglemaps_domain_model_map (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	fe_group varchar(100) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,
	categories int(11) unsigned DEFAULT '0' NOT NULL,

	map_type_id varchar(255) DEFAULT '' NOT NULL,
	width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	height mediumint(11) unsigned DEFAULT '0' NOT NULL,
	background_color varchar(7) DEFAULT '' NOT NULL,
	center_type tinyint(4) unsigned DEFAULT '0' NOT NULL,
	center varchar(255) DEFAULT '' NOT NULL,
	zoom tinyint(4) unsigned DEFAULT '0' NOT NULL,
	min_zoom tinyint(4) unsigned DEFAULT '0' NOT NULL,
	max_zoom tinyint(4) unsigned DEFAULT '0' NOT NULL,
	no_clear tinyint(4) unsigned DEFAULT '0' NOT NULL,

	disable_default_ui tinyint(4) unsigned DEFAULT '0' NOT NULL,
	map_type_control tinyint(4) unsigned DEFAULT '0' NOT NULL,
	map_type_control_options_map_type_ids varchar(255) DEFAULT '' NOT NULL,
	map_type_control_options_position varchar(255) DEFAULT '' NOT NULL,
	map_type_control_options_style varchar(255) DEFAULT '' NOT NULL,
	navigation_control tinyint(4) unsigned DEFAULT '0' NOT NULL,
	navigation_control_options_position varchar(255) DEFAULT '' NOT NULL,
	navigation_control_options_style varchar(255) DEFAULT '' NOT NULL,
	scale_control tinyint(4) unsigned DEFAULT '0' NOT NULL,
	scale_control_options_position varchar(255) DEFAULT '' NOT NULL,
	scale_control_options_style varchar(255) DEFAULT '' NOT NULL,
	pan_control tinyint(4) unsigned DEFAULT '0' NOT NULL,
	pan_control_options_position varchar(255) DEFAULT '' NOT NULL,
	zoom_control tinyint(4) unsigned DEFAULT '0' NOT NULL,
	zoom_control_options_position varchar(255) DEFAULT '' NOT NULL,
	zoom_control_options_style varchar(255) DEFAULT '' NOT NULL,
	street_view_control tinyint(4) unsigned DEFAULT '0' NOT NULL,
	street_view_control_options_position varchar(255) DEFAULT '' NOT NULL,

	disable_double_click_zoom tinyint(4) unsigned DEFAULT '0' NOT NULL,
	scrollwheel tinyint(4) unsigned DEFAULT '0' NOT NULL,
	draggable tinyint(4) unsigned DEFAULT '0' NOT NULL,
	draggable_cursor text,
	dragging_cursor text,
	keyboard_shortcuts tinyint(4) unsigned DEFAULT '0' NOT NULL,

	info_window_close_all_on_map_click tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_behaviour tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_placing_type tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_position varchar(64) DEFAULT '' NOT NULL,
	info_window_object_number varchar(64) DEFAULT '' NOT NULL,
	info_window_keep_open tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_close_on_click tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_disable_auto_pan tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_max_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	info_window_pixel_offset_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	info_window_pixel_offset_height mediumint(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY parent (pid,sorting),
	KEY language (l18n_parent,sys_language_uid)
);


#
# Table structure for table 'tx_adgooglemaps_domain_model_category'
#
CREATE TABLE tx_adgooglemaps_domain_model_category (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	fe_group varchar(100) DEFAULT '0' NOT NULL,

	title varchar(255) DEFAULT '' NOT NULL,

	icon text,
	icon_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_height mediumint(11) unsigned DEFAULT '0' NOT NULL,

	description text,
	rte_enabled tinyint(4) unsigned DEFAULT '0' NOT NULL,
	layers int(11) unsigned DEFAULT '0' NOT NULL,
	parent_category int(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY parent (pid,sorting),
	KEY language (l18n_parent,sys_language_uid)
);


#
# Table structure for table 'tx_adgooglemaps_domain_model_layer'
#
CREATE TABLE tx_adgooglemaps_domain_model_layer (
	uid int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,
	fe_group varchar(100) DEFAULT '0' NOT NULL,

	type varchar(64) DEFAULT '0' NOT NULL,

	title varchar(64) DEFAULT '0' NOT NULL,
	visible tinyint(4) unsigned DEFAULT '0' NOT NULL,
	coordinates_provider tinyint(4) unsigned DEFAULT '0' NOT NULL,
	coordinates text,
	addresses int(11) unsigned DEFAULT '0' NOT NULL,
	address_groups int(11) unsigned DEFAULT '0' NOT NULL,
	categories int(11) unsigned DEFAULT '0' NOT NULL,

	marker_clickable tinyint(4) unsigned DEFAULT '0' NOT NULL,
	shape_clickable tinyint(4) unsigned DEFAULT '0' NOT NULL,
	draggable tinyint(4) unsigned DEFAULT '0' NOT NULL,
	raise_on_drag tinyint(4) unsigned DEFAULT '0' NOT NULL,
	geodesic tinyint(4) unsigned DEFAULT '0' NOT NULL,
	marker_zindex mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shape_zindex mediumint(11) unsigned DEFAULT '0' NOT NULL,

	add_markers tinyint(4) unsigned DEFAULT '0' NOT NULL,
	item_titles text,
	item_titles_object_number varchar(64) DEFAULT '' NOT NULL,
	icon text,
	icon_object_number varchar(64) DEFAULT '' NOT NULL,
	icon_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_height mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_origin_x mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_origin_y mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_anchor_x mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_anchor_y mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_scaled_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	icon_scaled_height mediumint(11) unsigned DEFAULT '0' NOT NULL,

	shadow text,
	shadow_object_number varchar(64) DEFAULT '' NOT NULL,
	shadow_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shadow_height mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shadow_origin_x mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shadow_origin_y mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shadow_anchor_x mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shadow_anchor_y mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shadow_scaled_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	shadow_scaled_height mediumint(11) unsigned DEFAULT '0' NOT NULL,
	flat tinyint(4) unsigned DEFAULT '0' NOT NULL,

	kml_file text,
	kml_url text,
	kml_suppress_info_windows tinyint(4) unsigned DEFAULT '0' NOT NULL,

	shape_type varchar(255) DEFAULT '' NOT NULL,
	shape text,

	mouse_cursor text,

	stroke_color varchar(7) DEFAULT '' NOT NULL,
	stroke_opacity tinyint(4) unsigned DEFAULT '0' NOT NULL,
	stroke_weight tinyint(4) unsigned DEFAULT '0' NOT NULL,
	fill_color varchar(7) DEFAULT '' NOT NULL,
	fill_opacity tinyint(4) unsigned DEFAULT '0' NOT NULL,

	info_window int(11) DEFAULT '0' NOT NULL,
	info_window_placing_type tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_position varchar(64) DEFAULT '' NOT NULL,
	info_window_object_number varchar(64) DEFAULT '' NOT NULL,
	info_window_keep_open tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_close_on_click tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_disable_auto_pan tinyint(4) unsigned DEFAULT '0' NOT NULL,
	info_window_max_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	info_window_pixel_offset_width mediumint(11) unsigned DEFAULT '0' NOT NULL,
	info_window_pixel_offset_height mediumint(11) unsigned DEFAULT '0' NOT NULL,
	info_window_zindex mediumint(11) unsigned DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l18n_parent int(11) DEFAULT '0' NOT NULL,
	l18n_diffsource mediumblob NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,
	t3_origuid int(11) DEFAULT '0' NOT NULL,

	PRIMARY KEY (uid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
	KEY parent (pid,sorting),
	KEY language (l18n_parent,sys_language_uid)
);


#
# Table structure for table 'tx_adgooglemaps_map_category_mm'
#
CREATE TABLE tx_adgooglemaps_map_category_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_adgooglemaps_category_category_mm'
#
CREATE TABLE tx_adgooglemaps_category_category_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_adgooglemaps_category_layer_mm'
#
CREATE TABLE tx_adgooglemaps_category_layer_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,
	sorting_foreign int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_adgooglemaps_layer_ttcontent_mm'
#
CREATE TABLE tx_adgooglemaps_layer_ttcontent_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_adgooglemaps_layer_ttaddress_mm'
#
CREATE TABLE tx_adgooglemaps_layer_ttaddress_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tx_adgooglemaps_layer_ttaddressgroup_mm'
#
CREATE TABLE tx_adgooglemaps_layer_ttaddressgroup_mm (
	uid_local int(11) DEFAULT '0' NOT NULL,
	uid_foreign int(11) DEFAULT '0' NOT NULL,
	sorting int(11) DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);


#
# Table structure for table 'tt_address'
#
CREATE TABLE tt_address (
	tx_adgooglemaps_coordinates text
);