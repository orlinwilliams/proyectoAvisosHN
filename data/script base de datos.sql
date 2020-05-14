-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 14-05-2020 a las 21:34:49
-- Versión del servidor: 8.0.18
-- Versión de PHP: 7.3.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `avisoshn`
--

DELIMITER $$
--
-- Procedimientos
--
DROP PROCEDURE IF EXISTS `SP_CALIFICACION_VENDEDOR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CALIFICACION_VENDEDOR` (IN `pnIdAnuncio` INT, OUT `MensajeError` VARCHAR(200))  SP:BEGIN
    DECLARE vnConteo, vnIdUsuario        INT;
    DECLARE vnPromedio                   FLOAT;

    IF pnIdAnuncio = '' OR pnIdAnuncio IS NULL THEN
        SET MensajeError = 'Ingrese el idAnuncio ';
        LEAVE SP;
    END IF;

    SELECT idUsuario INTO vnIdUsuario FROM anuncios
    WHERE idAnuncios = pnIdAnuncio;

    SELECT COUNT(*) INTO vnConteo FROM calificacionesvendedor
    WHERE idUsuario=vnIdUsuario;

    SELECT ROUND((SELECT AVG(valoracion) FROM calificacionanuncio ca
    INNER JOIN anuncios a ON a.idAnuncios=ca.idAnuncios
    WHERE a.idUsuario=vnIdUsuario),1) INTO vnPromedio;

    IF vnConteo = 0 THEN 
        INSERT INTO calificacionesvendedor(idUsuario, cantidadEstrellas) VALUES (vnIdUsuario, vnPromedio);
        COMMIT;
        SET MensajeError = 'Valoracion insertada.';
        LEAVE SP;
    END IF;

    IF vnConteo=1 THEN
        UPDATE calificacionesvendedor SET cantidadEstrellas=vnPromedio
        WHERE idUsuario=vnIdUsuario;
        COMMIT;
        SET MensajeError = 'Valoracion actualizada.';
        LEAVE SP;
    END IF;

END$$

DROP PROCEDURE IF EXISTS `SP_CONTRASENIA`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_CONTRASENIA` (IN `pnIdUsuario` INT, IN `pcContraseniaActual` VARCHAR(200), IN `pcContraseniaNueva` VARCHAR(200), IN `pcConfirmación` VARCHAR(200), OUT `pbOcurrioError` BOOLEAN, OUT `pcMensaje` VARCHAR(45))  SP:BEGIN
    DECLARE vnIdUsuario, vnConteo INT;
    DECLARE tempMensaje VARCHAR(2000);
    SET autocommit=0;
	START TRANSACTION;
	SET tempMensaje='';
	SET pbOcurrioError=TRUE;

IF pcContraseniaActual = '' OR pcContraseniaActual IS NULL THEN
    SET tempMensaje = 'Contraseña actual, ';
END IF;

IF pcContraseniaNueva = '' OR pcContraseniaNueva IS NULL THEN
    SET tempMensaje = 'Contraseña Nueva, ';
END IF;

IF tempMensaje <> '' THEN
    SET pcMensaje = CONCAT('Falta agregar la contraseña: ', tempMensaje);
    LEAVE SP;
END IF;

SELECT COUNT(*) INTO vnConteo FROM usuario
WHERE idUsuario = pnIdUsuario AND contrasenia = pcContraseniaActual;

IF vnConteo=0 THEN
    SET pcMensaje="El usuario no existe";
    LEAVE SP;
END IF;

IF pcContraseniaActual=pcContraseniaNueva THEN
    SET pcMensaje = 'Contraseña Nueva es igual a contraseña Actual';
    LEAVE SP;
END if;

IF pcContraseniaNueva<>pcConfirmación THEN
    SET pcMensaje = 'Las contraseñas no coinciden';
    LEAVE SP;
END IF;

UPDATE usuario
    SET 	contrasenia=pcContraseniaNueva
	WHERE idUsuario= pnIdUsuario;
COMMIT;

SET pcMensaje = 'Contraseña actualizada con exito';
SET pbOcurrioError = FALSE;
LEAVE SP;

END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_ANUNCIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_ANUNCIO` (IN `pnIdAnuncios` INT, IN `pnIdUsuario` INT, IN `pcIdCategoria` VARCHAR(500), IN `pnPrecio` VARCHAR(100), IN `pcNombreArticulo` VARCHAR(45), IN `pcDescripcion` VARCHAR(45), IN `pcEstado` VARCHAR(45), OUT `pbOcurrioError` BOOLEAN, OUT `pcMensaje` VARCHAR(45))  SP:BEGIN
    DECLARE  vnConteo, vnIdUsuario, vnIdAnuncios, vnIdCategoria INT;
    DECLARE tempMensaje VARCHAR (2000);
SET autocommit=0;
START TRANSACTION;
SET tempMensaje='';
SET pbOcurrioError=TRUE;

IF pcNombreArticulo = '' OR pcNombreArticulo  IS NULL THEN
    SET tempMensaje= 'Nombre del articulo, ';
END IF;

IF pcIdCategoria = '' OR pcIdCategoria  IS NULL THEN
    SET tempMensaje = 'Categoria, ';
END IF;

IF pnPrecio = '' OR pnPrecio  IS NULL THEN
    SET tempMensaje = 'Precio, ';
END IF;

IF pcEstado = '' OR pcEstado  IS NULL THEN
    SET tempMensaje= 'Estado, ';
END IF;

IF tempMensaje <> '' THEN
    SET pcMensaje= CONCAT('Faltan los siguientes campos: ', tempMensaje);
    LEAVE SP;
END IF;

IF pnIdUsuario = '' OR pnIdUsuario IS NULL THEN
    SET tempMensaje='idUsuario, ';
END IF;

SELECT COUNT(*) INTO vnConteo FROM usuario u
WHERE u.idUsuario=pnIdUsuario;

IF vnConteo = 0 THEN
    SET pcMensaje='Usuario no existe';
    LEAVE SP;
END IF;

IF pnIdAnuncios = '' OR pnIdAnuncios IS NULL THEN
    SET tempMensaje='idAnuncios, ';
END IF;

SELECT COUNT(*) INTO vnConteo FROM anuncios a
WHERE a.idAnuncios=pnIdAnuncios;

IF vnConteo = 0 THEN
    SET pcMensaje = 'Anuncio no existe';
    LEAVE SP;
END IF;

SELECT u.idUsuario INTO vnIdUsuario FROM usuario u
WHERE u.idUsuario=pnIdUsuario;

SELECT a.idAnuncios INTO vnIdAnuncios FROM anuncios a
WHERE a.idAnuncios=pnIdAnuncios;

SELECT c.idcategoria INTO vnIdCategoria FROM categoria c
WHERE c.nombreCategoria=pcIdCategoria;



UPDATE anuncios SET idcategoria= vnIdCategoria, nombre= pcNombreArticulo, precio=pnPrecio, descripcion=pcDescripcion, estadoArticulo=pcEstado
    WHERE idUsuario= vnIdUsuario and idAnuncios=vnIdAnuncios;
COMMIT;
SET pcMensaje = 'Anuncio  actualizado con exito.';
SET pbOcurrioError = FALSE;
LEAVE SP;
END$$

