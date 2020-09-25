ALTER TABLE `af_child` ADD INDEX `child_order_idx` (`af_order_id` ASC) ;
ALTER TABLE `af_child` ADD INDEX `child_active_idx` (`ch_active` ASC) 
, ADD INDEX `child_placed_idx` (`ch_placed_ck` ASC) 
, ADD INDEX `child_config_idx` (`ch_conf_ck` ASC) 
, ADD INDEX `child_ship_idx` (`ch_ship_ck` ASC) ;
ALTER TABLE `af_attach` ADD INDEX `attach_type_idx` (`att_type` ASC) 
, ADD INDEX `attach_ref_idx` (`att_ref` ASC) 
, ADD INDEX `attach_ch_idx` (`att_ch` ASC) ;
ALTER TABLE `af_r2` ADD INDEX `r2_vend_idx` (`r2_ven_id` ASC) ;
ALTER TABLE `af_r2_items` ADD INDEX `r2_itemid_idx` (`r2i_itemid` ASC) ;
ALTER TABLE `af_items` ADD INDEX `items_itemid_idx` (`i_itemid` ASC) ;
ALTER TABLE `r2_history` ADD INDEX `history_cid_idx` (`r2_cid` ASC) ;
ALTER TABLE `email_conf` ADD INDEX `emailconf_date_idx` (`email_datetime` ASC) 
, ADD INDEX `emailconf_to_idx` (`email_to` ASC) 
, ADD INDEX `emailconf_from_idx` (`email_from` ASC) 
, ADD INDEX `emailconf_type_idx` (`email_type` ASC) ;
ALTER TABLE `af_child` ADD INDEX `child_po_idx` (`ch_po` ASC) ;
ALTER TABLE `af_child` ADD INDEX `child_vendor_idx` (`ch_vendor` ASC) ;
ALTER TABLE `af_revenue` ADD INDEX `revenue_orderid_idx` (`orderID` ASC) ;
ALTER TABLE `af_master` ADD INDEX `master_afdate_idx` (`af_date` ASC) ;
