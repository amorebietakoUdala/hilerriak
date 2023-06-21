/*
-- Query: SELECT * FROM hilerriak.cemetery
LIMIT 0, 1000

-- Date: 2023-04-21 07:51
*/
INSERT INTO `cemetery` (`id`,`name`) VALUES (1,'Etxano');
INSERT INTO `cemetery` (`id`,`name`) VALUES (2,'Leginetxe');

/*
-- Query: SELECT * FROM hilerriak.grave_type
LIMIT 0, 1000

-- Date: 2023-04-21 07:53
*/
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (1,'Nicho','Nitxo');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (2,'Nicho de restos','Gorpuzkien hilobia');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (3,'Panteon','Panteoia');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (4,'Columbario','Kolunbarioa');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (5,'Fosa','Hobia');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (6,'Sepultura','Ehorzleku');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (7,'Tumba','Hilobia');

/*
-- Query: SELECT * FROM hilerriak.movement_type
LIMIT 0, 5000

-- Date: 2023-04-27 14:14
*/
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (1,'Depósito de cenizas y restos','Errautsak zein giza hondarrak gorde');
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (2,'Inhumación','Hobiratzea');
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (3,'Exhumación','Desobiratzea');
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (4,'Traslado','Lekualdaketa');


/*
-- Query: SELECT * FROM hilerriak.destination_type
LIMIT 0, 5000

-- Date: 2023-04-27 14:14
*/
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (1,'Lugar','Tokia');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (2,'Caja de restos','Hondar kutxa');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (3,'Sudario','Hil-oihal');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (4,'Incinerar','Erraustu');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (5,'Fosa común','Hobi komuna');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (6,'Otros','Besteren bat');