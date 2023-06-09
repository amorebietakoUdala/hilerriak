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
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (2,'Nicho de restos','Hondar-nitxoa');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (3,'Panteon','Panteoia');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (4,'Columbario','Kolumbarioa');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (5,'Fosa','Hobia');
INSERT INTO `grave_type` (`id`,`description_es`,`description_eu`) VALUES (6,'Losa','Lauza');

/*
-- Query: SELECT * FROM hilerriak.movement_type
LIMIT 0, 5000

-- Date: 2023-04-27 14:14
*/
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (1,'Depósito de cenizas','Errautsak gorde');
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (2,'Inhumación','Hobiratzea');
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (3,'Exhumación','Desobiratzea');
INSERT INTO `movement_type` (`id`,`description_es`,`description_eu`) VALUES (4,'Traslado','Lekualdaketa');


/*
-- Query: SELECT * FROM hilerriak.destination_type
LIMIT 0, 5000

-- Date: 2023-04-27 14:14
*/
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (1,'Sepultura','Hilobia');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (2,'Caja de zinc','Zink kutxa');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (3,'Bolsa','Poltsa');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (4,'Incinerar','Erraustu');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (5,'Fosa común','Hobi komuna');
INSERT INTO `destination_type` (`id`,`description_es`,`description_eu`) VALUES (6,'Otros','Besteren bat');