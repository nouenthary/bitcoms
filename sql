truncate table tblcointranfer;
truncate table tblcontactus;
truncate table tbldeposit;
truncate table tbllogin;
truncate table tblpermission;
truncate table tbltradetitle;
truncate table tbltrde;
truncate table tblwallet;
truncate table tblwallettitle;
truncate table tblwidtraw;
truncate table users;


ALTER TABLE users
	ADD COLUMN language VARCHAR(255) NULL;


ALTER TABLE tblfee
    ADD COLUMN deposit_fee_percent FLOAT DEFAULT 0,
    ADD COLUMN profit_fee_percentage FLOAT DEFAULT 0;

ALTER TABLE tbldeposit
	ADD COLUMN percent_fee FLOAT DEFAULT 0,
	ADD COLUMN total_fee FLOAT DEFAULT 0;
