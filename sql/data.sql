-- -----------------------------------------
-- This file is a part of the GotCm project.
-- author: Calmacil
-- version: 1.0
-- -----------------------------------------

-- This data is essential and the app cannot function correctly without.

-- Table `crown`
INSERT INTO `crown`
  (`name`, `small_name`, `base_color`, `defense_bonus`, `influence_bonus`, `law_bonus`, `population_bonus`,
   `power_bonus`, `wealth_bonus`, `land_bonus`)
VALUES
  ('Port-Réal', 'real', '#999999', 5, -5, 20, 5, -5, -5, -5),
  ('Peyredragon', 'peyre', '#555555', 20, -5, 5, 0, 0, -5, -5),
  ('Le Nord', 'nord', '#ddddff', 5, 10, -10, -5, -5, -5, 20),
  ('Les îles de Fer', 'idf', '#dddd33', 10, -5, 0, 0, 10, 0, -5),
  ('Le Conflans', 'conflans', '#dd7700', -5, -5, 0, 10, 0, 5, 5),
  ('Les montagnes de la Lune', 'val', '#77dd00', 20, 10, -10, -5, 0, 0, -5),
  ('Les terres de l’Ouest', 'ouest', '#dd0000', -5, 10, -5, -5, 0, 20, -5),
  ('Le Bief', 'bief', '#33dd33', -5, 10, -5, 5, 0, 5, 0),
  ('Les terres de l’Orage', 'orage', '#dddd00', 5, 0, 10, -5, 5, 0, -5),
  ('Dorne', 'dorne', '#ddffdd', 0, -5, -5, 0, 10, 10, 0);

-- Table `defense_asset`
INSERT INTO `defense_asset`
  (`name`, `cost`, `min_ttb`, `max_ttb`, `units_capacity`, `units_defense`, `description`)
VALUES
  ('Château amélioré', 50, 154, 204, 10, 12, 'Dispose de plusieurs tours, édifices et bâtiments annexes, tous entourés d’une enceinte, et probablement de douves.'),
  ('Château', 40, 106, 156, 5, 8, 'Des forteresses impressionnantes. La plupart comprennent au moins un donjon central et plusieurs tours reliées par des murs et entourées de douves.'),
  ('Petit château', 30, 82, 132, 3, 6, 'Version modeste d’un château ordinaire. Il ne comporte généralement pas plus d’un seul donjon, et quelque chose comme deux tours et un mur.'),
  ('Demeure fortifiée', 20, 70, 120, 2, 4, 'Une demeure (ou donjon) est généralement un petit bâtiment fortifié. Il peut être ou non entouré d’une enceinte, et peut disposer d’une tour, mais c’est relativement rare.'),
  ('Tour', 10, 46, 86, 1, 3, 'Les tours tours sont des bâtiments en pierres brutes ou en bois qui s’ĺèvent au-dessus du sol. Quand elles sont pourvues ded épendances, celles-ci sont modestes et non protégées.');

-- Table `wealth_asset`
INSERT INTO `wealth_asset`
  (`name`, `cost`, `min_ttb`, `max_ttb`, `intendance_bonus`, `description`)
VALUES
  ('Artisan', 10, 2, 12, 0, 'Choisir une option: Armes en acier château, +1 en défense de fortifications, +1 en intendance.'),
  ('Bois sacré', 5, 26, 36, 0, '+2d6 - 6 en Intendance'),
  ('Guilde', 15, 2, 12, 0, 'Les membres de la maison bénéficient d’une remise de 10% sur les produits achetés sur leurs terres.'),
  ('Marché', 10, 1, 6, 0, 'Quand un événement d’intendance augmente votre valeur de Richesse, le marché l’augmente encore de 1.'),
  ('Mestre', 10, 1, 6, 3, 'Bonus de +3 aux tests d’intendance. De plus, votre famille s’attache les services d’un mestre.'),
  ('Mine', 10, 26, 36, 5, ''),
  ('Port', 10, 3, 18, 5, 'Bonus de +5 aux tests d’intendance. De plus, si vous avez aussi un marché, son bonus passe de +1 à +1d6.'),
  ('Septuaire', 15, 14, 24, 3, 'Bonus de +3 aux tests d’intendance. De plus, votre famille s’attache les services d’un septon ou d’une septa.'),
  ('Vignoble', 10, 26, 36, 5, '');

