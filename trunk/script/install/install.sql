CREATE TABLE `a_tr` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `member_id` int(10) unsigned NOT NULL default '0',
  `group_id` int(10) unsigned NOT NULL default '0',
  `amount` decimal(10,4) NOT NULL default '0.0000',
  `status` tinyint(1) unsigned default '0',
  `comments` text,
  `dt` datetime default NULL,
  `product_id` int(11) NOT NULL default '0',
  `buyer_id` int(11) NOT NULL default '0',
  `session` varchar(255) NOT NULL default '',
  `date_paid` datetime NOT NULL,
  `admin_note` varchar(255) NOT NULL,
  `txn_id` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `id_2` (`id`,`member_id`,`group_id`,`status`,`dt`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `after_login` (
  `id` int(11) NOT NULL auto_increment,
  `nr_days` int(11) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `message` longblob NOT NULL,
  `active` tinyint(4) NOT NULL default '0',
  `membership` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `autoresponder_config` (
  `id` int(11) NOT NULL auto_increment,
  `field` varchar(255) NOT NULL default '',
  `value` varchar(255) NOT NULL default '',
  `arp_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=136 DEFAULT CHARSET=latin1;
INSERT INTO `autoresponder_config` VALUES (1,'first_name','web_firstname',1);
INSERT INTO `autoresponder_config` VALUES (2,'method','2',1);
INSERT INTO `autoresponder_config` VALUES (3,'arp_name','EmailAces',1);
INSERT INTO `autoresponder_config` VALUES (4,'url','http://www.emailaces.com/interface/web_interface_pim.php',1);
INSERT INTO `autoresponder_config` VALUES (5,'email','web_email',1);
INSERT INTO `autoresponder_config` VALUES (6,'action','insert your value',1);
INSERT INTO `autoresponder_config` VALUES (7,'web_pass_standard','insert your value',1);
INSERT INTO `autoresponder_config` VALUES (8,'web_pass_custom','insert your value',1);
INSERT INTO `autoresponder_config` VALUES (9,'web_account','insert your value',1);
INSERT INTO `autoresponder_config` VALUES (10,'web_redirect','insert your value',1);
INSERT INTO `autoresponder_config` VALUES (11,'track_code','insert your value',1);
INSERT INTO `autoresponder_config` VALUES (12,'','',1);
INSERT INTO `autoresponder_config` VALUES (13,'','',1);
INSERT INTO `autoresponder_config` VALUES (14,'','',1);
INSERT INTO `autoresponder_config` VALUES (15,'','',1);
INSERT INTO `autoresponder_config` VALUES (49,'url','http://www.getresponse.com/cgi-bin/add.cgi',2);
INSERT INTO `autoresponder_config` VALUES (50,'email','category3',2);
INSERT INTO `autoresponder_config` VALUES (51,'category1','insert your value',2);
INSERT INTO `autoresponder_config` VALUES (46,'first_name','category2',2);
INSERT INTO `autoresponder_config` VALUES (47,'method','2',2);
INSERT INTO `autoresponder_config` VALUES (48,'arp_name','GetResponse',2);
INSERT INTO `autoresponder_config` VALUES (52,'ref','insert your value',2);
INSERT INTO `autoresponder_config` VALUES (53,'','',2);
INSERT INTO `autoresponder_config` VALUES (54,'','',2);
INSERT INTO `autoresponder_config` VALUES (55,'','',2);
INSERT INTO `autoresponder_config` VALUES (56,'','',2);
INSERT INTO `autoresponder_config` VALUES (57,'','',2);
INSERT INTO `autoresponder_config` VALUES (58,'','',2);
INSERT INTO `autoresponder_config` VALUES (59,'','',2);
INSERT INTO `autoresponder_config` VALUES (60,'','',2);
INSERT INTO `autoresponder_config` VALUES (61,'first_name','first_name',3);
INSERT INTO `autoresponder_config` VALUES (62,'method','2',3);
INSERT INTO `autoresponder_config` VALUES (63,'arp_name','AutoResponsePlus3',3);
INSERT INTO `autoresponder_config` VALUES (64,'url','http://INSERT_YOUR_SITE/cgi-bin/arp3/arp3-formcapture.pl',3);
INSERT INTO `autoresponder_config` VALUES (65,'email','email',3);
INSERT INTO `autoresponder_config` VALUES (66,'capitals','insert your value',3);
INSERT INTO `autoresponder_config` VALUES (67,'tracking_tag','insert your value',3);
INSERT INTO `autoresponder_config` VALUES (68,'id','insert your value',3);
INSERT INTO `autoresponder_config` VALUES (69,'extra_ar','insert your value',3);
INSERT INTO `autoresponder_config` VALUES (70,'','',3);
INSERT INTO `autoresponder_config` VALUES (71,'','',3);
INSERT INTO `autoresponder_config` VALUES (72,'','',3);
INSERT INTO `autoresponder_config` VALUES (73,'','',3);
INSERT INTO `autoresponder_config` VALUES (74,'','',3);
INSERT INTO `autoresponder_config` VALUES (75,'','',3);
INSERT INTO `autoresponder_config` VALUES (76,'first_name','name',4);
INSERT INTO `autoresponder_config` VALUES (77,'method','2',4);
INSERT INTO `autoresponder_config` VALUES (78,'arp_name','ProSender',4);
INSERT INTO `autoresponder_config` VALUES (79,'url','http://clients.prosender.com/scripts/addlead.pl',4);
INSERT INTO `autoresponder_config` VALUES (80,'email','from',4);
INSERT INTO `autoresponder_config` VALUES (81,'meta_forward_vars','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (82,'meta_required','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (83,'meta_message','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (84,'meta_adtracking','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (85,'redirect','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (86,'unit','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (87,'meta_split_id','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (88,'meta_web_form_id','insert your value',4);
INSERT INTO `autoresponder_config` VALUES (89,'','',4);
INSERT INTO `autoresponder_config` VALUES (90,'','',4);
INSERT INTO `autoresponder_config` VALUES (91,'first_name','name',5);
INSERT INTO `autoresponder_config` VALUES (92,'method','2',5);
INSERT INTO `autoresponder_config` VALUES (93,'arp_name','Aweber',5);
INSERT INTO `autoresponder_config` VALUES (94,'url','http://clients.aweber.com/scripts/addlead.pl',5);
INSERT INTO `autoresponder_config` VALUES (95,'email','from',5);
INSERT INTO `autoresponder_config` VALUES (96,'meta_forward_vars','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (97,'meta_required','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (98,'meta_message','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (99,'meta_adtracking','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (100,'redirect','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (101,'unit','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (102,'meta_split_id','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (103,'meta_web_form_id','insert your value',5);
INSERT INTO `autoresponder_config` VALUES (104,'','',5);
INSERT INTO `autoresponder_config` VALUES (105,'','',5);
INSERT INTO `autoresponder_config` VALUES (106,'first_name','Name',6);
INSERT INTO `autoresponder_config` VALUES (107,'method','2',6);
INSERT INTO `autoresponder_config` VALUES (108,'arp_name','1ShoppingCart',6);
INSERT INTO `autoresponder_config` VALUES (109,'url','http://www.mcssl.com/app/contactsave.asp',6);
INSERT INTO `autoresponder_config` VALUES (110,'email','Email1',6);
INSERT INTO `autoresponder_config` VALUES (111,'merchantid','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (112,'ARThankyouURL','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (113,'copyarresponse','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (114,'custom','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (115,'defaultar','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (116,'allowmulti','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (117,'visiblefields','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (118,'requiredfields','insert your value',6);
INSERT INTO `autoresponder_config` VALUES (119,'','',6);
INSERT INTO `autoresponder_config` VALUES (120,'','',6);
INSERT INTO `autoresponder_config` VALUES (121,'first_name','Name',7);
INSERT INTO `autoresponder_config` VALUES (122,'method','2',7);
INSERT INTO `autoresponder_config` VALUES (123,'arp_name','AutoContactor',7);
INSERT INTO `autoresponder_config` VALUES (124,'url','http://www.mcssl.com/app/contactsave.asp',7);
INSERT INTO `autoresponder_config` VALUES (125,'email','Email1',7);
INSERT INTO `autoresponder_config` VALUES (126,'merchantid','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (127,'ARThankyouURL','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (128,'copyarresponse','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (129,'custom','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (130,'defaultar','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (131,'allowmulti','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (132,'visiblefields','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (133,'requiredfields','insert your value',7);
INSERT INTO `autoresponder_config` VALUES (134,'','',7);
INSERT INTO `autoresponder_config` VALUES (135,'','',7);
CREATE TABLE `autoresponders` (
  `id` int(11) NOT NULL auto_increment,
  `from_email` varchar(255) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `header` text NOT NULL,
  `body` text NOT NULL,
  `footer` text NOT NULL,
  `membership` tinyint(2) NOT NULL default '0',
  `days` int(11) NOT NULL default '0',
  `count` int(11) NOT NULL default '0',
  `sent` int(11) NOT NULL default '0',
  `filter` text NOT NULL,
  `sendby` tinyint(1) NOT NULL default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;
CREATE TABLE `ban_rules` (
  `id` int(11) NOT NULL auto_increment,
  `ban` varchar(255) NOT NULL default '',
  `rule` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `buybuttons` (
  `id` int(11) NOT NULL auto_increment,
  `product_id` int(11) NOT NULL default '0',
  `image` varchar(255) NOT NULL default '',
  `url` tinyint(1) NOT NULL default '0',
  `processor` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `countries` (
  `id` int(11) NOT NULL auto_increment,
  `country` varchar(255) NOT NULL default '',
  `country_id` char(2) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=224 DEFAULT CHARSET=latin1;
INSERT INTO `countries` VALUES (1,'Afghanistan','AF');
INSERT INTO `countries` VALUES (2,'Albania','AL');
INSERT INTO `countries` VALUES (3,'Algeria','DZ');
INSERT INTO `countries` VALUES (4,'American Samoa','AS');
INSERT INTO `countries` VALUES (5,'Andorra','AD');
INSERT INTO `countries` VALUES (6,'Angola','AO');
INSERT INTO `countries` VALUES (7,'Anguilla','AI');
INSERT INTO `countries` VALUES (8,'Antarctica','AQ');
INSERT INTO `countries` VALUES (9,'Antigua and Barbuda','AG');
INSERT INTO `countries` VALUES (10,'Argentina','AR');
INSERT INTO `countries` VALUES (11,'Armenia','AM');
INSERT INTO `countries` VALUES (12,'Aruba','AW');
INSERT INTO `countries` VALUES (13,'Australia','AU');
INSERT INTO `countries` VALUES (14,'Austria','AT');
INSERT INTO `countries` VALUES (15,'Azerbaijan','AZ');
INSERT INTO `countries` VALUES (16,'Bahamas','BS');
INSERT INTO `countries` VALUES (17,'Bahrain','BH');
INSERT INTO `countries` VALUES (18,'Bangladesh','BD');
INSERT INTO `countries` VALUES (19,'Barbados','BB');
INSERT INTO `countries` VALUES (20,'Belarus','BY');
INSERT INTO `countries` VALUES (21,'Belgium','BE');
INSERT INTO `countries` VALUES (22,'Belize','BZ');
INSERT INTO `countries` VALUES (23,'Benin','BJ');
INSERT INTO `countries` VALUES (24,'Bermuda','BM');
INSERT INTO `countries` VALUES (25,'Bhutan','BT');
INSERT INTO `countries` VALUES (26,'Bolivia','BO');
INSERT INTO `countries` VALUES (27,'Bosnia and Herzegovina','BA');
INSERT INTO `countries` VALUES (28,'Botswana','BW');
INSERT INTO `countries` VALUES (29,'Bouvet Island','BV');
INSERT INTO `countries` VALUES (30,'Brazil','BR');
INSERT INTO `countries` VALUES (31,'British Indian Ocean Territory','IO');
INSERT INTO `countries` VALUES (32,'Brunei','BN');
INSERT INTO `countries` VALUES (33,'Bulgaria','BG');
INSERT INTO `countries` VALUES (34,'Burkina Faso','BF');
INSERT INTO `countries` VALUES (35,'Burundi','BI');
INSERT INTO `countries` VALUES (36,'Cambodia','KH');
INSERT INTO `countries` VALUES (37,'Cameroon','CM');
INSERT INTO `countries` VALUES (38,'Canada','CA');
INSERT INTO `countries` VALUES (39,'Cape Verde','CV');
INSERT INTO `countries` VALUES (40,'Cayman Islands','KY');
INSERT INTO `countries` VALUES (41,'Central African Republic','CF');
INSERT INTO `countries` VALUES (42,'Chad','TD');
INSERT INTO `countries` VALUES (43,'Chile','CL');
INSERT INTO `countries` VALUES (44,'China','CN');
INSERT INTO `countries` VALUES (45,'Christmas Island','CX');
INSERT INTO `countries` VALUES (46,'Colombia','CO');
INSERT INTO `countries` VALUES (47,'Comoros','KM');
INSERT INTO `countries` VALUES (48,'Congo','CG');
INSERT INTO `countries` VALUES (49,'Cook Islands','CK');
INSERT INTO `countries` VALUES (50,'Costa Rica','CR');
INSERT INTO `countries` VALUES (51,'Cuba','CU');
INSERT INTO `countries` VALUES (52,'Cyprus','CY');
INSERT INTO `countries` VALUES (53,'Czech Republic','CZ');
INSERT INTO `countries` VALUES (54,'Denmark','DK');
INSERT INTO `countries` VALUES (55,'Djibouti','DJ');
INSERT INTO `countries` VALUES (56,'Dominica','DM');
INSERT INTO `countries` VALUES (57,'Dominican Republic','DO');
INSERT INTO `countries` VALUES (58,'East Timor','TP');
INSERT INTO `countries` VALUES (59,'Ecuador','EC');
INSERT INTO `countries` VALUES (60,'Egypt','EG');
INSERT INTO `countries` VALUES (61,'El Salvador','SV');
INSERT INTO `countries` VALUES (62,'Equatorial Guinea','GQ');
INSERT INTO `countries` VALUES (63,'Eritrea','ER');
INSERT INTO `countries` VALUES (64,'Estonia','EE');
INSERT INTO `countries` VALUES (65,'Ethiopia','ET');
INSERT INTO `countries` VALUES (66,'Faroe Islands','FO');
INSERT INTO `countries` VALUES (67,'Fiji Islands','FJ');
INSERT INTO `countries` VALUES (68,'Finland','FI');
INSERT INTO `countries` VALUES (69,'France','FR');
INSERT INTO `countries` VALUES (70,'French Guiana','GF');
INSERT INTO `countries` VALUES (71,'French Polynesia','PF');
INSERT INTO `countries` VALUES (72,'French Southern and Antarctic Lands','TF');
INSERT INTO `countries` VALUES (73,'Gabon','GA');
INSERT INTO `countries` VALUES (74,'Gambia','GM');
INSERT INTO `countries` VALUES (75,'Georgia','GE');
INSERT INTO `countries` VALUES (76,'Germany','DE');
INSERT INTO `countries` VALUES (77,'Ghana','GH');
INSERT INTO `countries` VALUES (78,'Gibraltar','GI');
INSERT INTO `countries` VALUES (79,'Greece','GR');
INSERT INTO `countries` VALUES (80,'Greenland','GL');
INSERT INTO `countries` VALUES (81,'Grenada','GD');
INSERT INTO `countries` VALUES (82,'Guadeloupe','GP');
INSERT INTO `countries` VALUES (83,'Guam','GU');
INSERT INTO `countries` VALUES (84,'Guatemala','GT');
INSERT INTO `countries` VALUES (85,'Guinea','GN');
INSERT INTO `countries` VALUES (86,'Guyana','GY');
INSERT INTO `countries` VALUES (87,'Haiti','HT');
INSERT INTO `countries` VALUES (88,'Heard Island and McDonald Islands','HM');
INSERT INTO `countries` VALUES (89,'Honduras','HN');
INSERT INTO `countries` VALUES (90,'Hong Kong SAR','HK');
INSERT INTO `countries` VALUES (91,'Hungary','HU');
INSERT INTO `countries` VALUES (92,'Iceland','IS');
INSERT INTO `countries` VALUES (93,'India','IN');
INSERT INTO `countries` VALUES (94,'Indonesia','ID');
INSERT INTO `countries` VALUES (95,'Iran','IR');
INSERT INTO `countries` VALUES (96,'Iraq','IQ');
INSERT INTO `countries` VALUES (97,'Ireland','IE');
INSERT INTO `countries` VALUES (98,'Israel','IL');
INSERT INTO `countries` VALUES (99,'Italy','IT');
INSERT INTO `countries` VALUES (100,'Jamaica','JM');
INSERT INTO `countries` VALUES (101,'Japan','JP');
INSERT INTO `countries` VALUES (102,'Jordan','JO');
INSERT INTO `countries` VALUES (103,'Kazakhstan','KZ');
INSERT INTO `countries` VALUES (104,'Kenya','KE');
INSERT INTO `countries` VALUES (105,'Kiribati','KI');
INSERT INTO `countries` VALUES (106,'Korea','KR');
INSERT INTO `countries` VALUES (107,'Kuwait','KW');
INSERT INTO `countries` VALUES (108,'Kyrgyzstan','KG');
INSERT INTO `countries` VALUES (109,'Laos','LA');
INSERT INTO `countries` VALUES (110,'Latvia','LV');
INSERT INTO `countries` VALUES (111,'Lebanon','LB');
INSERT INTO `countries` VALUES (112,'Lesotho','LS');
INSERT INTO `countries` VALUES (113,'Liberia','LR');
INSERT INTO `countries` VALUES (114,'Libya','LY');
INSERT INTO `countries` VALUES (115,'Liechtenstein','LI');
INSERT INTO `countries` VALUES (116,'Lithuania','LT');
INSERT INTO `countries` VALUES (117,'Luxembourg','LU');
INSERT INTO `countries` VALUES (118,'Macao SAR','MO');
INSERT INTO `countries` VALUES (119,'Madagascar','MG');
INSERT INTO `countries` VALUES (120,'Malawi','MW');
INSERT INTO `countries` VALUES (121,'Malaysia','MY');
INSERT INTO `countries` VALUES (122,'Maldives','MV');
INSERT INTO `countries` VALUES (123,'Mali','ML');
INSERT INTO `countries` VALUES (124,'Malta','MT');
INSERT INTO `countries` VALUES (125,'Marshall Islands','MH');
INSERT INTO `countries` VALUES (126,'Martinique','MQ');
INSERT INTO `countries` VALUES (127,'Mauritania','MR');
INSERT INTO `countries` VALUES (128,'Mauritius','MU');
INSERT INTO `countries` VALUES (129,'Mayotte','YT');
INSERT INTO `countries` VALUES (130,'Mexico','MX');
INSERT INTO `countries` VALUES (131,'Micronesia','FM');
INSERT INTO `countries` VALUES (132,'Moldova','MD');
INSERT INTO `countries` VALUES (133,'Monaco','MC');
INSERT INTO `countries` VALUES (134,'Mongolia','MN');
INSERT INTO `countries` VALUES (135,'Montserrat','MS');
INSERT INTO `countries` VALUES (136,'Morocco','MA');
INSERT INTO `countries` VALUES (137,'Mozambique','MZ');
INSERT INTO `countries` VALUES (138,'Myanmar','MM');
INSERT INTO `countries` VALUES (139,'Namibia','NA');
INSERT INTO `countries` VALUES (140,'Nauru','NR');
INSERT INTO `countries` VALUES (141,'Nepal','NP');
INSERT INTO `countries` VALUES (142,'Netherlands','NL');
INSERT INTO `countries` VALUES (143,'Netherlands Antilles','AN');
INSERT INTO `countries` VALUES (144,'New Caledonia','NC');
INSERT INTO `countries` VALUES (145,'New Zealand','NZ');
INSERT INTO `countries` VALUES (146,'Nicaragua','NI');
INSERT INTO `countries` VALUES (147,'Niger','NE');
INSERT INTO `countries` VALUES (148,'Nigeria','NG');
INSERT INTO `countries` VALUES (149,'Niue','NU');
INSERT INTO `countries` VALUES (150,'Norfolk Island','NF');
INSERT INTO `countries` VALUES (151,'North Korea','KP');
INSERT INTO `countries` VALUES (152,'Northern Mariana Islands','MP');
INSERT INTO `countries` VALUES (153,'Norway','NO');
INSERT INTO `countries` VALUES (154,'Oman','OM');
INSERT INTO `countries` VALUES (155,'Pakistan','PK');
INSERT INTO `countries` VALUES (156,'Palau','PW');
INSERT INTO `countries` VALUES (157,'Panama','PA');
INSERT INTO `countries` VALUES (158,'Papua New Guinea','PG');
INSERT INTO `countries` VALUES (159,'Paraguay','PY');
INSERT INTO `countries` VALUES (160,'Peru','PE');
INSERT INTO `countries` VALUES (161,'Philippines','PH');
INSERT INTO `countries` VALUES (162,'Pitcairn Islands','PN');
INSERT INTO `countries` VALUES (163,'Poland','PL');
INSERT INTO `countries` VALUES (164,'Portugal','PT');
INSERT INTO `countries` VALUES (165,'Puerto Rico','PR');
INSERT INTO `countries` VALUES (166,'Qatar','QA');
INSERT INTO `countries` VALUES (167,'Reunion','RE');
INSERT INTO `countries` VALUES (168,'Romania','RO');
INSERT INTO `countries` VALUES (169,'Russia','RU');
INSERT INTO `countries` VALUES (170,'Rwanda','RW');
INSERT INTO `countries` VALUES (171,'Samoa','WS');
INSERT INTO `countries` VALUES (172,'San Marino','SM');
INSERT INTO `countries` VALUES (173,'Saudi Arabia','SA');
INSERT INTO `countries` VALUES (174,'Senegal','SN');
INSERT INTO `countries` VALUES (175,'Serbia and Montenegro','YU');
INSERT INTO `countries` VALUES (176,'Seychelles','SC');
INSERT INTO `countries` VALUES (177,'Sierra Leone','SL');
INSERT INTO `countries` VALUES (178,'Singapore','SG');
INSERT INTO `countries` VALUES (179,'Slovakia','SK');
INSERT INTO `countries` VALUES (180,'Slovenia','SI');
INSERT INTO `countries` VALUES (181,'Solomon Islands','SB');
INSERT INTO `countries` VALUES (182,'Somalia','SO');
INSERT INTO `countries` VALUES (183,'South Africa','ZA');
INSERT INTO `countries` VALUES (184,'South Georgia and the South Sandwich Islands','GS');
INSERT INTO `countries` VALUES (185,'Spain','ES');
INSERT INTO `countries` VALUES (186,'Sri Lanka','LK');
INSERT INTO `countries` VALUES (187,'Sudan','SD');
INSERT INTO `countries` VALUES (188,'Suriname','SR');
INSERT INTO `countries` VALUES (189,'Svalbard and Jan\\n Mayen','SJ');
INSERT INTO `countries` VALUES (190,'Swaziland','SZ');
INSERT INTO `countries` VALUES (191,'Sweden','SE');
INSERT INTO `countries` VALUES (192,'Switzerland','CH');
INSERT INTO `countries` VALUES (193,'Syria','SY');
INSERT INTO `countries` VALUES (194,'Taiwan','TW');
INSERT INTO `countries` VALUES (195,'Tajikistan','TJ');
INSERT INTO `countries` VALUES (196,'Tanzania','TZ');
INSERT INTO `countries` VALUES (197,'Thailand','TH');
INSERT INTO `countries` VALUES (198,'Togo','TG');
INSERT INTO `countries` VALUES (199,'Tokelau','TK');
INSERT INTO `countries` VALUES (200,'Tonga','TO');
INSERT INTO `countries` VALUES (201,'Trinidad and Tobago','TT');
INSERT INTO `countries` VALUES (202,'Tunisia','TN');
INSERT INTO `countries` VALUES (203,'Turkey','TR');
INSERT INTO `countries` VALUES (204,'Turkmenistan','TM');
INSERT INTO `countries` VALUES (205,'Turks and Caicos Islands','TC');
INSERT INTO `countries` VALUES (206,'Tuvalu','TV');
INSERT INTO `countries` VALUES (207,'Uganda','UG');
INSERT INTO `countries` VALUES (208,'Ukraine','UA');
INSERT INTO `countries` VALUES (209,'United Arab Emirates','AE');
INSERT INTO `countries` VALUES (210,'United Kingdom','UK');
INSERT INTO `countries` VALUES (211,'United States Minor Outlying Islands','UM');
INSERT INTO `countries` VALUES (212,'Uruguay','UY');
INSERT INTO `countries` VALUES (213,'Uzbekistan','UZ');
INSERT INTO `countries` VALUES (214,'Vanuatu','VU');
INSERT INTO `countries` VALUES (215,'Vatican City','VA');
INSERT INTO `countries` VALUES (216,'Venezuela','VE');
INSERT INTO `countries` VALUES (217,'Viet Nam','VN');
INSERT INTO `countries` VALUES (218,'Virgin Islands','VI');
INSERT INTO `countries` VALUES (219,'Wallis and Futuna','WF');
INSERT INTO `countries` VALUES (220,'Yemen','YE');
INSERT INTO `countries` VALUES (221,'Zambia','ZM');
INSERT INTO `countries` VALUES (222,'Zimbabwe','ZW');
INSERT INTO `countries` VALUES (223,'United States','US');
CREATE TABLE `currencies` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `short` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
INSERT INTO `currencies` VALUES (1,'Australian Dollar','AUD');
INSERT INTO `currencies` VALUES (2,'Canadian Dollar','CAD');
INSERT INTO `currencies` VALUES (3,'Euro','EUR');
INSERT INTO `currencies` VALUES (4,'Pound Sterling','GBP');
INSERT INTO `currencies` VALUES (5,'Japanese Yen','JPY');
INSERT INTO `currencies` VALUES (6,'U.S. Dollar','USD');
CREATE TABLE `cycle` (
  `id` int(11) NOT NULL auto_increment,
  `cycle` varchar(255) NOT NULL default '',
  `text` text NOT NULL,
  `file` varchar(255) NOT NULL default '',
  `display` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `cycle_stats` (
  `id` int(11) NOT NULL auto_increment,
  `value` varchar(255) NOT NULL default '',
  `page` varchar(20) NOT NULL default '',
  `used` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
CREATE TABLE `downloadprotect` (
  `id` int(11) NOT NULL auto_increment,
  `file` varchar(255) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `memberfile` varchar(255) NOT NULL default '',
  `membership_id` int(11) NOT NULL default '0',
  `manual` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `faq` (
  `id` int(10) NOT NULL auto_increment,
  `faq_category` varchar(255) NOT NULL default '',
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `position` int(5) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `faq_category` (`faq_category`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
CREATE TABLE `filters` (
  `id` int(3) NOT NULL auto_increment,
  `name` text NOT NULL,
  `filter` text NOT NULL,
  KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
INSERT INTO `filters` VALUES (2,'last','');
CREATE TABLE `last_cc_digits` (
  `id` int(11) NOT NULL auto_increment,
  `cc` varchar(4) NOT NULL,
  `exp_date` varchar(10) NOT NULL,
  `member_id` int(11) NOT NULL,
  `txn_id` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `levels` (
  `id` int(10) NOT NULL auto_increment,
  `membership_id` int(10) NOT NULL default '0',
  `level` int(3) NOT NULL default '0',
  `value` decimal(8,2) NOT NULL default '0.00',
  `paytype` enum('percent','full_amount','percent_split','full_amount_split') NOT NULL default 'percent',
  `product_id` int(10) NOT NULL default '0',
  `jv1` decimal(8,2) NOT NULL default '0.00',
  `jv2` decimal(8,2) NOT NULL default '0.00',
  `highcom` tinyint(1) NOT NULL default '0',
  `highval` int(11) NOT NULL default '0',
  `highdays` tinyint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `membership_id` (`membership_id`,`level`,`paytype`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=182 DEFAULT CHARSET=latin1;
CREATE TABLE `member_journal` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `subject` text NOT NULL,
  `body` text NOT NULL,
  `date` date NOT NULL default '0000-00-00',
  `date_added` datetime NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `member_notes` (
  `id` int(11) NOT NULL auto_increment,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL default '0',
  `writer` varchar(255) NOT NULL default '',
  `date` datetime NOT NULL default '0000-00-00 00:00:00',
  `date_added` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `members` (
  `id` int(10) NOT NULL auto_increment,
  `first_name` varchar(64) NOT NULL default '',
  `last_name` varchar(64) NOT NULL default '',
  `email` varchar(255) NOT NULL default '',
  `s_date` int(11) default NULL,
  `paypal_email` varchar(255) NOT NULL default '',
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
  `admin` char(1) NOT NULL default '0',
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
  `oto_email` tinyint(1) NOT NULL,
  `history` text NOT NULL,
  `mdid` varchar(255) NOT NULL,
  `initial_membership` int(11) NOT NULL,
  `jv_customsales` blob NOT NULL,
  `jv_customdownload` blob NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `email` (`email`),
  KEY `aff` (`aff`),
  KEY `membership_id` (`membership_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
INSERT INTO `members` VALUES (1,'HelpDesk','Support','support@example.com',NULL,'','','','','','','','','','','','','','','','','',0,10,1138665223,1,1,1,0,1,1,1,1,1,0,0,0,1,1,1,1,1,1,1,0,0,0,0,'0',0,'',0,'0000-00-00',0,0,'',0,'0000-00-00 00:00:00','',0,0,'',0,'','',0,'','');
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
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 PACK_KEYS=1;
INSERT INTO `membership` VALUES (1,'FREE',53,1,'NONE',54,1,0,'');
INSERT INTO `membership` VALUES (2,'PAID',55,4,'NONE',56,1,0,'');
INSERT INTO `membership` VALUES (3,'PRO1 - One Time Offer',57,2,'NONE',25,1,0,'');
INSERT INTO `membership` VALUES (4,'PRO2 - One Time Offer',59,3,'NONE',40,1,0,'');
INSERT INTO `membership` VALUES (5,'SILVER',61,5,'NONE',62,1,0,'');
INSERT INTO `membership` VALUES (6,'GOLD',63,6,'NONE',64,1,0,'');
INSERT INTO `membership` VALUES (7,'PLATINUM',65,7,'NONE',66,1,0,'');
INSERT INTO `membership` VALUES (8,'DIAMOND',67,8,'NONE',68,1,0,'');
INSERT INTO `membership` VALUES (9,'ELITE',69,9,'NONE',70,1,0,'');
CREATE TABLE `menu_permissions` (
  `id` int(11) NOT NULL auto_increment,
  `menu_item` tinyint(4) NOT NULL default '0',
  `membership_id` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `menus` (
  `id` int(10) NOT NULL auto_increment,
  `menu_category` enum('main','members') NOT NULL default 'main',
  `name` varchar(255) NOT NULL default '',
  `link` text NOT NULL,
  `position` int(5) NOT NULL default '0',
  `open_new_window` tinyint(1) NOT NULL default '0',
  `active` tinyint(1) NOT NULL default '1',
  `alogin` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `menu_category` (`menu_category`),
  KEY `position` (`position`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
INSERT INTO `menus` VALUES (1,'main','Home','index.php',1,0,1,0);
INSERT INTO `menus` VALUES (2,'main','FAQ','faq.php',2,0,1,0);
INSERT INTO `menus` VALUES (10,'members','FAQ','faq.php',10,0,1,0);
INSERT INTO `menus` VALUES (3,'main','Sign Up','signup.php',3,0,1,0);
INSERT INTO `menus` VALUES (4,'main','Terms & Conditions','terms.php',5,0,1,0);
INSERT INTO `menus` VALUES (5,'main','Login','login.php',4,0,1,0);
INSERT INTO `menus` VALUES (6,'members','Home','member.area.profile.php',1,0,1,0);
INSERT INTO `menus` VALUES (7,'members','Logout','member.area.logout.php',11,0,1,0);
INSERT INTO `menus` VALUES (8,'members','Profile Directory','member.area.directory.php',2,0,1,0);
INSERT INTO `menus` VALUES (9,'members','Inbox ({inbox})','member.area.inbox.php',3,0,1,0);
INSERT INTO `menus` VALUES (19,'members','Promo Tools','member.area.promo.tools.php',6,0,1,0);
INSERT INTO `menus` VALUES (18,'members','About Us','about.us.ag.php',12,1,1,0);
INSERT INTO `menus` VALUES (20,'members','Membership','member.area.membership.ag.php',7,0,1,0);
INSERT INTO `menus` VALUES (21,'members','Affiliate Earnings','a.aff.info.php',8,0,1,0);
INSERT INTO `menus` VALUES (22,'members','HelpDesk','member.area.write.message.php?id=1',9,0,1,0);
INSERT INTO `menus` VALUES (23,'members','Earn Money','member.area.earn.money.ag.php',5,0,1,0);
INSERT INTO `menus` VALUES (24,'members','Journal','member.area.notes.php',4,0,0,0);
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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;
CREATE TABLE `mwg_gizmo` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL,
  `ordre` int(11) NOT NULL,
  `identity` varchar(255) NOT NULL,
  `params` text NOT NULL,
  `data` longtext,
  `active` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `identity` (`identity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `mwg_setting` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default 'Site Settings',
  `group` varchar(255) default NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  `default_value` text NOT NULL,
  `input_type` enum('textbox','input','checkbox','radio','hidden','select','qselect') NOT NULL default 'input',
  `label` varchar(255) NOT NULL,
  `help_text` text NOT NULL,
  `options` text NOT NULL,
  `rank` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
INSERT INTO `mwg_setting` VALUES (1,'Email Settings',NULL,'email_mailer',NULL,'phpmail','select','Choose a mailing function.','','a:3:{s:7:\"phpmail\";s:17:\"PHP Mail Function\";s:4:\"smtp\";s:4:\"SMTP\";s:8:\"sendmail\";s:8:\"Sendmail\";}',0);
INSERT INTO `mwg_setting` VALUES (2,'Email Settings',NULL,'email_from_name',NULL,'','input','From Name','','',0);
INSERT INTO `mwg_setting` VALUES (3,'Email Settings',NULL,'email_from_address',NULL,'','input','From Address','','',0);
INSERT INTO `mwg_setting` VALUES (4,'Email Settings',NULL,'email_sendmail_cmd',NULL,'/usr/sbin/sendmail','input','Sendmail Cmd','Enter the full path and commandline to your Sendmail compatible program.','',0);
INSERT INTO `mwg_setting` VALUES (5,'Email Settings',NULL,'email_smtp_connection',NULL,'none','select','SMTP Security','','a:3:{s:4:\"none\";s:8:\"Standard\";s:3:\"ssl\";s:3:\"SSL\";s:3:\"tls\";s:3:\"TLS\";}',0);
INSERT INTO `mwg_setting` VALUES (6,'Email Settings',NULL,'email_smtp_host',NULL,'localhost','input','SMTP Host','','',0);
INSERT INTO `mwg_setting` VALUES (7,'Email Settings',NULL,'email_smtp_port',NULL,'25','input','SMTP Port','','',0);
INSERT INTO `mwg_setting` VALUES (8,'Email Settings',NULL,'email_smtp_username',NULL,'','input','SMTP Username','','',0);
INSERT INTO `mwg_setting` VALUES (9,'Email Settings',NULL,'email_smtp_password',NULL,'','input','SMTP Password','','',0);
INSERT INTO `mwg_setting` VALUES (10,'Global Site Settings',NULL,'site_dbversion','1.3','1.1','hidden','','','',0);
INSERT INTO `mwg_setting` VALUES (11,'Global Site Settings',NULL,'theme_subtitle','Just Another Marketing Website Generator Site','','input','Site Subtitle','Some themes (wordpress) have the option to use a subtitle. Enter that here.','',2);
INSERT INTO `mwg_setting` VALUES (12,'Global Site Settings',NULL,'site_title','Online Marketing','','input','Site Title','The title of your site. Appears on most themes and is the default title of all your pages.','',1);
INSERT INTO `mwg_setting` VALUES (13,'Global Site Settings',NULL,'site_description','Visit our website to find out exactly what you need for online marketing.','','input','Site Description','This is the text of your site-wide meta description tag. It should be 160 characters or less, and appears in search results.','',3);
CREATE TABLE `payment_log` (
  `id` int(11) NOT NULL auto_increment,
  `process_type` varchar(30) NOT NULL default '',
  `comment` text NOT NULL,
  `stamp` int(11) default NULL,
  `txn_id` varchar(255) NOT NULL default '0',
  `product` varchar(255) NOT NULL default '',
  `ip` varchar(20) NOT NULL default '',
  `buyer_id` int(11) NOT NULL,
  `affiliate_id` int(11) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
CREATE TABLE `paypal_log` (
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
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `pending` (
  `id` int(11) NOT NULL auto_increment,
  `autoresponder_id` int(11) NOT NULL default '0',
  `to_email` varchar(50) NOT NULL default '',
  `subject` varchar(100) NOT NULL default '',
  `body` text NOT NULL,
  `from_email` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=119 DEFAULT CHARSET=latin1;
CREATE TABLE `products` (
  `id` int(10) NOT NULL auto_increment,
  `price` decimal(8,2) NOT NULL default '0.00',
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
  `trial_amount` decimal(6,2) NOT NULL default '0.00',
  `trial_period` int(11) NOT NULL default '0',
  `trial_period_type` char(1) NOT NULL default '',
  `paypal` tinyint(4) NOT NULL default '0',
  `clickbank` tinyint(4) NOT NULL default '0',
  `auth` tinyint(4) NOT NULL default '0',
  `2co` tinyint(4) NOT NULL default '0',
  `fee` text NOT NULL,
  `physical` tinyint(1) NOT NULL default '0',
  `recurring_auth` tinyint(1) NOT NULL,
  `period_auth` tinyint(3) NOT NULL,
  `type_auth` varchar(10) NOT NULL,
  `times_auth` int(11) NOT NULL,
  `times_trial_auth` tinyint(2) NOT NULL,
  `trial_auth_amount` decimal(8,2) NOT NULL,
  `start_auth_subscr` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `membership_id` (`membership_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
INSERT INTO `products` VALUES (1,'50.00',3,'OTO1','One Time Offer',0,0,'D',0,0,1,1,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (2,'10.00',4,'OTO2','One Time Offer Upsell',0,0,'D',0,0,1,1,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (3,'20.00',2,'PAID','PAID MEMBERSHIP',0,0,'D',0,0,0,0,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (4,'30.00',5,'SILVER','SILVER  MEMBERSIP',0,0,'D',0,0,0,0,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (5,'40.00',6,'GOLD','GOLD MEMBERSHIP',0,0,'D',0,0,0,0,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (6,'50.00',7,'PLATINUM','PLATINUM MEMBERSHIP',0,0,'D',0,0,0,0,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (7,'60.00',8,'DIAMOND','DIAMOMD MEMBERSHIP',0,0,'D',0,0,0,0,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (8,'70.00',9,'ELITE','ELITE MEMBERSHIP',0,0,'D',0,0,0,0,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (10,'10.00',3,'OTO_BCK','OTO BACKUP',0,0,'D',0,0,1,1,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
INSERT INTO `products` VALUES (11,'10.00',4,'OTO2_BCK','OTO2 Backup',0,0,'D',0,0,0,0,0,0,0,0,0,'0.00',0,'D',0,0,0,0,'',0,0,0,'',0,0,'0.00',0);
CREATE TABLE `promo_tools` (
  `id` int(10) NOT NULL auto_increment,
  `category` varchar(255) NOT NULL default '',
  `content` blob NOT NULL,
  `template` tinyint(1) NOT NULL default '0',
  `rank` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `category` (`category`),
  KEY `template` (`template`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
INSERT INTO `promo_tools` VALUES (1,'Emails',0x3C5441424C452077696474683D35353020626F726465723D303E0D0A3C54424F44593E0D0A3C54523E0D0A3C54442077696474683D3131343E456D61696C205375626A6563743A3C2F54443E0D0A3C54442077696474683D3432363E5B46495253544E414D455D2C20636865636B2074686973206F7574213C2F54443E3C2F54523E0D0A3C54523E0D0A3C54443E456D61696C20426F64793A203C2F54443E0D0A3C54443E0D0A3C503E3C5350414E207374796C653D22464F4E542D46414D494C593A20547265627563686574204D53223E5B46495253544E414D455D2C3C42523E49206A7573742077616E74656420746F2073686F7720796F75206120636F6F6C20736974653A3C2F5350414E3E3C2F503E0D0A3C503E3C5350414E207374796C653D22464F4E542D46414D494C593A20547265627563686574204D53223E7B6166665F6C696E6B7D3C2F5350414E3E3C2F503E0D0A3C503E3C5350414E207374796C653D22464F4E542D46414D494C593A20547265627563686574204D53223E5468616E6B732C3C42523E7B6E616D657D2E3C2F5350414E3E3C2F503E3C2F54443E3C2F54523E3C2F54424F44593E3C2F5441424C453E,0,0);
INSERT INTO `promo_tools` VALUES (2,'Emails',0x3C7461626C652077696474683D223535302220626F726465723D2230223E0D0A20203C74723E0D0A202020203C74642077696474683D22313134223E456D61696C205375626A6563743A3C2F74643E0D0A202020203C74642077696474683D22343236223E46696C6C20686572652074686520656D61696C207375626A6563742E203C2F74643E0D0A20203C2F74723E0D0A20203C74723E0D0A202020203C74643E456D61696C20426F64793A203C2F74643E0D0A202020203C74643E3C703E46696C6C20686572652074686520656D61696C20626F64792E203C2F703E0D0A202020203C2F74643E0D0A20203C2F74723E0D0A3C2F7461626C653E0D0A,1,0);
INSERT INTO `promo_tools` VALUES (22,' Ezine Ads',0x3C4449563E557365207468697320696E20796F7572206661766F7269746520657A696E65733A3C2F4449563E0D0A3C4449563E3C2F4449563E0D0A3C4449563E3C544558544152454120726F77733D313020636F6C733D3530204E414D453D22746578746172656131223E456E74657220486572652074686520457A696E652041642E3C2F54455854415245413E3C2F4449563E,1,0);
INSERT INTO `promo_tools` VALUES (23,'Safelists Ads',0x3C4449563E436F70792F5061737465207468697320416420616E642075736520697420696E20616C6C206F6620796F7572203C423E536166656C69737473203A3C2F423E3C42523E3C2F4449563E0D0A3C4449563E3C5445585441524541206E616D653D74657874617265613120726F77733D313020636F6C733D35303E456E74657220486572652074686520536166656C6973742041642E3C2F54455854415245413E3C2F4449563E,1,0);
INSERT INTO `promo_tools` VALUES (24,'Banners and Graphics',0x3C4449563E596F75722062616E6E65727320616E642068746D6C20706173746520636F6465206172652062656C6F773A3C2F4449563E0D0A3C4449563E3C2F4449563E0D0A3C4449563E416464206865726520796F75722062616E6E657220696D6167652E3C2F4449563E0D0A3C4449563E3C2F4449563E0D0A3C4449563E3C5445585441524541206E616D653D74657874617265613120726F77733D313020636F6C733D35303E456E7465722048657265207468652042616E6E65722048544D4C20436F64652E3C2F54455854415245413E3C2F4449563E,1,0);
INSERT INTO `promo_tools` VALUES (25,' Pay Per Click',0x3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C423E5061792050657220436C69636B2043616D706169676E733A3C2F423E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C5354524F4E473E512E3C42523E5768617420617265205050432043616D706169676E733F3C42523E3C42523E412E3C2F5354524F4E473E3C42523E50504320285061792050657220436C69636B292063616D706169676E732061726520686F7720796F752063616E2067657420796F757220616666696C6961746520736974657320746F2074686520746F70206F66207468652073656172636820656E67696E65732E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E486572652061726520697320616E206578616D706C6520616420796F752063616E206D616B653A3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E456E746572204865726520796F7572205050432041642E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E7573652074686973206C696E6B3A3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C494E5055542073697A653D34302076616C75653D7B6166665F6C696E6B7D204E414D453D227465787431223E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E3C2F5350414E3E3C2F4449563E0D0A3C44495620616C69676E3D6C6566743E3C5350414E207374796C653D22434F4C4F523A2023303030303030223E546865206B657920697320746F2075736520746865206B6579776F7264732062656C6F77206E6F74206F6E6C7920696E20796F75722063616D706169676E7320776F7264732C2062757420616C736F20617320776F72647320696E20796F7572206164732E205573652074686520476F6F676C65204164776F726473204164205475746F7269616C20746F2068656C7020796F752064657369676E206772656174206164732E3C2F4449563E0D0A3C50207374796C653D222220616C69676E3D6C6566743E486572652069732061206C697374206F66206B657920776F72647320796F752063616E2075736520666F7220796F75722063616D706169676E732E3C2F503E0D0A3C444956207374796C653D222220616C69676E3D6C6566743E466F72206D6F726520696E666F206F6E203C423E4164776F7264733C2F423E2C203C4120687265663D22687474703A2F2F7777772E676F6F676C652E636F6D2F7365617263683F713D6164776F72647322207461726765743D5F626C616E6B3E636C69636B20686572652E3C2F413E3C2F4449563E0D0A3C444956207374796C653D222220616C69676E3D6C6566743E3C2F4449563E0D0A3C444956207374796C653D222220616C69676E3D6C6566743E3C544558544152454120726F77733D313020636F6C733D3530204E414D453D22746578746172656131223E46696C6C2068657265207769746820796F7572206B6579776F7264732E3C2F54455854415245413E3C2F4449563E0D0A3C444956207374796C653D222220616C69676E3D6C6566743E3C2F4449563E3C2F5350414E3E,1,0);
INSERT INTO `promo_tools` VALUES (26,' Email Signatures',0x3C4449563E3C5354524F4E473E512E3C42523E576861742061726520456D61696C20616E6420466F72756D205369676E6174757265733F3C42523E3C42523E412E3C2F5354524F4E473E3C42523E496620796F7520686176652065766572207365656E20616E20656D61696C2066726F6D20736F6D656F6E6520616E642061742074686520626F74746F6D206F662074686520656D61696C206974206C6F6F6B206C696B65206120502E532E20666F72206173206164766572746973656D656E742E205468617420697320616E206175746F6D61746963616C6C7920696E73657274656420656D61696C207369676E6174757265732E205468697320697320616C736F20646F6E6520696E20666F72756D732061732077656C6C2E3C2F4449563E0D0A3C4449563E3C2F4449563E0D0A3C4449563E496620796F752048617665205961686F6F2C204D534E2C20796F7572206F776E20646F6D61696E2C206F72206576656E20414F4C20616464207468657365207369676E61747572657320746F2074686520626F74746F6D73206F6620616C6C206F6620796F7572206F7574676F696E6720656D61696C732E204A75737420676F20746F20796F757220656D61696C20707265666572656E6365732054414220616E6420636F7079207061737465207468657365207369676E61747572657320746F20796F757220656D61696C7320616E6420776174636820796F757220646F776E6C696E6520726F636B6574213C2F4449563E0D0A3C444956207374796C653D22223E3C2F4449563E0D0A3C444956207374796C653D22223E0D0A3C50207374796C653D22223E32204C696E65205369676E61747572653C42523E3C5445585441524541206E616D653D533120726F77733D3620636F6C733D36343E46696C6C20686572652074686520656D61696C207369676E61747572652E3C2F54455854415245413E3C2F503E0D0A3C50207374796C653D22223E33204C696E65205369676E61747572653C42523E3C5445585441524541206E616D653D533120726F77733D3720636F6C733D36343E46696C6C20686572652074686520656D61696C207369676E61747572652E3C2F54455854415245413E200D0A3C50207374796C653D22223E34204C696E65205369676E61747572653C42523E3C5445585441524541206E616D653D533120726F77733D3620636F6C733D36343E46696C6C20686572652074686520656D61696C207369676E61747572652E3C2F54455854415245413E3C2F503E0D0A3C50207374796C653D22223E35204C696E65205369676E61747572653C42523E3C5445585441524541206E616D653D533120726F77733D3720636F6C733D36343E46696C6C20686572652074686520656D61696C207369676E61747572652E3C2F54455854415245413E3C2F503E3C2F4449563E,1,0);
INSERT INTO `promo_tools` VALUES (27,' Top Sponsor Ads',0x3C5020616C69676E3D63656E7465723E48657265206172652074776F20477265617420506C6163657320746F2067657420542E532E412E27733C42523E3C42523E2834204C494E45293C2F503E0D0A3C5020616C69676E3D63656E7465723E436F70792F5061737465207468697320416420746F2075736520617320612022546F702053706F6E736F722041642220696E20616E20457A696E65206F7220536166656C6973742E3C42523E3C5445585441524541206E616D653D533120726F77733D3620636F6C733D36303E456E74657220796F75722034206C696E6520746F702073706F6E736F722061642E3C2F54455854415245413E3C2F503E0D0A3C5020616C69676E3D63656E7465723E203C2F503E0D0A3C464F524D20616374696F6E3D5F646572697665642F6E6F7274626F74732E68746D206D6574686F643D706F737420776562626F742D616374696F6E3D222D2D574542424F542D53454C462D2D2220776562626F742D6F6E5375626D69743E3C212D2D776562626F7420626F743D2253617665526573756C74732220752D66696C653D22433A5C446F63756D656E747320616E642053657474696E67735C4F776E65725C4D7920446F63756D656E74735C4D7920576562735C5F707269766174655C666F726D5F726573756C74732E6373762220732D666F726D61743D22544558542F4353562220732D6C6162656C2D6669656C64733D2254525545222073746172747370616E202D2D3E3C212D2D776562626F7420626F743D2253617665526573756C74732220656E647370616E20692D636865636B73756D3D22343334303622202D2D3E0D0A3C5020616C69676E3D63656E7465723E2835204C494E45293C2F503E0D0A3C5020616C69676E3D63656E7465723E436F70792F5061737465207468697320416420746F2075736520617320612022546F702053706F6E736F722041642220696E20616E20457A696E65206F7220536166656C6973742E3C42523E3C5445585441524541206E616D653D533120726F77733D3720636F6C733D36313E456E74657220796F75722035206C696E6520746F702073706F6E736F722061642E3C2F54455854415245413E3C2F503E3C2F464F524D3E,1,0);
INSERT INTO `promo_tools` VALUES (28,'Tell A Friend',0x3C4449563E456D61696C7320746F2073656E6420746F20796F757220667269656E64733A3C2F4449563E0D0A3C4449563E3C2F4449563E0D0A3C4449563E456D61696C205375626A6563743A3C2F4449563E0D0A3C4449563E3C494E5055542073697A653D35302076616C75653D22456E74657220486572652054686520456D61696C205375626A6563742E22204E414D453D227465787431223E3C2F4449563E0D0A3C4449563E3C2F4449563E0D0A3C4449563E456D61696C20426F64793A3C2F4449563E0D0A3C4449563E3C5445585441524541206E616D653D74657874617265613120726F77733D313020636F6C733D35303E456E74657220486572652074686520456D61696C20426F64792E3C2F54455854415245413E3C2F4449563E,1,0);
INSERT INTO `promo_tools` VALUES (31,'Blog Review',0x3C7461626C652077696474683D223535302220626F726465723D2230223E0D0A20203C74723E0D0A202020203C74642077696474683D22313134223E426C6F6720526576696577205375626A6563743A3C2F74643E0D0A202020203C74642077696474683D22343236223E46696C6C20686572652074686520426C6F6720726576696577207375626A6563742E203C2F74643E0D0A20203C2F74723E0D0A20203C74723E0D0A202020203C74643E426C6F67205265766965772020426F64793A203C2F74643E0D0A202020203C74643E3C703E46696C6C20686572652074686520426C6F672072657669657720626F64792E203C2F703E0D0A202020203C2F74643E0D0A20203C2F74723E0D0A3C2F7461626C653E0D0A,1,0);
INSERT INTO `promo_tools` VALUES (30,'Article Review',0x3C7461626C652077696474683D223535302220626F726465723D2230223E0D0A20203C74723E0D0A202020203C74642077696474683D22313134223E41727469636C6520526576696577205375626A6563743A3C2F74643E0D0A202020203C74642077696474683D22343236223E46696C6C2068657265207468652061727469636C6520726576696577207375626A6563742E203C2F74643E0D0A20203C2F74723E0D0A20203C74723E0D0A202020203C74643E41727469636C65205265766965772020426F64793A203C2F74643E0D0A202020203C74643E3C703E46696C6C2068657265207468652061727469636C652072657669657720626F64792E203C2F703E0D0A202020203C2F74643E0D0A20203C2F74723E0D0A3C2F7461626C653E0D0A,1,0);
INSERT INTO `promo_tools` VALUES (49,' Tell a friend',0x203C666F726D20616374696F6E3D22646F2E7461662E70687022206D6574686F643D22706F737422206E616D653D22666F726D31222069643D22666F726D31223E0D0A3C7461626C652077696474683D223538252220616C69676E3D2263656E746572223E0D0A3C74723E3C746420636F6C7370616E3D2233223E0D0A3C64697620616C69676E3D2263656E746572223E46726F6D3A207B66697273745F6E616D657D207B6C6173745F6E616D657D203C7B656D61696C7D3E3C2F6469763E3C2F74643E0D0A20203C2F74723E0D0A202020203C74723E0D0A0D0A2020202020203C74643E203C2F74643E0D0A2020202020203C74642077696474683D22343625223E3C64697620616C69676E3D2263656E746572223E467269656E642773206E616D653C2F6469763E3C2F74643E0D0A2020202020203C74642077696474683D22343925223E3C64697620616C69676E3D2263656E746572223E467269656E64277320656D61696C3C2F6469763E3C2F74643E0D0A202020203C2F74723E0D0A202020203C74723E0D0A2020202020203C74643E3C7374726F6E673E23313C2F7374726F6E673E3C2F74643E0D0A2020202020203C74643E0D0A0D0A20202020202020203C64697620616C69676E3D2263656E746572223E0D0A202020202020202020203C696E707574206E616D653D226E616D657831222069643D226E616D657831222073697A653D2232302220747970653D2274657874223E0D0A20202020202020203C2F6469763E3C2F74643E0D0A2020202020203C74643E3C64697620616C69676E3D2263656E746572223E0D0A20202020202020203C696E707574206E616D653D22656D61696C7831222069643D22656D61696C7831222073697A653D2232302220747970653D2274657874223E0D0A2020202020203C2F6469763E3C2F74643E0D0A202020203C2F74723E0D0A202020203C74723E0D0A2020202020203C74643E3C7374726F6E673E23323C2F7374726F6E673E3C2F74643E0D0A0D0A2020202020203C74643E0D0A20202020202020203C64697620616C69676E3D2263656E746572223E0D0A202020202020202020203C696E707574206E616D653D226E616D657832222069643D226E616D657832222073697A653D2232302220747970653D2274657874223E0D0A20202020202020203C2F6469763E3C2F74643E0D0A2020202020203C74643E3C64697620616C69676E3D2263656E746572223E0D0A20202020202020203C696E707574206E616D653D22656D61696C7832222069643D22656D61696C7832222073697A653D2232302220747970653D2274657874223E0D0A2020202020203C2F6469763E3C2F74643E0D0A202020203C2F74723E0D0A202020203C74723E0D0A0D0A2020202020203C74643E3C7374726F6E673E23333C2F7374726F6E673E3C2F74643E0D0A2020202020203C74643E0D0A20202020202020203C64697620616C69676E3D2263656E746572223E0D0A202020202020202020203C696E707574206E616D653D226E616D657833222069643D226E616D657833222073697A653D2232302220747970653D2274657874223E0D0A20202020202020203C2F6469763E3C2F74643E0D0A2020202020203C74643E3C64697620616C69676E3D2263656E746572223E0D0A20202020202020203C696E707574206E616D653D22656D61696C7833222069643D22656D61696C7833222073697A653D2232302220747970653D2274657874223E0D0A2020202020203C2F6469763E3C2F74643E0D0A0D0A202020203C2F74723E0D0A202020203C74723E0D0A2020202020203C74643E3C7374726F6E673E23343C2F7374726F6E673E3C2F74643E0D0A2020202020203C74643E0D0A20202020202020203C64697620616C69676E3D2263656E746572223E0D0A202020202020202020203C696E707574206E616D653D226E616D657834222069643D226E616D657834222073697A653D2232302220747970653D2274657874223E0D0A20202020202020203C2F6469763E3C2F74643E0D0A2020202020203C74643E3C64697620616C69676E3D2263656E746572223E0D0A0D0A20202020202020203C696E707574206E616D653D22656D61696C7834222069643D22656D61696C7834222073697A653D2232302220747970653D2274657874223E0D0A2020202020203C2F6469763E3C2F74643E0D0A202020203C2F74723E0D0A202020203C74723E0D0A2020202020203C74643E3C7374726F6E673E23353C2F7374726F6E673E3C2F74643E0D0A2020202020203C74643E0D0A20202020202020203C64697620616C69676E3D2263656E746572223E0D0A202020202020202020203C696E707574206E616D653D226E616D657835222069643D226E616D657835222073697A653D2232302220747970653D2274657874223E0D0A0D0A20202020202020203C2F6469763E3C2F74643E0D0A2020202020203C74643E3C64697620616C69676E3D2263656E746572223E0D0A20202020202020203C696E707574206E616D653D22656D61696C7835222069643D22656D61696C7835222073697A653D2232302220747970653D2274657874223E0D0A2020202020203C2F6469763E3C2F74643E0D0A202020203C2F74723E0D0A20203C2F74626F64793E3C2F7461626C653E0D0A20203C64697620616C69676E3D2263656E746572223E0D0A202020203C703E5375626A6563743A3C62723E0D0A0D0A2020202020203C696E707574206E616D653D2276616C756531222069643D2276616C756531222076616C75653D225B46495253544E414D455D2C20436865636B2074686973206F7574222073697A653D2235302220747970653D2274657874223E200D0A3C2F703E0D0A3C703E426F64793A3C62723E0D0A20203C7465787461726561206E616D653D2276616C7565322220636F6C733D2236302220726F77733D2236222069643D2276616C756532223E4869205B46495253544E414D455D2C0D0A0D0A49206A7573742074686F7567687420796F75206D61792077616E7420746F206B6E6F772061626F75740D0A7468697320636F6F6C20746F6F6C204920666F756E642E0D0A0D0A49206C696B6520697420616E6420492074686F75676874206F6620796F75207768656E204920676F742069742E0D0A7B6166665F6C696E6B7D0D0A0D0A497420697320636F6F6C20616E642049206B6E657720796F7520776F756C642077616E7420746F2073656520697420746F6F2E0D0A0D0A5468616E6B732C0D0A0D0A7B66697273745F6E616D657D207B6C6173745F6E616D657D3C2F74657874617265613E200D0A20203C2F703E0D0A3C703E0D0A7B636170746368617D3C2F703E0D0A3C7020616C69676E3D2263656E746572223E0D0A2020202020203C696E707574206E616D65783D2253656E64222069643D2253656E64222076616C75653D2253656E642220747970653D227375626D6974223E0D0A3C2F703E0D0A202020203C2F666F726D3E,0,10011002);
INSERT INTO `promo_tools` VALUES (54,'Pop Exit',0x3C534352495054204C414E47554147453D224A617661536372697074223E2076617220636F6F6B69653D227173705646384A43223B2076617220657869743D747275653B207661722066696C656E616D653D277B6166665F6C696E6B7D273B2076617220706F7075703B20766172206865696768743D222B73637265656E2E6865696768742B223B207661722077696474683D222B73637265656E2E77696474682B223B20766172206C6566743D2873637265656E2E77696474682F32292D28222B73637265656E2E77696474682B222F32293B2076617220746F703D2873637265656E2E6865696768742F32292D28222B73637265656E2E6865696768742B222F32293B2066756E6374696F6E2065786974706F7028297B2069662865786974297B2069662028676574636F6F6B696528636F6F6B6965293D3D2222297B20706F707570203D2077696E646F772E6F70656E2866696C656E616D652C2022222C226865696768743D222B6865696768742B222C77696474683D222B77696474682B222C746F703D222B746F702B222C6C6566743D222B6C6566742B222C6C6F636174696F6E3D7965732C6D656E756261723D7965732C726573697A61626C653D7965732C7363726F6C6C626172733D7965732C7374617475733D7965732C7469746C656261723D7965732C746F6F6C6261723D7965732C6469726563746F726965733D79657322293B20736574636F6F6B696528293B207D207D207D2066756E6374696F6E20676574636F6F6B696528636F6F6B69654E616D6529207B20766172206964203D20636F6F6B69654E616D65202B20223D223B2076617220636F6F6B696576616C7565203D2022223B2069662028646F63756D656E742E636F6F6B69652E6C656E677468203E203029207B206F6666736574203D20646F63756D656E742E636F6F6B69652E696E6465784F66286964293B20696620286F666673657420213D202D3129207B20636F6F6B696576616C7565203D202278223B207D207D2072657475726E20636F6F6B696576616C75653B207D2066756E6374696F6E20736574636F6F6B6965202829207B2076617220746F646179203D206E6577204461746528293B207661722065787064617465203D206E6577204461746528746F6461792E67657454696D652829202B2031202A203234202A203630202A203630202A2031303030293B20646F63756D656E742E636F6F6B6965203D20636F6F6B6965202B20223D22202B20657363617065202822646F6E6522292B20223B657870697265733D22202B20657870646174652E746F474D54537472696E6728293B207D20646F63756D656E742E6F6E756E6C6F61643D65786974706F703B2077696E646F772E6F6E756E6C6F61643D65786974706F703B203C2F5343524950543E20,1,0);
INSERT INTO `promo_tools` VALUES (55,'Pop Under',0x203C534352495054204C414E47554147453D224A617661536372697074223E203C212D2D626567696E202F2A202A20506F70757020636F64652067656E65726174656420627920506F7055704D61737465722050726F2066726F6D202A20687474703A2F2F706F7075706D61737465722E636F6D202A20436F7079726967687420286329323030332C20537465766520536861772C2074616B616E6F6D692E636F6D202A2F2076617220636F6F6B69653D2279394B457A4C4876223B2076617220706F7075703B20766172206865696768743D222B73637265656E2E6865696768742B223B207661722077696474683D222B73637265656E2E77696474682B223B20766172206C6566743D303B2076617220746F703D303B20656E747279706F7028277B6166665F6C696E6B7D27293B2066756E6374696F6E20656E747279706F702866696C656E616D65297B2069662028676574636F6F6B696528636F6F6B6965293D3D2222297B20706F707570203D2077696E646F772E6F70656E2866696C656E616D652C2022222C226865696768743D222B6865696768742B222C77696474683D222B77696474682B222C746F703D222B746F702B222C6C6566743D222B6C6566742B222C6C6F636174696F6E3D7965732C6D656E756261723D7965732C726573697A61626C653D7965732C7363726F6C6C626172733D7965732C7374617475733D7965732C7469746C656261723D7965732C746F6F6C6261723D7965732C6469726563746F726965733D79657322293B2073656C662E666F63757328293B20736574636F6F6B696528293B207D207D2066756E6374696F6E20676574636F6F6B696528636F6F6B69654E616D6529207B20766172206964203D20636F6F6B69654E616D65202B20223D223B2076617220636F6F6B696576616C7565203D2022223B2069662028646F63756D656E742E636F6F6B69652E6C656E677468203E203029207B206F6666736574203D20646F63756D656E742E636F6F6B69652E696E6465784F66286964293B20696620286F666673657420213D202D3129207B20636F6F6B696576616C7565203D202278223B207D207D2072657475726E20636F6F6B696576616C75653B207D2066756E6374696F6E20736574636F6F6B6965202829207B20646F63756D656E742E636F6F6B6965203D20636F6F6B6965202B20223D22202B20657363617065202822646F6E6522293B207D202F2F20656E64202D2D3E203C2F5343524950543E20,1,0);
CREATE TABLE `race_details` (
  `id` int(11) NOT NULL auto_increment,
  `start` date NOT NULL default '0000-00-00',
  `end_type` tinyint(4) NOT NULL default '0',
  `date_end` date NOT NULL default '0000-00-00',
  `ref_end` int(11) NOT NULL default '0',
  `enable` tinyint(4) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `race_stats` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `level1_ref` int(11) NOT NULL default '0',
  `race_id` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
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
  `subscriber_id` int(11) NOT NULL,
  `cancelated` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `session_id` (`session_id`,`product_id`),
  KEY `member_id` (`member_id`),
  KEY `paid` (`paid`),
  KEY `paid_step2` (`paid_step2`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `settings` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `name` varchar(64) NOT NULL default '',
  `value` text NOT NULL,
  `box_type` enum('textbox','input','checkbox','hidden','select','radio') NOT NULL default 'textbox',
  `description` text NOT NULL,
  `cat` enum('General Site Settings','Email Address','Sign Up','Payment','OTO (One Time Offer)','Security','MWG Affiliate','3rd Party Autoresponder','Stats','Downline Settings','JV Partner') NOT NULL default 'General Site Settings',
  `rank` int(11) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM AUTO_INCREMENT=3361 DEFAULT CHARSET=latin1 COMMENT='Settings table';
INSERT INTO `settings` VALUES (15,'enable_oto_1','','checkbox','Enable one time offer after sign up ? If you leave this checked the new members will get the one time offer page after they sign up. If you uncheck it then they will be driven directly to members area.','OTO (One Time Offer)',15);
INSERT INTO `settings` VALUES (13,'paypal_email','paypalexample.com','input','<b><font color=\"#003366\">PAYPAL: </font></b> Enter your paypal address where you would like to receive payments','Payment',14);
INSERT INTO `settings` VALUES (10,'free_signup','1','checkbox','Check this box if you want members to sign up for free at the site. Uncheck this box if you want people to pay to become a member. (NOTE: The new One-Click OTO upsell function using Authorize.net requires that this box NOT be checked so the user must make a purchase to get into the site.)','Sign Up',10);
INSERT INTO `settings` VALUES (14,'accept_paypal','','checkbox','<b><font color=\"#003366\">PAYPAL: </font> Accept payments via paypal ?</b>','Payment',13);
INSERT INTO `settings` VALUES (9,'emailing_from_email','owner@example.com','hidden','The Email Address that will appear in the From: field of the emails sent (welcome emails, lost password emails, ...)','Email Address',9);
INSERT INTO `settings` VALUES (8,'emailing_from_name','Site Owner','hidden','The Name that will appear in the From: field of the emails sent (welcome emails, lost password emails, ...)','Email Address',8);
INSERT INTO `settings` VALUES (7,'send_welcome_emails','1','checkbox','Send welcome emails to new members ?','',3);
INSERT INTO `settings` VALUES (6,'lostpass_email_body','Hi [firstname],\r\n\r\nyour password: [password]\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin.','textbox','Lost password email body','',6);
INSERT INTO `settings` VALUES (5,'lostpass_email_subject','[firstname], your password for [sitename]!','input','Lost password email subject.','',5);
INSERT INTO `settings` VALUES (4,'welcome_email_body','Hi [firstname],\r\n\r\nwelcome to [sitename], \r\n\r\nyour login info is:\r\n\r\nemail: [email]\r\npassword: [password]\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin.','textbox','New member welcome email body.','',4);
INSERT INTO `settings` VALUES (3,'welcome_email_subject','[firstname], welcome to [sitename] !','input','New member welcome email subject.','',3);
INSERT INTO `settings` VALUES (19,'site_full_url','','input','The full URL to your site including folder if necessary(Example: <b>http://www.minigolf.com/</b> or <b>http://www.minigolf.com/ball/</b>)','General Site Settings',19);
INSERT INTO `settings` VALUES (2,'webmaster_contact_email','email@example.com','input','Email address where the contact form should send the messages','General Site Settings',2);
INSERT INTO `settings` VALUES (20,'txn_id','','input','<b><font color=\"#003366\">PAYPAL: </font></b> Paypal TXN_ID setting, this is used for paypal instant payment notification and it\'s a temporary payment session ID, do not modify','Payment',20);
INSERT INTO `settings` VALUES (1,'site_name','Generator 1.0','input','Your Site Name','General Site Settings',1);
INSERT INTO `settings` VALUES (16,'enable_oto_2','','checkbox','Check this box if you want an one time offer upsell(2nd one time offer) after member paid for one time offer.','OTO (One Time Offer)',16);
INSERT INTO `settings` VALUES (17,'affiliate_variable','thankyou-page','input','This is the affiliate variable used by the site... For example: <b>http://yoursite.com/?<font color=red>affiliate</font>=id</b>','General Site Settings',17);
INSERT INTO `settings` VALUES (18,'secret_string','c82f98d71095aac45897cdd0a6f9','hidden','A unique string that you only know. It will be used to protect the session ID of all logged users. (Changing the default setting for this is very important!)','Security',18);
INSERT INTO `settings` VALUES (21,'bm_aff_link','','input','Your MWG Affiliate link','MWG Affiliate',21);
INSERT INTO `settings` VALUES (22,'enable_bm_aff_link','1','select','Enable your MWG Affiliate Link at the bottom of your site. If you do not have your MWG Affiliate link please <a href=\"http://marketingwebsitegenerator.com/\" target=_blank>click here</a> to get one.','MWG Affiliate',22);
INSERT INTO `settings` VALUES (31,'enable_arp','','hidden','Enable subscription to 3rd Party autoresponders for new members','3rd Party Autoresponder',31);
INSERT INTO `settings` VALUES (32,'arp_email','arp@example.com','hidden','The Email Address of the 3rd Party Autoresponder','3rd Party Autoresponder',32);
INSERT INTO `settings` VALUES (33,'arp_message_subject','Subject for arp email','hidden','This is the subject of the mail that will be sent to the autoresponder for subscription','3rd Party Autoresponder',33);
INSERT INTO `settings` VALUES (34,'arp_message_body','Body of email','hidden','This is the body of the mail that will be sent to the autoresponder for subscription','3rd Party Autoresponder',34);
INSERT INTO `settings` VALUES (35,'enable_profile_directory','1','checkbox','Enable profile directory in members area ?','General Site Settings',35);
INSERT INTO `settings` VALUES (40,'show_promo_signup','0','hidden','','General Site Settings',40);
INSERT INTO `settings` VALUES (37,'verticalmenumain','','hidden','','General Site Settings',37);
INSERT INTO `settings` VALUES (38,'verticalmenumembers','','hidden','','General Site Settings',38);
INSERT INTO `settings` VALUES (41,'show_promo_profile','1','hidden','','General Site Settings',41);
INSERT INTO `settings` VALUES (42,'activation_email','','checkbox','User Can not access members area without activating their account by clicking the confirmation link they receive to their email address.','General Site Settings',42);
INSERT INTO `settings` VALUES (43,'signup_with_code','','hidden','Code used for signup','General Site Settings',43);
INSERT INTO `settings` VALUES (44,'activation_email_subject','Your account activation','input','','General Site Settings',44);
INSERT INTO `settings` VALUES (45,'activation_email_body','Hi, Your signup was successful but we need you to activate your account by clicking this link: {activation_link} Admin','textbox','','General Site Settings',45);
INSERT INTO `settings` VALUES (46,'signup_code','','hidden','','General Site Settings',46);
INSERT INTO `settings` VALUES (47,'text_no_buy','No, thanks I\\\'m not interested... ','input','This is the link where the members click of they don\'t want to buy the One Time Offer','OTO (One Time Offer)',47);
INSERT INTO `settings` VALUES (48,'text_for_popup','Are you sure you wish to continue? This offer will never be made to you again...','textbox','Enter text for the popup on the one time offer if they choose not to buy:','OTO (One Time Offer)',48);
INSERT INTO `settings` VALUES (56,'text_for_signup_code','Sign up code','hidden','','General Site Settings',56);
INSERT INTO `settings` VALUES (63,'send_mail','','checkbox','Allow members to email their downline ?','Downline Settings',63);
INSERT INTO `settings` VALUES (64,'mail_interval','6','input','Once every how many days can the users email their downline ?','Downline Settings',64);
INSERT INTO `settings` VALUES (65,'mail_levels','2','input','Users can email downline how many levels ?','Downline Settings',65);
INSERT INTO `settings` VALUES (60,'view_downline','','checkbox','Allow members to view their downline ?','Downline Settings',60);
INSERT INTO `settings` VALUES (66,'view_stats','','checkbox','Allow member to see site statistics ?','Stats',66);
INSERT INTO `settings` VALUES (61,'view_downline_levels','1','input','Allow members to view how many levels of their downline ?','Downline Settings',61);
INSERT INTO `settings` VALUES (67,'site_overview','1,2,3,4,5,6,7,8,9','hidden','','General Site Settings',67);
INSERT INTO `settings` VALUES (68,'enable_credit','','hidden','','General Site Settings',68);
INSERT INTO `settings` VALUES (69,'nr_credit','0','hidden','','General Site Settings',69);
INSERT INTO `settings` VALUES (70,'delete_user','','checkbox','If a payment is refunded or cancelated should the member be deleted? (check if yes)','Payment',70);
INSERT INTO `settings` VALUES (71,'suspend_user','','checkbox','If a payment is refunded or cancelated should the member be suspended? (check if yes)','Payment',71);
INSERT INTO `settings` VALUES (137,'shipping_email_body','Please ship {ship_quantity}*{ship_product}\r\n\r\nTo: {ship_to_first_name} {ship_to_last_name}\r\nAddress: {ship_to_address_street}, {ship_to_address_city}, {ship_to_address_zip}, \r\n{ship_to_address_state}, {ship_to_address_country} ({ship_to_address_country_code})\r\n\r\nThanks,\r\n{ship_ask_company}','textbox','This is the body of the email which goes to your shipping company<br>Tags to use: {ship_to_first_name}, {ship_to_last_name}, {ship_to_address_street}, {ship_to_address_city}, {ship_to_address_zip}, {ship_to_address_country}, {ship_to_address_country_code}, {ship_to_address_state}, {ship_ask_company}.','General Site Settings',145);
INSERT INTO `settings` VALUES (72,'change_membership','Chose membership','select','<b><font color=\"#003366\">PAYPAL: </font></b> If a payment is refunded change membership of member to:','Payment',72);
INSERT INTO `settings` VALUES (57,'meta-description','','hidden','','General Site Settings',57);
INSERT INTO `settings` VALUES (53,'keywords','','hidden','','General Site Settings',53);
INSERT INTO `settings` VALUES (54,'delete_acount','1','checkbox','Do you want to allow members to delete their account ?','General Site Settings',54);
INSERT INTO `settings` VALUES (73,'default_free','1','select','Choose default membership for new users, if they don\'t make any payment.In case of paid signup this is the default membership on signup.','Sign Up',73);
INSERT INTO `settings` VALUES (74,'enable_jv','','checkbox','Use JV special signup. Send this url {url}signup_jv.php to your JV partner','JV Partner',74);
INSERT INTO `settings` VALUES (75,'jv_membership','Chose membership','select','What membership should a JV have at signup','JV Partner',75);
INSERT INTO `settings` VALUES (76,'jv_code','','input','Enter the JV code','JV Partner',76);
INSERT INTO `settings` VALUES (77,'splitoption','2','radio','Choose which order to pay when split payment occurs.','Payment',77);
INSERT INTO `settings` VALUES (87,'searchperpage','100','hidden','','General Site Settings',87);
INSERT INTO `settings` VALUES (88,'reset_email_subject','Hi {first_name}, Your Password has been reset.','input','This is the subject of the email that goes to members when you reset their password.','General Site Settings',88);
INSERT INTO `settings` VALUES (89,'reset_email_body','Hi {first_name},\r\n\r\nYour password has been reset to: {password}\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin','textbox','This is the body of the email that goes to members when you reset their password','General Site Settings',89);
INSERT INTO `settings` VALUES (90,'referral_email_subject','Congratulations {first_name}, You Just made a referral','input','This is the subject of the mail going to members to announce that they made a new referral','General Site Settings',90);
INSERT INTO `settings` VALUES (92,'referral_email_body','Hi {first_name},\r\n\r\nYou have just made a new referral to our site.\r\n\r\n{member_details}\r\n\r\nKeep up the good work.\r\n\r\nLogin now to make even more referrals.\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin','textbox','This is the body of the email which goes to member when he makes a new referral<br> Tags to use:{buyer_first_name},{buyer_last_name},{buyer_id},{buyer_email}','General Site Settings',92);
INSERT INTO `settings` VALUES (93,'referral_email','1','checkbox','Send message to members when they make a new referral ?','General Site Settings',90);
INSERT INTO `settings` VALUES (94,'sales_email','1','checkbox','Send email to member when he makes a sale ?','General Site Settings',94);
INSERT INTO `settings` VALUES (95,'sales_email_subject','Congratulations {first_name}, You Just made a sale','input','This is the subject of the email that goes to members when they make a sale.','General Site Settings',95);
INSERT INTO `settings` VALUES (96,'sales_email_body','Hi {first_name},\r\n\r\nYou have just made a sale at [sitename]\r\n\r\nYou sold {product}.\r\n\r\nYour commission for that is {value}.\r\n\r\nKeep up the good work.\r\n\r\nLogin now to get even more sales.\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin','textbox','This is the body of the email that goes out to member when they make a sale<br> Tags to use:{buyer_first_name}{buyer_last_name},{buyer_id},{buyer_email}','General Site Settings',96);
INSERT INTO `settings` VALUES (103,'arp_in_use_type','1','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (102,'arp_in_use','4','hidden','','3rd Party Autoresponder',0);
INSERT INTO `settings` VALUES (101,'enable_oto_paid_signup','0','radio','Choose Flow:','Sign Up',11);
INSERT INTO `settings` VALUES (100,'view_stats_chk','1,3,2','checkbox','','Stats',67);
INSERT INTO `settings` VALUES (99,'allow_private_messages','','checkbox','Allow members to choose wether they email or send a private message to their downline ?','Downline Settings',99);
INSERT INTO `settings` VALUES (98,'downline_em','','checkbox','Allow members to view the emails addresses for members in their downline ?','Downline Settings',98);
INSERT INTO `settings` VALUES (105,'vendor_id','','input','<font color=\"#990000\"><b>CLICKBANK: </b></font> Product Clickbank Vendor ID','Payment',105);
INSERT INTO `settings` VALUES (106,'secret_key','','input','<font color=\"#990000\"><b>CLICKBANK: </b></font> Clickbank Secret Key','Payment',106);
INSERT INTO `settings` VALUES (104,'accept_clickbank','','checkbox','<b><font color=\"#990000\">CLICKBANK: </font> Accept payments via Clickbank ?</b>','Payment',104);
INSERT INTO `settings` VALUES (109,'sid','','input','<b><font color=\"#006633\">2CheckOut:</font></b> Product 2Checkout Vendor ID','Payment',109);
INSERT INTO `settings` VALUES (110,'secret_key_2co','','input','<b><font color=\"#006633\">2CheckOut:</font></b> 2Checkout Secret Word (in 2co under \"look and feel\" link)','Payment',110);
INSERT INTO `settings` VALUES (111,'quantity','1','input','<b><font color=\"#006633\">2CheckOut:</font></b> Product quantity','Payment',111);
INSERT INTO `settings` VALUES (108,'accept_2co','','checkbox','<b><font color=\"#006633\">2CheckOut:</font> Accept payments via 2Checkout ?</b> ','Payment',108);
INSERT INTO `settings` VALUES (112,'signup_code_redirect','','input','Enter what page do you want to redirect the user after filling the promo code.(Leave empty for default page)','General Site Settings',47);
INSERT INTO `settings` VALUES (113,'logout_redirect_url','','input','Insert the page you want the user to be redirected after logout (If empty it will redirect to homepage).','General Site Settings',0);
INSERT INTO `settings` VALUES (114,'oto_backup','','checkbox','Check this if you want people to receive a down sell (lower price OTO1) if they did not buy the first OTO','OTO (One Time Offer)',15);
INSERT INTO `settings` VALUES (115,'cut_signup','','checkbox','Check this box if you do not want to collect the password on the signup page. This can increase conversion. The new user will not have to create a password until after he/she joins the site and views your OTO sequence (if you have one.) The user will be asked to create a unique and personal password after this process and before accessing the members area.','General Site Settings',0);
INSERT INTO `settings` VALUES (116,'index_signup','','checkbox','Check this if you want the signup form to appear on the index page. For this you need to put in the homepage.html the tag {signup_form} where you want the form to appear.','General Site Settings',0);
INSERT INTO `settings` VALUES (117,'choose_aff','2','radio','If you want to choose another affiliate variable name you can do that and the previous one will still be available. You can switch back any time, both of them remaining active. However only the current one will be displayed in member area.','General Site Settings',18);
INSERT INTO `settings` VALUES (118,'old_aff','','hidden','','General Site Settings',17);
INSERT INTO `settings` VALUES (119,'accept_auth','','checkbox','<font color=\'#FF6600\'><b>AUTHORIZE.NET:</b></font> <b>Accept payments via Authorize.net</b>?','Payment',112);
INSERT INTO `settings` VALUES (120,'oto_bck_2','','checkbox','Check this if you want people to receive a down-sell (lower price OTO2) if they did not buy the second OTO','OTO (One Time Offer)',16);
INSERT INTO `settings` VALUES (121,'auth_key','','input','<font color=\'#FF6600\'><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net <b>Transaction Key</b> for single-payment purchases.</p><p>*This is the second part of the information required in order to be able to accept single payments through Authorize.net<b></b></p>','Payment',113);
INSERT INTO `settings` VALUES (122,'auth_login','','input','<p><font color=\'#FF6600\'><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net \r\n  <b>API Login ID</b> for one-time payments:</p>\r\n<p>*REQUIREMENTS:<br>\r\n  - the <b><i>Account>Settings>Return/Receipt URL</i></b> in Authorize.net \r\n  must have <font color=\"#990000\"><b>https://{your installed url}/auth.pay.return.php</b></font> \r\n  in either the <i>Default Receipt URL</i> or one of the allowed <i>Relay / Response URLS</i> (tells Authorize.net that your site is a valid site for submitting orders)</p>\r\n   ','Payment',112);
INSERT INTO `settings` VALUES (123,'auth_hash','','input','<font color=\"#FF6600\"><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net <b>MD5 Hash</b> (optional - but must match setting in Authorize.net):','Payment',114);
INSERT INTO `settings` VALUES (125,'cb_popup','','checkbox','<font color=\"#990000\"><b>CLICKBANK: </b></font> Check this if you want a popup to set the Clickbank affiliate.(old way)','Payment',107);
INSERT INTO `settings` VALUES (124,'cb_invisible','1','checkbox','<font color=\"#990000\"><b>CLICKBANK: </b></font> Check this if you want an invisible popup to set up your the Clickbank affiliate.','Payment',107);
INSERT INTO `settings` VALUES (126,'dual_templates','','checkbox','Check here to have different templates for logged in and not logged members ','General Site Settings',0);
INSERT INTO `settings` VALUES (127,'activation_code_email','dudu','input','Activation code','General Site Settings',43);
INSERT INTO `settings` VALUES (128,'activation_email_type','2','radio','','General Site Settings',42);
INSERT INTO `settings` VALUES (129,'activate_cycler','','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (130,'ban_active','0','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (131,'ban_kind','0','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (132,'ipblocker','','checkbox','Block same IP from joining ','Sign Up',132);
INSERT INTO `settings` VALUES (133,'blockfor','Chose what to do with members that pay by echeck','select','','Sign Up',133);
INSERT INTO `settings` VALUES (135,'sales_email_cc','','checkbox','Check this if you want a second person to receive an email for a sale.','General Site Settings',0);
INSERT INTO `settings` VALUES (136,'sales_email_cc_adr','','input','Insert the second person\'s email which receives the sales email.','General Site Settings',0);
INSERT INTO `settings` VALUES (3329,'otobckem','1','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3330,'otobckeusescript','1','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3331,'otobckeb','Hi {first_name},\r\n\r\nI\'m writing you to make sure you know we had a glitch in our system that prevented some users to buy our one time offer.\r\n\r\nWe are very sorry. This glitch has caused much stress on our help desk.\r\n\r\nWell over 75 customers were looking to make the purchase.\r\n\r\nAgain, we are happy it was reported it has been fixed and consider this a reply to your help desk ticket if you sent one. We are closing all related tickets without a reply based on this email. Please login here to review the One Time offer:\r\n\r\n{special_oto_link}\r\n\r\nThank you,\r\n\r\n[sitename]\r\nAdmin','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3332,'otobckedays','1','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3333,'otobckeactive','1','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3334,'otobckes','{first_name}, the glitch that made you loose','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3335,'2co_demo','','checkbox','<b><font color=\"#006633\">2CheckOut:</font></b> Check this if you want to enable 2Checkout payment test mode.','Payment',108);
INSERT INTO `settings` VALUES (3336,'auth_test','','checkbox','<p><font color=\'#FF6600\'><b>AUTHORIZE.NET:</b></font> Check this if you want to enable Authorize.net payment <b>TEST mode</b>.</p>\r\n<p><i>*REQUIREMENTS:</i><br>\r\n  - You must also set test mode in your Authorize.net account. Be sure to remove test mode before going live.</p>\r\n','Payment',112);
INSERT INTO `settings` VALUES (138,'shipping_email_subject','Shipping details','input','This is the subject of the email which goes to your shipping company','General Site Settings',144);
INSERT INTO `settings` VALUES (3337,'send_shipping_email','','checkbox','Send email to your shipping company?','General Site Settings',141);
INSERT INTO `settings` VALUES (3338,'shipping_email','','input','Shipping company email address','General Site Settings',142);
INSERT INTO `settings` VALUES (3339,'ask_country_on_product','1','checkbox','Ask user to choose country for physical products (under each buy button will be a dropdown list with countries)','General Site Settings',140);
INSERT INTO `settings` VALUES (3340,'shipping_email_from','','input','Company email that ask for delivery','General Site Settings',143);
INSERT INTO `settings` VALUES (3341,'no_shipping','Sorry - we currently are not setup to ship to your country of residence. Please visit our support department for further information','textbox','Message for members from countries where you don\'t make shppings','General Site Settings',3);
INSERT INTO `settings` VALUES (3342,'enable_captcha','','checkbox','Use captcha (a code made of 5 characters that are shown in a picture and is required to be entered when signing up)','Sign Up',134);
INSERT INTO `settings` VALUES (3343,'make_winner','','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3344,'admin_sale_email','Hi {first_name},\r\n\r\nYou have just made a sale at [sitename].\r\n\r\nYou sold {product}.\r\n\r\nThank you,\r\n\r\n[sitename] Admin','hidden','This is the body of the email that goes out to admin when a sale is made','General Site Settings',0);
INSERT INTO `settings` VALUES (3345,'give_oto_jv_new','1','checkbox','Check this to show to JV partners OTO offers','JV Partner',75);
INSERT INTO `settings` VALUES (3346,'paypal_currency','USD','select','<b><font color=\"#003366\">PAYPAL: </font></b> Currency for PayPal transactions','Payment',15);
INSERT INTO `settings` VALUES (3347,'cancel_new_system','1','checkbox','<b><font color=\"#003366\">PAYPAL: </font></b> If a payment is refunded or canceled just remove access to the product? (check if yes).','Payment',71);
INSERT INTO `settings` VALUES (3354,'auth_test2','','checkbox','<font color=\"#FF6600\"><b>AUTHORIZE.NET:</b></font> Check this if you want to enable Authorize.net payment <b>TEST mode</b> with <b><font color=\"#993300\">AIM</font></b> purchases ','Payment',123);
INSERT INTO `settings` VALUES (3353,'auth_one_click','','checkbox','<p><font color=\"#FF6600\"><b>AUTHORIZE.NET:</b></font> Enable <b>One Click OTO \r\n  Payments</b> </p>\r\n<p><i>*REQUIREMENTS:</i><br>\r\n  1. the <b><font color=\"#993300\">AIM</font></b> system must be used<br>\r\n  2. <b>SSL Certificate</b> (and the order form must use an https:// secure page url on your site)<br>\r\n  3. Paid signup system. Will not work with free signup sites.</p>\r\n','Payment',121);
INSERT INTO `settings` VALUES (3352,'use_aim','0','checkbox','<p><font color=\'#FF6600\'><b>AUTHORIZE.NET:</b></font> Use <b>Credit Card capture</b> \r\n  (<b><font color=\"#993300\">AIM</font></b>) with Authorize.net. <i>If this is not checked, you will be using the Authorize.net order form that is hosted by authnet, which requires a live authnet account instead of a test acct</i>.<br>\r\n</p>\r\n<p><i>*REQUIREMENTS:</i><br>\r\n  - <b>SSL Certificate</b> (and the order form must use an https:// secure page url on your site ... because your order form is hosted on your own site.) \r\n  <br>\r\n</p>','Payment',120);
INSERT INTO `settings` VALUES (3350,'auth_key_arb','','input',' \r\n<p><font color=\"#FF6600\"><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net \r\n  <b>Transaction Key</b> for <font color=\"#330066\"><b>SUBSCRIPTIONS</b></font> \r\n  (multiple payment purchases). </p>\r\n<p>*This is the second part of the information required in order to be able to accept multiple payments through Authorize.net<b></b></p>\r\n','Payment',131);
INSERT INTO `settings` VALUES (3349,'auth_login_arb','','input','<p><font color=\"#FF6600\"><b>AUTHORIZE.NET:</b></font> Insert the Authorize.net \r\n  <b>API Login ID</b> for <font color=\"#330066\"><b>SUBSCRIPTIONS</b></font> (multiple \r\n  payment purchases). </p>\r\n<p>*REQUIREMENTS:<br>\r\n  1. <b>SSL Certificate</b> (and the order form must use an https:// secure page url on your site)<br>\r\n  2. <font color=\"#660033\"><b>ARB</b></font> (Automatic Recurring Billing) must be enabled in Authorize.net (<b><i>Tools > Recurring Billing</i></b>) ... costs $10 per month<br>\r\n  3. the <b><i>Account>Settings>Silent Post URL</i></b> in Authorize.net \r\n  must be set to <font color=\"#990000\"><b>https://{your installed url}/auth.ipn.php</b></font></p>\r\n','Payment',130);
INSERT INTO `settings` VALUES (3355,'enable_captcha_taf','1','checkbox','Use captcha (a code made of 5 characters that are shown in a picture and is required to be entered when submitting the Tell-A-Friend promo tool)','General Site Settings',135);
INSERT INTO `settings` VALUES (3356,'jv_custom','0','checkbox','Give members ability to add custom bonuses to sales page.Put {jv_customsales} on the page you want the bonus to display and inside members area {jv_customdownload} for the dowlnoad link from jv','General Site Settings',0);
INSERT INTO `settings` VALUES (3357,'jv_custom_memberships','','checkbox','','General Site Settings',0);
INSERT INTO `settings` VALUES (3358,'twitter','0','checkbox','Use twitter promoting tool','General Site Settings',0);
INSERT INTO `settings` VALUES (3359,'twitter_html','','hidden','','General Site Settings',0);
INSERT INTO `settings` VALUES (3360,'lock','1','hidden','','General Site Settings',0);
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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
INSERT INTO `signup_settings` VALUES (1,'first_name',1,1,1,'First Name',1,0);
INSERT INTO `signup_settings` VALUES (2,'last_name',0,0,1,'Last Name',2,0);
INSERT INTO `signup_settings` VALUES (3,'email',1,1,1,'Email Address',3,0);
INSERT INTO `signup_settings` VALUES (4,'paypal_email',0,0,1,'PayPal Email',4,0);
INSERT INTO `signup_settings` VALUES (6,'password',1,1,1,'Password',6,0);
INSERT INTO `signup_settings` VALUES (7,'address',0,0,1,'Address',7,0);
INSERT INTO `signup_settings` VALUES (8,'city',0,0,1,'City',8,0);
INSERT INTO `signup_settings` VALUES (9,'state',0,0,1,'State',9,0);
INSERT INTO `signup_settings` VALUES (10,'zip',0,0,1,'Zip Code',10,0);
INSERT INTO `signup_settings` VALUES (11,'country',0,0,1,'Country',11,0);
INSERT INTO `signup_settings` VALUES (12,'home_phone',0,0,1,'Home Phone',12,0);
INSERT INTO `signup_settings` VALUES (13,'work_phone',0,0,1,'Work Phone',13,0);
INSERT INTO `signup_settings` VALUES (14,'cell_phone',0,0,1,'Cell Phone',14,0);
INSERT INTO `signup_settings` VALUES (15,'icq_id',0,0,1,'Icq Id',15,0);
INSERT INTO `signup_settings` VALUES (16,'msn_id',0,0,1,'Msn Id',16,0);
INSERT INTO `signup_settings` VALUES (17,'yahoo_id',0,0,1,'Yahoo Id',17,0);
INSERT INTO `signup_settings` VALUES (18,'ssn',0,0,0,'Social Security Number (ssn)',18,0);
INSERT INTO `signup_settings` VALUES (19,'url1',0,0,1,'Your Website - 1',19,0);
INSERT INTO `signup_settings` VALUES (20,'url2',0,0,1,'Your Website - 2',20,0);
INSERT INTO `signup_settings` VALUES (21,'url3',0,0,1,'Your Website - 3',21,0);
INSERT INTO `signup_settings` VALUES (22,'clickbank_id',0,0,1,'ClickBank Vendor ID',22,1);
INSERT INTO `signup_settings` VALUES (23,'jv_customdownload',0,0,1,'Your Custom Download HTML',40,0);
INSERT INTO `signup_settings` VALUES (24,'jv_customsales',0,0,1,'Your Custom Sales HTML',41,0);
CREATE TABLE `tags` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(50) NOT NULL default '',
  `field` varchar(50) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;
INSERT INTO `tags` VALUES (39,'home_phone_number','home_phone');
INSERT INTO `tags` VALUES (38,'y_id','yahoo_id');
INSERT INTO `tags` VALUES (29,'first_name','first_name');
INSERT INTO `tags` VALUES (30,'last_name','last_name');
INSERT INTO `tags` VALUES (31,'email','email');
INSERT INTO `tags` VALUES (32,'city','city');
INSERT INTO `tags` VALUES (33,'state','state');
INSERT INTO `tags` VALUES (34,'zip','zip');
INSERT INTO `tags` VALUES (35,'address','address');
INSERT INTO `tags` VALUES (36,'country','country');
INSERT INTO `tags` VALUES (37,'id','id');
INSERT INTO `tags` VALUES (40,'affiliate_id','aff');
CREATE TABLE `temp` (
  `id` int(10) NOT NULL auto_increment,
  `content` longblob NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `temp_cc` (
  `id` int(11) NOT NULL auto_increment,
  `member_id` int(11) NOT NULL default '0',
  `cc` varchar(255) NOT NULL default '',
  `exp_date` varchar(10) NOT NULL default '',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
CREATE TABLE `templates` (
  `id` int(10) NOT NULL auto_increment,
  `filename` text NOT NULL,
  `name` varchar(255) NOT NULL default '',
  `description` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=79 DEFAULT CHARSET=latin1;
INSERT INTO `templates` VALUES (6,'about.us.ag.html','About Us','About Us');
INSERT INTO `templates` VALUES (1,'homepage.html','Homepage','This is your homepage.');
INSERT INTO `templates` VALUES (2,'contact.html','Contact Us','Contact Us Template');
INSERT INTO `templates` VALUES (3,'do.contact.html','Do Contact Us','The page after the message is sent..');
INSERT INTO `templates` VALUES (4,'do.login.error.html','Do Login Error','The page that shows if you type the wrong login info');
INSERT INTO `templates` VALUES (5,'error.html','Error Page','General Error Page');
INSERT INTO `templates` VALUES (7,'faq.html','FAQ','FAQ Page');
INSERT INTO `templates` VALUES (8,'faq.question.answer.html','FAQ Question and Answer','FAQ Question and Answer');
INSERT INTO `templates` VALUES (9,'faq.question.html','FAQ Question','FAQ Question ');
INSERT INTO `templates` VALUES (10,'login.html','Login Page','Login Page');
INSERT INTO `templates` VALUES (11,'main.html','The main template','This is the main template of the site. It will be the frame for all pages except members area.');
INSERT INTO `templates` VALUES (12,'member.area.directory.html','Member Area Directory','Member Area Directory File');
INSERT INTO `templates` VALUES (13,'member.area.do.save.profile.error.html','Member Area Save Profile Error','The error page that is shown if save profile failes');
INSERT INTO `templates` VALUES (14,'member.area.error.html','Member Area Error','Session expired for member area error page');
INSERT INTO `templates` VALUES (15,'member.area.error.string.html','Member Area Error String','General Error Page');
INSERT INTO `templates` VALUES (16,'member.area.inbox.html','Member Area Inbox','The inbox file');
INSERT INTO `templates` VALUES (17,'member.area.inbox.rows.html','Member Area Inbox Rows','Member Area Inbox Rows');
INSERT INTO `templates` VALUES (18,'member.area.other.profile.html','Member area other profile','Other member profile page');
INSERT INTO `templates` VALUES (19,'member.area.profile.html','Member Area Profile','Your profile page');
INSERT INTO `templates` VALUES (20,'member.area.promo.tools.category.html','Member Area Promo Tools Category','Category for promo tools');
INSERT INTO `templates` VALUES (21,'member.area.promo.tools.html','Member Area Promo Tools','The promo tools page');
INSERT INTO `templates` VALUES (22,'member.area.promo.tools.item.html','Member Area Promo Tools Item','Item template for promo tools page.');
INSERT INTO `templates` VALUES (23,'member.area.read.message.html','Member Area Read Message','The read email message template');
INSERT INTO `templates` VALUES (24,'member.area.write.message.html','Member Area Write Message','The compose new message page.');
INSERT INTO `templates` VALUES (25,'oto1.html','Template Salespage for PRO1 - One Time Offer','One Time Offer Sales Page (1)');
INSERT INTO `templates` VALUES (26,'pay.paypal.html','Paypal Template','Paypal Template');
INSERT INTO `templates` VALUES (28,'signup.error.html','Sign Up Error Page','Sign Up Error Page');
INSERT INTO `templates` VALUES (29,'signup.html','Sign Up Page','Sign Up Page');
INSERT INTO `templates` VALUES (30,'signup.paid.html','Sign Up Template With Pay Option','Sign Up Template With Pay Option before sign up');
INSERT INTO `templates` VALUES (31,'terms.html','Terms Page','Terms Page');
INSERT INTO `templates` VALUES (32,'faq.cat.html','FAQ Category','The FAQ Category file');
INSERT INTO `templates` VALUES (33,'member.area.membership.ag.html','Membership','Membership');
INSERT INTO `templates` VALUES (64,'member.area.membership.sl.6.ag.html','Template Salespage for GOLD','');
INSERT INTO `templates` VALUES (63,'member.area.membership.dw.6.ag.html','Template Bonus for membership GOLD','');
INSERT INTO `templates` VALUES (39,'member.area.earn.money.ag.html','Earn Money','Earn Money');
INSERT INTO `templates` VALUES (40,'oto2.html','Template Salespage for PRO2 - One Time Offer','One Time Offer Upsell Sales Page (2)');
INSERT INTO `templates` VALUES (41,'main.vertical.html','The main vertical menu template','This is the main vertical menu template of the site. It will be the frame for all pages . (only if the vertical menus options is selected in menus)');
INSERT INTO `templates` VALUES (42,'member.area.earn.money.ag.html','Members Area - Earn money','The Earn money template from members area');
INSERT INTO `templates` VALUES (43,'member.area.profile.no.directory.html','Member Area - Profile -  No directory','The members area profile page - this template is used when the profile directory is disabled');
INSERT INTO `templates` VALUES (59,'member.area.membership.dw.4.ag.html','Template Bonus for membership PRO2 - One Time Offer','');
INSERT INTO `templates` VALUES (57,'member.area.membership.dw.3.ag.html','Template Bonus for membership PRO1 - One Time Offer','');
INSERT INTO `templates` VALUES (56,'member.area.membership.sl.2.ag.html','Template Salespage for PAID','');
INSERT INTO `templates` VALUES (55,'member.area.membership.dw.2.ag.html','Template Bonus for membership PAID','');
INSERT INTO `templates` VALUES (54,'member.area.membership.sl.1.ag.html','Template Salespage for FREE','');
INSERT INTO `templates` VALUES (53,'member.area.membership.dw.1.ag.html','Template Bonus for membership FREE','');
INSERT INTO `templates` VALUES (61,'member.area.membership.dw.5.ag.html','Template Bonus for membership SILVER','');
INSERT INTO `templates` VALUES (62,'member.area.membership.sl.5.ag.html','Template Salespage for SILVER','');
INSERT INTO `templates` VALUES (65,'member.area.membership.dw.7.ag.html','Template Bonus for membership PLATINUM','');
INSERT INTO `templates` VALUES (66,'member.area.membership.sl.7.ag.html','Template Salespage for PLATINUM','');
INSERT INTO `templates` VALUES (67,'member.area.membership.dw.8.ag.html','Template Bonus for membership DIAMOND','');
INSERT INTO `templates` VALUES (68,'member.area.membership.sl.8.ag.html','Template Salespage for DIAMOND','');
INSERT INTO `templates` VALUES (69,'member.area.membership.dw.9.ag.html','Template Bonus for membership ELITE','');
INSERT INTO `templates` VALUES (70,'member.area.membership.sl.9.ag.html','Template Salespage for ELITE','');
INSERT INTO `templates` VALUES (72,'oto_bck.html','One Time Offer Backup','Lower Price One Time Offer');
INSERT INTO `templates` VALUES (74,'oto2_bck.html','Template Salespage for OTO2 downsell','One Time Offer Sales Page (2)');
INSERT INTO `templates` VALUES (75,'main.not.logged.in.html','The main template no login','This is the main template of the site when member is not logged in. It will be the frame for all pages except members area.');
INSERT INTO `templates` VALUES (76,'main.vertical.not.logged.in.html','The main vertical menu template no login','This is the main vertical menu template of the site when not logged in. It will be the frame for all pages . (only if the vertical menus options is selected in menus)');
INSERT INTO `templates` VALUES (77,'logout.html','Logout','Logout Template.');
INSERT INTO `templates` VALUES (78,'clickbank.thankyou.html','Thank you page for Clickbank','Thank you page for Clickbank');
CREATE TABLE `twitter` (
  `id` int(10) NOT NULL auto_increment,
  `tweet` varchar(140) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
