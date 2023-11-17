use JobBoard;

delete from peoples_advertissements;
delete from advertisements;
delete from companies;
delete from peoples;

 -- *************** companies ******************
INSERT INTO companies(`id`, `name`,`description`) VALUES
(1, 'Apple','Je suis une entreprise leader'),
(2, 'Microsoft','Je fais partie des gafam'),
(3, 'Dipole','Conception et intégration de logiciels LIMS pour les laboratoires d Analyse'),
(4, 'ADDE','ADDE conceptualise, fabrique et installe des équipements audiovisuels destinés aux multiplexes, salles de cinéma, collectivités locales et aux professionnels du secteur.');

 -- *************** advertisements ******************
INSERT INTO advertisements(`id`, `name`, `message`, `date_debut`, `salaire`, `type_de_poste`, `ville`, `id_companie`) VALUES
(1, 'Recherche alternant', "A la recherche d'alternance pour faire des iphones","2024-01-02 12:00:00", 2000.00, 'developpeur', 'lyon', 1),
(2, 'Recherche alternant', "On a besoin de quelqu'un pour faire les prochaines maj minecraft", "2023-12-25 12:00:00", 2000.01, 'developpeur', 'paris', 2),
(3, 'Recherche D employé', "Help me pleeeaaase", NOW(), 4242.42, 'developpeur', '2042-12-24 12:42:24', 4);

INSERT INTO peoples (`id`, `mail`, `name`, `password` ,`token`, `admin` ) VALUES 
(1, 'admin@gmail.com', 'admin', '$2y$10$nQds18knQ9cHDvqOYwM86uOU1r9QCGAQpBiyEWxefu0Oq2DMbi.Ue', 'eff6f50fce226af5bdeca3507909f267577b963079da506066c9d112f47c66ce8b668977acbfd25300ffec4337d14d07cfb1a15dd444814f64c6964540ec0614', TRUE ),
(2, 'fethi@gmail.com', 'fethi', '$2y$10$318XEah68bsP8e8U/zST8u9SM/M6hQX94qMZwZVBTZ7b7ChyUXaoK', '43b8ef327595ef27bfc9c51ac32e537f524df9c38ebfcdef1b4ad82dbcd7e81d9c64843e3c3617e6c859bce4b5302ccac436445ac1183be3e42fcac4bf626c5b', FALSE ),
(3, 'alexis@gmail.com', 'angelo', '$2y$10$PMVZRZeLYE3IGd7siAAKHueDXtMOY2twt7yG8iH9ZP7NTqBBKXqSK', 'af42bc646bfeb31ee22e9635065d8aa077568210ebf48d5da9f5d4e955e7a325ad6f7d7f20c7555fd608a0902aeaf0cdd06a3397dff3d7e599cf8292b1068db2', FALSE );

INSERT INTO peoples_advertissements ( `id_people`, `id_advertissements`) VALUES 
(2, 1),
(2, 2),
(3, 1),
(3, 3);