-- Table `land_asset`
INSERT INTO `land_asset`
  (`name`, `cost`, `type`)
VALUES
  ('Colline', 7, 'Terrain'),
  ('Marécages', 3, 'Terrain'),
  ('Montagnes', 9, 'Terrain'),
  ('Plaine', 5, 'Terrain'),
  ('Bois clairsemés', 3, 'Bois'),
  ('Bois denses', 5, 'Bois'),
  ('Ruisseau', 1, 'Cours d’eau'),
  ('Rivière/Fleuve', 3, 'Cours d’eau'),
  ('Étang', 5, 'Cours d’eau'),
  ('Lac', 7, 'Cours d’eau'),
  ('Île', 10, 'Autre'),
  ('Littoral', 3, 'Autre'),
  ('Hameau', 10, 'Localité'),
  ('Petite ville', 20, 'Localité'),
  ('Ville', 30, 'Localité'),
  ('Grande ville', 40, 'Localité'),
  ('Ville immense', 50, 'Localité'),
  ('Prairie', 1, 'Autre'),
  ('Route', 5, 'Autre'),
  ('Ruine', 3, 'Autre');

-- Table `skill`
INSERT INTO `skill` (`name`) VALUES
  ('Agilité'),
  ('Art Militaire'),
  ('Athlétisme'),
  ('Connaissance'),
  ('Corps à corps'),
  ('Discrétion'),
  ('Dressage'),
  ('Duperie'),
  ('Endurance'),
  ('Ingéniosité'),
  ('Langue'),
  ('Larcin'),
  ('Persuasion'),
  ('Soins'),
  ('Statut'),
  ('Survie'),
  ('Tir'),
  ('Vigilance'),
  ('Volonté');

-- Table `speciality`
INSERT INTO `speciality` (`skill_id`, `name`) VALUES
  (1, 'Acrobaties'), (1, 'Équilibre'), (1, 'Contorsions'), (1, 'Esquive'), (1, 'Vivacité'),
  (2, 'Commandement'), (2, 'Stratégie'), (2, 'Tactique'),
  (3, 'Escalade'), (3, 'Saut'), (3, 'Course'), (3, 'Force'), (3, 'Natation'), (3, 'Jet'),
  (4, 'Éducation'), (4, 'Recherches'), (4, 'Connaissance de la rue'),
  (5, 'Haches'), (5, 'Casse-tête'), (5, 'Rixe'), (5, 'Escrime'), (5, 'Lames longues'), (5, 'Armes d’Hast'), (5, 'Lames courtes'), (5, 'Lances'), (5, 'Boucliers'),
  (6, 'Caméléon'), (6, 'Furtivité'),
  (7, 'Charme'), (7, 'Conduite'), (7, 'Équitation'), (7, 'Exercices'),
  (8, 'Comédie'), (8, 'Bluff'), (8, 'Triche'), (8, 'Déguisement'),
  (9, 'Résilience'), (9, 'Vigueur'),
  (10, 'Décryptage'), (10, 'Logique'), (10, 'Mémoire'),
  (12, 'Crochetage'), (12, 'Passe-passe'), (12, 'Vol'),
  (13, 'Marchander'), (13, 'Charmer'), (13, 'Convaincre'), (13, 'Inciter'), (13, 'Intimider'), (13, 'Séduire'), (13, 'Persifler'),
  (14, 'Diagnostic'), (14, 'Infections'), (14, 'Blessures'),
  (15, 'Bienséance'), (15, 'Réputation'), (15, 'Intendance'), (15, 'Tournois'),
  (16, 'Fourrageur'), (16, 'Chasse'), (16, 'Chasse'), (16, 'Orientation'),
  (17, 'Arcs'), (17, 'Arbalètes'), (17, 'Siège'), (17, 'Jet'),
  (18, 'Empathie'), (18, 'Observation'),
  (19, 'Courage'), (19, 'Coordination'), (19, 'Dévouement');

