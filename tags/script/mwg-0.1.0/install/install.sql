CREATE TABLE `a_tr` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  `amount` float(10,4) NOT NULL default '0.0000',
  `status` tinyint(1) unsigned default '0',
  `comments` text,
  `dt` datetime default NULL,
  `product_id` int(11) NOT NULL default '0',
  `buyer_id` int(11) NOT NULL default '0',
  `session` varchar(255) NOT NULL default '',
  `date_paid` datetime NOT NULL,
  `admin_note` varchar(255) NOT NULL,
  PRIMARY KEY  (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `id_2` (`id`,`member_id`,`group_id`,`status`,`dt`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `after_login` (
  `id` int(11) NOT NULL auto_increment,
  `nr_days` int(11) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `message` longblob NOT NULL,
  `active` tinyint(4) NOT NULL default '0',
  `membership` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `autoresponder_config` (
  `id` int(11) NOT NULL auto_increment,
  `field` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `arp_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=136 ;
INSERT INTO `autoresponder_config` VALUES (1, 'first_name', 'web_firstname', 1);
INSERT INTO `autoresponder_config` VALUES (2, 'method', '2', 1);
INSERT INTO `autoresponder_config` VALUES (3, 'arp_name', 'EmailAces', 1);
INSERT INTO `autoresponder_config` VALUES (4, 'url', 'http://www.emailaces.com/interface/web_interface_pim.php', 1);
INSERT INTO `autoresponder_config` VALUES (5, 'email', 'web_email', 1);
INSERT INTO `autoresponder_config` VALUES (6, 'action', 'insert your value', 1);
INSERT INTO `autoresponder_config` VALUES (7, 'web_pass_standard', 'insert your value', 1);
INSERT INTO `autoresponder_config` VALUES (8, 'web_pass_custom', 'insert your value', 1);
INSERT INTO `autoresponder_config` VALUES (9, 'web_account', 'insert your value', 1);
INSERT INTO `autoresponder_config` VALUES (10, 'web_redirect', 'insert your value', 1);
INSERT INTO `autoresponder_config` VALUES (11, 'track_code', 'insert your value', 1);
INSERT INTO `autoresponder_config` VALUES (12, '', '', 1);
INSERT INTO `autoresponder_config` VALUES (13, '', '', 1);
INSERT INTO `autoresponder_config` VALUES (14, '', '', 1);
INSERT INTO `autoresponder_config` VALUES (15, '', '', 1);
INSERT INTO `autoresponder_config` VALUES (49, 'url', 'http://www.getresponse.com/cgi-bin/add.cgi', 2);
INSERT INTO `autoresponder_config` VALUES (50, 'email', 'category3', 2);
INSERT INTO `autoresponder_config` VALUES (51, 'category1', 'insert your value', 2);
INSERT INTO `autoresponder_config` VALUES (46, 'first_name', 'category2', 2);
INSERT INTO `autoresponder_config` VALUES (47, 'method', '2', 2);
INSERT INTO `autoresponder_config` VALUES (48, 'arp_name', 'GetResponse', 2);
INSERT INTO `autoresponder_config` VALUES (52, 'ref', 'insert your value', 2);
INSERT INTO `autoresponder_config` VALUES (53, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (54, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (55, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (56, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (57, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (58, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (59, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (60, '', '', 2);
INSERT INTO `autoresponder_config` VALUES (61, 'first_name', 'first_name', 3);
INSERT INTO `autoresponder_config` VALUES (62, 'method', '2', 3);
INSERT INTO `autoresponder_config` VALUES (63, 'arp_name', 'AutoResponsePlus3', 3);
INSERT INTO `autoresponder_config` VALUES (64, 'url', 'http://INSERT_YOUR_SITE/cgi-bin/arp3/arp3-formcapture.pl', 3);
INSERT INTO `autoresponder_config` VALUES (65, 'email', 'email', 3);
INSERT INTO `autoresponder_config` VALUES (66, 'capitals', 'insert your value', 3);
INSERT INTO `autoresponder_config` VALUES (67, 'tracking_tag', 'insert your value', 3);
INSERT INTO `autoresponder_config` VALUES (68, 'id', 'insert your value', 3);
INSERT INTO `autoresponder_config` VALUES (69, 'extra_ar', 'insert your value', 3);
INSERT INTO `autoresponder_config` VALUES (70, '', '', 3);
INSERT INTO `autoresponder_config` VALUES (71, '', '', 3);
INSERT INTO `autoresponder_config` VALUES (72, '', '', 3);
INSERT INTO `autoresponder_config` VALUES (73, '', '', 3);
INSERT INTO `autoresponder_config` VALUES (74, '', '', 3);
INSERT INTO `autoresponder_config` VALUES (75, '', '', 3);
INSERT INTO `autoresponder_config` VALUES (76, 'first_name', 'name', 4);
INSERT INTO `autoresponder_config` VALUES (77, 'method', '2', 4);
INSERT INTO `autoresponder_config` VALUES (78, 'arp_name', 'ProSender', 4);
INSERT INTO `autoresponder_config` VALUES (79, 'url', 'http://clients.prosender.com/scripts/addlead.pl', 4);
INSERT INTO `autoresponder_config` VALUES (80, 'email', 'from', 4);
INSERT INTO `autoresponder_config` VALUES (81, 'meta_forward_vars', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (82, 'meta_required', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (83, 'meta_message', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (84, 'meta_adtracking', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (85, 'redirect', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (86, 'unit', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (87, 'meta_split_id', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (88, 'meta_web_form_id', 'insert your value', 4);
INSERT INTO `autoresponder_config` VALUES (89, '', '', 4);
INSERT INTO `autoresponder_config` VALUES (90, '', '', 4);
INSERT INTO `autoresponder_config` VALUES (91, 'first_name', 'name', 5);
INSERT INTO `autoresponder_config` VALUES (92, 'method', '2', 5);
INSERT INTO `autoresponder_config` VALUES (93, 'arp_name', 'Aweber', 5);
INSERT INTO `autoresponder_config` VALUES (94, 'url', 'http://clients.aweber.com/scripts/addlead.pl', 5);
INSERT INTO `autoresponder_config` VALUES (95, 'email', 'from', 5);
INSERT INTO `autoresponder_config` VALUES (96, 'meta_forward_vars', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (97, 'meta_required', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (98, 'meta_message', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (99, 'meta_adtracking', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (100, 'redirect', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (101, 'unit', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (102, 'meta_split_id', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (103, 'meta_web_form_id', 'insert your value', 5);
INSERT INTO `autoresponder_config` VALUES (104, '', '', 5);
INSERT INTO `autoresponder_config` VALUES (105, '', '', 5);
INSERT INTO `autoresponder_config` VALUES (106, 'first_name', 'Name', 6);
INSERT INTO `autoresponder_config` VALUES (107, 'method', '2', 6);
INSERT INTO `autoresponder_config` VALUES (108, 'arp_name', '1ShoppingCart', 6);
INSERT INTO `autoresponder_config` VALUES (109, 'url', 'http://www.mcssl.com/app/contactsave.asp', 6);
INSERT INTO `autoresponder_config` VALUES (110, 'email', 'Email1', 6);
INSERT INTO `autoresponder_config` VALUES (111, 'merchantid', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (112, 'ARThankyouURL', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (113, 'copyarresponse', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (114, 'custom', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (115, 'defaultar', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (116, 'allowmulti', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (117, 'visiblefields', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (118, 'requiredfields', 'insert your value', 6);
INSERT INTO `autoresponder_config` VALUES (119, '', '', 6);
INSERT INTO `autoresponder_config` VALUES (120, '', '', 6);
INSERT INTO `autoresponder_config` VALUES (121, 'first_name', 'Name', 7);
INSERT INTO `autoresponder_config` VALUES (122, 'method', '2', 7);
INSERT INTO `autoresponder_config` VALUES (123, 'arp_name', 'AutoContactor', 7);
INSERT INTO `autoresponder_config` VALUES (124, 'url', 'http://www.mcssl.com/app/contactsave.asp', 7);
INSERT INTO `autoresponder_config` VALUES (125, 'email', 'Email1', 7);
INSERT INTO `autoresponder_config` VALUES (126, 'merchantid', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (127, 'ARThankyouURL', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (128, 'copyarresponse', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (129, 'custom', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (130, 'defaultar', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (131, 'allowmulti', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (132, 'visiblefields', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (133, 'requiredfields', 'insert your value', 7);
INSERT INTO `autoresponder_config` VALUES (134, '', '', 7);
INSERT INTO `autoresponder_config` VALUES (135, '', '', 7);
CREATE TABLE `autoresponders` (
  `id` int(11) NOT NULL auto_increment,
  `from_email` varchar(255) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `header` text NOT NULL,
  `body` text NOT NULL,
  `footer` text NOT NULL,
  `membership` tinyint(2) NOT NULL default '0',
  `days` tinyint(2) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `sent` int(11) NOT NULL default '0',
  `filter` text NOT NULL default '',
  `sendby` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=17 ;
CREATE TABLE `ban_rules` (
  `id` int(11) NOT NULL auto_increment,
  `ban` varchar(255) NOT NULL default '',
  `rule` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `buybuttons` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0',
  `image` varchar(255) NOT NULL default '',
  `url` tinyint(1) NOT NULL default '0',
  `processor` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `cycle` (
  `id` int(11) NOT NULL auto_increment,
  `cycle` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `file` varchar(255) NOT NULL default '',
  `display` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `cycle_stats` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(255) NOT NULL default '',
  `page` varchar(20) NOT NULL default '',
  `used` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=4 ;
CREATE TABLE `downloadprotect` (
  `id` int(11) NOT NULL auto_increment,
  `file` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `memberfile` varchar(255) NOT NULL default '',
  `membership_id` int(11) NOT NULL default '0',
  `manual` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `faq` (
  `id` int(10) NOT NULL auto_increment,
  `faq_category` varchar(255) NOT NULL default '',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `position` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `faq_category` (`faq_category`),
  KEY `position` (`position`)
) TYPE=MyISAM AUTO_INCREMENT=6 ;
CREATE TABLE `levels` (
  `id` int(10) NOT NULL auto_increment,
  `membership_id` int(10) NOT NULL default '0',
  `level` int(3) NOT NULL default '0',
  `value` float(8,2) NOT NULL default '0.00',
  `paytype` enum('percent','full_amount','percent_split','full_amount_split') NOT NULL default 'percent',
  `product_id` int(10) NOT NULL default '0',
  `jv1` float(8,2) NOT NULL default '0.00',
  `jv2` float(8,2) NOT NULL default '0.00',
  `highcom` tinyint(1) NOT NULL default '0',
  `highval` int(11) NOT NULL default '0',
  `highdays` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `membership_id` (`membership_id`,`level`,`paytype`),
  KEY `product_id` (`product_id`)
) TYPE=MyISAM AUTO_INCREMENT=182 ;
CREATE TABLE `member_journal` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `date_added` DATETIME NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `member_id` (`member_id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `member_notes` (
  `id` int(11) NOT NULL auto_increment,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL default '0',
  `writer` varchar(255) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `members` (
  `id` int(10) NOT NULL auto_increment,
  `first_name` varchar(64) NOT NULL default '',
  `last_name` varchar(64) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `s_date` int(11) default NULL,
  `paypal_email` varchar(255) NOT NULL default '',
  `stormpay_email` varchar(255) NOT NULL default '',
  `password` varchar(64) NOT NULL default '',
  `city` varchar(128) NOT NULL default '',
  `state` varchar(64) NOT NULL default '',
  `zip` varchar(32) NOT NULL default '',
  `address` varchar(255) NOT NULL default '',
  `country` varchar(255) NOT NULL default '',
  `home_phone` varchar(64) NOT NULL default '',
  `work_phone` varchar(64) NOT NULL default '',
  `cell_phone` varchar(64) NOT NULL default '',
  `icq_id` varchar(128) NOT NULL default '',
  `msn_id` varchar(128) NOT NULL default '',
  `yahoo_id` varchar(128) NOT NULL default '',
  `ssn` varchar(64) NOT NULL default '',
  `url1` varchar(255) NOT NULL default '',
  `url2` varchar(255) NOT NULL default '',
  `url3` varchar(255) NOT NULL default '',
  `aff` int(10) NOT NULL default '0',
  `membership_id` int(10) NOT NULL default '1',
  `upgrade_date` int(14) NOT NULL default '0',
  `p_email` tinyint(1) NOT NULL default '1',
  `p_first_name` tinyint(1) NOT NULL default '1',
  `p_last_name` tinyint(1) NOT NULL default '1',
  `p_paypal_email` tinyint(1) NOT NULL default '0',
  `p_stormpay_email` tinyint(1) NOT NULL default '0',
  `p_address` tinyint(1) NOT NULL default '1',
  `p_city` tinyint(1) NOT NULL default '1',
  `p_state` tinyint(1) NOT NULL default '1',
  `p_zip` tinyint(1) NOT NULL default '1',
  `p_country` tinyint(1) NOT NULL default '1',
  `p_home_phone` tinyint(1) NOT NULL default '0',
  `p_cell_phone` tinyint(1) NOT NULL default '0',
  `p_work_phone` tinyint(1) NOT NULL default '0',
  `p_msn_id` tinyint(1) NOT NULL default '1',
  `p_yahoo_id` tinyint(1) NOT NULL default '1',
  `p_icq_id` tinyint(1) NOT NULL default '1',
  `p_ssn` tinyint(1) NOT NULL default '1',
  `p_url1` tinyint(1) NOT NULL default '1',
  `p_url2` tinyint(1) NOT NULL default '1',
  `p_url3` tinyint(1) NOT NULL default '1',
  `public_profile` tinyint(1) NOT NULL default '1',
  `oto1` tinyint(1) NOT NULL default '0',
  `oto2` tinyint(1) NOT NULL default '0',
  `jv` tinyint(1) NOT NULL default '0',
  `unsubscribed` tinyint(1) NOT NULL default '0',
  `code` varchar(64) NOT NULL default '',
  `active` tinyint(1) NOT NULL default '0',
  `last_mail` date NOT NULL default '0000-00-00',
  `suspended` tinyint(1) NOT NULL default '0',
  `credits` int(11) NOT NULL default '0',
  `ip` varchar(15) NOT NULL default '',
  `seen` tinyint(1) NOT NULL default '0',
  `last_login` datetime NOT NULL default '0000-00-00 00:00:00',
  `clickbank_id` varchar(255) NOT NULL default '',
  `unsub_downline` tinyint(4) NOT NULL default '0',
  `nr_logins` int(11) NOT NULL default '0',
  `msg_viewed` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `email` (`email`),
  KEY `aff` (`aff`),
  KEY `membership_id` (`membership_id`)
) TYPE=MyISAM AUTO_INCREMENT={autoincrementstartfrom};
INSERT INTO `members` VALUES (1, 'HelpDesk', 'Support', 'support@sitename.com', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 0, 10, 1138665223, 1, 1, 1, 0, 0, 1, 1, 1, 1, 1, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, '', 0, '0000-00-00', 0, 0, '', 0, '0000-00-00 00:00:00', '', 0, 0, '');
CREATE TABLE `membership` (
  `id` int(3) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `template_id` int(10) NOT NULL default '0',
  `rank` tinyint(2) NOT NULL default '0',
  `promo_code` varchar(255) NOT NULL default 'NONE',
  `template_id2` int(10) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `ref_no` int(11) NOT NULL default '0',
  `shown_to` varchar(255) NOT NULL default '',
  KEY `id` (`id`,`name`),
  KEY `template_id` (`template_id`),
  KEY `rank` (`rank`,`promo_code`),
  KEY `template_id2` (`template_id2`),
  KEY `active` (`active`)
) TYPE=MyISAM PACK_KEYS=1 AUTO_INCREMENT=10 ;
INSERT INTO `membership` VALUES (1, 'FREE', 53, 1, 'NONE', 54, 1, 0, '');
INSERT INTO `membership` VALUES (2, 'PAID', 55, 4, 'NONE', 56, 1, 0, '');
INSERT INTO `membership` VALUES (3, 'PRO1 - One Time Offer', 57, 2, 'NONE', 25, 1, 0, '');
INSERT INTO `membership` VALUES (4, 'PRO2 - One Time Offer', 59, 3, 'NONE', 40, 1, 0, '');
INSERT INTO `membership` VALUES (5, 'SILVER', 61, 5, 'NONE', 62, 1, 0, '');
INSERT INTO `membership` VALUES (6, 'GOLD', 63, 6, 'NONE', 64, 1, 0, '');
INSERT INTO `membership` VALUES (7, 'PLATINUM', 65, 7, 'NONE', 66, 1, 0, '');
INSERT INTO `membership` VALUES (8, 'DIAMOND', 67, 8, 'NONE', 68, 1, 0, '');
INSERT INTO `membership` VALUES (9, 'ELITE', 69, 9, 'NONE', 70, 1, 0, '');
CREATE TABLE `menu_permissions` (
  `id` int(11) NOT NULL auto_increment,
  `menu_item` tinyint(4) NOT NULL default '0',
  `membership_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `menus` (
  `id` int(10) NOT NULL auto_increment,
  `menu_category` enum('main','members') NOT NULL default 'main',
  `name` varchar(255) NOT NULL default '',
  `link` text NOT NULL,
  `position` int(5) NOT NULL default '0',
  `open_new_window` tinyint(1) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`),
  KEY `menu_category` (`menu_category`),
  KEY `position` (`position`)
) TYPE=MyISAM AUTO_INCREMENT=26 ;
INSERT INTO `menus` VALUES (1, 'main', 'Home', 'index.php', 1, 0, 1);
INSERT INTO `menus` VALUES (2, 'main', 'FAQ', 'faq.php', 2, 0, 1);
INSERT INTO `menus` VALUES (10, 'members', 'FAQ', 'faq.php', 10, 0, 1);
INSERT INTO `menus` VALUES (3, 'main', 'Sign Up', 'signup.php', 3, 0, 1);
INSERT INTO `menus` VALUES (4, 'main', 'Terms & Conditions', 'terms.php', 5, 0, 1);
INSERT INTO `menus` VALUES (5, 'main', 'Login', 'login.php', 4, 0, 1);
INSERT INTO `menus` VALUES (6, 'members', 'Home', 'member.area.profile.php', 1, 0, 1);
INSERT INTO `menus` VALUES (7, 'members', 'Logout', 'member.area.logout.php', 11, 0, 1);
INSERT INTO `menus` VALUES (8, 'members', 'Profile Directory', 'member.area.directory.php', 2, 0, 1);
INSERT INTO `menus` VALUES (9, 'members', 'Inbox ({inbox})', 'member.area.inbox.php', 3, 0, 1);
INSERT INTO `menus` VALUES (19, 'members', 'Promo Tools', 'member.area.promo.tools.php', 6, 0, 1);
INSERT INTO `menus` VALUES (18, 'members', 'About Us', 'about.us.ag.php', 12, 1, 1);
INSERT INTO `menus` VALUES (20, 'members', 'Membership', 'member.area.membership.ag.php', 7, 0, 1);
INSERT INTO `menus` VALUES (21, 'members', 'Affiliate Earnings', 'a.aff.info.php', 8, 0, 1);
INSERT INTO `menus` VALUES (22, 'members', 'HelpDesk', 'member.area.write.message.php?id=1', 9, 0, 1);
INSERT INTO `menus` VALUES (23, 'members', 'Earn Money', 'member.area.earn.money.ag.php', 5, 0, 1);
INSERT INTO `menus` VALUES (24, 'members', 'Journal', 'member.area.notes.php', 4, 0, 0);
CREATE TABLE `messages` (
  `id` int(10) NOT NULL auto_increment,
  `member_id` int(10) NOT NULL default '0',
  `from_member_id` int(11) NOT NULL default '0',
  `subject` varchar(255) NOT NULL default '',
  `body` text NOT NULL,
  `time_sent` time NOT NULL default '00:00:00',
  `date_sent` date NOT NULL default '0000-00-00',
  `read_flag` tinyint(1) NOT NULL default '0',
  KEY `id` (`id`,`member_id`,`time_sent`,`date_sent`),
  KEY `from_member_id` (`from_member_id`)
) TYPE=MyISAM AUTO_INCREMENT=30 ;
CREATE TABLE `payment_log` (
  `id` int(11) NOT NULL auto_increment,
  `process_type` varchar(30) NOT NULL default '',
  `comment` text NOT NULL,
  `stamp` int(11) default NULL,
  `txn_id` varchar(255) NOT NULL default '0',
  `product` varchar(255) NOT NULL default '',
  `ip` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=19 ;
CREATE TABLE `pending` (
  `id` int(11) NOT NULL auto_increment,
  `autoresponder_id` int(11) NOT NULL default '0',
  `to_email` varchar(50) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `body` text NOT NULL,
  `from_email` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=119 ;
CREATE TABLE `products` (
  `id` int(10) NOT NULL auto_increment,
  `price` float(8,2) NOT NULL default '0.00',
  `membership_id` int(10) NOT NULL default '0',
  `nid` varchar(255) NOT NULL default '',
  `display_name` varchar(255) NOT NULL default '',
  `recurring` tinyint(1) NOT NULL default '0',
  `period` int(11) NOT NULL default '0',
  `type` char(1) NOT NULL default '',
  `times` int(11) NOT NULL default '0',
  `signup` tinyint(1) NOT NULL default '0',
  `nid_clickbank` int(11) NOT NULL default '0',
  `nid_2co` int(11) NOT NULL default '0',
  `cb_but` int(11) NOT NULL default '0',
  `pp_but` int(11) NOT NULL default '0',
  `2co_but` int(11) NOT NULL default '0',
  `auth_but` int(11) NOT NULL default '0',
  `trial` tinyint(1) NOT NULL default '0',
  `trial_amount` float(6,2) NOT NULL default '0.00',
  `trial_period` int(11) NOT NULL default '0',
  `trial_period_type` char(1) NOT NULL default '',
  `paypal` tinyint(4) NOT NULL default '0',
  `clickbank` tinyint(4) NOT NULL default '0',
  `auth` tinyint(4) NOT NULL default '0',
  `2co` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `membership_id` (`membership_id`)
) TYPE=MyISAM AUTO_INCREMENT=14 ;
INSERT INTO `products` VALUES (1, 50.00, 3, 'OTO1', 'One Time Offer', 0, 0, 'D', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (2, 10.00, 4, 'OTO2', 'One Time Offer Upsell', 0, 0, 'D', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (3, 20.00, 2, 'PAID', 'PAID MEMBERSHIP', 0, 0, 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (4, 30.00, 5, 'SILVER', 'SILVER  MEMBERSIP', 0, 0, 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (5, 40.00, 6, 'GOLD', 'GOLD MEMBERSHIP', 0, 0, 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (6, 50.00, 7, 'PLATINUM', 'PLATINUM MEMBERSHIP', 0, 0, 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (7, 60.00, 8, 'DIAMOND', 'DIAMOMD MEMBERSHIP', 0, 0, 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (8, 70.00, 9, 'ELITE', 'ELITE MEMBERSHIP', 0, 0, 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (10, 10.00, 3, 'OTO_BCK', 'OTO BACKUP', 0, 0, 'D', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
INSERT INTO `products` VALUES (11, 10.00, 4, 'OTO2_BCK', 'OTO2 Backup', 0, 0, 'D', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0.00, 0, 'D', 0, 0, 0, 0);
CREATE TABLE `promo_tools` (
  `id` int(10) NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default '',
  `content` text NOT NULL,
  `template` tinyint(1) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `category` (`category`),
  KEY `template` (`template`)
) TYPE=MyISAM AUTO_INCREMENT=54 ;
INSERT INTO `promo_tools` VALUES (1, 'Emails', '<TABLE width=550 border=0>\r\n<TBODY>\r\n<TR>\r\n<TD width=114>Email Subject:</TD>\r\n<TD width=426>[FIRSTNAME], check this out!</TD></TR>\r\n<TR>\r\n<TD>Email Body: </TD>\r\n<TD>\r\n<P><SPAN style="FONT-FAMILY: Trebuchet MS">[FIRSTNAME],<BR>I just wanted to show you a cool site:</SPAN></P>\r\n<P><SPAN style="FONT-FAMILY: Trebuchet MS">{aff_link}</SPAN></P>\r\n<P><SPAN style="FONT-FAMILY: Trebuchet MS">Thanks,<BR>{name}.</SPAN></P></TD></TR></TBODY></TABLE>', 0, 0);
INSERT INTO `promo_tools` VALUES (2, 'Emails', '<table width="550" border="0">\r\n  <tr>\r\n    <td width="114">Email Subject:</td>\r\n    <td width="426">Fill here the email subject. </td>\r\n  </tr>\r\n  <tr>\r\n    <td>Email Body: </td>\r\n    <td><p>Fill here the email body. </p>\r\n    </td>\r\n  </tr>\r\n</table>\r\n', 1, 0);
INSERT INTO `promo_tools` VALUES (22, ' Ezine Ads', '<DIV>Use this in your favorite ezines:</DIV>\r\n<DIV></DIV>\r\n<DIV><TEXTAREA rows=10 cols=50 NAME="textarea1">Enter Here the Ezine Ad.</TEXTAREA></DIV>', 1, 0);
INSERT INTO `promo_tools` VALUES (23, 'Safelists Ads', '<DIV>Copy/Paste this Ad and use it in all of your <B>Safelists :</B><BR></DIV>\r\n<DIV><TEXTAREA name=textarea1 rows=10 cols=50>Enter Here the Safelist Ad.</TEXTAREA></DIV>', 1, 0);
INSERT INTO `promo_tools` VALUES (24, 'Banners and Graphics', '<DIV>Your banners and html paste code are below:</DIV>\r\n<DIV></DIV>\r\n<DIV>Add here your banner image.</DIV>\r\n<DIV></DIV>\r\n<DIV><TEXTAREA name=textarea1 rows=10 cols=50>Enter Here the Banner HTML Code.</TEXTAREA></DIV>', 1, 0);
INSERT INTO `promo_tools` VALUES (25, ' Pay Per Click', '<DIV align=left><SPAN style="COLOR: #000000"><B>Pay Per Click Campaigns:</B></SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000"></SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000"><STRONG>Q.<BR>What are PPC Campaigns?<BR><BR>A.</STRONG><BR>PPC (Pay Per Click) campaigns are how you can get your affiliate sites to the top of the search engines.</SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000"></SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000">Here are is an example ad you can make:</SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000"></SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000">Enter Here your PPC Ad.</SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000"></SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000">use this link:</SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000"><INPUT size=40 value={aff_link} NAME="text1"></SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000"></SPAN></DIV>\r\n<DIV align=left><SPAN style="COLOR: #000000">The key is to use the keywords below not only in your campaigns words, but also as words in your ads. Use the Google Adwords Ad Tutorial to help you design great ads.</DIV>\r\n<P style="" align=left>Here is a list of key words you can use for your campaigns.</P>\r\n<DIV style="" align=left>For more info on <B>Adwords</B>, <A href="http://www.google.com/search?q=adwords" target=_blank>click here.</A></DIV>\r\n<DIV style="" align=left></DIV>\r\n<DIV style="" align=left><TEXTAREA rows=10 cols=50 NAME="textarea1">Fill here with your keywords.</TEXTAREA></DIV>\r\n<DIV style="" align=left></DIV></SPAN>', 1, 0);
INSERT INTO `promo_tools` VALUES (26, ' Email Signatures', '<DIV><STRONG>Q.<BR>What are Email and Forum Signatures?<BR><BR>A.</STRONG><BR>If you have ever seen an email from someone and at the bottom of the email it look like a P.S. for as advertisement. That is an automatically inserted email signatures. This is also done in forums as well.</DIV>\r\n<DIV></DIV>\r\n<DIV>If you Have Yahoo, MSN, your own domain, or even AOL add these signatures to the bottoms of all of your outgoing emails. Just go to your email preferences TAB and copy paste these signatures to your emails and watch your downline rocket!</DIV>\r\n<DIV style=""></DIV>\r\n<DIV style="">\r\n<P style="">2 Line Signature<BR><TEXTAREA name=S1 rows=6 cols=64>Fill here the email signature.</TEXTAREA></P>\r\n<P style="">3 Line Signature<BR><TEXTAREA name=S1 rows=7 cols=64>Fill here the email signature.</TEXTAREA> \r\n<P style="">4 Line Signature<BR><TEXTAREA name=S1 rows=6 cols=64>Fill here the email signature.</TEXTAREA></P>\r\n<P style="">5 Line Signature<BR><TEXTAREA name=S1 rows=7 cols=64>Fill here the email signature.</TEXTAREA></P></DIV>', 1, 0);
INSERT INTO `promo_tools` VALUES (27, ' Top Sponsor Ads', '<P align=center>Here are two Great Places to get T.S.A.''s<BR><BR>(4 LINE)</P>\r\n<P align=center>Copy/Paste this Ad to use as a "Top Sponsor Ad" in an Ezine or Safelist.<BR><TEXTAREA name=S1 rows=6 cols=60>Enter your 4 line top sponsor ad.</TEXTAREA></P>\r\n<P align=center> </P>\r\n<FORM action=_derived/nortbots.htm method=post webbot-action="--WEBBOT-SELF--" webbot-onSubmit><!--webbot bot="SaveResults" u-file="C:\\Documents and Settings\\Owner\\My Documents\\My Webs\\_private\\form_results.csv" s-format="TEXT/CSV" s-label-fields="TRUE" startspan --><!--webbot bot="SaveResults" endspan i-checksum="43406" -->\r\n<P align=center>(5 LINE)</P>\r\n<P align=center>Copy/Paste this Ad to use as a "Top Sponsor Ad" in an Ezine or Safelist.<BR><TEXTAREA name=S1 rows=7 cols=61>Enter your 5 line top sponsor ad.</TEXTAREA></P></FORM>', 1, 0);
INSERT INTO `promo_tools` VALUES (28, 'Tell A Friend', '<DIV>Emails to send to your friends:</DIV>\r\n<DIV></DIV>\r\n<DIV>Email Subject:</DIV>\r\n<DIV><INPUT size=50 value="Enter Here The Email Subject." NAME="text1"></DIV>\r\n<DIV></DIV>\r\n<DIV>Email Body:</DIV>\r\n<DIV><TEXTAREA name=textarea1 rows=10 cols=50>Enter Here the Email Body.</TEXTAREA></DIV>', 1, 0);
INSERT INTO `promo_tools` VALUES (31, 'Blog Review', '<table width="550" border="0">\r\n  <tr>\r\n    <td width="114">Blog Review Subject:</td>\r\n    <td width="426">Fill here the Blog review subject. </td>\r\n  </tr>\r\n  <tr>\r\n    <td>Blog Review  Body: </td>\r\n    <td><p>Fill here the Blog review body. </p>\r\n    </td>\r\n  </tr>\r\n</table>\r\n', 1, 0);
INSERT INTO `promo_tools` VALUES (30, 'Article Review', '<table width="550" border="0">\r\n  <tr>\r\n    <td width="114">Article Review Subject:</td>\r\n    <td width="426">Fill here the article review subject. </td>\r\n  </tr>\r\n  <tr>\r\n    <td>Article Review  Body: </td>\r\n    <td><p>Fill here the article review body. </p>\r\n    </td>\r\n  </tr>\r\n</table>\r\n', 1, 0);
INSERT INTO `promo_tools` VALUES (49, ' Tell a friend', ' <form action="do.taf.php" method="post" name="form1" id="form1">\r\n<table width="58%" align="center">\r\n<tr><td colspan="3">\r\n<div align="center">From: {first_name} {last_name} <{email}></div></td>\r\n  </tr>\r\n    <tr>\r\n\r\n      <td> </td>\r\n      <td width="46%"><div align="center">Friend''s name</div></td>\r\n      <td width="49%"><div align="center">Friend''s email</div></td>\r\n    </tr>\r\n    <tr>\r\n      <td><strong>#1</strong></td>\r\n      <td>\r\n\r\n        <div align="center">\r\n          <input name="namex1" id="namex1" size="20" type="text">\r\n        </div></td>\r\n      <td><div align="center">\r\n        <input name="emailx1" id="emailx1" size="20" type="text">\r\n      </div></td>\r\n    </tr>\r\n    <tr>\r\n      <td><strong>#2</strong></td>\r\n\r\n      <td>\r\n        <div align="center">\r\n          <input name="namex2" id="namex2" size="20" type="text">\r\n        </div></td>\r\n      <td><div align="center">\r\n        <input name="emailx2" id="emailx2" size="20" type="text">\r\n      </div></td>\r\n    </tr>\r\n    <tr>\r\n\r\n      <td><strong>#3</strong></td>\r\n      <td>\r\n        <div align="center">\r\n          <input name="namex3" id="namex3" size="20" type="text">\r\n        </div></td>\r\n      <td><div align="center">\r\n        <input name="emailx3" id="emailx3" size="20" type="text">\r\n      </div></td>\r\n\r\n    </tr>\r\n    <tr>\r\n      <td><strong>#4</strong></td>\r\n      <td>\r\n        <div align="center">\r\n          <input name="namex4" id="namex4" size="20" type="text">\r\n        </div></td>\r\n      <td><div align="center">\r\n\r\n        <input name="emailx4" id="emailx4" size="20" type="text">\r\n      </div></td>\r\n    </tr>\r\n    <tr>\r\n      <td><strong>#5</strong></td>\r\n      <td>\r\n        <div align="center">\r\n          <input name="namex5" id="namex5" size="20" type="text">\r\n\r\n        </div></td>\r\n      <td><div align="center">\r\n        <input name="emailx5" id="emailx5" size="20" type="text">\r\n      </div></td>\r\n    </tr>\r\n  </tbody></table>\r\n  <div align="center">\r\n    <p>Subject:<br>\r\n\r\n      <input name="value1" id="value1" value="[FIRSTNAME], Check this out" size="50" type="text"> \r\n</p>\r\n<p>Body:<br>\r\n  <textarea name="value2" cols="60" rows="6" id="value2">Hi [FIRSTNAME],\r\n\r\nI just thought you may want to know about\r\nthis cool tool I found.\r\n\r\nI like it and I thought of you when I got it.\r\n{aff_link}\r\n\r\nIt is cool and I knew you would want to see it too.\r\n\r\nThanks,\r\n\r\n{first_name} {last_name}</textarea> \r\n  </p>\r\n<p>\r\n{captcha}</p>\r\n<p align="center">\r\n      <input namex="Send" id="Send" value="Send" type="submit">\r\n</p>\r\n    </form>', 0, 10011002);
CREATE TABLE `race_details` (
  `id` int(11) NOT NULL auto_increment,
  `start` date NOT NULL default '0000-00-00',
  `end_type` tinyint(4) NOT NULL default '0',
  `date_end` date NOT NULL default '0000-00-00',
  `ref_end` int(11) NOT NULL default '0',
  `enable` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `race_stats` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `level1_ref` int(11) NOT NULL default '0',
  `race_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `session` (
  `id` int(10) NOT NULL auto_increment,
  `session_id` varchar(255) NOT NULL default '',
  `product_id` int(10) NOT NULL default '0',
  `member_id` int(10) NOT NULL default '0',
  `paid` tinyint(1) NOT NULL default '0',
  `paid_step2` int(10) NOT NULL default '0',
  `affiliate_id` int(11) NOT NULL default '0',
  `stamp` int(11) NOT NULL default '0',
  `secret_pay_id` varchar(255) NOT NULL default '',
  `ip` varchar(20) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `session_id` (`session_id`,`product_id`),
  KEY `member_id` (`member_id`),
  KEY `paid` (`paid`),
  KEY `paid_step2` (`paid_step2`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `value` text NOT NULL,
  `box_type` enum('textbox','input','checkbox','hidden','select','radio') NOT NULL default 'textbox',
  `description` text NOT NULL,
  `cat` enum('General Site Settings','Automatically Generated Emails on Sign Up and Lost Password','Sign Up','Payment','OTO (One Time Offer)','Security','MWG Affiliate','3rd Party Autoresponder','Stats','Downline Settings','JV Partner','Activation Codes') NOT NULL default 'General Site Settings',
  `rank` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `cat` (`cat`)
) TYPE=MyISAM COMMENT='Settings table' AUTO_INCREMENT=3329 ;
INSERT INTO `settings` VALUES (15, 'enable_oto_1', '', 'checkbox', 'Enable one time offer after sign up ? If you leave this checked the new members will get the one time offer page after they sign up. If you uncheck it then they will be driven directly to members area.', 'General Site Settings', 15);
INSERT INTO `settings` VALUES (13, 'paypal_email', 'paypal@sitename.com', 'input', '<b><font color="#003366">PAYPAL: </font></b> Enter your paypal address where you would like to receive payments', 'Payment', 14);
INSERT INTO `settings` VALUES (10, 'free_signup', '1', 'checkbox', 'Check this box if you want members to sign up for free at the site. Uncheck this box if you want people to pay to become a member. (NOTE: The new One-Click OTO upsell function using Authorize.net requires that this box NOT be checked so the user must make a purchase to get into the site.)', 'Sign Up', 10);
INSERT INTO `settings` VALUES (14, 'accept_paypal', '', 'checkbox', '<b><font color="#003366">PAYPAL: </font> Accept payments via paypal ?</b>', 'Payment', 13);
INSERT INTO `settings` VALUES (9, 'emailing_from_email', 'owner@sitename.com', 'input', 'The Email Address that will appear in the From: field of the emails sent (welcome emails, lost password emails, ...)', 'Automatically Generated Emails on Sign Up and Lost Password', 9);
INSERT INTO `settings` VALUES (8, 'emailing_from_name', 'Site Owner', 'input', 'The Name that will appear in the From: field of the emails sent (welcome emails, lost password emails, ...)', 'Automatically Generated Emails on Sign Up and Lost Password', 8);
INSERT INTO `settings` VALUES (7, 'send_welcome_emails', '1', 'checkbox', 'Send welcome emails to new members ?', 'Automatically Generated Emails on Sign Up and Lost Password', 3);
INSERT INTO `settings` VALUES (6, 'lostpass_email_body', 'Hi [firstname],\r\n\r\nyour password: [password]\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin.', 'textbox', 'Lost password email body', 'Automatically Generated Emails on Sign Up and Lost Password', 6);
INSERT INTO `settings` VALUES (5, 'lostpass_email_subject', '[firstname], your password for [sitename]!', 'input', 'Lost password email subject.', 'Automatically Generated Emails on Sign Up and Lost Password', 5);
INSERT INTO `settings` VALUES (4, 'welcome_email_body', 'Hi [firstname],\r\n\r\nwelcome to [sitename], \r\n\r\nyour login info is:\r\n\r\nemail: [email]\r\npassword: [password]\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin.', 'textbox', 'New member welcome email body.', 'Automatically Generated Emails on Sign Up and Lost Password', 4);
INSERT INTO `settings` VALUES (3, 'welcome_email_subject', '[firstname], welcome to [sitename] !', 'input', 'New member welcome email subject.', 'Automatically Generated Emails on Sign Up and Lost Password', 3);
INSERT INTO `settings` VALUES (19, 'site_full_url', '', 'input', 'The full URL to your site including folder if necessary(Example: <b>http://www.minigolf.com/</b> or <b>http://www.minigolf.com/ball/</b>)', 'General Site Settings', 19);
INSERT INTO `settings` VALUES (2, 'webmaster_contact_email', 'email@email.com', 'input', 'Email address where the contact form should send the messages', 'General Site Settings', 2);
INSERT INTO `settings` VALUES (20, 'txn_id', '', 'input', '<b><font color="#003366">PAYPAL: </font></b> Paypal TXN_ID setting, this is used for paypal instant payment notification and it''s a temporary payment session ID, do not modify', 'Payment', 20);
INSERT INTO `settings` VALUES (1, 'site_name', 'SiteWizard 1.5', 'input', 'Your Site Name', 'General Site Settings', 1);
INSERT INTO `settings` VALUES (16, 'enable_oto_2', '', 'checkbox', 'Check this box if you want an one time offer upsell(2nd one time offer) after member paid for one time offer.', 'General Site Settings', 16);
INSERT INTO `settings` VALUES (17, 'affiliate_variable', 'thankyou-page', 'input', 'This is the affiliate variable used by the site... For example: <b>http://yoursite.com/?<font color=red>affiliate</font>=id</b>', 'General Site Settings', 17);
INSERT INTO `settings` VALUES (18, 'secret_string', 'changeme', 'input', 'A unique string that you only know. It will be used to protect the session ID of all logged users. (Changing the default setting for this is very important!)', 'Security', 18);
INSERT INTO `settings` VALUES (21, 'bm_aff_link', '', 'input', 'Your MWG Affiliate link', 'MWG Affiliate', 21);
INSERT INTO `settings` VALUES (22, 'enable_bm_aff_link', '1', 'select', 'Enable your MWG Affiliate Link at the bottom of your site. If you do not have a MWG Affiliate Link please <a href="http://marketingwebsitegenerator.com/go/affiliate" target=_blank>click here</a> to get one.', 'MWG Affiliate', 22);
INSERT INTO `settings` VALUES (31, 'enable_arp', '', 'hidden', 'Enable subscription to 3rd Party autoresponders for new members', '3rd Party Autoresponder', 31);
INSERT INTO `settings` VALUES (32, 'arp_email', 'arp@arp.com', 'hidden', 'The Email Address of the 3rd Party Autoresponder', '3rd Party Autoresponder', 32);
INSERT INTO `settings` VALUES (33, 'arp_message_subject', 'Subject for arp email', 'hidden', 'This is the subject of the mail that will be sent to the autoresponder for subscription', '3rd Party Autoresponder', 33);
INSERT INTO `settings` VALUES (34, 'arp_message_body', 'Body of email', 'hidden', 'This is the body of the mail that will be sent to the autoresponder for subscription', '3rd Party Autoresponder', 34);
INSERT INTO `settings` VALUES (35, 'enable_profile_directory', '1', 'hidden', 'Enable profile directory in members area ?', 'General Site Settings', 35);
INSERT INTO `settings` VALUES (40, 'show_promo_signup', '0', 'hidden', '', 'General Site Settings', 40);
INSERT INTO `settings` VALUES (37, 'verticalmenumain', '', 'hidden', '', 'General Site Settings', 37);
INSERT INTO `settings` VALUES (38, 'verticalmenumembers', '', 'hidden', '', 'General Site Settings', 38);
INSERT INTO `settings` VALUES (41, 'show_promo_profile', '1', 'hidden', '', 'General Site Settings', 41);
INSERT INTO `settings` VALUES (42, 'activation_email', '', 'checkbox', 'User Can not access members area without acivating their email address.', 'General Site Settings', 42);
INSERT INTO `settings` VALUES (43, 'signup_with_code', '', 'hidden', 'Code used for signup', 'General Site Settings', 43);
INSERT INTO `settings` VALUES (44, 'activation_email_subject', 'Your account activation', 'input', '', 'General Site Settings', 44);
INSERT INTO `settings` VALUES (45, 'activation_email_body', 'Hi,\r\n\r\nYour signup was succesful but we need you to activate your account by clicking this link:\r\n\r\n{activation_link}\r\n\r\nAdmin', 'textbox', '', 'General Site Settings', 45);
INSERT INTO `settings` VALUES (46, 'signup_code', '', 'hidden', '', 'General Site Settings', 46);
INSERT INTO `settings` VALUES (47, 'text_no_buy', 'No, thanks I\\''m not interested... ', 'input', 'This is the link where the members click of they don''t want to buy the One Time Offer', 'OTO (One Time Offer)', 47);
INSERT INTO `settings` VALUES (48, 'text_for_popup', 'Are you sure you wish to continue? This offer will never be made to you again...', 'textbox', 'Enter text for the popup on the one time offer if they choose not to buy:', 'OTO (One Time Offer)', 48);
INSERT INTO `settings` VALUES (56, 'text_for_signup_code', 'Sign up code', 'hidden', '', 'General Site Settings', 56);
INSERT INTO `settings` VALUES (63, 'send_mail', '', 'checkbox', 'Allow members to email their downline ?', 'Downline Settings', 63);
INSERT INTO `settings` VALUES (64, 'mail_interval', '6', 'input', 'Once every how many days can the users email their downline ?', 'Downline Settings', 64);
INSERT INTO `settings` VALUES (65, 'mail_levels', '2', 'input', 'Users can email downline how many levels ?', 'Downline Settings', 65);
INSERT INTO `settings` VALUES (60, 'view_downline', '', 'checkbox', 'Allow members to view their downline ?', 'Downline Settings', 60);
INSERT INTO `settings` VALUES (66, 'view_stats', '', 'checkbox', 'Allow member to see site statistics ?', 'Stats', 66);
INSERT INTO `settings` VALUES (61, 'view_downline_levels', '1', 'input', 'Allow members to view how many levels of their downline ?', 'Downline Settings', 61);
INSERT INTO `settings` VALUES (67, 'site_overview', '1,2,3,4,5,6,7,8,9', 'hidden', '', 'General Site Settings', 67);
INSERT INTO `settings` VALUES (68, 'enable_credit', '', 'hidden', '', 'General Site Settings', 68);
INSERT INTO `settings` VALUES (69, 'nr_credit', '0', 'hidden', '', 'General Site Settings', 69);
INSERT INTO `settings` VALUES (70, 'delete_user', '', 'checkbox', '<b><font color="#003366">PAYPAL: </font></b> If a payment is refunded or canceled should the member be deleted? (check if yes)', 'Payment', 70);
INSERT INTO `settings` VALUES (71, 'suspend_user', '', 'checkbox', '<b><font color="#003366">PAYPAL: </font></b> If a payment is refunded or canceled should the member be suspended? (check if yes)', 'Payment', 71);
INSERT INTO `settings` VALUES (72, 'change_membership', 'Chose membership','select', '<b><font color="#003366">PAYPAL: </font></b> If a payment is refunded change membership of member to:', 'Payment', 72);
INSERT INTO `settings` VALUES (57, 'meta-description', '', 'hidden', '', 'General Site Settings', 57);
INSERT INTO `settings` VALUES (53, 'keywords', '', 'hidden', '', 'General Site Settings', 53);
INSERT INTO `settings` VALUES (54, 'delete_acount', '1', 'checkbox', 'Do you want to alow members to delete their acount ?', 'General Site Settings', 54);
INSERT INTO `settings` VALUES (73, 'default_free', '1', 'select', 'Choose default membership for new users, if they don''t make any payment', 'Sign Up', 73);
INSERT INTO `settings` VALUES (74, 'enable_jv', '', 'checkbox', 'Use JV special signup. Send this url {url}signup_jv.php to your JV partner', 'JV Partner', 74);
INSERT INTO `settings` VALUES (75, 'jv_membership', 'Chose membership', 'select', 'What membership sould a JV have at signup', 'JV Partner', 75);
INSERT INTO `settings` VALUES (76, 'jv_code', '', 'input', 'Enter the JV code', 'JV Partner', 76);
INSERT INTO `settings` VALUES (77, 'splitoption', '2', 'radio', '<b><font color="#003366">PAYPAL: </font></b> Choose which order to pay when split payment occurs.', 'Payment', 77);
INSERT INTO `settings` VALUES (87, 'searchperpage', '100', 'hidden', '', 'General Site Settings', 87);
INSERT INTO `settings` VALUES (88, 'reset_email_subject', 'Hi {first_name}, Your Password has been reset.', 'input', 'This is the subject of the email that goes to members when you reset their password.', 'General Site Settings', 88);
INSERT INTO `settings` VALUES (89, 'reset_email_body', 'Hi {first_name},\r\n\r\nYour password has been reset to:\r\n{password}\r\n\r\nThank you,\r\n\r\nSiteWizard 1.5\r\nAdmin', 'textbox', 'This is the body of the email that goes to members when you reset their password', 'General Site Settings', 89);
INSERT INTO `settings` VALUES (90, 'referral_email_subject', 'Congratulations {first_name}, You Just made a referral', 'input', 'This is the subject of the mail going to members to announce that they made a new referral', 'General Site Settings', 90);
INSERT INTO `settings` VALUES (92, 'referral_email_body', 'Hi {first_name},\r\n\r\nYou have just made a new referral to our site.\r\n\r\n{member_details}\r\n\r\nKeep up the good work. Login now\r\nto make even more referrals.\r\n\r\nThank you,\r\nSiteWizard 1.5\r\nAdmin', 'textbox', 'This is the body of the email which goes to member when he makes a new referral<br> Tags to use:{buyer_first_name},{buyer_last_name},{buyer_id},{buyer_email}', 'General Site Settings', 92);
INSERT INTO `settings` VALUES (93, 'referral_email', '1', 'checkbox', 'Send message to members when they make a new refferal ?', 'General Site Settings', 90);
INSERT INTO `settings` VALUES (94, 'sales_email', '1', 'checkbox', 'Send email to member when he makes a sale ?', 'General Site Settings', 94);
INSERT INTO `settings` VALUES (95, 'sales_email_subject', 'Congratulations {first_name}, You Just made a sale', 'input', 'This is the subject of the email that goes to members when they make a sale.', 'General Site Settings', 95);
INSERT INTO `settings` VALUES (96, 'sales_email_body', 'Hi {first_name},\r\n\r\nYou have just made a sale at SiteWizard 1.5\r\n\r\nYou sold {product}.\r\n\r\nYou comission for that is {value}.\r\n\r\nKeep up the good work. Login now\r\nto get even more sales.\r\n\r\nThank you,\r\n\r\nSiteWizard 1.5.com\r\nAdmin', 'textbox', 'This is the body of the email that goes out to member when they make a sale<br> Tags to use:{buyer_first_name}{buyer_last_name},{buyer_id},{buyer_email}', 'General Site Settings', 96);
INSERT INTO `settings` VALUES (103, 'arp_in_use_type', '1', 'hidden', '', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (102, 'arp_in_use', '4', 'hidden', '', '3rd Party Autoresponder', 0);
INSERT INTO `settings` VALUES (101, 'enable_oto_paid_signup', '0', 'radio', 'Choose Flow:', 'Sign Up', 11);
INSERT INTO `settings` VALUES (100, 'view_stats_chk', '1,3,2', 'checkbox', '', 'Stats', 67);
INSERT INTO `settings` VALUES (99, 'allow_private_messages', '', 'checkbox', 'Allow members to choose wether they email or send a private message to their downline ?', 'Downline Settings', 99);
INSERT INTO `settings` VALUES (98, 'downline_em', '', 'checkbox', 'Allow members to view the emails addresses for members in their downline ?', 'Downline Settings', 98);
INSERT INTO `settings` VALUES (105, 'vendor_id', '', 'input', '<font color="#990000"><b>CLICKBANK: </b></font> Product Clickbank Vendor ID', 'Payment', 105);
INSERT INTO `settings` VALUES (106, 'secret_key', '', 'input', '<font color="#990000"><b>CLICKBANK: </b></font> Clickbank Secret Key', 'Payment', 106);
INSERT INTO `settings` VALUES (104, 'accept_clickbank', '', 'checkbox', '<b><font color="#990000">CLICKBANK: </font> Accept payments via Clickbank ?</b>', 'Payment', 104);
INSERT INTO `settings` VALUES (109, 'sid', '', 'input', '<b><font color="#006633">2CheckOut:</font></b> Product 2Checkout Vendor ID', 'Payment', 109);
INSERT INTO `settings` VALUES (110, 'secret_key_2co', '', 'input', '<b><font color="#006633">2CheckOut:</font></b> 2Checkout Secret Word (in 2co under "look and feel" link)', 'Payment', 110);
INSERT INTO `settings` VALUES (111, 'quantity', '1', 'input', '<b><font color="#006633">2CheckOut:</font></b> Product quantity', 'Payment', 111);
INSERT INTO `settings` VALUES (108, 'accept_2co', '', 'checkbox', '<b><font color="#006633">2CheckOut:</font> Accept payments via 2Checkout ?</b> ', 'Payment', 108);
INSERT INTO `settings` VALUES (112, 'signup_code_redirect', '', 'input', 'Enter what page do you want to redirect the user after filling the promo code.(Leave empty for default page)', 'General Site Settings', 47);
INSERT INTO `settings` VALUES (113, 'logout_redirect_url', '', 'input', 'Insert the page you want the user to be redirected after logout (If empty it will redirect to homepage).', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (114, 'oto_backup', '', 'checkbox', 'Check this if you want people to recieve a down sell (lower price OTO1) if they did not buy the first OTO', 'General Site Settings', 15);
INSERT INTO `settings` VALUES (115, 'cut_signup', '', 'checkbox', 'Check this box if you do not want to collect the password on the signup page. This can increase conversion. The new user will not have to create a password until after he/she joins the site and views your OTO sequence (if you have one.) The user will be asked to create a unique and personal password after this process and before accessing the members area.', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (116, 'index_signup', '', 'checkbox', 'Check this if you want the signup form to apear on the index page. For this you need to put in the homepage.html the tag {signup_form} where you want the form to appear.', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (117, 'choose_aff', '2', 'radio', 'If you want to choose another affiliate variable name you can do that and the previous one will still be available. You can switch back any time, both of them remaining active. However only the curent one will be displayed in member area.', 'General Site Settings', 18);
INSERT INTO `settings` VALUES (118, 'old_aff', '', 'hidden', '', 'General Site Settings', 17);
INSERT INTO `settings` VALUES (119, 'accept_auth', '', 'checkbox', '<font color=''#FF6600''><b>AUTHORIZE.NET:</b></font> <b>Accept payments via Authorize.net</b>?', 'Payment', 112);
INSERT INTO `settings` VALUES (120, 'oto_bck_2', '', 'checkbox', 'Check this if you want people to recieve a down-sell (lower price OTO2) if they did not buy the second OTO', 'General Site Settings', 16);
INSERT INTO `settings` VALUES (121, 'auth_key', '', 'input', '<font color=''#FF6600''><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net <b>Transaction Key</b> for single-payment purchases.</p><p>*This is the second part of the information required in order to be able to accept single payments through Authorize.net<b></b></p>', 'Payment', 113);
INSERT INTO `settings` VALUES (122, 'auth_login', '', 'input', '<p><font color=''#FF6600''><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net \r\n  <b>API Login ID</b> for one-time payments:</p>\r\n<p>*REQUIREMENTS:<br>\r\n  - the <b><i>Account>Settings>Return/Receipt URL</i></b> in Authorize.net \r\n  must have <font color="#990000"><b>https://{your installed url}/auth.pay.return.php</b></font> \r\n  in either the <i>Default Receipt URL</i> or one of the allowed <i>Relay / Response URLS</i> (tells Authorize.net that your site is a valid site for submitting orders)</p>\r\n   ', 'Payment', 112);
INSERT INTO `settings` VALUES (123, 'auth_hash', '', 'input', '<font color="#FF6600"><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net <b>MD5 Hash</b> (optional - but must match setting in Authorize.net):', 'Payment', 114);
INSERT INTO `settings` VALUES (125, 'cb_popup', '', 'checkbox', '<font color="#990000"><b>CLICKBANK: </b></font> Check this if you want a popup to set the Clickbank affiliate.(old way)', 'Payment', 107);
INSERT INTO `settings` VALUES (124, 'cb_invisible', '1', 'checkbox', '<font color="#990000"><b>CLICKBANK: </b></font> Check this if you want an invisible popup to set up your the Clickbank affiliate.', 'Payment', 107);
INSERT INTO `settings` VALUES (126, 'dual_templates', '', 'checkbox', 'Check here to have different templates for logged in and not logged members ', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (127, 'activation_code_email', 'dudu', 'input', 'Activation code', 'General Site Settings', 43);
INSERT INTO `settings` VALUES (128, 'activation_email_type', '2', 'radio', '', 'General Site Settings', 42);
INSERT INTO `settings` VALUES (129, 'activate_cycler', '', 'hidden', '', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (130, 'ban_active', '0', 'hidden', '', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (131, 'ban_kind', '0', 'hidden', '', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (134, 'activation_link', '', 'input', 'This is handled thru System Emails. This allows you to have The System automatically send an activation link to the member to click after they join. Click <a href="sysemails.php#activation">here</a> to access this setting now.', 'Activation Codes', 0);
INSERT INTO `settings` VALUES (132, 'ipblocker', '', 'checkbox', 'Block same IP from joining ', 'Sign Up', 132);
INSERT INTO `settings` VALUES (133, 'blockfor', 'Chose what to do with members that pay by echeck', 'select', '', 'Sign Up', 133);
INSERT INTO `settings` VALUES (135, 'sales_email_cc', '', 'checkbox', 'Check this if you want a second person to receive an email for a sale.', 'General Site Settings', 0);
INSERT INTO `settings` VALUES (136, 'sales_email_cc_adr', '', 'input', 'Insert the second person''s email which receives the sales email.', 'General Site Settings', 0);
CREATE TABLE `signup_settings` (
  `id` int(11) NOT NULL auto_increment,
  `field` varchar(60) NOT NULL default '',
  `atsignup` tinyint(1) NOT NULL default '0',
  `required` tinyint(1) NOT NULL default '0',
  `membersarea` tinyint(1) NOT NULL default '0',
  `description` text NOT NULL,
  `position` int(11) NOT NULL default '0',
  `new` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=23 ;
INSERT INTO `signup_settings` VALUES (1, 'first_name', 1, 1, 1, 'First Name', 1, 0);
INSERT INTO `signup_settings` VALUES (2, 'last_name', 1, 1, 1, 'Last Name', 2, 0);
INSERT INTO `signup_settings` VALUES (3, 'email', 1, 1, 1, 'Email Address', 3, 0);
INSERT INTO `signup_settings` VALUES (4, 'paypal_email', 1, 1, 1, 'PayPal Email', 4, 0);
INSERT INTO `signup_settings` VALUES (6, 'password', 1, 1, 1, 'Password', 6, 0);
INSERT INTO `signup_settings` VALUES (7, 'address', 1, 0, 1, 'Address', 7, 0);
INSERT INTO `signup_settings` VALUES (8, 'city', 1, 0, 1, 'City', 8, 0);
INSERT INTO `signup_settings` VALUES (9, 'state', 1, 0, 1, 'State', 9, 0);
INSERT INTO `signup_settings` VALUES (10, 'zip', 1, 0, 1, 'Zip Code', 10, 0);
INSERT INTO `signup_settings` VALUES (11, 'country', 1, 0, 1, 'Country', 11, 0);
INSERT INTO `signup_settings` VALUES (12, 'home_phone', 1, 0, 1, 'Home Phone', 12, 0);
INSERT INTO `signup_settings` VALUES (13, 'work_phone', 1, 0, 1, 'Work Phone', 13, 0);
INSERT INTO `signup_settings` VALUES (14, 'cell_phone', 1, 0, 1, 'Cell Phone', 14, 0);
INSERT INTO `signup_settings` VALUES (15, 'icq_id', 1, 0, 1, 'Icq Id', 15, 0);
INSERT INTO `signup_settings` VALUES (16, 'msn_id', 1, 0, 1, 'Msn Id', 16, 0);
INSERT INTO `signup_settings` VALUES (17, 'yahoo_id', 1, 0, 1, 'Yahoo Id', 17, 0);
INSERT INTO `signup_settings` VALUES (18, 'ssn', 1, 0, 1, 'Social Security Number (ssn)', 18, 0);
INSERT INTO `signup_settings` VALUES (19, 'url1', 1, 0, 1, 'Your Website - 1', 19, 0);
INSERT INTO `signup_settings` VALUES (20, 'url2', 1, 0, 1, 'Your Website - 2', 20, 0);
INSERT INTO `signup_settings` VALUES (21, 'url3', 1, 0, 1, 'Your Website - 3', 21, 0);
INSERT INTO `signup_settings` VALUES (22, 'clickbank_id', 1, 0, 1, 'ClickBank Vendor ID', 22, 1);
CREATE TABLE `tags` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `field` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=41 ;
INSERT INTO `tags` VALUES (39, 'home_phone_number', 'home_phone');
INSERT INTO `tags` VALUES (38, 'y_id', 'yahoo_id');
INSERT INTO `tags` VALUES (29, 'first_name', 'first_name');
INSERT INTO `tags` VALUES (30, 'last_name', 'last_name');
INSERT INTO `tags` VALUES (31, 'email', 'email');
INSERT INTO `tags` VALUES (32, 'city', 'city');
INSERT INTO `tags` VALUES (33, 'state', 'state');
INSERT INTO `tags` VALUES (34, 'zip', 'zip');
INSERT INTO `tags` VALUES (35, 'address', 'address');
INSERT INTO `tags` VALUES (36, 'country', 'country');
INSERT INTO `tags` VALUES (37, 'id', 'id');
INSERT INTO `tags` VALUES (40, 'affiliate_id', 'aff');
CREATE TABLE `temp` (
  `id` int(10) NOT NULL auto_increment,
  `content` longblob NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
CREATE TABLE `templates` (
  `id` int(10) NOT NULL auto_increment,
  `filename` text NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=78 ;
INSERT INTO `templates` VALUES (6, 'about.us.ag.html', 'About Us', 'About Us');
INSERT INTO `templates` VALUES (1, 'homepage.html', 'Homepage', 'This is your homepage.');
INSERT INTO `templates` VALUES (2, 'contact.html', 'Contact Us', 'Contact Us Template');
INSERT INTO `templates` VALUES (3, 'do.contact.html', 'Do Contact Us', 'The page after the message is sent..');
INSERT INTO `templates` VALUES (4, 'do.login.error.html', 'Do Login Error', 'The page that shows if you type the wrong login info');
INSERT INTO `templates` VALUES (5, 'error.html', 'Error Page', 'General Error Page');
INSERT INTO `templates` VALUES (7, 'faq.html', 'FAQ', 'FAQ Page');
INSERT INTO `templates` VALUES (8, 'faq.question.answer.html', 'FAQ Question and Answer', 'FAQ Question and Answer');
INSERT INTO `templates` VALUES (9, 'faq.question.html', 'FAQ Question', 'FAQ Question ');
INSERT INTO `templates` VALUES (10, 'login.html', 'Login Page', 'Login Page');
INSERT INTO `templates` VALUES (11, 'main.html', 'The main template', 'This is the main template of the site. It will be the frame for all pages except members area.');
INSERT INTO `templates` VALUES (12, 'member.area.directory.html', 'Member Area Directory', 'Member Area Directory File');
INSERT INTO `templates` VALUES (13, 'member.area.do.save.profile.error.html', 'Member Area Save Profile Error', 'The error page that is shown if save profile failes');
INSERT INTO `templates` VALUES (14, 'member.area.error.html', 'Member Area Error', 'Session expired for member area error page');
INSERT INTO `templates` VALUES (15, 'member.area.error.string.html', 'Member Area Error String', 'General Error Page');
INSERT INTO `templates` VALUES (16, 'member.area.inbox.html', 'Member Area Inbox', 'The inbox file');
INSERT INTO `templates` VALUES (17, 'member.area.inbox.rows.html', 'Member Area Inbox Rows', 'Member Area Inbox Rows');
INSERT INTO `templates` VALUES (18, 'member.area.other.profile.html', 'Member area other profile', 'Other member profile page');
INSERT INTO `templates` VALUES (19, 'member.area.profile.html', 'Member Area Profile', 'Your profile page');
INSERT INTO `templates` VALUES (20, 'member.area.promo.tools.category.html', 'Member Area Promo Tools Category', 'Category for promo tools');
INSERT INTO `templates` VALUES (21, 'member.area.promo.tools.html', 'Member Area Promo Tools', 'The promo tools page');
INSERT INTO `templates` VALUES (22, 'member.area.promo.tools.item.html', 'Member Area Promo Tools Item', 'Item template for promo tools page.');
INSERT INTO `templates` VALUES (23, 'member.area.read.message.html', 'Member Area Read Message', 'The read email message template');
INSERT INTO `templates` VALUES (24, 'member.area.write.message.html', 'Member Area Write Message', 'The compose new message page.');
INSERT INTO `templates` VALUES (25, 'oto1.html', 'Template Salespage for PRO1 - One Time Offer', 'One Time Offer Sales Page (1)');
INSERT INTO `templates` VALUES (26, 'pay.paypal.html', 'Paypal Template', 'Paypal Template');
INSERT INTO `templates` VALUES (27, 'pay.stormpay.html', 'Stormpay Template', 'Stormpay Template');
INSERT INTO `templates` VALUES (28, 'signup.error.html', 'Sign Up Error Page', 'Sign Up Error Page');
INSERT INTO `templates` VALUES (29, 'signup.html', 'Sign Up Page', 'Sign Up Page');
INSERT INTO `templates` VALUES (30, 'signup.paid.html', 'Sign Up Template With Pay Option', 'Sign Up Template With Pay Option before sign up');
INSERT INTO `templates` VALUES (31, 'terms.html', 'Terms Page', 'Terms Page');
INSERT INTO `templates` VALUES (32, 'faq.cat.html', 'FAQ Category', 'The FAQ Category file');
INSERT INTO `templates` VALUES (33, 'member.area.membership.ag.html', 'Membership', 'Membership');
INSERT INTO `templates` VALUES (64, 'member.area.membership.sl.6.ag.html', 'Template Salespage for GOLD', '');
INSERT INTO `templates` VALUES (63, 'member.area.membership.dw.6.ag.html', 'Template Bonus for membership GOLD', '');
INSERT INTO `templates` VALUES (39, 'member.area.earn.money.ag.html', 'Earn Money', 'Earn Money');
INSERT INTO `templates` VALUES (40, 'oto2.html', 'Template Salespage for PRO2 - One Time Offer', 'One Time Offer Upsell Sales Page (2)');
INSERT INTO `templates` VALUES (41, 'main.vertical.html', 'The main vertical menu template', 'This is the main vertical menu template of the site. It will be the frame for all pages . (only if the vertical menus options is selected in menus)');
INSERT INTO `templates` VALUES (42, 'member.area.earn.money.ag.html', 'Members Area - Earn money', 'The Earn money template from members area');
INSERT INTO `templates` VALUES (43, 'member.area.profile.no.directory.html', 'Member Area - Profile -  No directory', 'The members area profile page - this template is used when the profile directory is disabled');
INSERT INTO `templates` VALUES (59, 'member.area.membership.dw.4.ag.html', 'Template Bonus for membership PRO2 - One Time Offer', '');
INSERT INTO `templates` VALUES (57, 'member.area.membership.dw.3.ag.html', 'Template Bonus for membership PRO1 - One Time Offer', '');
INSERT INTO `templates` VALUES (56, 'member.area.membership.sl.2.ag.html', 'Template Salespage for PAID', '');
INSERT INTO `templates` VALUES (55, 'member.area.membership.dw.2.ag.html', 'Template Bonus for membership PAID', '');
INSERT INTO `templates` VALUES (54, 'member.area.membership.sl.1.ag.html', 'Template Salespage for FREE', '');
INSERT INTO `templates` VALUES (53, 'member.area.membership.dw.1.ag.html', 'Template Bonus for membership FREE', '');
INSERT INTO `templates` VALUES (61, 'member.area.membership.dw.5.ag.html', 'Template Bonus for membership SILVER', '');
INSERT INTO `templates` VALUES (62, 'member.area.membership.sl.5.ag.html', 'Template Salespage for SILVER', '');
INSERT INTO `templates` VALUES (65, 'member.area.membership.dw.7.ag.html', 'Template Bonus for membership PLATINUM', '');
INSERT INTO `templates` VALUES (66, 'member.area.membership.sl.7.ag.html', 'Template Salespage for PLATINUM', '');
INSERT INTO `templates` VALUES (67, 'member.area.membership.dw.8.ag.html', 'Template Bonus for membership DIAMOND', '');
INSERT INTO `templates` VALUES (68, 'member.area.membership.sl.8.ag.html', 'Template Salespage for DIAMOND', '');
INSERT INTO `templates` VALUES (69, 'member.area.membership.dw.9.ag.html', 'Template Bonus for membership ELITE', '');
INSERT INTO `templates` VALUES (70, 'member.area.membership.sl.9.ag.html', 'Template Salespage for ELITE', '');
INSERT INTO `templates` VALUES (72, 'oto_bck.html', 'One Time Offer Backup', 'Lower Price One Time Offer');
INSERT INTO `templates` VALUES (74, 'oto2_bck.html', 'Template Salespage for OTO2 downsell', 'One Time Offer Sales Page (2)');
INSERT INTO `templates` VALUES (75, 'main.not.logged.in.html', 'The main template no login', 'This is the main template of the site when member is not logged in. It will be the frame for all pages except members area.');
INSERT INTO `templates` VALUES (76, 'main.vertical.not.logged.in.html', 'The main vertical menu template no login', 'This is the main vertical menu template of the site when not logged in. It will be the frame for all pages . (only if the vertical menus options is selected in menus)');
INSERT INTO `templates` VALUES (77, 'logout.html', 'Logout', 'Logout Template.');
INSERT INTO `settings` ( `id` , `name` , `value` , `box_type` , `description` , `cat` , `rank` )
VALUES (
NULL , 'otobckem', '1', 'hidden', '', 'General Site Settings', '0'
), (
NULL , 'otobckeusescript', '1', 'hidden', '', 'General Site Settings', '0'
);
ALTER TABLE `members` ADD `oto_email` TINYINT( 1 ) NOT NULL ;
INSERT INTO `settings` ( `id` , `name` , `value` , `box_type` , `description` , `cat` , `rank` )
VALUES (
NULL , 'otobckeb', ' Hi {first_name} I''m writing you to make sure you know we had a glitch in our system that prevented some users to buy our one time offer. We are very sorry. This glitch has caused much stress on our help desk. Well over 75 customers were looking to make the purchase. Again, we are happy it was reporte it has been fixed and consider this a reply to your help desk ticket if you sent one. We are closing all related tickets without a reply based on this email." Thanks, SiteWizard 1.5 Admin', 'hidden', '', 'General Site Settings', '0'
), (
NULL , 'otobckedays', '1', 'hidden', '', 'General Site Settings', '0'
);
INSERT INTO `settings` ( `id` , `name` , `value` , `box_type` , `description` , `cat` , `rank` )
VALUES (
NULL , 'otobckeactive', '1', 'hidden', '', 'General Site Settings', '0'
), (
NULL , 'otobckes', '{first_name}, the glitch that made you loose', 'hidden', '', 'General Site Settings', '0');
ALTER TABLE `menus` ADD `alogin` TINYINT( 1 ) NOT NULL DEFAULT '0';
UPDATE `settings` SET `description` = 'User Can not access members area without activating their account by clicking the confirmation link they receive to their email address.' WHERE name='activation_email' LIMIT 1 ;
UPDATE `settings` SET `value` = 'Hi, Your signup was successful but we need you to activate your account by clicking this link: {activation_link} Admin' WHERE name='activation_email_body' LIMIT 1 ;
UPDATE `settings` SET `value` = 'Hi {first_name}, You have just made a sale at SiteWizard 1.5 You sold {product}. You commission for that is {value}. Keep up the good work. Login now to get even more sales. Thank you, SiteWizard 1.5.com Admin' WHERE name='sales_email_body' LIMIT 1 ;
UPDATE `settings` SET `description` = 'Check this if you want the signup form to appear on the index page. For this you need to put in the homepage.html the tag {signup_form} where you want the form to appear.' WHERE name='index_signup' LIMIT 1 ;
UPDATE `settings` SET `description` = 'Check this if you want people to receive a down-sell (lower price OTO2) if they did not buy the second OTO' WHERE name='oto_bck_2' LIMIT 1 ;
UPDATE `settings` SET `description` = 'Check this if you want people to receive a down sell (lower price OTO1) if they did not buy the first OTO' WHERE name='oto_backup' LIMIT 1 ;
UPDATE `settings` SET `description` = 'If you want to choose another affiliate variable name you can do that and the previous one will still be available. You can switch back any time, both of them remaining active. However only the current one will be displayed in member area.' WHERE name='choose_aff' LIMIT 1 ;
UPDATE `settings` SET `description` = 'Do you want to allow members to delete their account ?' WHERE name='delete_acount' LIMIT 1 ;
UPDATE `settings` SET `description` = 'Choose which order to pay when split payment occurs.' WHERE name='splitoption' LIMIT 1 ;
UPDATE `settings` SET `description` = 'What membership should a JV have at signup' WHERE name='jv_membership' LIMIT 1 ;
UPDATE `settings` SET `description` = 'This is handled through System Emails. This allows you to have The System automatically send an activation link to the member to click after they join. Click <a href="sysemails.php#activation">here</a> to access this setting now.' WHERE name='activation_link' LIMIT 1 ;
UPDATE `settings` SET `description` = 'Send message to members when they make a new referral ?' WHERE name='referral_email' LIMIT 1 ;
UPDATE `settings` SET `value` = 'Hi {first_name},\r\n\r\nYour password has been reset to: {password}\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin' WHERE name='reset_email_body' LIMIT 1 ;
UPDATE `settings` SET `value` = 'Hi {first_name},\r\n\r\nYou have just made a new referral to our site.\r\n\r\n{member_details}\r\n\r\nKeep up the good work.\r\n\r\nLogin now to make even more referrals.\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin' WHERE name='referral_email_body' LIMIT 1 ;
UPDATE `settings` SET `value` = 'Hi {first_name},\r\n\r\nYou have just made a sale at [sitename]\r\n\r\nYou sold {product}.\r\n\r\nYour commission for that is {value}.\r\n\r\nKeep up the good work.\r\n\r\nLogin now to get even more sales.\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin' WHERE name='sales_email_body' LIMIT 1 ;
UPDATE `settings` SET `value` = 'Hi {first_name},\r\n\r\nI''m writing you to make sure you know we had a glitch in our system that prevented some users to buy our one time offer.\r\n\r\nWe are very sorry. This glitch has caused much stress on our help desk.\r\n\r\nWell over 75 customers were looking to make the purchase.\r\n\r\nAgain, we are happy it was reported it has been fixed and consider this a reply to your help desk ticket if you sent one. We are closing all related tickets without a reply based on this email. Please login here to review the One Time offer:\r\n\r\n{special_oto_link}\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin' WHERE name='otobckeb' LIMIT 1 ;
UPDATE `settings` SET `description` = 'Choose default membership for new users, if they don''t make any payment.In case of paid signup this is the default membership on signup.' WHERE name='default_free' LIMIT 1 ;
INSERT INTO `settings` ( `id` , `name` , `value` , `box_type` , `description` , `cat` , `rank` )
VALUES (
NULL , '2co_demo', '', 'checkbox', '<b><font color="#006633">2CheckOut:</font></b> Check this if you want to enable 2Checkout payment test mode.', 'Payment', '108'
);
INSERT INTO `settings` ( `id` , `name` , `value` , `box_type` , `description` , `cat` , `rank` )
VALUES (
NULL , 'auth_test', '', 'checkbox', '<p><font color=''#FF6600''><b>AUTHORIZE.NET:</b></font> Check this if you want to enable Authorize.net payment <b>TEST mode</b>.</p>\r\n<p><i>*REQUIREMENTS:</i><br>\r\n  - You must also set test mode in your Authorize.net account. Be sure to remove test mode before going live.</p>\r\n', 'Payment', '112'
);
UPDATE `settings` SET `description` = 'If a payment is refunded or cancelated should the member be deleted? (check if yes)' WHERE `settings`.`name` ='delete_user' LIMIT 1 ;
UPDATE `settings` SET `description` = 'If a payment is refunded or cancelated should the member be suspended? (check if yes)' WHERE `settings`.`name` ='suspend_user' LIMIT 1 ;
ALTER TABLE `products` ADD `fee` TEXT NOT NULL ;
ALTER TABLE `products` ADD `physical` tinyint(1) NOT NULL DEFAULT '0' ;
ALTER TABLE `members` ADD `history` TEXT NOT NULL ;
INSERT INTO `settings` VALUES (137, 'shipping_email_body', 'Please ship {ship_quantity}*{ship_product}\r\n\r\nTo: {ship_to_first_name} {ship_to_last_name}\r\nAddress: {ship_to_address_street}, {ship_to_address_city}, {ship_to_address_zip}, \r\n{ship_to_address_state}, {ship_to_address_country} ({ship_to_address_country_code})\r\n\r\nThanks,\r\n{ship_ask_company}', 'textbox', 'This is the body of the email which goes to your shipping company<br>Tags to use: {ship_to_first_name}, {ship_to_last_name}, {ship_to_address_street}, {ship_to_address_city}, {ship_to_address_zip}, {ship_to_address_country}, {ship_to_address_country_code}, {ship_to_address_state}, {ship_ask_company}.', 'General Site Settings', 145);
INSERT INTO `settings` VALUES (138, 'shipping_email_subject', 'Shipping details', 'input', 'This is the subject of the email which goes to your shipping company', 'General Site Settings', 144);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'send_shipping_email', '', 'checkbox', 'Send email to your shipping company?', 'General Site Settings', 141);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'shipping_email', '', 'input', 'Shipping company email address', 'General Site Settings', 142);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'ask_country_on_product', '1', 'checkbox', 'Ask user to choose country for physical products (under each buy button will be a dropdown list with countries)', 'General Site Settings', 140);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'shipping_email_from', '', 'input', 'Company email that ask for delivery', 'General Site Settings', 143);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'no_shipping', 'Sorry - we currently are not setup to ship to your country of residence. Please visit our support department for further information', 'textbox', 'Message for members from countries where you don''t make shppings', 'General Site Settings', 3);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'enable_captcha', '', 'checkbox', 'Use captcha (a code made of 5 characters that are shown in a picture and is required to be entered when signing up)', 'Sign Up', 134);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL , 'make_winner', '', 'hidden', '', 'General Site Settings', '0');
INSERT INTO `settings` SET `name` = 'admin_sale_email',`value` = 'Hi {first_name},\r\n\r\nYou have just made a sale at [sitename].\r\n\r\nYou sold {product}.\r\n\r\nThank you,\r\n\r\n[sitename] Admin', `box_type` = 'hidden', `description` = 'This is the body of the email that goes out to admin when a sale is made';
CREATE TABLE `countries` (
  `id` int(11) NOT NULL auto_increment,
  `country` varchar(255) NOT NULL default '',
  `country_id` char(2) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=1 ;
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (1, 'Afghanistan', 'AF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (2, 'Albania', 'AL');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (3, 'Algeria', 'DZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (4, 'American Samoa', 'AS');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (5, 'Andorra', 'AD');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (6, 'Angola', 'AO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (7, 'Anguilla', 'AI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (8, 'Antarctica', 'AQ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (9, 'Antigua and Barbuda', 'AG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (10, 'Argentina', 'AR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (11, 'Armenia', 'AM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (12, 'Aruba', 'AW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (13, 'Australia', 'AU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (14, 'Austria', 'AT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (15, 'Azerbaijan', 'AZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (16, 'Bahamas', 'BS');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (17, 'Bahrain', 'BH');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (18, 'Bangladesh', 'BD');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (19, 'Barbados', 'BB');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (20, 'Belarus', 'BY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (21, 'Belgium', 'BE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (22, 'Belize', 'BZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (23, 'Benin', 'BJ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (24, 'Bermuda', 'BM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (25, 'Bhutan', 'BT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (26, 'Bolivia', 'BO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (27, 'Bosnia and Herzegovina', 'BA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (28, 'Botswana', 'BW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (29, 'Bouvet Island', 'BV');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (30, 'Brazil', 'BR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (31, 'British Indian Ocean Territory', 'IO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (32, 'Brunei', 'BN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (33, 'Bulgaria', 'BG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (34, 'Burkina Faso', 'BF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (35, 'Burundi', 'BI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (36, 'Cambodia', 'KH');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (37, 'Cameroon', 'CM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (38, 'Canada', 'CA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (39, 'Cape Verde', 'CV');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (40, 'Cayman Islands', 'KY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (41, 'Central African Republic', 'CF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (42, 'Chad', 'TD');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (43, 'Chile', 'CL');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (44, 'China', 'CN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (45, 'Christmas Island', 'CX');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (46, 'Colombia', 'CO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (47, 'Comoros', 'KM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (48, 'Congo', 'CG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (49, 'Cook Islands', 'CK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (50, 'Costa Rica', 'CR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (51, 'Cuba', 'CU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (52, 'Cyprus', 'CY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (53, 'Czech Republic', 'CZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (54, 'Denmark', 'DK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (55, 'Djibouti', 'DJ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (56, 'Dominica', 'DM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (57, 'Dominican Republic', 'DO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (58, 'East Timor', 'TP');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (59, 'Ecuador', 'EC');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (60, 'Egypt', 'EG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (61, 'El Salvador', 'SV');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (62, 'Equatorial Guinea', 'GQ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (63, 'Eritrea', 'ER');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (64, 'Estonia', 'EE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (65, 'Ethiopia', 'ET');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (66, 'Faroe Islands', 'FO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (67, 'Fiji Islands', 'FJ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (68, 'Finland', 'FI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (69, 'France', 'FR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (70, 'French Guiana', 'GF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (71, 'French Polynesia', 'PF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (72, 'French Southern and Antarctic Lands', 'TF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (73, 'Gabon', 'GA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (74, 'Gambia', 'GM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (75, 'Georgia', 'GE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (76, 'Germany', 'DE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (77, 'Ghana', 'GH');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (78, 'Gibraltar', 'GI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (79, 'Greece', 'GR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (80, 'Greenland', 'GL');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (81, 'Grenada', 'GD');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (82, 'Guadeloupe', 'GP');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (83, 'Guam', 'GU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (84, 'Guatemala', 'GT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (85, 'Guinea', 'GN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (86, 'Guyana', 'GY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (87, 'Haiti', 'HT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (88, 'Heard Island and McDonald Islands', 'HM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (89, 'Honduras', 'HN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (90, 'Hong Kong SAR', 'HK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (91, 'Hungary', 'HU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (92, 'Iceland', 'IS');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (93, 'India', 'IN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (94, 'Indonesia', 'ID');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (95, 'Iran', 'IR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (96, 'Iraq', 'IQ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (97, 'Ireland', 'IE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (98, 'Israel', 'IL');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (99, 'Italy', 'IT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (100, 'Jamaica', 'JM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (101, 'Japan', 'JP');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (102, 'Jordan', 'JO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (103, 'Kazakhstan', 'KZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (104, 'Kenya', 'KE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (105, 'Kiribati', 'KI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (106, 'Korea', 'KR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (107, 'Kuwait', 'KW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (108, 'Kyrgyzstan', 'KG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (109, 'Laos', 'LA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (110, 'Latvia', 'LV');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (111, 'Lebanon', 'LB');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (112, 'Lesotho', 'LS');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (113, 'Liberia', 'LR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (114, 'Libya', 'LY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (115, 'Liechtenstein', 'LI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (116, 'Lithuania', 'LT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (117, 'Luxembourg', 'LU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (118, 'Macao SAR', 'MO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (119, 'Madagascar', 'MG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (120, 'Malawi', 'MW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (121, 'Malaysia', 'MY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (122, 'Maldives', 'MV');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (123, 'Mali', 'ML');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (124, 'Malta', 'MT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (125, 'Marshall Islands', 'MH');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (126, 'Martinique', 'MQ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (127, 'Mauritania', 'MR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (128, 'Mauritius', 'MU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (129, 'Mayotte', 'YT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (130, 'Mexico', 'MX');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (131, 'Micronesia', 'FM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (132, 'Moldova', 'MD');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (133, 'Monaco', 'MC');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (134, 'Mongolia', 'MN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (135, 'Montserrat', 'MS');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (136, 'Morocco', 'MA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (137, 'Mozambique', 'MZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (138, 'Myanmar', 'MM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (139, 'Namibia', 'NA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (140, 'Nauru', 'NR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (141, 'Nepal', 'NP');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (142, 'Netherlands', 'NL');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (143, 'Netherlands Antilles', 'AN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (144, 'New Caledonia', 'NC');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (145, 'New Zealand', 'NZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (146, 'Nicaragua', 'NI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (147, 'Niger', 'NE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (148, 'Nigeria', 'NG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (149, 'Niue', 'NU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (150, 'Norfolk Island', 'NF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (151, 'North Korea', 'KP');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (152, 'Northern Mariana Islands', 'MP');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (153, 'Norway', 'NO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (154, 'Oman', 'OM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (155, 'Pakistan', 'PK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (156, 'Palau', 'PW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (157, 'Panama', 'PA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (158, 'Papua New Guinea', 'PG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (159, 'Paraguay', 'PY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (160, 'Peru', 'PE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (161, 'Philippines', 'PH');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (162, 'Pitcairn Islands', 'PN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (163, 'Poland', 'PL');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (164, 'Portugal', 'PT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (165, 'Puerto Rico', 'PR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (166, 'Qatar', 'QA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (167, 'Reunion', 'RE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (168, 'Romania', 'RO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (169, 'Russia', 'RU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (170, 'Rwanda', 'RW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (171, 'Samoa', 'WS');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (172, 'San Marino', 'SM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (173, 'Saudi Arabia', 'SA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (174, 'Senegal', 'SN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (175, 'Serbia and Montenegro', 'YU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (176, 'Seychelles', 'SC');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (177, 'Sierra Leone', 'SL');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (178, 'Singapore', 'SG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (179, 'Slovakia', 'SK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (180, 'Slovenia', 'SI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (181, 'Solomon Islands', 'SB');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (182, 'Somalia', 'SO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (183, 'South Africa', 'ZA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (184, 'South Georgia and the South Sandwich Islands', 'GS');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (185, 'Spain', 'ES');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (186, 'Sri Lanka', 'LK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (187, 'Sudan', 'SD');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (188, 'Suriname', 'SR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (189, 'Svalbard and Jan\\n Mayen', 'SJ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (190, 'Swaziland', 'SZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (191, 'Sweden', 'SE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (192, 'Switzerland', 'CH');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (193, 'Syria', 'SY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (194, 'Taiwan', 'TW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (195, 'Tajikistan', 'TJ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (196, 'Tanzania', 'TZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (197, 'Thailand', 'TH');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (198, 'Togo', 'TG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (199, 'Tokelau', 'TK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (200, 'Tonga', 'TO');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (201, 'Trinidad and Tobago', 'TT');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (202, 'Tunisia', 'TN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (203, 'Turkey', 'TR');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (204, 'Turkmenistan', 'TM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (205, 'Turks and Caicos Islands', 'TC');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (206, 'Tuvalu', 'TV');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (207, 'Uganda', 'UG');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (208, 'Ukraine', 'UA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (209, 'United Arab Emirates', 'AE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (210, 'United Kingdom', 'UK');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (211, 'United States Minor Outlying Islands', 'UM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (212, 'Uruguay', 'UY');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (213, 'Uzbekistan', 'UZ');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (214, 'Vanuatu', 'VU');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (215, 'Vatican City', 'VA');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (216, 'Venezuela', 'VE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (217, 'Viet Nam', 'VN');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (218, 'Virgin Islands', 'VI');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (219, 'Wallis and Futuna', 'WF');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (220, 'Yemen', 'YE');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (221, 'Zambia', 'ZM');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (222, 'Zimbabwe', 'ZW');
INSERT INTO `countries` (`id`, `country`, `country_id`) VALUES (223, 'United States', 'US');
UPDATE `settings` SET `box_type` = 'checkbox' WHERE `settings`.`name` ='enable_profile_directory' LIMIT 1 ;
UPDATE `settings` SET `value` = 'Hi {first_name},\r\n\r\nYour password has been reset to: {password}\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin' WHERE name='reset_email_body' LIMIT 1 ;
INSERT INTO `templates` ( `id` , `filename` , `name` , `description` )
VALUES (
NULL , 'clickbank.thankyou.html', 'Thank you page for Clickbank', 'Thank you page for Clickbank'
);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'give_oto_jv_new', '1', 'checkbox', 'Check this to show to JV partners OTO offers', 'JV Partner', 75);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'paypal_currency', 'USD', 'select', '<b><font color="#003366">PAYPAL: </font></b> Currency for PayPal transactions', 'Payment', 15);
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `short` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) TYPE=MyISAM AUTO_INCREMENT=7 ;
INSERT INTO `currencies` VALUES (1, 'Australian Dollar', 'AUD');
INSERT INTO `currencies` VALUES (2, 'Canadian Dollar', 'CAD');
INSERT INTO `currencies` VALUES (3, 'Euro', 'EUR');
INSERT INTO `currencies` VALUES (4, 'Pound Sterling', 'GBP');
INSERT INTO `currencies` VALUES (5, 'Japanese Yen', 'JPY');
INSERT INTO `currencies` VALUES (6, 'U.S. Dollar', 'USD');
ALTER TABLE `members` ADD `mdid` VARCHAR( 255 ) NOT NULL ;
CREATE TABLE `filters` (  `id` int(3) NOT NULL auto_increment,  `name` text NOT NULL,  `filter` text NOT NULL,  KEY `id` (`id`)) TYPE=MyISAM AUTO_INCREMENT=0 ;
INSERT INTO `filters` VALUES(0, 'last', '');
UPDATE `filters` SET `id`='0' WHERE `id`='1';
ALTER TABLE `autoresponders` CHANGE `days` `days` INT NOT NULL DEFAULT '0';
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES (NULL, 'cancel_new_system', '1', 'checkbox', '<b><font color="#003366">PAYPAL: </font></b> If a payment is refunded or canceled just remove access to the product? (check if yes).', 'Payment', 71);
ALTER TABLE `products` ADD `recurring_auth` TINYINT( 1 ) NOT NULL ,
ADD `period_auth` TINYINT( 3 ) NOT NULL ,
ADD `type_auth` VARCHAR( 10 ) NOT NULL ,
ADD `times_auth` INT NOT NULL ,
ADD `times_trial_auth` TINYINT( 2 ) NOT NULL ,
ADD `trial_auth_amount` FLOAT( 8, 2 ) NOT NULL ;
ALTER TABLE `members` ADD `initial_membership` INT NOT NULL ;
ALTER TABLE `payment_log` ADD `session_id` VARCHAR( 100 ) NOT NULL ,
ADD `status` VARCHAR( 100 ) NOT NULL ;
CREATE TABLE IF NOT EXISTS `last_cc_digits` (
  `id` int(11) NOT NULL auto_increment,
  `cc` varchar(4) NOT NULL,
  `exp_date` varchar(10) NOT NULL,
  `member_id` int(11) NOT NULL,
  `txn_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;
CREATE TABLE IF NOT EXISTS `temp_cc` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `cc` varchar(255) NOT NULL default '',
  `exp_date` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=1;
ALTER TABLE `payment_log` ADD `buyer_id` INT NOT NULL AFTER `ip` ,
ADD `affiliate_id` INT NOT NULL AFTER `buyer_id` ;
ALTER TABLE `session` ADD `subscriber_id` INT NOT NULL ,
ADD `cancelated` TINYINT NOT NULL ;
ALTER TABLE `a_tr` ADD `txn_id` VARCHAR( 100 ) NOT NULL ;
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES
(3354, 'auth_test2', '', 'checkbox', '<font color="#FF6600"><b>AUTHORIZE.NET:</b></font> Check this if you want to enable Authorize.net payment <b>TEST mode</b> with <b><font color="#993300">AIM</font></b> purchases ', 'Payment', 123),
(3353, 'auth_one_click', '', 'checkbox', '<p><font color="#FF6600"><b>AUTHORIZE.NET:</b></font> Enable <b>One Click OTO \r\n  Payments</b> </p>\r\n<p><i>*REQUIREMENTS:</i><br>\r\n  1. the <b><font color="#993300">AIM</font></b> system must be used<br>\r\n  2. <b>SSL Certificate</b> (and the order form must use an https:// secure page url on your site)<br>\r\n  3. Paid signup system. Will not work with free signup sites.</p>\r\n', 'Payment', 121),
(3352, 'use_aim', '0', 'checkbox', '<p><font color=''#FF6600''><b>AUTHORIZE.NET:</b></font> Use <b>Credit Card capture</b> \r\n  (<b><font color="#993300">AIM</font></b>) with Authorize.net. <i>If this is not checked, you will be using the Authorize.net order form that is hosted by authnet, which requires a live authnet account instead of a test acct</i>.<br>\r\n</p>\r\n<p><i>*REQUIREMENTS:</i><br>\r\n  - <b>SSL Certificate</b> (and the order form must use an https:// secure page url on your site ... because your order form is hosted on your own site.) \r\n  <br>\r\n</p>', 'Payment', 120),
(3350, 'auth_key_arb', '', 'input', ' \r\n<p><font color="#FF6600"><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net \r\n  <b>Transaction Key</b> for <font color="#330066"><b>SUBSCRIPTIONS</b></font> \r\n  (multiple payment purchases). </p>\r\n<p>*This is the second part of the information required in order to be able to accept multiple payments through Authorize.net<b></b></p>\r\n', 'Payment', 131),
(3349, 'auth_login_arb', '', 'input', '<p><font color="#FF6600"><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net \r\n  <b>API Login ID</b> for <font color="#330066"><b>SUBSCRIPTIONS</b></font> (multiple \r\n  payment purchases). </p>\r\n<p>*REQUIREMENTS:<br>\r\n  1. <b>SSL Certificate</b> (and the order form must use an https:// secure page url on your site)<br>\r\n  2. <font color="#660033"><b>ARB</b></font> (Automatic Recurring Billing) must be enabled in Authorize.net (<b><i>Tools > Recurring Billing</i></b>) ... costs $10 per month<br>\r\n  3. the <b><i>Account>Settings>Silent Post URL</i></b> in Authorize.net \r\n  must be set to <font color="#990000"><b>https://{your installed url}/auth.ipn.php</b></font></p>\r\n', 'Payment', 130);
ALTER TABLE  `products` ADD  `start_auth_subscr` TINYINT( 4 ) NOT NULL ;
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES
(NULL, 'enable_captcha_taf', '1', 'checkbox', 'Use captcha (a code made of 5 characters that are shown in a picture and is required to be entered when submitting the Tell-A-Friend promo tool)', 'General Site Settings', 135);
ALTER TABLE `members` ADD `jv_customsales` BLOB NOT NULL ,
ADD `jv_customdownload` BLOB NOT NULL ;
INSERT INTO `signup_settings` (`id`, `field`, `atsignup`, `required`, `membersarea`, `description`, `position`, `new`) VALUES
(null, 'jv_customdownload', 0, 0, 1, 'Your Custom Download HTML', 40, 0),
(null, 'jv_customsales', 0, 0, 1, 'Your Custom Sales HTML', 41, 0);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES
(null,'jv_custom', '0', 'checkbox', 'Give members ability to add custom bonuses to sales page.Put {jv_customsales} on the page you want the bonus to display and inside members area {jv_customdownload} for the dowlnoad link from jv', 'General Site Settings', 0),(null, 'jv_custom_memberships', '', 'checkbox', '', 'General Site Settings', 0);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES
(null, 'twitter', '0', 'checkbox', 'Use twitter promoting tool', 'General Site Settings', 0);
INSERT INTO `settings` (`id`, `name`, `value`, `box_type`, `description`, `cat`, `rank`) VALUES
(null, 'twitter_html', '', 'hidden', '', 'General Site Settings', 0);
CREATE TABLE IF NOT EXISTS `twitter` (
  `id` int(10) NOT NULL auto_increment,
  `tweet` varchar(140) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  AUTO_INCREMENT=1 ;
CREATE TABLE IF NOT EXISTS `paypal_log` (
  `id` int(10) NOT NULL auto_increment,
  `vars` text NOT NULL,
  `item_name` varchar(100) NOT NULL,
  `item_number` varchar(100) NOT NULL,
  `payment_status` varchar(100) NOT NULL,
  `mc_gross` varchar(100) NOT NULL,
  `mc_currency` varchar(100) NOT NULL,
  `txn_id` varchar(100) NOT NULL,
  `receiver_email` varchar(100) NOT NULL,
  `payer_email` varchar(100) NOT NULL,
  `txn_type` varchar(100) NOT NULL,
  `custom` varchar(100) NOT NULL,
  `payment_type` varchar(100) NOT NULL,
  `pending_reason` varchar(100) NOT NULL,
  `mc_amount1` varchar(100) NOT NULL,
  `shipping` varchar(100) NOT NULL,
  `tax` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1 ;
