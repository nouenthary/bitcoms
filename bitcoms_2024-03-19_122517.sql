CREATE TABLE `tblcointranfer` (
    `tranfercoinid` int NOT NULL AUTO_INCREMENT, `fkuserid` int DEFAULT NULL, `fkwalletid` int DEFAULT NULL, `fromwalletname` varchar(100) NOT NULL, `towalletname` varchar(100) NOT NULL, `logofromwallet` varchar(100) NOT NULL, `logotowallet` varchar(100) NOT NULL, `amount` float NOT NULL DEFAULT '0', `timeupdate` varchar(100) NOT NULL, `dateupdate` varchar(100) NOT NULL, `amount_transfer` float DEFAULT '0', `exchange_price` float DEFAULT '0', PRIMARY KEY (`tranfercoinid`)
);

CREATE TABLE `tblcompany` (
    `companyid` int NOT NULL AUTO_INCREMENT, `nameweb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL, `logo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL, PRIMARY KEY (`companyid`)
);

CREATE TABLE `tblcontactus` (
    `contactusid` int NOT NULL, `phone` varchar(100) COLLATE utf8mb3_bin NOT NULL, `address` varchar(100) COLLATE utf8mb3_bin NOT NULL, `city` varchar(100) COLLATE utf8mb3_bin NOT NULL, `coutry` varchar(100) COLLATE utf8mb3_bin NOT NULL, `Description` varchar(1000) COLLATE utf8mb3_bin NOT NULL, `email` varchar(100) COLLATE utf8mb3_bin NOT NULL, PRIMARY KEY (`contactusid`)
);

CREATE TABLE `tbldeposit` (
    `depositid` int NOT NULL AUTO_INCREMENT, `fkuserid` int NOT NULL, `fkwalletid` int NOT NULL, `namewallet` varchar(255) COLLATE utf8mb3_bin NOT NULL, `qrimage` varchar(255) COLLATE utf8mb3_bin NOT NULL, `walletaddr` varchar(255) COLLATE utf8mb3_bin NOT NULL, `amout` double DEFAULT '0', `paymentvoucher` varchar(255) COLLATE utf8mb3_bin NOT NULL, `status` varchar(255) COLLATE utf8mb3_bin NOT NULL, `timeupdate` varchar(255) COLLATE utf8mb3_bin NOT NULL, `dateupdate` varchar(255) COLLATE utf8mb3_bin NOT NULL, `userconfirmid` int DEFAULT NULL, `confirmtime` varchar(255) COLLATE utf8mb3_bin DEFAULT NULL, `confirmdate` varchar(255) COLLATE utf8mb3_bin DEFAULT NULL, PRIMARY KEY (`depositid`)
);

CREATE TABLE `tblfee` (
    `feeid` int NOT NULL AUTO_INCREMENT, `tradeffeepercent` float NOT NULL, `widtrwfeepercent` float NOT NULL, `timeupdate` varchar(100) COLLATE utf8mb3_bin NOT NULL, `dateupdate` varchar(100) COLLATE utf8mb3_bin NOT NULL, PRIMARY KEY (`feeid`)
);

CREATE TABLE `tbllogin` (
    `loginid` bigint NOT NULL AUTO_INCREMENT, `fkuserid` int NOT NULL, `Longtitude` varchar(100) NOT NULL, `Latitude` varchar(100) NOT NULL, `ISP` varchar(100) NOT NULL, `Browser` varchar(100) NOT NULL, `ip` varchar(100) NOT NULL, `timelogin` varchar(100) NOT NULL, `datelogin` varchar(100) NOT NULL, PRIMARY KEY (`loginid`)
);

CREATE TABLE `tblpermission` (
    `permissionid` int NOT NULL AUTO_INCREMENT, `fkuserid` int NOT NULL, `normal` tinyint(1) DEFAULT '0', `admin` tinyint(1) DEFAULT '0', `timeupdate` varchar(100) NOT NULL, `dateupdate` varchar(100) NOT NULL, PRIMARY KEY (`permissionid`)
);

CREATE TABLE `tblprivcy` (
    `privcyid` int NOT NULL, `desceng` varchar(1000) COLLATE utf8mb3_bin NOT NULL, `descesp` varchar(1000) COLLATE utf8mb3_bin NOT NULL, `descfre` varchar(1000) COLLATE utf8mb3_bin NOT NULL, PRIMARY KEY (`privcyid`)
);

CREATE TABLE `tbltradetitle` (
    `tradetitleid` int NOT NULL AUTO_INCREMENT, `fkuserid` int NOT NULL, `wintrade` varchar(255) COLLATE utf8mb3_bin NOT NULL, `timeupdate` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL, `dateupdate` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_bin DEFAULT NULL, PRIMARY KEY (`tradetitleid`)
);