DROP PROCEDURE IF EXISTS `SP_EDITAR_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_USUARIO` (IN `pnIdUsuario` INT, IN `pcNombre` VARCHAR(45), IN `pcApellido` VARCHAR(45), IN `pdFechaNacimiento` VARCHAR(45), IN `pcCorreo` VARCHAR(45), IN `pnTelefono` VARCHAR(45), IN `pcMunicipio` VARCHAR(45), IN `pcRTN` VARCHAR(45), OUT `pbOcurrioError` BOOLEAN, OUT `pcMensaje` VARCHAR(45))  SP:BEGIN
     DECLARE  vnConteo, vnIdUsuario, vnIdTipoUsuario,vnIdMunicipio INT;
	DECLARE	vnFechaRegistro DATE;
     DECLARE tempMensaje VARCHAR(2000);
     SET autocommit=0;
	START TRANSACTION;
	SET tempMensaje='';
	SET pbOcurrioError=TRUE;

IF pcNombre = '' OR pcNombre  IS NULL THEN
    SET tempMensaje = 'Nombre, ';
END IF;

IF pcApellido = '' OR pcApellido IS NULL THEN
    SET tempMensaje = CONCAT(tempMensaje,'Apellido, ');
END IF;

IF pdFechaNacimiento = '' OR pdFechaNacimiento IS NULL THEN
    SET tempMensaje = CONCAT(tempMensaje,'Fecha de nacimiento, ');
END IF;

IF pnTelefono = '' OR pnTelefono IS NULL THEN
    SET tempMensaje = CONCAT(tempMensaje,'Telefono, ');
END IF;

IF pcCorreo = '' OR pcCorreo IS NULL THEN
    SET tempMensaje = CONCAT(tempMensaje,'correo, ');
END IF;

IF pcMunicipio = '' OR pcMunicipio IS NULL THEN
    SET tempMensaje = CONCAT(tempMensaje,'Municipio, ');
END IF;

IF tempMensaje <> '' THEN
    SET pcMensaje = CONCAT('Faltan los siguientes campos: ', tempMensaje);
    LEAVE SP;
END IF;

/*SELECCIONARA EL USUARIO POR SU ID*/
IF pnIdUsuario = '' OR pnIdUsuario IS NULL THEN
    SET tempMensaje =  'idUsuario, ';
END IF;

SELECT COUNT(*) INTO vnConteo FROM usuario u
WHERE u.idUsuario=pnIdUsuario;

IF vnConteo = 0 THEN
    SET pcMensaje = 'Usuario no existe';
    LEAVE SP;
END if;

SELECT COUNT(*) INTO vnConteo FROM municipios
WHERE pcMunicipio=idMunicipios;

IF vnConteo=0 THEN
    SET pcMensaje="El municipio no existe";
    LEAVE SP;
END IF;


UPDATE usuario
SET 	idMunicipios=pcMunicipio,
	    pNombre= pcNombre,
	    pApellido=pcApellido,
	    correoElectronico=pcCorreo,
	    numTelefono=pnTelefono,
	    fechaNacimiento=pdFechaNacimiento,
	    RTN=pcRTN
	WHERE idUsuario = pnIdUsuario;
COMMIT;

SET pcMensaje = 'Usuario  actualizado con exito.';
SET pbOcurrioError = FALSE;
LEAVE SP;

END$$

DROP PROCEDURE IF EXISTS `SP_ELIMINAR_ANUNCIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ELIMINAR_ANUNCIO` (IN `pnIdAnuncio` INT, IN `pnIdUsuario` INT, OUT `pcMensaje` VARCHAR(500))  SP:BEGIN
    DECLARE vnConteo INT;
    DECLARE pcMensajeTemp VARCHAR(500);
    SET AUTOCOMMIT = 0;
    START TRANSACTION;
    SET pcMensajeTemp='';

    IF pnIdAnuncio = '' OR pnIdAnuncio  IS NULL THEN
        SET pcMensajeTemp= 'ID del articulo';
    END IF;

    IF pnIdUsuario = '' OR pnIdUsuario  IS NULL THEN
        SET pcMensajeTemp= CONCAT('ID del articulo', pcMensajeTemp);
    END IF;

    IF pcMensajeTemp <> '' THEN
        SET pcMensaje=CONCAT('Se necesita el: ', pcMensajeTemp);
        LEAVE SP;
    END IF;

    SELECT COUNT(*) INTO vnConteo FROM anuncios
    WHERE idAnuncios=pnIdAnuncio AND idUsuario=pnIdUsuario;

    IF vnConteo = 0 THEN
        SET pcMensaje = "El usuario y el anuncio que desea eliminar no coinciden";
        LEAVE SP;
    END IF;

    DELETE FROM fotos
    WHERE idAnuncios = pnIdAnuncio;

    DELETE FROM anuncios
    WHERE idAnuncios = pnIdAnuncio;

    COMMIT;
    SET pcMensaje = 'Se ha eliminado correctamente';
    LEAVE SP;
END$$

DROP PROCEDURE IF EXISTS `SP_ELIMINAR_ANUNCIO_ADMIN`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ELIMINAR_ANUNCIO_ADMIN` (IN `pnIdUsuario` INT, OUT `pbOcurrioError` BOOLEAN, OUT `pcMensaje` VARCHAR(1000))  SP:BEGIN
    DECLARE vnConteo  INT;
    SET autocommit=0;
    START TRANSACTION;
    SET pbOcurrioError=TRUE;

    IF pnIdUsuario  = '' OR pnIdUsuario  IS NULL THEN
        SET pcMensaje =  'idusuario, ';
        LEAVE SP;
    END IF;

    SELECT COUNT(*) INTO vnConteo FROM Usuario u
    WHERE u.idusuario = pnIdUsuario ;

    IF vnConteo = 0 THEN
        SET pcMensaje = 'idusuario no existe';
        LEAVE SP;
    END IF;

    DELETE FROM denuncias
    WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE idUsuario=pnIdUsuario);

    DELETE FROM calificacionesvendedor
    WHERE idUsuario = pnIdUsuario;

    DELETE FROM comentariosvendedor
    WHERE idusuarioCalificador = pnIdUsuario OR idUsuarioCalificado = pnIdUsuario;

    DELETE FROM calificacionanuncio
    WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE idUsuario=pnIdUsuario);

    DELETE FROM fotos
    WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE idUsuario=pnIdUsuario);

    DELETE FROM anuncios
    WHERE idUsuario = pnIdUsuario;

    DELETE FROM usuario
    WHERE idUsuario = pnIdUsuario;

    COMMIT;
    SET pcMensaje = 'Usuario eliminado con éxito.';
    SET pbOcurrioError = FALSE;
    LEAVE SP;

 END$$

DROP PROCEDURE IF EXISTS `SP_ELIMINAR_USUARIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ELIMINAR_USUARIO` (IN `pnIdUsuario` INT, IN `pcContrasenia` VARCHAR(50), OUT `pbOcurrioError` BOOLEAN, OUT `pcMensaje` VARCHAR(1000))  SP:BEGIN

        DECLARE vnConteo  INT;
        DECLARE vcContrasenia VARCHAR(50);
        DECLARE tempMensaje VARCHAR(2000);
        SET autocommit=0;
		START TRANSACTION;
		SET tempMensaje='';
		SET pbOcurrioError=TRUE;

                 IF pnIdUsuario  = '' OR pnIdUsuario  IS NULL THEN
                    SET tempMensaje =  'idusuario, ';
                END IF;
                IF pcContrasenia  = '' OR pcContrasenia  IS NULL THEN
                    SET tempMensaje =  'contraseña, ';
                END IF;
                IF tempMensaje <> '' THEN
                    SET pcMensaje= CONCAT('Faltan campos requeridos: ', tempMensaje);
                END IF;
                
                SELECT u.contrasenia INTO vcContrasenia FROM Usuario u 
                WHERE u.idusuario = pnIdUsuario;

                IF vcContrasenia <> pcContrasenia THEN
                    SET pcMensaje='Contraseña no correcta';
                    LEAVE SP;
                END IF;

                SELECT COUNT(*) INTO vnConteo FROM Usuario u
                WHERE u.idusuario = pnIdUsuario ;
                IF vnConteo = 0 THEN
                    SET pcMensaje = 'idusuario no existe';
                    LEAVE SP;
                 END if;

        DELETE FROM Usuario
        WHERE idusuario = pnIdUsuario;
 END$$

DROP PROCEDURE IF EXISTS `SP_PUBLICAR_ANUNCIO`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_PUBLICAR_ANUNCIO` (IN `pcidUsuario` INT, IN `pcCategoria` INT, IN `pcMunicipios` INT, IN `pcNombreArticulo` VARCHAR(50), IN `pcPrecio` VARCHAR(200), IN `pcEstado` VARCHAR(10), IN `pcDescripcion` VARCHAR(200), OUT `pcMensaje` VARCHAR(300))  SP:BEGIN

	DECLARE vnConteo INT;
    DECLARE vcMensajeTemp varchar (200);

    SET vcMensajeTemp ="";
    
	IF pcNombreArticulo = "" OR pcNombreArticulo IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Nombre");
	END IF;
    
	IF pcPrecio= "" OR pcPrecio IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "precio");
	END IF;
    
    
	IF pcEstado= "" OR pcEstado IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "estado");
	END IF;
   
	IF pcDescripcion= "" OR pcDescripcion IS NULL THEN
		SET pcDescripcion= "Sin descripcion";
	END IF;
    
	IF vcMensajeTemp<>'' THEN
		SET pcMensaje=CONCAT('Se necesita que ingrese los siguientes campos: ', vcMensajeTemp);
		LEAVE SP;
    END IF;