-- Table `unit_type`
INSERT INTO `unit_type`
(`name`, `cost_mod`, `population_cost`,`wealth_cost`, `discipline_mod`, `skill_1`, `skill_2`, `skill_3`, `armor`,
 `armor_malus`, `encumbrance`, `melee_damage_skill`, `melee_damage_mod`, `dist_damage_skill`, `dist_damage_mod`,
 `dist_range`, `armor_upg`, `armor_malus_upg`, `encumbrance_upg`, `melee_damage_mod_upg`, `dist_damage_mod_upg`)
VALUES
  ('Archers', 3, 0, 0, 3, 1, 17, 18, 2, -1, 0, 3, -1, 1, 2, 'longue portée', 3, -2, 0, 0, 3),
  ('Cavalerie', 5, 0, 0, -3, 1, 5, 7, 5, -3, 2, 7, 3, NULL, 0, NULL, 9, -5, 3, 5, NULL ),
  ('Criminels', 1, 0, 0, 6, 5, 6, 9, 1, 0, 0, 3, -1, 3, -1, 'courte portée', 2, -1, 0, 0, 0),
  ('Croisés', 4, 0, 0, 0, 3, 5, 9, 3, -2, 0, 3, 1, NULL, 0, NULL, 4, -2, 1, 2, NULL),
  ('Éclaireurs', 2, 0, 0, 3, 9, 6, 18, 2, -1, 0, 3, 0, 1, 0, 'longue portée', 3, -2, 0, 1, 1),
  ('Garde personnelle', 6, 0, 0, -6, 3, 5, 9, 6, -3, 2, 3, 1, NULL, 0, NULL, 10, -6, 3, 2, NULL),
  ('Garnison', 2, 0, 0, 0, 5, 9, 18, 3, -2, 0, 3, 1, NULL, 0, NULL, 5, -3, 2, 2, NULL),
  ('Guérilleros', 2, 0, 0, 3, 3, 6, 17, 1, 0, 0, 3, 0, 1, 1, 'courte portée', 3, -2, 0, 1, 2),
  ('Infanterie', 4, 0, 0, 0, 3, 5, 9, 3, -2, 0, 3, 1, NULL, 0, NULL, 4, -2, 1, 2, NULL),
  ('Ingénieurs', 2, 0, 0, 3, 2, 5, 9, 2, -1, 0, 3, -1, NULL, 0, NULL, 5, -3, 2, 0, NULL),
  ('Marins', 4, 0, 0, 0, 1, 5, 18, 0, 0, 0, 3, 1, NULL, 0, NULL, 2, -1, 0, 2, NULL),
  ('Mercenaires', 1, 0, 4, 3, 3, 5, 9, 4, -2, 1, 3, 1, NULL, 0, NULL, 5, -3, 2, 3, NULL),
  ('Navires de guerre', 7, 0, 0, 0, 5, 17, 18, 5, 0, 0, 3, 1, 1, 1, 'longue portée', 10, 0, 0, 4, 3),
  ('Paysans conscrits', 0, 2, 0, 6, 7, 16, 18, 0, 0, 0, 3, -1, 3, -1, 'courte portée', 2, -1, 0, 0, 0),
  ('Pillards', 3, 0, 0, 3, 1, 5, 9, 2, -1, 0, 3, 1, NULL, 0, NULL, 5, -2, 2, 2, NULL),
  ('Soutien', 2, 0, 0, 3, 7, 9, 14, 0, 0, 0, 3, -1, NULL, 0, NULL, 2, -1, 0, 0, NULL),
  ('Spéciale', 4, 0, 0, 0, 0, 0, 0, 2, -1, 0, 3, 0, 1, 0, NULL, 6, -3, 2, 1, 1);