CREATE TABLE `tbltrde` (
    `tradeid` int NOT NULL AUTO_INCREMENT, `fkuserid` int NOT NULL, `feepercent` float NOT NULL, `feeamount` float NOT NULL, `amount` float NOT NULL, `totalamount` float NOT NULL, `namecurrency` varchar(100) COLLATE utf8mb3_bin NOT NULL, `wintrade` varchar(100) COLLATE utf8mb3_bin NOT NULL, `lastprice` float NOT NULL, `logocurrency` varchar(100) COLLATE utf8mb3_bin NOT NULL, `timeupdate` varchar(100) COLLATE utf8mb3_bin NOT NULL, `dateupdate` varchar(100) COLLATE utf8mb3_bin NOT NULL, `timetrade` varchar(100) COLLATE utf8mb3_bin NOT NULL, `tradetitle` varchar(100) COLLATE utf8mb3_bin NOT NULL, `status` varchar(100) COLLATE utf8mb3_bin NOT NULL, PRIMARY KEY (`tradeid`)
);

CREATE TABLE `tblwallet` (
    `walletid` int NOT NULL AUTO_INCREMENT, `fkuserid` int NOT NULL, `fkwallettileid` int NOT NULL, `balance` float NOT NULL, `createtime` varchar(100) NOT NULL, `createdate` varchar(100) NOT NULL, `codeaddress` varchar(100) DEFAULT NULL, `codelink` varchar(100) DEFAULT NULL, PRIMARY KEY (`walletid`)
);

CREATE TABLE `tblwallettitle` (
    `walletid` int NOT NULL AUTO_INCREMENT, `namecurencywallet` varchar(100) COLLATE utf8mb3_bin NOT NULL, `namecurency` varchar(100) COLLATE utf8mb3_bin NOT NULL, `walletaddress` varchar(100) COLLATE utf8mb3_bin NOT NULL, `qrimage` varchar(100) COLLATE utf8mb3_bin NOT NULL, `imagecurency` varchar(100) COLLATE utf8mb3_bin NOT NULL, `timeupdate` varchar(100) COLLATE utf8mb3_bin NOT NULL, `dateupdate` varchar(100) COLLATE utf8mb3_bin NOT NULL, PRIMARY KEY (`walletid`)
);

CREATE TABLE `tblwidtraw` (
    `withdrawid` int NOT NULL AUTO_INCREMENT, `fkuserid` int NOT NULL, `fkwalletid` int DEFAULT NULL, `balance` float NOT NULL, `fee` float NOT NULL, `totalamount` float NOT NULL, `codeaddress` varchar(100) DEFAULT NULL, `codelink` varchar(100) DEFAULT NULL, `status` varchar(100) DEFAULT NULL, `createtime` varchar(100) DEFAULT NULL, `createdate` varchar(100) DEFAULT NULL, `confirmuserid` int DEFAULT NULL, `confirmtime` varchar(100) DEFAULT NULL, `confirmdate` varchar(100) DEFAULT NULL, `feeamount` float NOT NULL, PRIMARY KEY (`withdrawid`)
);

CREATE TABLE `users` (
    `id` bigint NOT NULL AUTO_INCREMENT, `name` varchar(100) NOT NULL, `accnumber` int DEFAULT NULL, `image` varchar(200) DEFAULT NULL, `sex` varchar(10) DEFAULT NULL, `address` varchar(100) DEFAULT NULL, `city` varchar(100) DEFAULT NULL, `country` varchar(100) DEFAULT NULL, `verificode` int DEFAULT NULL, `email` varchar(100) NOT NULL, `password` varchar(100) NOT NULL, `status` varchar(50) DEFAULT NULL, `remember_token` varchar(100) DEFAULT NULL, `phone` varchar(255) DEFAULT NULL, `invitationcode` varchar(50) DEFAULT NULL, `invitationlink` varchar(100) DEFAULT NULL, `referrercode` varchar(50) DEFAULT NULL, `idcard` int DEFAULT NULL, `idname` varchar(100) DEFAULT NULL, `frontimage` varchar(100) DEFAULT NULL, `backimage` varchar(100) DEFAULT NULL, `dob` varchar(100) DEFAULT NULL, `Longtitude` varchar(100) DEFAULT NULL, `Latitude` varchar(100) DEFAULT NULL, `browser` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL, `isp` varchar(100) DEFAULT NULL, `ip` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL, `timeupdate` varchar(100) DEFAULT NULL, `dateupdate` varchar(100) DEFAULT NULL, `uderconfirmid` int DEFAULT NULL, `confirmtime` varchar(100) DEFAULT NULL, `confirmdate` varchar(100) DEFAULT NULL, `created_at` timestamp NULL DEFAULT NULL, `updated_at` timestamp NULL DEFAULT NULL, `email_verified_at` timestamp NULL DEFAULT NULL, `userlogin` tinyint(1) DEFAULT NULL, `codeaddress` varchar(100) DEFAULT NULL, `codelink` varchar(100) DEFAULT NULL, `walletamount` double DEFAULT '0', PRIMARY KEY (`id`)
);