SELECT 
    (MAX(idAnuncios) + 1)
INTO vnConteo FROM
    anuncios;

    
    INSERT INTO anuncios (idAnuncios,idUsuario,idcategoria,idMunicipios,precio,nombre,descripcion,fechaPublicacion,estadoArticulo,estadoAnuncio,fechaLimite)
    VALUES ( vnConteo,pcidUsuario,pcCategoria,pcMunicipios,  pcPrecio, pcNombreArticulo , pcDescripcion, SYSDATE(), pcEstado,'A',NULL);
    
    INSERT INTO  calificacionanuncio (idAnuncios,valoracion)
    VALUES (vnConteo,0);
    COMMIT;
    SET pcMensaje = "Se ha publicado correctamente";
    LEAVE SP;
    
END$$

DROP PROCEDURE IF EXISTS `SP_REGISTRAR`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_REGISTRAR` (IN `pcNombre` VARCHAR(45), IN `pcApellido` VARCHAR(45), IN `pcCorreo` VARCHAR(60), IN `pcContraseña` VARCHAR(500), IN `pcConfirmacion` VARCHAR(500), IN `pcTelefono` VARCHAR(20), IN `pdNacimiento` VARCHAR(10), IN `pcRTN` VARCHAR(16), IN `pcURL` VARCHAR(1000), IN `pnMunicipio` INT, OUT `pcMensaje` VARCHAR(300))  SP:BEGIN
	DECLARE vnConteo, vnConteo2 INT;
    DECLARE vcMensajeTemp varchar (200);
    SET vcMensajeTemp ="";
    
	IF pcNombre = "" OR pcNombre IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Nombre");
	END IF;
    
	IF pcApellido= "" OR pcApellido IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Apellido");
	END IF;
    
	IF pcCorreo= "" OR pcCorreo IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Correo");
	END IF;
    
	IF pcContraseña= "" OR pcContraseña IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Contraseña");
	END IF;
    
	IF pcConfirmacion= "" OR pcConfirmacion IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Confirmación de contraseña");
	END IF;
    
	IF pcTelefono= "" OR pcTelefono IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Telefono");
	END IF;
    
	IF pdNacimiento= "" OR pdNacimiento IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Fecha de nacimiento");
	END IF;
    
	IF pnMunicipio= "" OR pnMunicipio IS NULL THEN
		SET vcMensajeTemp = CONCAT(vcMensajeTemp, "Municipio");
	END IF;
    
	IF vcMensajeTemp<>'' THEN
		SET pcMensaje=CONCAT('Se necesita que ingrese los siguientes campos: ', vcMensajeTemp);
		LEAVE SP;
    END IF;
    
SELECT 
    COUNT(*)
INTO vnConteo FROM
    usuario
WHERE
    correoElectronico = pcCorreo;
    
    IF vnConteo>0 THEN
		SET pcMensaje = "Este correo ya está en uso";
        LEAVE SP;
	END IF;
    
IF pcContraseña != pcConfirmacion THEN
	SET pcMensaje = "Las contraseñas no coinciden";
    LEAVE SP;
END IF;
    
SELECT 
    (MAX(idUsuario) + 1)
INTO vnConteo FROM
    usuario;
    
    INSERT INTO `usuario` (`idUsuario`, `idtipoUsuario`, `idMunicipios`, `pNombre`, `pApellido`, `correoElectronico`, `contrasenia`, `numTelefono`, `fechaRegistro`, `fechaNacimiento`, `RTN`, `urlFoto`)
    VALUES ( vnConteo, 2, pnMunicipio, pcNombre, pcApellido, pcCorreo, pcContraseña, pcTelefono, curdate(), pdNacimiento, '', '../images/imgUsuarios/user.png');
    
    SELECT (MAX(idCalificacionVendedor)+1) INTO vnConteo2 FROM calificacionesvendedor;
    
    INSERT INTO `calificacionesvendedor` (`idCalificacionVendedor`,`cantidadEstrellas`, `idUsuario`) VALUES (vnConteo2 ,0 , vnConteo);
    
    COMMIT;
    SET pcMensaje = "Se ha registrado correctamente";
    LEAVE SP;
    
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `anuncios`
--

DROP TABLE IF EXISTS `anuncios`;
CREATE TABLE IF NOT EXISTS `anuncios` (
  `idAnuncios` int(11) NOT NULL AUTO_INCREMENT,
  `idUsuario` int(11) NOT NULL,
  `idcategoria` int(11) NOT NULL,
  `idMunicipios` int(11) NOT NULL,
  `precio` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fechaPublicacion` timestamp NOT NULL,
  `estadoArticulo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estadoAnuncio` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'A',
  `fechaLimite` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAnuncios`),
  KEY `fk_anuncios_categoria1` (`idcategoria`),
  KEY `fk_anuncios_municipios1` (`idMunicipios`),
  KEY `fk_anuncios_Usuario1` (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncios`, `idUsuario`, `idcategoria`, `idMunicipios`, `precio`, `nombre`, `descripcion`, `fechaPublicacion`, `estadoArticulo`, `estadoAnuncio`, `fechaLimite`) VALUES
