CREATE TABLE `usuario` (
  `usuario_id` int auto_increment,
  `password` varchar(255) not null,
  `status` varchar(1) not null,
  PRIMARY KEY (`usuario_id`)
);

CREATE TABLE `rol` (
  `rol_id` int auto_increment,
  `nombre_rol` varchar(255) not null,
  `rol_desc` varchar(500) not null,
  PRIMARY KEY (`rol_id`)
);

CREATE TABLE `usuario_rol` (
  `usuario_id` int not null,
  `rol_id` int not null,
  PRIMARY KEY (`usuario_id`, `rol_id`),
  FOREIGN KEY (`rol_id`) REFERENCES `rol`(`nombre_rol`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`usuario_id`)
);

CREATE TABLE `jugadores` (
  `jugador_id` int auto_increment,
  `usuario_id` int not null,
  `jugador_nombre` varchar(255) not null,
  `jugador_sexo` varchar(1) not null,
  PRIMARY KEY (`jugador_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`usuario_id`)
);

CREATE TABLE `nivel` (
  `nivel_id` int auto_increment,
  `nivel_nombre` varchar(255) not null,
  `nivel_desc` varchar(255) not null,
  `adicional` varchar(255)  null,
  PRIMARY KEY (`nivel_id`)
);

CREATE TABLE `desafio` (
  `desafio_id` int auto_increment,
  `nivel_id` int not null,
  `usuario_id` int not null,
  `desafio_desc` varchar(255) not null,
  `tiempo_segundos` int null,
  `status` varchar(1) not null,
  PRIMARY KEY (`desafio_id`),
  FOREIGN KEY (`nivel_id`) REFERENCES `nivel`(`nivel_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES `usuario`(`usuario_id`)
);

CREATE TABLE `desafio_nivel` (
  `desafio_nivel_id` int auto_increment,
  `numero_desafios` int not null,
  `nivel_id` int not null,
  PRIMARY KEY (`desafio_nivel_id`),
  FOREIGN KEY (`nivel_id`) REFERENCES `nivel`(`nivel_id`)
);

