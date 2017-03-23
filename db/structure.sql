DROP TABLE IF EXISTS candidate;
DROP TABLE IF EXISTS offer;
DROP TABLE IF EXISTS company;
DROP TABLE IF EXISTS person;



CREATE TABLE person (
    id_person       INTEGER NOT NULL PRIMARY KEY auto_increment,
    type_person     VARCHAR(25) NOT NULL, -- Possible values: etudiant, ancien_non_ad, ancien_ad, admin, pro
    mail_person     VARCHAR(100) NOT NULL,
	name_person     VARCHAR(50) NOT NULL,
	surname_person  VARCHAR(50) NOT NULL,
	password_person VARCHAR(50) NOT NULL
) engine=innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE company (
    id_company      INTEGER NOT NULL PRIMARY KEY auto_increment,
    name_company    VARCHAR(50) NOT NULL,
    mail_company    VARCHAR(100) NOT NULL,
	address_company VARCHAR(250) NOT NULL
) engine=innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE offer (
	id_offer            INTEGER NOT NULL PRIMARY KEY auto_increment,
	type_offer          VARCHAR(20) NOT NULL, -- Possible values: CDI, CDD, stage
	title_offer         VARCHAR(150) NOT NULL,
	desc_short          VARCHAR(500) NOT NULL,
	desc_long           VARCHAR(2000) NOT NULL,
	remuneration        FLOAT NOT NULL,
	duration_offer      INTEGER,  -- Can be unlimited duration
	sector              VARCHAR(100) NOT NULL,
	country             VARCHAR(100) NOT NULL,
	region              VARCHAR(100), -- Depending on the country, not always a region to specify
	city                VARCHAR(100) NOT NULL,
	posting_date        DATE NOT NULL,
	attached_file_name  VARCHAR(250),
	nb_candidacy        INTEGER NOT NULL,
	limit_date			DATE NOT NULL,
	validation          BOOLEAN NOT NULL,
	password            VARCHAR(20) NOT NULL, -- random generation at insertion	
	id_company          INTEGER NOT NULL,
	FOREIGN KEY (id_company) REFERENCES company (id_company)
) engine=innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;


CREATE TABLE candidate (
    id_offer        INTEGER NOT NULL,
    id_person       INTEGER NOT NULL,
    date_candidacy  DATE NOT NULL,
	PRIMARY KEY (id_offer, id_person),
	FOREIGN KEY (id_offer) REFERENCES offer (id_offer),
	FOREIGN KEY (id_person) REFERENCES person (id_person)
) engine=innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;