(57, 3, 0, 170, '$ 8000', 'iPhone X', 'iPhone X con 3 meses de uso, doy 2 meses de garantía', '2014-02-03 00:21:20', 'Usado', 'A', NULL),
(56, 4, 2, 160, 'L 1800', 'Prueba 8', 'Nueva descripcion', '2019-01-02 00:21:20', 'Usado', 'A', NULL),
(58, 3, 0, 190, 'L 100', 'pruebaHomero', 'pruebaHomero', '2015-03-05 00:21:20', 'Nuevo', 'A', NULL),
(59, 4, 0, 10, 'L 1000', 'prueba2', 'prueba2', '2019-04-05 00:21:20', 'Nuevo', 'A', NULL),
(62, 4, 0, 44, '$ 50000', 'Lapotop 1', 'PROBANDO ACTUALIZAR DATOS 2', '2019-07-05 00:21:20', 'Restaurado', 'A', NULL),
(61, 4, 0, 36, '$ 40000', 'PS4', 'intentando corregir datos', '2020-06-06 00:21:20', 'Restaurado', 'A', NULL),
(60, 4, 0, 22, 'L 100000', 'Celular SAMSUNG', 'testing 3 name', '2019-05-05 00:21:20', 'Nuevo', 'A', NULL),
(63, 3, 1, 66, '$ 3500', 'RX 470', 'Como nueva', '2020-08-03 00:21:20', 'Usado', 'A', NULL),
(65, 3, 3, 90, '$ 8000', 'Xbox One X', 'Consola nueva con 2 controles y forza horizon 4', '2020-10-05 00:21:20', 'Nuevo', 'A', NULL),
(66, 3, 5, 125, 'L 30000', 'APPLE SMART TV', 'No funciona WiFi', '2020-11-05 00:21:20', 'Usado', 'A', NULL),
(67, 3, 0, 170, '$ 19000', 'Red Magic 5g', 'Totalmente nuevo, para conocer mas detalle ponte en contacto', '2020-12-05 00:21:20', 'Nuevo', 'A', NULL),
(68, 3, 0, 110, 'L 21000', 'One Plus 8 pro', 'Totalmente nuevo', '2020-12-05 00:21:20', 'Nuevo', 'A', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacionanuncio`
--

DROP TABLE IF EXISTS `calificacionanuncio`;
CREATE TABLE IF NOT EXISTS `calificacionanuncio` (
  `idCalificacionAnuncio` int(11) NOT NULL AUTO_INCREMENT,
  `idAnuncios` int(11) NOT NULL,
  `valoracion` int(11) NOT NULL,
  PRIMARY KEY (`idCalificacionAnuncio`),
  KEY `idAnuncios` (`idAnuncios`)
) ENGINE=MyISAM AUTO_INCREMENT=214 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `calificacionanuncio`
--

INSERT INTO `calificacionanuncio` (`idCalificacionAnuncio`, `idAnuncios`, `valoracion`) VALUES
(56, 56, 5),
(57, 57, 3),
(75, 61, 5),
(74, 61, 5),
(73, 61, 2),
(72, 61, 5),
(71, 62, 2),
(70, 62, 5),
(69, 62, 4),
(68, 62, 2),
(67, 62, 2),
(66, 62, 4),
(65, 61, 2),
(64, 62, 4),
(63, 62, 2),
(58, 58, 4),
(59, 59, 5),
(60, 60, 1),
(61, 61, 2),
(62, 62, 2),
(76, 61, 5),
(77, 61, 5),
(78, 61, 5),
(79, 61, 5),
(158, 4, 4),
(81, 61, 5),
(82, 62, 5),
(83, 62, 5),
(84, 62, 5),
(85, 62, 5),
(86, 62, 5),
(87, 62, 5),
(88, 62, 5),
(89, 62, 5),
(90, 62, 5),
(91, 62, 5),
(92, 62, 5),
(93, 62, 5),
(94, 62, 5),
(95, 62, 5),
(96, 62, 5),
(97, 62, 5),
(98, 62, 5),
(99, 62, 5),
(100, 62, 5),
(101, 62, 5),
(102, 62, 5),
(103, 62, 3),
(104, 62, 5),
(105, 62, 5),
(106, 62, 5),
(107, 62, 1),
(108, 62, 1),
(109, 62, 5),
(110, 62, 5),
(111, 62, 5),
(112, 62, 5),
(113, 62, 5),
(114, 62, 5),
(115, 62, 5),
(116, 62, 5),
(117, 62, 5),
(118, 62, 5),
(119, 62, 5),
(120, 62, 5),
(121, 62, 5),
(122, 62, 5),
(123, 62, 5),
(124, 62, 5),
(125, 62, 5),
(126, 62, 5),
(127, 62, 5),
(128, 62, 5),
(129, 62, 5),
(130, 62, 5),
(131, 62, 5),
(132, 62, 5),
(133, 62, 5),
(134, 62, 5),
(135, 62, 5),
(136, 62, 5),
(137, 62, 5),
(138, 62, 5),
(139, 62, 5),
(140, 62, 5),
(141, 62, 5),
(142, 62, 5),
(143, 62, 5),
(144, 62, 5),
(145, 62, 5),
(146, 62, 5),
(147, 62, 5),
(148, 62, 5),
(149, 62, 5),
(150, 62, 5),
(151, 62, 5),
(152, 62, 5),
(153, 62, 5),
(154, 62, 5),
(155, 62, 5),
(156, 62, 5),
(157, 80, 4),
(159, 62, 5),
(160, 62, 3),
(161, 62, 5),
(162, 62, 2),
(163, 62, 1),
(164, 62, 5),
(165, 62, 1),
(166, 62, 1),
(167, 62, 1),
(168, 62, 1),
(169, 62, 1),
(170, 62, 1),
(171, 62, 1),
(172, 62, 5),
(173, 62, 5),
(174, 62, 5),
(175, 62, 5),
(176, 62, 5),
(177, 62, 5),
(178, 62, 5),
(179, 62, 5),
(180, 62, 5),
(181, 62, 5),
(182, 62, 5),
(183, 62, 5),
(184, 62, 5),
(185, 62, 5),
(186, 62, 1),
(187, 62, 1),
(188, 62, 1),
(189, 62, 1),
(190, 62, 1),
(191, 62, 1),
(192, 62, 1),
(193, 62, 1),
(194, 62, 1),
(195, 62, 1),
(196, 62, 1),
(197, 62, 1),
(198, 62, 1),
(199, 62, 1),
(200, 62, 1),
(201, 62, 1),
(202, 62, 1),
(203, 62, 1),
(204, 62, 1),
(205, 62, 1),
(206, 57, 5),
(207, 57, 1),
(208, 64, 4),
(209, 63, 2),
(210, 65, 4),
(211, 66, 5),
(212, 67, 4),
(213, 68, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacionescomprador`
--

DROP TABLE IF EXISTS `calificacionescomprador`;
CREATE TABLE IF NOT EXISTS `calificacionescomprador` (
  `idcalificacionesComprador` int(11) NOT NULL,
  `cantidadEstrellas` int(1) DEFAULT NULL,
  `comentarios` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idcalificacionesComprador`),
  KEY `fk_calificacionesComprador_Usuario1` (`idUsuario`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `calificacionesvendedor`
--

DROP TABLE IF EXISTS `calificacionesvendedor`;
CREATE TABLE IF NOT EXISTS `calificacionesvendedor` (
  `idCalificacionVendedor` int(11) NOT NULL AUTO_INCREMENT,
  `cantidadEstrellas` float DEFAULT NULL,
  `idUsuario` int(11) NOT NULL,
  PRIMARY KEY (`idCalificacionVendedor`),
  KEY `fk_calificacionesVendedor_Usuario1` (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `calificacionesvendedor`
--

INSERT INTO `calificacionesvendedor` (`idCalificacionVendedor`, `cantidadEstrellas`, `idUsuario`) VALUES
(3, 3.9, 4),
(2, 3.8, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

DROP TABLE IF EXISTS `categoria`;
CREATE TABLE IF NOT EXISTS `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombreCategoria` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `idgrupocategoria` int(8) NOT NULL,
  PRIMARY KEY (`idcategoria`),
  KEY `fk_categoria_grupocategoria1` (`idgrupocategoria`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombreCategoria`, `idgrupocategoria`) VALUES
(0, 'Móviles y Telefonía', 0),
(1, 'Informática y Tablets', 0),
(2, 'Cámaras y Fotografía', 0),
(3, 'Consolas y Videojuegos', 0),
(4, 'Hogar y Decoración', 1),
(5, 'Eletrodomésticos', 1),
(6, 'Bricolaje', 1),
(7, 'Terraza y Jardín', 1),
(8, 'Ropa de hombre', 2),
(9, 'Ropa de mujer', 2),
(10, 'Ropa y calzado de niños', 2),
(11, 'Calzado', 2),
(12, 'Ciclismo', 3),
(13, 'Fitness, Running y Yoga', 3),
(14, 'Pádel y Tenis', 3),
(15, 'Pesca', 3),
(16, 'Repuestos para coches', 4),
(17, 'Audio, tecnología y navegación', 4),
(18, 'Tuning para coches', 4),
(19, 'Accesorios para coches', 4),
(20, 'Arte y Antigüedades', 5),
(21, 'Artículos militares', 5),
(22, 'Artículos de Escritorio', 5),
(23, 'Cromos', 5),
(24, 'Relojes y Joyas', 6),
(25, 'Belleza y Salud', 6),
(26, 'Manicura y Pedicura', 6),
(27, 'Maquillaje', 6),
(28, 'Juguetes', 7),
(29, 'Instrumentos musicales', 7),
(30, 'Libros y Música', 7),
(31, 'Viajes', 7),
(32, 'Vinos y Gastronomía', 8),
(33, 'Bebés', 8),
(34, 'Equipamento y Maquinaría', 8),
(35, 'Artículos para animales', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comentariosvendedor`
--

DROP TABLE IF EXISTS `comentariosvendedor`;
CREATE TABLE IF NOT EXISTS `comentariosvendedor` (
  `idComentariosVendedor` int(11) NOT NULL AUTO_INCREMENT,
  `comentario` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `idusuarioCalificador` int(11) NOT NULL,
  `idUsuarioCalificado` int(11) NOT NULL,
  `fechaRegistro` timestamp NOT NULL,
  PRIMARY KEY (`idComentariosVendedor`),
  KEY `idusuarioCalificador` (`idusuarioCalificador`),
  KEY `idUsuarioCalificado` (`idUsuarioCalificado`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `comentariosvendedor`
--

INSERT INTO `comentariosvendedor` (`idComentariosVendedor`, `comentario`, `idusuarioCalificador`, `idUsuarioCalificado`, `fechaRegistro`) VALUES
(1, '', 4, 0, '2020-05-17 12:00:00'),
(2, 'probando comentario 1', 4, 3, '2020-05-18 17:06:12'),
(3, 'probando comentario 2', 4, 3, '2020-05-20 19:17:12');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `denuncias`
--

DROP TABLE IF EXISTS `denuncias`;
CREATE TABLE IF NOT EXISTS `denuncias` (
  `idDenuncias` int(11) NOT NULL AUTO_INCREMENT,
  `idrazonDenuncia` int(11) NOT NULL,
  `idAnuncios` int(11) NOT NULL,
  `comentarios` varchar(600) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaRegistro` timestamp NOT NULL,
  PRIMARY KEY (`idDenuncias`),
  KEY `idrazonDenuncia` (`idrazonDenuncia`),
  KEY `idAnuncios` (`idAnuncios`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `denuncias`
--

INSERT INTO `denuncias` (`idDenuncias`, `idrazonDenuncia`, `idAnuncios`, `comentarios`, `fechaRegistro`) VALUES
(1, 8, 58, 'Parece ser un articulo falso', '0000-00-00 00:00:00'),
(2, 8, 58, 'No es un artículo legítimo', '0000-00-00 00:00:00'),
(3, 8, 56, 'No es un artículo legítimo', '0000-00-00 00:00:00'),
(4, 8, 56, 'Parece no tener intención de vender una articulo pues no hay fotos, ni descripción del artículo', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamentos`
--

DROP TABLE IF EXISTS `departamentos`;
CREATE TABLE IF NOT EXISTS `departamentos` (
  `idDepartamentos` int(11) NOT NULL,
  `nombreDepartamento` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idDepartamentos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `departamentos`
--

INSERT INTO `departamentos` (`idDepartamentos`, `nombreDepartamento`) VALUES
(1, 'Atlántida'),
(2, 'Colón'),
(3, 'Comayagua'),
(4, 'Copán'),
(5, 'Cortés'),
(6, 'Choluteca'),
(7, 'El Paraíso'),
(8, 'Francisco Morazán'),
(9, 'Gracias a Dios'),
(10, 'Intibucá'),
(11, 'Islas de la Bahía'),
(12, 'La Paz'),
(13, 'Lempira'),
(14, 'Ocotepeque'),
(15, 'Olancho'),
(16, 'Santa Bárbara'),
(17, 'Valle'),
(18, 'Yoro');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `favoritos`
--

DROP TABLE IF EXISTS `favoritos`;
CREATE TABLE IF NOT EXISTS `favoritos` (
  `idFavoritos` int(11) NOT NULL AUTO_INCREMENT,
  `idSeguidor` int(11) NOT NULL,
  `idSeguido` int(11) NOT NULL,
  PRIMARY KEY (`idFavoritos`),
  KEY `idSeguidor` (`idSeguidor`),
  KEY `idSeguido` (`idSeguido`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `fotos`
--

DROP TABLE IF EXISTS `fotos`;
CREATE TABLE IF NOT EXISTS `fotos` (
  `idFotos` int(11) NOT NULL AUTO_INCREMENT,
  `idAnuncios` int(11) NOT NULL,
  `nombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `localizacion` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `size` float NOT NULL,
  PRIMARY KEY (`idFotos`),
  KEY `FK_idAnuncios` (`idAnuncios`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`idFotos`, `idAnuncios`, `nombre`, `localizacion`, `size`) VALUES
(36, 57, '', '../images/fotosAnuncio/sbethuell@gmail.com/3.jpg', 0),
(35, 57, '', '../images/fotosAnuncio/sbethuell@gmail.com/2.jpg', 0),
(34, 57, '', '../images/fotosAnuncio/sbethuell@gmail.com/1.JPG', 0),
(26, 56, '', '../images/fotosAnuncio/sbethuell@gmail.com/4BE.png', 0),
(27, 56, '', '../images/fotosAnuncio/sbethuell@gmail.com/4FB.jpg', 0),
(37, 58, '', '../images/fotosAnuncio/sbethuell@gmail.com/homero.jpg', 0),
(38, 59, '', '../images/fotosAnuncio/sbethuell@gmail.com/corazon.jpg', 0),
(45, 60, 'sm1.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/sm1.jpg', 71738),
(57, 61, 'laptop1.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/laptop1.jpg', 71738),
(61, 62, 'laptop.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/laptop.jpg', 408132),
(54, 62, 'laptop1.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/laptop1.jpg', 71738),
(62, 63, '1.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/1.jpg', 859917),
(63, 63, '2.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/2.jpg', 898090),
(66, 65, '5.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/5.jpg', 67278),
(67, 65, '6.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/6.jpg', 53671),
(68, 66, '7.webp', '../images/fotosAnuncio/sbethuell@gmail.com/7.webp', 77540),
(69, 67, '8.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/8.jpg', 266115),
(70, 67, '9.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/9.jpg', 49091),
(71, 68, '11.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/11.jpg', 33539),
(72, 68, '10.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/10.jpg', 31790);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `grupocategoria`
--

DROP TABLE IF EXISTS `grupocategoria`;
CREATE TABLE IF NOT EXISTS `grupocategoria` (
  `idgrupocategoria` int(11) NOT NULL,
  `nombregrupo` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  PRIMARY KEY (`idgrupocategoria`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `grupocategoria`
--

INSERT INTO `grupocategoria` (`idgrupocategoria`, `nombregrupo`) VALUES
(0, 'Electrónica'),
(1, 'Casa y Jardín'),
(2, 'Moda'),
(3, 'Deportes'),
(4, 'Motor'),
(5, 'Coleccionismo'),
(6, 'Joyería y Belleza'),
(7, 'Ocio'),
(8, 'Otras categorías');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipios`
--

DROP TABLE IF EXISTS `municipios`;
CREATE TABLE IF NOT EXISTS `municipios` (
  `idMunicipios` int(11) NOT NULL,
  `idDepartamentos` int(11) NOT NULL,
  `municipio` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idMunicipios`),
  KEY `fk_municipios_departamentos1` (`idDepartamentos`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `municipios`
--

INSERT INTO `municipios` (`idMunicipios`, `idDepartamentos`, `municipio`) VALUES
(1, 1, 'La Ceiba'),
(2, 1, 'El Porvenir'),
(3, 1, 'Tela'),
(4, 1, 'Jutiapa'),
(5, 1, 'La Masica'),
(6, 1, 'San Francisco'),
(7, 1, 'Arizona'),
(8, 1, 'Esparta'),
(9, 2, 'Trijullo'),
(10, 2, 'Balfate'),
(11, 2, 'Iriona'),
(12, 2, 'Limón'),
(13, 2, 'Sabá'),
(14, 2, 'Santa Fe'),
(15, 2, 'Santa Rosa de Aguán'),
(16, 2, 'Sonaguera'),
(17, 2, 'Tocoa'),
(18, 2, 'Bonito Oriental'),
(19, 3, 'Comayagua'),
(20, 3, 'Ajuterique'),
(21, 3, 'El Rosario'),
(22, 3, 'Esquías'),
(23, 3, 'Humuya'),
(24, 3, 'La libertad'),
(25, 3, 'Lamaní'),
(26, 3, 'La Trinidad'),
(27, 3, 'Lejamani'),
(28, 3, 'Meambar'),
(29, 3, 'Minas de Oro'),
(30, 3, 'Ojos de Agua'),
(31, 3, 'San Jerónimo'),
(32, 3, 'San José de Comayagua'),
(33, 3, 'San José del Potrero'),
(34, 3, 'San Luis'),
(35, 3, 'San Sebastián'),
(36, 3, 'Siguatepeque'),
(37, 3, 'Villa de San Antonio'),
(38, 3, 'Las Lajas'),
(39, 3, 'Taulabé'),
(40, 4, 'Santa Rosa de Copán'),
(41, 4, 'Cabañas'),
(42, 4, 'Concepción'),
(43, 4, 'Copán Ruinas'),
(44, 4, 'Corquín'),
(45, 4, 'Cucuyagua'),
(46, 4, 'Dolores'),
(47, 4, 'Dulce Nombre'),
(48, 4, 'El Paraíso'),
(49, 4, 'Florida'),
(50, 4, 'La Jigua'),
(51, 4, 'La Unión'),
(52, 4, 'Nueva Arcadia'),
(53, 4, 'San Agustín'),
(54, 4, 'San Antonio'),
(55, 4, 'San Jerónimo'),
(56, 4, 'San José'),
(57, 4, 'San Juan de Opoa'),
(58, 4, 'San Nicolás'),
(59, 4, 'San Pedro'),
(60, 4, 'Santa Rita'),
(61, 4, 'Trinidad de Copán'),
(62, 4, 'Veracruz'),
(63, 5, 'San Pedro Sula'),
(64, 5, 'Choloma'),
(65, 5, 'Omoa'),
(66, 5, 'Pimienta'),
(67, 5, 'Potrerillos'),
(68, 5, 'Puerto Cortés'),
(69, 5, 'San Antonio de Cortés'),
(70, 5, 'San Francisco de Yojoa'),
(71, 5, 'San Manuel'),
(72, 5, 'Santa Cruz de Yojoa'),
(73, 5, 'Villanueva'),
(74, 5, 'La Lima'),
(75, 6, 'Choluteca'),
(76, 6, 'Apacilagua'),
(77, 6, 'Concepción de María'),
(78, 6, 'Duyure'),
(79, 6, 'El Corpus'),
(80, 6, 'El Triunfo'),
(81, 6, 'Marcovia'),
(82, 6, 'Morolica'),
(83, 6, 'Namasigue'),
(84, 6, 'Orocuina'),
(85, 6, 'Pespire'),
(86, 6, 'San Antonio de Flores'),
(87, 6, 'San Isidro'),
(88, 6, 'San José'),
(89, 6, 'San Marcos de Colón'),
(90, 6, 'Santa Ana de Yusguare'),
(91, 7, 'Yuscarán'),
(92, 7, 'Alauca'),
(93, 7, 'Danlí'),
(94, 7, 'El Paraíso'),
(95, 7, 'Güinope'),
(96, 7, 'Jacaleapa'),
(97, 7, 'Liure'),
(98, 7, 'Morocelí'),
(99, 7, 'Oropolí'),
(100, 7, 'Potrerillos'),
(101, 7, 'San Antonio de Flores'),
(102, 7, 'San Lucas'),
(103, 7, 'San Matías'),
(104, 7, 'Soledad'),
(105, 7, 'Teupasenti'),
(106, 7, 'Texiguat'),
(107, 7, 'Vado Ancho'),
(108, 7, 'Yauyupe'),
(109, 7, 'Trojes'),
(110, 8, 'Distrito Central'),
(111, 8, 'Alubarén'),
(112, 8, 'Cedros'),
(113, 8, 'Curarén'),
(114, 8, 'El Porvenir'),
(115, 8, 'Guaimaca'),
(116, 8, 'La Libertad'),
(117, 8, 'La Venta'),
(118, 8, 'Lepaterique'),
(119, 8, 'Maraita'),
(120, 8, 'Marale'),
(121, 8, 'Nueva Armenia'),
(122, 8, 'Ojojona'),
(123, 8, 'Orica'),
(124, 8, 'Reitoca'),
(125, 8, 'Sabanagrande'),
(126, 8, 'San Antonio de Oriente'),
(127, 8, 'San Buenaventura'),
(128, 8, 'San Ignacio'),
(129, 8, 'San Juan de Flores'),
(130, 8, 'San Miguelito'),
(131, 8, 'Santa Ana'),
(132, 8, 'Santa Lucía'),
(133, 8, 'Talanga'),
(134, 8, 'Tatumbla'),
(135, 8, 'Valle de Ángeles'),
(136, 8, 'Villa de San Francisco'),
(137, 8, 'Vallecillo'),
(138, 9, 'Puerto Lempira'),
(139, 9, 'Brus Laguna'),
(140, 9, 'Ahuas'),
(141, 9, 'Juan Francisco Bulnes'),
(142, 9, 'Ramón Villeda Morales'),
(143, 9, 'Wampusirpe'),
(144, 10, 'La Esperanza'),
(145, 10, 'Camasca'),
(146, 10, 'Colomoncagua'),
(147, 10, 'Concepción'),
(148, 10, 'Dolores'),
(149, 10, 'Intibucá'),
(150, 10, 'Jesús de Otoro'),
(151, 10, 'Magdalena'),
(152, 10, 'Masaguara'),
(153, 10, 'San Antonio'),
(154, 10, 'San Isidro'),
(155, 10, 'San Juan'),
(156, 10, 'San Marcos de la Sierra'),
(157, 10, 'San Miguel Guancapla'),
(158, 10, 'Santa Lucía'),
(159, 10, 'Yamaranguila'),
(160, 10, 'San Francisco de Opalaca'),
(161, 11, 'Roatán'),
(162, 11, 'Guanaja'),
(163, 11, 'José Santos Guardiola'),
(164, 11, 'Utila'),
(165, 12, 'La Paz'),
(166, 12, 'Aguanqueterique'),
(167, 12, 'Cabañas'),
(168, 12, 'Cane'),
(169, 12, 'Chinacla'),
(170, 12, 'Guajiquiro'),
(171, 12, 'Lauterique'),
(172, 12, 'Marcala'),
(173, 12, 'Mercedes de Oriente'),
(174, 12, 'Opatoro'),
(175, 12, 'San Antonio del Norte'),
(176, 12, 'San José'),
(177, 12, 'San Juan'),
(178, 12, 'San Pedro de Tutule'),
(179, 12, 'Santa Ana'),
(180, 12, 'Santa Elena'),
(181, 12, 'Santa María'),
(182, 12, 'Santiago de Puringla'),
(183, 12, 'Yarula'),
(184, 13, 'Gracias'),
(185, 13, 'Belén'),
(186, 13, 'Candelaria'),
(187, 13, 'Cololaca'),
(188, 13, 'Erandique'),
(189, 13, 'Gualcince'),
(190, 13, 'Guarita'),
(191, 13, 'La Campa'),
(192, 13, 'La Iguala'),
(193, 13, 'Las Flores'),
(194, 13, 'La Unión'),
(195, 13, 'La Virtud'),
(196, 13, 'Lepaera'),
(197, 13, 'Mapulaca'),
(198, 13, 'Piraera'),
(199, 13, 'San Andrés'),
(200, 13, 'San Francisco'),
(201, 13, 'San Juan Guarita'),
(202, 13, 'San Manuel Colohete'),
(203, 13, 'San Rafael'),
(204, 13, 'San Sebastián'),
(205, 13, 'Santa Cruz'),
(206, 13, 'Talgua'),
(207, 13, 'Tambla'),
(208, 13, 'Tomalá'),
(209, 13, 'Valladolid'),
(210, 13, 'Virginia'),
(211, 13, 'San Marcos de Caiquín'),
(212, 14, 'Ocotepeque'),
(213, 14, 'Belén Gualcho'),
(214, 14, 'Concepción'),
(215, 14, 'Dolores Merendón'),
(216, 14, 'Fraternidad'),
(217, 14, 'La Encarnación'),
(218, 14, 'La Labor'),
(219, 14, 'Lucerna'),
(220, 14, 'Mercedes'),
(221, 14, 'San Fernando'),
(222, 14, 'San Francisco del Valle'),
(223, 14, 'San Jorge'),
(224, 14, 'San Marcos'),
(225, 14, 'Santa Fe'),
(226, 14, 'Sensenti'),
(227, 14, 'Sinuapa'),
(228, 15, 'Juticalpa'),
(229, 15, 'Campamento'),
(230, 15, 'Catacamas'),
(231, 15, 'Concordia'),
(232, 15, 'Dulce Nombre de Culmí'),
(233, 15, 'El Rosario'),
(234, 15, 'Esquipulas del Norte'),
(235, 15, 'Gualaco'),
(236, 15, 'Guarizama'),
(237, 15, 'Guata'),
(238, 15, 'Guayape'),
(239, 15, 'Jano'),
(240, 15, 'La Unión'),
(241, 15, 'Mangulile'),
(242, 15, 'Manto'),
(243, 15, 'Salamá'),
(244, 15, 'San Esteban'),
(245, 15, 'San Francisco de Becerra'),
(246, 15, 'San Francisco de la Paz'),
(247, 15, 'Santa María del Real'),
(248, 15, 'Patuca'),
(249, 15, 'Yocón'),
(250, 15, 'Patuca'),
(251, 16, 'Santa Bárbara'),
(252, 16, 'Arada'),
(253, 16, 'Atima'),
(254, 16, 'Azacualpa'),
(255, 16, 'Ceguaca'),
(256, 16, 'Concepción del Norte'),
(257, 16, 'Concepción del Sur'),
(258, 16, 'Chinda'),
(259, 16, 'El Níspero'),
(260, 16, 'Gualala'),
(261, 16, 'Ilama'),
(262, 16, 'Las Vegas'),
(263, 16, 'Macuelizo'),
(264, 16, 'Naranjito'),
(265, 16, 'Nuevo Celilac'),
(266, 16, 'Nueva Frontera'),
(267, 16, 'Petoa'),
(268, 16, 'Protección'),
(269, 16, 'Quimistán'),
(270, 16, 'San Francisco de Ojuera'),
(271, 16, 'San José de las Colinas'),
(272, 16, 'San Luis'),
(273, 16, 'San Marcos'),
(274, 16, 'San Nicolás'),
(275, 16, 'San Pedro Zacapa'),
(276, 16, 'San Vicente Centenario'),
(277, 16, 'Santa Rita'),
(278, 16, 'Trinidad'),
(279, 17, 'Nacaome'),
(280, 17, 'Alianza'),
(281, 17, 'Amapala'),
(282, 17, 'Aramecina'),
(283, 17, 'Caridad'),
(284, 17, 'Goascorán'),
(285, 17, 'Langue'),
(286, 17, 'San Francisco de Coray'),
(287, 17, 'San Lorenzo'),
(288, 18, 'Yoro'),
(289, 18, 'Arenal'),
(290, 18, 'El Negrito'),
(291, 18, 'El Progreso'),
(292, 18, 'Jocón'),
(293, 18, 'Morazán'),
(294, 18, 'Olanchito'),
(295, 18, 'Santa Rita'),
(296, 18, 'Sulaco'),
(297, 18, 'Victoria'),
(298, 18, 'Yorito');

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `publicaciones_anio`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `publicaciones_anio`;
CREATE TABLE IF NOT EXISTS `publicaciones_anio` (
`mes` varchar(10)
,`publicaciones` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `publicaciones_categoria`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `publicaciones_categoria`;
CREATE TABLE IF NOT EXISTS `publicaciones_categoria` (
`nombregrupo` varchar(80)
,`publicaciones` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `publicaciones_lugar`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `publicaciones_lugar`;
CREATE TABLE IF NOT EXISTS `publicaciones_lugar` (
`nombreDepartamento` varchar(45)
,`publicaciones` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `razondenuncia`
--

DROP TABLE IF EXISTS `razondenuncia`;
CREATE TABLE IF NOT EXISTS `razondenuncia` (
  `idrazonDenuncia` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idrazonDenuncia`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `razondenuncia`
--

INSERT INTO `razondenuncia` (`idrazonDenuncia`, `descripcion`) VALUES
(1, 'Descripción imprecisa'),
(2, 'Contenido ofensivo o dañino'),
(3, 'Estafa'),
(4, 'Articulo falso'),
(5, 'Contenido sexual'),
(6, 'Venta de armas o drogas'),
(7, 'Publicación discriminatoria'),
(8, 'Sin intención de venta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipousuario`
--

DROP TABLE IF EXISTS `tipousuario`;
CREATE TABLE IF NOT EXISTS `tipousuario` (
  `idtipoUsuario` int(11) NOT NULL AUTO_INCREMENT,
  `tipoUsuario` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  PRIMARY KEY (`idtipoUsuario`),
  UNIQUE KEY `idtipoUsuario_UNIQUE` (`idtipoUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tipousuario`
--

INSERT INTO `tipousuario` (`idtipoUsuario`, `tipoUsuario`) VALUES
(1, 'no registrado'),
(2, 'Miembro'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `idUsuario` int(11) NOT NULL,
  `idtipoUsuario` int(11) NOT NULL,
  `idMunicipios` int(11) NOT NULL,
  `pNombre` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `pApellido` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `correoElectronico` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `contrasenia` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `token` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `numTelefono` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaRegistro` date NOT NULL,
  `fechaNacimiento` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `RTN` varchar(45) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `urlFoto` varchar(1000) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT 'user.png',
  `estado` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idUsuario`),
  UNIQUE KEY `idPersona_UNIQUE` (`idUsuario`),
  KEY `fk_Usuario_tipoUsuario1` (`idtipoUsuario`),
  KEY `fk_Usuario_municipios1` (`idMunicipios`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`idUsuario`, `idtipoUsuario`, `idMunicipios`, `pNombre`, `pApellido`, `correoElectronico`, `contrasenia`, `token`, `numTelefono`, `fechaRegistro`, `fechaNacimiento`, `RTN`, `urlFoto`, `estado`) VALUES
(3, 3, 110, 'Maynor', 'Pineda', 'sbethuell@gmail.com', 'asd.456', NULL, ' 504 9619-96-60', '2020-03-25', '1995-12-01', '', '../images/imgUsuarios/5e94d52855d5b5e713b9d83aebIMG_20160714_170043.jpg', 1),
(2, 2, 14, 'Bethuell', 'Sauceda', 'pmaynorpineda@yahoo.es', 'asdzxc', '', ' 504 9605-01-00', '2020-03-09', '1995-12-01', '', '../images/imgUsuarios/user.png', 1),
(4, 2, 110, 'Jared', 'Castro', 'jaredcastro13@yahoo.es', 'asd123', NULL, ' 504 9858-00-12', '2020-03-30', '1995-10-03', '', '../images/imgUsuarios/5e97defbe9b51user.jpg', 1);

-- --------------------------------------------------------

--
-- Estructura Stand-in para la vista `usuarios_mes`
-- (Véase abajo para la vista actual)
--
DROP VIEW IF EXISTS `usuarios_mes`;
CREATE TABLE IF NOT EXISTS `usuarios_mes` (
`mes` varchar(10)
,`publicaciones` bigint(21)
);

-- --------------------------------------------------------

--
-- Estructura para la vista `publicaciones_anio`
--
DROP TABLE IF EXISTS `publicaciones_anio`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `publicaciones_anio`  AS  select (case month(`anuncios`.`fechaPublicacion`) when 1 then 'Enero' when 2 then 'Febrero' when 3 then 'Marzo' when 4 then 'Abril' when 5 then 'Mayo' when 6 then 'Junio' when 7 then 'Julio' when 8 then 'Agosto' when 9 then 'Septiembre' when 10 then 'Octubre' when 11 then 'Noviembre' when 12 then 'Diciembre' end) AS `mes`,count(0) AS `publicaciones` from `anuncios` where (year(`anuncios`.`fechaPublicacion`) = year(curdate())) group by `mes` order by `anuncios`.`fechaPublicacion` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `publicaciones_categoria`
--
DROP TABLE IF EXISTS `publicaciones_categoria`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `publicaciones_categoria`  AS  select `grupocategoria`.`nombregrupo` AS `nombregrupo`,count(0) AS `publicaciones` from ((`anuncios` join `categoria` on((`categoria`.`idcategoria` = `anuncios`.`idcategoria`))) join `grupocategoria` on((`grupocategoria`.`idgrupocategoria` = `categoria`.`idgrupocategoria`))) where (year(`anuncios`.`fechaPublicacion`) = year(curdate())) group by `grupocategoria`.`nombregrupo` order by `grupocategoria`.`nombregrupo` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `publicaciones_lugar`
--
DROP TABLE IF EXISTS `publicaciones_lugar`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `publicaciones_lugar`  AS  select `departamentos`.`nombreDepartamento` AS `nombreDepartamento`,count(0) AS `publicaciones` from ((`anuncios` join `municipios` on((`municipios`.`idMunicipios` = `anuncios`.`idMunicipios`))) join `departamentos` on((`departamentos`.`idDepartamentos` = `municipios`.`idDepartamentos`))) where (year(`anuncios`.`fechaPublicacion`) = year(curdate())) group by `departamentos`.`nombreDepartamento` order by `departamentos`.`idDepartamentos` ;

-- --------------------------------------------------------

--
-- Estructura para la vista `usuarios_mes`
--
DROP TABLE IF EXISTS `usuarios_mes`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `usuarios_mes`  AS  select (case month(`usuario`.`fechaRegistro`) when 1 then 'Enero' when 2 then 'Febrero' when 3 then 'Marzo' when 4 then 'Abril' when 5 then 'Mayo' when 6 then 'Junio' when 7 then 'Julio' when 8 then 'Agosto' when 9 then 'Septiembre' when 10 then 'Octubre' when 11 then 'Noviembre' when 12 then 'Diciembre' end) AS `mes`,count(`usuario`.`idUsuario`) AS `publicaciones` from `usuario` where ((year(`usuario`.`fechaRegistro`) = year(curdate())) and (`usuario`.`estado` = 1)) group by `mes` order by `usuario`.`fechaRegistro` ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
