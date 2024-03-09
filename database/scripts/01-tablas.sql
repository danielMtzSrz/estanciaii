CREATE TABLE `estados` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `pais_id` bigint,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `municipios` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `estado_id` bigint,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `colonias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `municipio_id` bigint,
  `cp` varchar(255),
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `paises` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `nacionalidad` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `periodos` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `tipo_periodo_id` bigint,
  `titulo` varchar(255),
  `descripcion` varchar(255),
  `fecha_inicio` datetime(3),
  `fecha_fin` datetime(3),
  `periodo_activo` boolean,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `tipos_convocatoria` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `contenido` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `convocatorias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `periodo_id` bigint,
  `tipo_convocatoria_id` bigint,
  `contenido` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `tipos_periodo` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `descripcion` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `grupos` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `carrera_id` bigint,
  `aula_id` bigint,
  `tutor_id` bigint,
  `nombre` varchar(255),
  `turno` int,
  `horarios` json,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `aulas` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `edificio_id` bigint,
  `tipo_aula_id` bigint,
  `nombre` varchar(255),
  `estatus` bool,
  `capacidad` int,
  `horarios` json,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `aulas_reservacion` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `aula_id` bigint,
  `solicitante_id` bigint,
  `horario_inicio` datetime(3),
  `horario_final` datetime(3),
  `asunto` varchar(255),
  `descripcion` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `carreras` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `imagen` varchar(255),
  `descripcion` varchar(255),
  `estatus` boolean,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `materias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `cuatrimestre_id` bigint,
  `nombre` varchar(255),
  `plan_estudios_id` bigint,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `planes_estudio` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `carrera_id` bigint,
  `mapa_curricular_id` bigint,
  `estatus` varchar(255),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `grupo_materia` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `profesor_id` bigint,
  `materia_id` bigint,
  `grupo_id` bigint,
  `periodo_id` bigint,
  `horarios` json,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `mapas_curriculares` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `clave_mapa_curricular` varchar(255),
  `total_cuatrimestres` int,
  `total_horas` int,
  `total_creditos` int,
  `total_materias` int,
  `duracion` int,
  `vigencia` int,
  `fecha_revision` datetime(3),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `asesorias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `materia_id` bigint,
  `user_id` bigint,
  `descripcion` varchar(255),
  `ubicacion` varchar(255),
  `hora_inicio` datetime(3),
  `hora_fin` datetime(3),
  `created_at` timestamp,
  `updated_at` timestamp,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `failed_jobs` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT (CURRENT_TIMESTAMP),
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null
);

CREATE TABLE `model_has_roles` (
  `role_id` bigint NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `permissions` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `module_name` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `personal_access_tokens` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text,
  `last_used_at` timestamp DEFAULT null,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `roles` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null
);

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint NOT NULL,
  `role_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `sessions` (
  `id` varchar(255) PRIMARY KEY,
  `user_id` bigint DEFAULT null,
  `ip_address` varchar(45) DEFAULT null,
  `user_agent` text,
  `payload` text NOT NULL,
  `last_activity` int NOT NULL,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `expediente` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint,
  `habilidades_blandas` json,
  `habilidades_profesionales` json,
  `experiencia_profesional` json,
  `educacion` json,
  `idiomas` json,
  `contacto` json,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

CREATE TABLE `tipos_anuncio` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `contenido` varchar(255),
  `imagen` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `anuncios` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `tipo_anuncio_id` bigint,
  `empresa_id` bigint,
  `titulo` varchar(255),
  `contenido` varchar(255),
  `imagen` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `empresas` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `colonia_id` bigint,
  `calle` varchar(255),
  `numero_exterior` int,
  `numero_interior` int,
  `codigo_postal` int,
  `nombre_empresa` varchar(255),
  `razon_social` varchar(255),
  `rfc` varchar(255),
  `imagen` varchar(255),
  `created_at` timestamp,
  `updated_at` timestamp
);

CREATE TABLE `users` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `colonia_id` bigint,
  `tipo_sangre_id` bigint,
  `estado_civil_id` bigint,
  `generos_id` bigint,
  `nacionalidad_id` bigint,
  `apellido_paterno` varchar(255),
  `apellido_materno` varchar(255),
  `fecha_nacimiento` date,
  `curp` varchar(255),
  `rfc` varchar(255),
  `nss` bigint,
  `telefono_local` int,
  `telefono_celular` int,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `calle` varchar(255),
  `numero_exterior` int,
  `numero_interior` int,
  `email_verified_at` timestamp DEFAULT null,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text,
  `two_factor_recovery_codes` text,
  `two_factor_confirmed_at` timestamp DEFAULT null,
  `remember_token` varchar(100) DEFAULT null,
  `current_team_id` bigint DEFAULT null,
  `profile_photo_path` varchar(2048) DEFAULT null,
  `created_at` timestamp DEFAULT null,
  `updated_at` timestamp DEFAULT null,
  `deleted_at` timestamp DEFAULT null
);

ALTER TABLE `empresas` ADD FOREIGN KEY (`colonia_id`) REFERENCES `colonias` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`colonia_id`) REFERENCES `colonias` (`id`);

ALTER TABLE `asesorias` ADD FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

ALTER TABLE `asesorias` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `anuncios` ADD FOREIGN KEY (`tipo_anuncio_id`) REFERENCES `tipos_anuncio` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`);

ALTER TABLE `aulas_reservacion` ADD FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`);

ALTER TABLE `aulas_reservacion` ADD FOREIGN KEY (`solicitante_id`) REFERENCES `users` (`id`);

ALTER TABLE `estados` ADD FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`);

ALTER TABLE `municipios` ADD FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`);

ALTER TABLE `colonias` ADD FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`);

ALTER TABLE `periodos` ADD FOREIGN KEY (`tipo_periodo_id`) REFERENCES `tipos_periodo` (`id`);

ALTER TABLE `convocatorias` ADD FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`);

ALTER TABLE `convocatorias` ADD FOREIGN KEY (`tipo_convocatoria_id`) REFERENCES `tipos_convocatoria` (`id`);

ALTER TABLE `materias` ADD FOREIGN KEY (`plan_estudios_id`) REFERENCES `planes_estudio` (`id`);

ALTER TABLE `planes_estudio` ADD FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`);

ALTER TABLE `planes_estudio` ADD FOREIGN KEY (`mapa_curricular_id`) REFERENCES `mapas_curriculares` (`id`);

ALTER TABLE `grupo_materia` ADD FOREIGN KEY (`profesor_id`) REFERENCES `users` (`id`);

ALTER TABLE `grupo_materia` ADD FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

ALTER TABLE `grupo_materia` ADD FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`);

ALTER TABLE `grupo_materia` ADD FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`nacionalidad_id`) REFERENCES `paises` (`id`);

ALTER TABLE `expediente` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `model_has_permissions` ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_roles` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `anuncios` ADD FOREIGN KEY (`empresa_id`) REFERENCES `empresas` (`id`);