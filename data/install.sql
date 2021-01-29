--
-- Add new tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('contact-campaign', 'contact-single', 'Campaign', 'Recent Contact', 'fas fa-campaign', '', '1', '', '');

--
-- Add new partial
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'partial', 'Campaign', 'contact_campaign', 'contact-campaign', 'contact-single', 'col-md-12', '', '', '0', '1', '0', '', '', '');

--
-- add button
--
INSERT INTO `core_form_button` (`Button_ID`, `label`, `icon`, `title`, `href`, `class`, `append`, `form`, `mode`, `filter_check`, `filter_value`) VALUES
(NULL, 'Add Campaign', 'fas fa-campaign', 'Add Campaign', '/contact/campaign/add/##ID##', 'primary', '', 'contact-view', 'link', '', ''),
(NULL, 'Save Campaign', 'fas fa-save', 'Save Campaign', '#', 'primary saveForm', '', 'contactcampaign-single', 'link', '', '');

--
-- create campaign table
--
CREATE TABLE `contact_campaign` (
  `Campaign_ID` int(11) NOT NULL,
  `contact_idfs` int(11) NOT NULL,
  `comment` TEXT NOT NULL DEFAULT '',
  `created_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_by` int(11) NOT NULL,
  `modified_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `contact_campaign`
  ADD PRIMARY KEY (`Campaign_ID`);

ALTER TABLE `contact_campaign`
  MODIFY `Campaign_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- add campaign form
--
INSERT INTO `core_form` (`form_key`, `label`, `entity_class`, `entity_tbl_class`) VALUES
('contactcampaign-single', 'Contact Campaign', 'OnePlace\\Contact\\Campaign\\Model\\Campaign', 'OnePlace\\Contact\\Campaign\\Model\\CampaignTable');

--
-- add form tab
--
INSERT INTO `core_form_tab` (`Tab_ID`, `form`, `title`, `subtitle`, `icon`, `counter`, `sort_id`, `filter_check`, `filter_value`) VALUES
('campaign-base', 'contactcampaign-single', 'Campaign', 'Recent Contact', 'fas fa-campaign', '', '1', '', '');

--
-- add address fields
--
INSERT INTO `core_form_field` (`Field_ID`, `type`, `label`, `fieldkey`, `tab`, `form`, `class`, `url_view`, `url_list`, `show_widget_left`, `allow_clear`, `readonly`, `tbl_cached_name`, `tbl_class`, `tbl_permission`) VALUES
(NULL, 'text', 'Comment', 'comment', 'campaign-base', 'contactcampaign-single', 'col-md-6', '', '', '0', '1', '0', '', '', ''),
(NULL, 'hidden', 'Contact', 'contact_idfs', 'campaign-base', 'contactcampaign-single', 'col-md-3', '', '/', '0', '1', '0', '', '', '');

--
-- permission add campaign
--
INSERT INTO `permission` (`permission_key`, `module`, `label`, `nav_label`, `nav_href`, `show_in_menu`) VALUES
('add', 'OnePlace\\Contact\\Campaign\\Controller\\CampaignController', 'Add Campaign', '', '', '0');