#
# Table structure for table 'tx_mhhttpbl_blocklog'
#
CREATE TABLE tx_mhhttpbl_blocklog (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	block_ip varchar(15) DEFAULT '' NOT NULL,
	block_type tinyint(3) DEFAULT '0' NOT NULL,
	block_score tinyint(3) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);



#
# Table structure for table 'tx_mhhttpbl_whitelist'
#
CREATE TABLE tx_mhhttpbl_whitelist (
	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	whitelist_ip varchar(15) DEFAULT '' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY parent (pid)
);