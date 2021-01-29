--
-- add type fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'select', 'Type', 'type_idfs', 'campaign-base', 'contactcampaign-single', 'col-md-3', '', '/tag/api/list/contactcampaign-single/type', 0, 1, 0, 'entitytag-single', 'OnePlace\\Tag\\Model\\EntityTagTable', 'add-OnePlace\\Contact\\Campaign\\Controller\\TypeController'),
(NULL, 'datetime', 'Date', 'date', 'campaign-base', 'contactcampaign-single', 'col-md-2', '', '', 0, 1, 0, '', '', '');

--
-- permission
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Campaign\\Controller\\TypeController', 'Add Type', '', '', '0'),
('index', 'OnePlace\\Contact\\Campaign\\Controller\\CampaignController', 'Campaign Index', '', '', '0'),
('create', 'OnePlace\\Contact\\Campaign\\Controller\\CampaignController', 'Create Campaign', '', '', '0'),
('view', 'OnePlace\\Contact\\Campaign\\Controller\\CampaignController', 'View Campaign', '', '', '0'),
('list', 'OnePlace\\Contact\\Campaign\\Controller\\ApiController', 'List Campaigns', '', '', '0');

--
-- custom tags
--
INSERT INTO `core_entity_tag` (`Entitytag_ID`, `entity_form_idfs`, `tag_idfs`, `tag_value`, `tag_icon`, `parent_tag_idfs`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(NULL, 'contactcampaign-single', (select `Tag_ID` from `core_tag` where `tag_key`='type'), 'E-Mail incoming', '', '0', '1', CURRENT_TIME(), '1', CURRENT_TIME()),
(NULL, 'contactcampaign-single', (select `Tag_ID` from `core_tag` where `tag_key`='type'), 'E-Mail outgoing', '', '0', '1', CURRENT_TIME(), '1', CURRENT_TIME()),
(NULL, 'contactcampaign-single', (select `Tag_ID` from `core_tag` where `tag_key`='type'), 'Mail incoming', '', '0', '1', CURRENT_TIME(), '1', CURRENT_TIME()),
(NULL, 'contactcampaign-single', (select `Tag_ID` from `core_tag` where `tag_key`='type'), 'Mail outgoing', '', '0', '1', CURRENT_TIME(), '1', CURRENT_TIME()),
(NULL, 'contactcampaign-single', (select `Tag_ID` from `core_tag` where `tag_key`='type'), 'Phone incoming', '', '0', '1', CURRENT_TIME(), '1', CURRENT_TIME()),
(NULL, 'contactcampaign-single', (select `Tag_ID` from `core_tag` where `tag_key`='type'), 'Phone outgoing', '', '0', '1', CURRENT_TIME(), '1', CURRENT_TIME());

--
-- quicksearch fix
--
INSERT INTO `settings` (`settings_key`, `settings_value`) VALUES ('quicksearch-contactcampaign-customlabel', 'comment');

--
-- buttons
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Campaigns', 'fas fa-address-card', 'Campaigns', '/contact/campaign', 'secondary', '', 'contact-index', 'link', '', ''),
(NULL, 'Add Campaign', 'fas fa-plus', 'Add Campaign', '/contact/campaign/create', 'primary', '', 'campaign-index', 'link', '', ''),
(NULL, 'Save Campaign', 'fas fa-save', 'Save Campaign', '#', 'primary saveForm', '', 'campaign-single', 'link', '', '');

--
-- campaign index
--
INSERT INTO `core_index_table` (`table_name`, `form`, `label`) VALUES ('campaign-index', 'campaign-single', 'Campaign Index');

