CREATE TABLE `area` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `descripcion` varchar(255),
  `imagen` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `asesorias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `escuela_id` int,
  `materia_id` bigint,
  `maestro_id` bigint,
  `descripcion` varchar(255),
  `ubicacion` varchar(255),
  `hora_inicio` datetime,
  `hora_fin` datetime,
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `empresasAsociadas` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `domicilio_id` bigint,
  `calle` varchar(255),
  `numero_exterior` int,
  `numero_interior` int,
  `codigo_postal` int,
  `nombre_empresa` varchar(255),
  `razon_social` varchar(255),
  `rfc` varchar(255),
  `imagen` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `tipoAnuncio` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `empresasAsociadas_id` bigint,
  `titulo` varchar(255),
  `contenido` varchar(255),
  `imagen` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `anuncios` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `tipo_anuncio_id` bigint,
  `escuela_id` int,
  `empresasAsociadas_id` bigint,
  `titulo` varchar(255),
  `contenido` varchar(255),
  `imagen` varchar(255),
  `created_at` datetime,
  `updated_at` datetime
);

CREATE TABLE `grupos` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `carrera_id` bigint,
  `aula_id` bigint,
  `tutor_id` bigint,
  `nombre` varchar(255),
  `turno` boolean,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `aulas` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `edificio_id` bigint,
  `tipo_aula_id` bigint,
  `nombre` varchar(255),
  `estatus` bool,
  `capacidad` int,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `tiposAulas` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `edificios` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `aulasReservacion` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `aula_id` bigint,
  `solicitante_id` bigint,
  `horario_inicio` timestamp,
  `horario_final` timestamp,
  `asunto` varchar(255),
  `descripcion` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `estadoCivil` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `generos` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `clave` varchar(255),
  `descripcion` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `tiposSangre` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `paises` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `nacionalidad` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `estados` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `pais_id` bigint,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `municipios` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `estado_id` bigint,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `colonias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `municipio_id` bigint,
  `cp` varchar(255),
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `paisPersona` (
  `nacionalidad_id` bigint,
  `usuario_id` bigint,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `domicilios` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `colonia_id` bigint,
  `referencias` varchar(255),
  `calle` varchar(255),
  `numero_interior` varchar(255),
  `numero_exterior` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `horarios` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `aula_id` bigint,
  `dia_semana_id` bigint,
  `hora_inicio` time,
  `hora_fin` time,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `diasSemana` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `periodos` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `tipo_periodo_id` bigint,
  `titulo` varchar(255),
  `descripcion` varchar(255),
  `fecha_inicio` datetime,
  `fecha_fin` datetime,
  `periodo_activo` boolean,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `tiposConvocatorias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `plantilla` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `convocatorias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `periodo_id` bigint,
  `tipo_convocatoria_id` bigint,
  `contenido` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `tipoPeriodo` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `descripcion` varchar(255),
  `color` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `mapasCurriculares` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `clave_mapa_curricular` varchar(255),
  `total_cuatrimestres` int,
  `total_horas` int,
  `total_creditos` int,
  `total_materias` int,
  `duracion` int,
  `vigencia` int,
  `fecha_revision` datetime,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `carreras` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `imagen` varchar(255),
  `descripcion` varchar(255),
  `estatus` boolean,
  `tipo_coordinacion_carrera` int,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `materias` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `cuatrimestre_id` bigint,
  `nombre` varchar(255),
  `plan_estudios_id` bigint,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `planesEstudio` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `carrera_id` bigint,
  `mapa_curricular_id` bigint,
  `estatus` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `cuatrimestre` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `nombre` varchar(255),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `grupoMateria` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `profesor_id` bigint,
  `materia_id` bigint,
  `horario_id` bigint,
  `grupo_id` bigint,
  `periodo_id` bigint,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `horarioGrupoMateria` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `horario_id` bigint,
  `grupo_materia_id` bigint,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `failed_jobs` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT (CURRENT_TIMESTAMP),
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `model_has_permissions` (
  `permission_id` bigint NOT NULL,
  `model_type` varchar(255) NOT NULL,
  `model_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL
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
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `personal_access_tokens` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
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
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `guard_name` varchar(255) NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL
);

CREATE TABLE `role_has_permissions` (
  `permission_id` bigint NOT NULL,
  `role_id` bigint NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `sessions` (
  `id` varchar(255) PRIMARY KEY,
  `user_id` bigint DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` text NOT NULL,
  `last_activity` int NOT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `users` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `tipo_sangre_id` bigint,
  `estado_civil_id` bigint,
  `generos_id` bigint,
  `nacionalidad_id` bigint,
  `domicilio_id` bigint,
  `apellido_paterno` varchar(255),
  `apellido_materno` varchar(255),
  `fecha_nacimiento` date,
  `curp` varchar(255),
  `rfc` varchar(255),
  `nss` bigint,
  `correo_personal` varchar(255),
  `correo_administrativo` varchar(255),
  `telefono_local` int,
  `telefono_celular` int,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text,
  `two_factor_recovery_codes` text,
  `two_factor_confirmed_at` timestamp DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `current_team_id` bigint DEFAULT NULL,
  `profile_photo_path` varchar(2048) DEFAULT NULL,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

CREATE TABLE `maestro` (
  `id` bigint PRIMARY KEY AUTO_INCREMENT,
  `user_id` bigint,
  `habilidades_blandas` text,
  `habilidades_profesionales` text,
  `experiencia_profesional` text,
  `educacion` text,
  `idiomas` text,
  `contacto` text,
  `created_at` timestamp DEFAULT NULL,
  `updated_at` timestamp DEFAULT NULL,
  `deleted_at` timestamp DEFAULT NULL
);

ALTER TABLE `asesorias` ADD FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

ALTER TABLE `asesorias` ADD FOREIGN KEY (`maestro_id`) REFERENCES `maestro` (`id`);

ALTER TABLE `empresasAsociadas` ADD FOREIGN KEY (`domicilio_id`) REFERENCES `domicilios` (`id`);

ALTER TABLE `anuncios` ADD FOREIGN KEY (`tipo_anuncio_id`) REFERENCES `tipoAnuncio` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`);

ALTER TABLE `grupos` ADD FOREIGN KEY (`tutor_id`) REFERENCES `users` (`id`);

ALTER TABLE `aulas` ADD FOREIGN KEY (`edificio_id`) REFERENCES `edificios` (`id`);

ALTER TABLE `aulas` ADD FOREIGN KEY (`tipo_aula_id`) REFERENCES `tiposAulas` (`id`);

ALTER TABLE `aulasReservacion` ADD FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`);

ALTER TABLE `aulasReservacion` ADD FOREIGN KEY (`solicitante_id`) REFERENCES `users` (`id`);

ALTER TABLE `estados` ADD FOREIGN KEY (`pais_id`) REFERENCES `paises` (`id`);

ALTER TABLE `municipios` ADD FOREIGN KEY (`estado_id`) REFERENCES `estados` (`id`);

ALTER TABLE `colonias` ADD FOREIGN KEY (`municipio_id`) REFERENCES `municipios` (`id`);

ALTER TABLE `paisPersona` ADD FOREIGN KEY (`nacionalidad_id`) REFERENCES `paises` (`id`);

ALTER TABLE `paisPersona` ADD FOREIGN KEY (`usuario_id`) REFERENCES `users` (`id`);

ALTER TABLE `domicilios` ADD FOREIGN KEY (`colonia_id`) REFERENCES `colonias` (`id`);

ALTER TABLE `horarios` ADD FOREIGN KEY (`aula_id`) REFERENCES `aulas` (`id`);

ALTER TABLE `horarios` ADD FOREIGN KEY (`dia_semana_id`) REFERENCES `diasSemana` (`id`);

ALTER TABLE `periodos` ADD FOREIGN KEY (`tipo_periodo_id`) REFERENCES `tipoPeriodo` (`id`);

ALTER TABLE `convocatorias` ADD FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`);

ALTER TABLE `convocatorias` ADD FOREIGN KEY (`tipo_convocatoria_id`) REFERENCES `tiposConvocatorias` (`id`);

ALTER TABLE `materias` ADD FOREIGN KEY (`cuatrimestre_id`) REFERENCES `cuatrimestre` (`id`);

ALTER TABLE `materias` ADD FOREIGN KEY (`plan_estudios_id`) REFERENCES `planesEstudio` (`id`);

ALTER TABLE `planesEstudio` ADD FOREIGN KEY (`carrera_id`) REFERENCES `carreras` (`id`);

ALTER TABLE `planesEstudio` ADD FOREIGN KEY (`mapa_curricular_id`) REFERENCES `mapasCurriculares` (`id`);

ALTER TABLE `grupoMateria` ADD FOREIGN KEY (`profesor_id`) REFERENCES `users` (`id`);

ALTER TABLE `grupoMateria` ADD FOREIGN KEY (`materia_id`) REFERENCES `materias` (`id`);

ALTER TABLE `grupoMateria` ADD FOREIGN KEY (`horario_id`) REFERENCES `horarios` (`id`);

ALTER TABLE `grupoMateria` ADD FOREIGN KEY (`grupo_id`) REFERENCES `grupos` (`id`);

ALTER TABLE `grupoMateria` ADD FOREIGN KEY (`periodo_id`) REFERENCES `periodos` (`id`);

ALTER TABLE `horarioGrupoMateria` ADD FOREIGN KEY (`horario_id`) REFERENCES `horarios` (`id`);

ALTER TABLE `horarioGrupoMateria` ADD FOREIGN KEY (`grupo_materia_id`) REFERENCES `grupoMateria` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`tipo_sangre_id`) REFERENCES `tiposSangre` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`estado_civil_id`) REFERENCES `estadoCivil` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`generos_id`) REFERENCES `generos` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`nacionalidad_id`) REFERENCES `paises` (`id`);

ALTER TABLE `users` ADD FOREIGN KEY (`domicilio_id`) REFERENCES `domicilios` (`id`);

ALTER TABLE `maestro` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

ALTER TABLE `model_has_permissions` ADD FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE;

ALTER TABLE `model_has_roles` ADD FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

ALTER TABLE `anuncios` ADD FOREIGN KEY (`empresasAsociadas_id`) REFERENCES `empresasAsociadas` (`id`);
