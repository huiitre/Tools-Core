CREATE DATABASE IF NOT EXISTS tools_dofus;

PROMPT "14/06/2023 : Création des tables dans tools_dofus pour l'intégration des objets et des ressources"
CREATE TABLE `tools_dofus`.`item_type` (
  `iditem_type` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64),
  PRIMARY KEY (`iditem_type`),
  UNIQUE (`iditem_type`)
);
alter table tools_dofus.item_type 
add column code varchar(255) not null;

CREATE TABLE `tools_dofus`.`resource_type` (
  `idresource_type` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(64),
  PRIMARY KEY (`idresource_type`),
  UNIQUE (`idresource_type`)
);
alter table tools_dofus.resource_type 
add column code varchar(255) not null;

CREATE TABLE `tools_dofus`.`item` (
  iditem INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(64) NOT NULL,
  img VARCHAR(256) NOT NULL,
  level INT NOT NULL,
  iditem_type INT NOT NULL,
  qty_bank INT DEFAULT 0,
  PRIMARY KEY (iditem),
  UNIQUE (iditem),
  FOREIGN KEY (iditem_type) REFERENCES item_type(iditem_type)
);
ALTER TABLE `tools_dofus`.`item`
ADD CONSTRAINT fk_item_type
FOREIGN KEY (iditem_type) REFERENCES item_type(iditem_type);
alter table tools_dofus.item 
add column code varchar(255) not null;

CREATE TABLE `tools_dofus`.`resource` (
  idresource INT NOT NULL AUTO_INCREMENT,
  name VARCHAR(64) NOT NULL,
  img VARCHAR(256) NOT NULL,
  idresource_type INT NOT NULL,
  qty_bank INT DEFAULT 0,
  PRIMARY KEY (idresource),
  UNIQUE (idresource),
  FOREIGN KEY (idresource_type) REFERENCES resource_type(idresource_type)
);
ALTER TABLE `tools_dofus`.`resource`
ADD CONSTRAINT fk_resource_type
FOREIGN KEY (idresource_type) REFERENCES resource_type(idresource_type);
alter table `tools_dofus`.`resource` 
add column code varchar(255) not null;

create table `tools_dofus`.`recipe`(
	`idrecipe` int not null,
	`idparent` int not null,
	`idenfant` int not null,
	`quantity` int default null,
	primary key (idrecipe),
	unique (idrecipe)
);
