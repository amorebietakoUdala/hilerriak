-- ----------------------------------------------------------
-- MDB Tools - A library for reading MS Access database files
-- Copyright (C) 2000-2011 Brian Bruns and others.
-- Files in libmdb are licensed under LGPL and the utilities under
-- the GPL, see COPYING.LIB and COPYING files respectively.
-- Check out http://mdbtools.sourceforge.net
-- ----------------------------------------------------------

DROP TABLE IF EXISTS `Adjudicación1`;
DROP TABLE IF EXISTS `Titular1`;
DROP TABLE IF EXISTS `Sepultura1`;
DROP TABLE IF EXISTS `Registro1`;

DROP TABLE IF EXISTS `Adjudicación2`;
DROP TABLE IF EXISTS `Titular2`;
DROP TABLE IF EXISTS `Sepultura2`;
DROP TABLE IF EXISTS `Registro2`;


-- ----------------------------------------------------------
-- ETXANO
-- ----------------------------------------------------------

-- That file uses encoding UTF-8

CREATE TABLE IF NOT EXISTS `Adjudicación1`
 (
	`Fecha_Registro`			datetime, 
	`Año_Alta`			varchar (4), 
	`Titular`			varchar (65), 
	`Titular_02`			varchar (65), 
	`Localizacion`			varchar (65), 
	`Descripcion`			varchar (65), 
	`Fecha_Caduc`			varchar (4), 
	`Renovado`			boolean NOT NULL, 
	`Prescito`			boolean NOT NULL, 
	`Cambio_titular`			boolean NOT NULL, 
	`N_Expediente`			varchar (50), 
	`Registro`			double, 
	`Id`			int
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Adjudicación1` ADD INDEX `ADJUDICACION_NICHOTitular_Adjudicacion` (`Titular`);
ALTER TABLE `Adjudicación1` ADD INDEX `AdjudicaciónLocalizacion_adjudicacion` (`Localizacion`);
ALTER TABLE `Adjudicación1` ADD INDEX `ArchivoRegistro` (`Registro`);
-- ALTER TABLE `Adjudicación1` ADD INDEX `Id` (`Id_adjudicacion`);
-- ALTER TABLE `Adjudicación1` ADD PRIMARY KEY (`Id`);

CREATE TABLE IF NOT EXISTS `Sepultura1`
 (
	`Descripcion`			text, 
	`Vigencia`			varchar (10), 
	`Anno`			varchar (4), 
	`Registro`			double, 
	`Localizacion`			varchar (65), 
	`Libre`			boolean NOT NULL, 
	`Id`			int not null auto_increment unique, 
	`Cementerio`			varchar (50), 
	`Tipo`			varchar (50)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Sepultura1` ADD INDEX `ArchivoRegistro` (`Registro`);
-- ALTER TABLE `Sepultura1` ADD INDEX `Id` (`Id_sepultura`);
ALTER TABLE `Sepultura1` ADD PRIMARY KEY (`Localizacion`);

CREATE TABLE IF NOT EXISTS `Titular1`
 (
	`N_Expediente`			varchar (50), 
	`Año_Alta`			varchar (4), 
	`Registro`			double, 
	`Titular`			varchar (65), 
	`DNI`			varchar (12), 
	`Telefono`			int, 
	`Id`			int not null auto_increment unique
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Titular1` ADD INDEX `ADJUDICACION_NICHOTitular` (`Titular`);
ALTER TABLE `Titular1` ADD INDEX `ArchivoRegistro` (`Registro`);
-- ALTER TABLE `Titular1` ADD INDEX `Id` (`Id_titular`);
ALTER TABLE `Titular1` ADD PRIMARY KEY (`Titular`);

CREATE TABLE IF NOT EXISTS `Registro1`
 (
	`Id`			int not null auto_increment unique, 
	`Nº_Registro`			int, 
	`Año`			varchar (4), 
	`Tipo_Acción`			varchar (50), 
	`Sepultura_destino`			varchar (50), 
	`Fecha_Registro`			datetime, 
	`Difunto`			varchar (50), 
	`Descripción`			varchar (150), 
	`Origen restos`			varchar (50), 
	`N_Expediente`			varchar (50), 
	`Incidencias`			varchar (75)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Registro1` ADD PRIMARY KEY (`Id`);

-- ----------------------------------------------------------
-- LEGINETXE
-- ----------------------------------------------------------

-- That file uses encoding UTF-8

CREATE TABLE IF NOT EXISTS `Adjudicación2`
 (
	`Fecha_Registro`			datetime, 
	`Año_Alta`			varchar (4), 
	`Titular`			varchar (65), 
	`Titular_02`			varchar (65), 
	`Localizacion`			varchar (65), 
	`Descripcion`			varchar (65), 
	`Fecha_Caduc`			varchar (4), 
	`Renovado`			boolean NOT NULL, 
	`Prescito`			boolean NOT NULL, 
	`Cambio_titular`			boolean NOT NULL, 
	`N_Expediente`			varchar (50), 
	`Registro`			double, 
	`Id`			int
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Adjudicación2` ADD INDEX `ADJUDICACION_NICHOTitular_Adjudicacion2` (`Titular`);
ALTER TABLE `Adjudicación2` ADD INDEX `AdjudicaciónLocalizacion_adjudicacion2` (`Localizacion`);
ALTER TABLE `Adjudicación2` ADD INDEX `ArchivoRegistro2` (`Registro`);
-- ALTER TABLE `Adjudicación1` ADD INDEX `Id` (`Id_adjudicacion`);
-- ALTER TABLE `Adjudicación2` ADD PRIMARY KEY (`Id`);

CREATE TABLE IF NOT EXISTS `Sepultura2`
 (
	`Descripcion`			text, 
	`Vigencia`			varchar (10), 
	`Anno`			varchar (4), 
	`Registro`			double, 
	`Localizacion`			varchar (65), 
	`Libre`			boolean NOT NULL, 
	`Id`			int not null auto_increment unique, 
	`Cementerio`			varchar (50), 
	`Tipo`			varchar (50)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Sepultura2` ADD INDEX `ArchivoRegistro2` (`Registro`);
-- ALTER TABLE `Sepultura1` ADD INDEX `Id` (`Id_sepultura`);
ALTER TABLE `Sepultura2` ADD PRIMARY KEY (`Localizacion`);

CREATE TABLE IF NOT EXISTS `Titular2`
 (
	`N_Expediente`			varchar (50), 
	`Año_Alta`			varchar (4), 
	`Registro`			double, 
	`Titular`			varchar (65), 
	`DNI`			varchar (12), 
	`Telefono`			int, 
	`Id`			int not null auto_increment unique
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Titular2` ADD INDEX `ADJUDICACION_NICHOTitular2` (`Titular`);
ALTER TABLE `Titular2` ADD INDEX `ArchivoRegistro2` (`Registro`);
-- ALTER TABLE `Titular` ADD INDEX `Id` (`Id_titular`);
ALTER TABLE `Titular2` ADD PRIMARY KEY (`Titular`);

CREATE TABLE IF NOT EXISTS `Registro2`
 (
	`Id`			int not null auto_increment unique, 
	`Nº_Registro`			int, 
	`Año`			varchar (4), 
	`Tipo_Acción`			varchar (50), 
	`Sepultura_destino`			varchar (50), 
	`Fecha_Registro`			datetime, 
	`Difunto`			varchar (50), 
	`Descripción`			varchar (150), 
	`Origen restos`			varchar (50), 
	`N_Expediente`			varchar (50), 
	`Incidencias`			varchar (75)
) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_spanish2_ci`;

-- CREATE INDEXES ...
ALTER TABLE `Registro2` ADD PRIMARY KEY (`Id`);