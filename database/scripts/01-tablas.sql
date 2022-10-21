CREATE TABLE `anuncios` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `areas` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(250) NOT NULL,
  `imagen` varchar(250) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `asesorias` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `materia_id` bigint(20) NOT NULL,
  `maestro_id` bigint(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `ubicacion` varchar(255) NOT NULL,
  `hora_inicio` datetime NOT NULL,
  `hora_fin` datetime NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `colonias` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `municipio_id` bigint(20) NOT NULL,
  `CP` varchar(5) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `contenidos` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `subtema_id` bigint(20) NOT NULL,
  `material` text NOT NULL,
  `material_didactico` varchar(255) NOT NULL,
  `didactics_id` bigint(20) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `empresas` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `colonia_id` bigint(20) NOT NULL,
  `calle` varchar(255) DEFAULT NULL,
  `num_ext` varchar(255) DEFAULT NULL,
  `num_int` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `razon_social` varchar(255) DEFAULT NULL,
  `rfc` varchar(255) DEFAULT NULL,
  `imagen` varchar(255) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `estados` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `examenes` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `unidad_id` bigint(20) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `materias` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `area_id` bigint(20) DEFAULT NULL,
  `maestro_id` bigint(20) NOT NULL,
  `clave` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `materia_usuarios` (
  `materia_id` bigint(20) NOT NULL,
  `alumno_id` bigint(20) NOT NULL,
  `estatus` boolean NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `municipios` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `estado_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `subtemas` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `tema_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `temas` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `unidad_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `unidades` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `materia_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `users` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `colonia_id` bigint(20) NOT NULL,
  `name` varchar(250) NOT NULL,
  `sexo` tinyint(1) DEFAULT NULL,
  `num_telefono` varchar(250) DEFAULT NULL,
  `num_telefono2` varchar(250) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text,
  `two_factor_recovery_codes` text,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `vacantes` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `empresa_id` bigint(20) NOT NULL,
  `name` varchar(255) NOT NULL,
  `contenido` text NOT NULL,
  `imagen` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `failed_jobs` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `model_has_roles` (
  `role_id` bigint NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `permissions` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `roles` (
  `id` bigint(20) PRIMARY KEY NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint NOT NULL,
  `role_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `sessions` (
  `id` bigint(20) PRIMARY KEY,
  `user_id` bigint DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` text NOT NULL,
  `last_activity` int NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

ALTER TABLE `anuncios` ADD FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`);

ALTER TABLE `colonias` ADD FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`);

ALTER TABLE `empresas` ADD FOREIGN KEY (`colonia_id`) REFERENCES `colonias` (`id`);

ALTER TABLE `examenes` ADD FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`);

ALTER TABLE `municipios` ADD FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`);

ALTER TABLE `subtemas` ADD FOREIGN KEY (`tema_id`) REFERENCES `temas` (`id`);

ALTER TABLE `temas` ADD FOREIGN KEY (`unidad_id`) REFERENCES `unidades` (`id`);

ALTER TABLE `unidades` ADD FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

ALTER TABLE `vacantes` ADD FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`);

ALTER TABLE `materias` ADD FOREIGN KEY (`maestro_id`) REFERENCES `users` (`id`);

ALTER TABLE `materias` ADD FOREIGN KEY (`area_id`) REFERENCES `areas` (`id`);

ALTER TABLE `asesorias` ADD FOREIGN KEY (`maestro_id`) REFERENCES `users` (`id`);

ALTER TABLE `asesorias` ADD FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

ALTER TABLE `materia_usuarios` ADD FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

ALTER TABLE `materia_usuarios` ADD FOREIGN KEY (`alumno_id`) REFERENCES `users` (`id`);

ALTER TABLE `contenidos` ADD FOREIGN KEY (`subtema_id`) REFERENCES `subtemas` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`colonia_id`) REFERENCES `colonias` (`id`);

ALTER TABLE `model_has_permissions` ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_roles` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;
