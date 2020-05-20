-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1:3306
-- Tiempo de generación: 20-05-2020 a las 21:55:49
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
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_EDITAR_ANUNCIO` (IN `pnIdAnuncios` INT, IN `pnIdUsuario` INT, IN `pcIdCategoria` INT, IN `pcIdMunicipio` INT, IN `pnPrecio` VARCHAR(100), IN `pcNombreArticulo` VARCHAR(45), IN `pcDescripcion` VARCHAR(2500), IN `pcEstado` VARCHAR(45), OUT `pcMensaje` VARCHAR(45), OUT `pbOcurrioError` BOOLEAN)  SP:BEGIN
    DECLARE  vnConteo, vnIdUsuario, vnIdAnuncios INT;
    DECLARE tempMensaje VARCHAR (2000);
SET autocommit=0;
START TRANSACTION;
SET tempMensaje='';
SET pbOcurrioError=TRUE;

IF pcNombreArticulo = '' OR pcNombreArticulo  IS NULL THEN
    SET tempMensaje= 'Nombre del articulo, ';
END IF;

IF pcIdCategoria = '' OR pcIdCategoria  IS NULL THEN
    SET
    tempMensaje = 'Categoria, ';
END IF;
IF pcIdMunicipio = '' OR pcIdMunicipio  IS NULL THEN
    SET
    tempMensaje = 'Municipio, ';
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




UPDATE anuncios SET idcategoria=pcIdCategoria, idMunicipios=pcIdMunicipio, nombre= pcNombreArticulo, precio=pnPrecio, descripcion=pcDescripcion, estadoArticulo=pcEstado
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

DROP PROCEDURE IF EXISTS `SP_ELIMINAR_PUBLICACIONES_FLIMITE`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `SP_ELIMINAR_PUBLICACIONES_FLIMITE` (OUT `pcMensaje` VARCHAR(1000))  SP:BEGIN
                        
                        DELETE FROM calificacionanuncio
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d'));
                    
                        DELETE FROM denuncias
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d'));
                    
                        DELETE FROM fotos
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d'));
                    
                        DELETE FROM anuncios
                        WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d');
                        
                        SET pcMensaje = 'las publicaciones han expirado';
                    
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
  `descripcion` varchar(2500) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `fechaPublicacion` timestamp NOT NULL,
  `estadoArticulo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `estadoAnuncio` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'A',
  `fechaLimite` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`idAnuncios`),
  KEY `fk_anuncios_categoria1` (`idcategoria`),
  KEY `fk_anuncios_municipios1` (`idMunicipios`),
  KEY `fk_anuncios_Usuario1` (`idUsuario`)
) ENGINE=MyISAM AUTO_INCREMENT=120 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `anuncios`
--

INSERT INTO `anuncios` (`idAnuncios`, `idUsuario`, `idcategoria`, `idMunicipios`, `precio`, `nombre`, `descripcion`, `fechaPublicacion`, `estadoArticulo`, `estadoAnuncio`, `fechaLimite`) VALUES
(57, 3, 0, 172, '$ 250', 'iPhone X', 'iPhone X con 3 meses de uso, doy 2 meses de garantía', '2019-02-03 00:21:20', 'Usado', 'A', NULL),
(62, 4, 1, 44, '$ 150', 'Laptop hp', 'Laptop hp, restaurada, funciona excelente.', '2019-07-05 00:21:20', 'Restaurado', 'A', NULL),
(61, 3, 3, 36, '$ 40000', 'PS4', 'Consola PS4, usada, pero funciona excelente.', '2020-04-06 00:21:20', 'Usado', 'A', NULL),
(60, 3, 0, 22, 'L 15000', 'Celular SAMSUNG', 'Celular nuevo, color blanco, en empaque, con cargador y audifonos en paquete.', '2019-04-05 00:21:20', 'Nuevo', 'A', NULL),
(63, 4, 1, 66, '$ 3500', 'RX 470', 'Como nueva', '2020-02-03 00:21:20', 'Usado', 'A', NULL),
(65, 3, 3, 90, '$ 800', 'Xbox One X', 'Consola nueva con 2 controles y forza horizon 4', '2019-10-05 00:21:20', 'Nuevo', 'A', NULL),
(66, 0, 5, 125, 'L 20000', 'APPLE SMART TV', 'No funciona WiFi', '2020-01-05 00:21:20', 'Usado', 'A', NULL),
(67, 3, 0, 170, 'L 19000', 'Red Magic 5g', 'Totalmente nuevo, para conocer mas detalle ponte en contacto', '2019-12-05 00:21:20', 'Nuevo', 'A', NULL),
(68, 3, 0, 110, 'L 16000', 'One Plus 8 pro', 'Totalmente nuevo', '2019-06-05 00:21:20', 'Nuevo', 'A', NULL),
(69, 0, 2, 6, '$ 300', 'Camara Canon EOS', 'Canon EOS 5d mark iii Camera with 24-105 lens battery \r\ncharge and memory card', '2020-05-19 05:58:32', 'Nuevo', 'A', NULL),
(70, 0, 2, 6, '$ 100', 'Lentes para cámara Sony', 'Sony E-mount 18-135mm F/3.5-5.6 Oss 135mm Zoom Lens Sel18135', '2019-01-18 06:00:00', 'Nuevo', 'A', NULL),
(71, 0, 5, 6, '$ 160', 'Mini nevera de hotel', 'Mini nevera de hotel de 20 litros, refrigeración	Electrónica condensador de refrigeración,\r\nTemperatura llamó	0-10 °C,\r\nPoder	50 W,\r\nTamaño	42x49x40 cm,\r\nTensión de	220 v.', '2020-04-19 06:00:47', 'Usado', 'A', NULL),
(72, 1, 4, 24, 'L 7000', 'Muebles de sala', 'Excelente juego de muebles para tus reuniones sociales, cuenta con una mesita con 4 portavasos y espacio para los snacks, a un precio genial de la fábrica a tu casa sin intermediarios.', '2020-02-19 06:06:16', 'Nuevo', 'A', NULL),
(73, 1, 4, 24, 'L 100', 'Lamparas diagonales LED', 'Lámpara cuántica, lámparas hexagonales, iluminación Modular ,sensible al tacto, luz LED nocturna, Hexagonal magnético, decoración creativa, Lampara de pared, Color	Blanco, Tamaño 108mm, Poder 6 W.', '2019-02-19 06:00:00', 'Nuevo', 'A', NULL),
(74, 1, 6, 24, 'L 450', 'Máquina de corte por láser', '40 \"pulgadas 1000mm profesional baldosas de herramientas de  máquina de corte por láser de bricolaje en casa ', '2019-03-19 06:09:16', 'Usado', 'A', NULL),
(75, 1, 6, 24, 'L 500', 'Herramientas eléctricas', 'Conjunto de herramientas eléctricas de bricolaje,  Taladro Inalámbrico combinado, herramientas manuales eléctricas para precisión de madera.\nHerramienta incluye:    Combinación, taladro eléctrico, OEM\nUso:     Materiales, como ladrillos, etc.', '2019-04-19 06:00:00', 'Usado', 'A', NULL),
(76, 1, 7, 24, 'L 30000', 'Techo impermeable', 'Kits de sistema de techo de rejilla impermeable,  pérgola de aluminio bioclimática para jardín de Gazebo al aire libre.', '2020-05-19 06:19:55', 'Nuevo', 'A', NULL),
(77, 1, 7, 24, 'L 200', 'Macetas', 'Macetas para interiores y exteriores, con excelentes diseños y variedad de colores.\r\n', '2019-06-19 06:20:37', 'Usado', 'A', NULL),
(78, 2, 8, 14, '$ 40', 'Ropa para hombre', 'Excelentes trajes para hombres, nuevos, el precio puede variar por cada traje.', '2019-07-19 06:00:00', 'Nuevo', 'A', NULL),
(79, 2, 8, 14, '$ 20', 'Camisas para hombre', 'Camisas excelentes para hombres, diversidad de colores y tallas.', '2020-05-19 06:32:33', 'Nuevo', 'A', NULL),
(80, 2, 9, 14, '$ 40', 'Ropa para mujer', 'Bonitos trajes de mujer de moda,  para ejercicio o invierno,  variedad de estilos, colores y tallas.', '2019-08-19 06:00:00', 'Nuevo', 'A', NULL),
(81, 2, 9, 14, '$ 22', 'Vestidos de mujer', 'Bonitos y hermosos vestidos de mujer, diferentes tallas y colores dependiendo de tus gustos.', '2020-03-19 06:36:34', 'Nuevo', 'A', NULL),
(82, 2, 10, 14, '$ 22', 'Ropa de niño', 'Ropa de niño, todo tipo de talla y estilos para que puedas elegir', '2020-05-19 08:05:44', 'Nuevo', 'A', NULL),
(83, 2, 0, 14, '$ 20', 'Zapatos para niños', 'Zapatos deportivos para niños, color blanco y negro.', '2019-09-22 06:00:00', 'Nuevo', 'A', NULL),
(84, 2, 11, 14, 'L 400', 'Zapatos de mujer', 'Zaptos de mujer, en buen estado.', '2019-11-10 06:00:00', 'Usado', 'A', NULL),
(85, 2, 0, 14, 'L 550', 'Calzado de hombre', 'Zapatos de hombre, completamente nuevos y buen precio.', '2020-02-05 06:00:00', 'Nuevo', 'A', NULL),
(86, 5, 12, 32, '$ 60', 'Bicicletas', 'Bicicleta de carretera de alta calidad a bajo precio/bicicleta de montaña con neumático grueso/bicicleta de nieve mtb con neumático de aire.', '2020-05-19 08:28:46', 'Nuevo', 'A', NULL),
(87, 5, 12, 32, '$ 20', 'Bicicleta para niñas.', 'Bicicleta de alta calidad para niñas de 20 pulgadas/bicicleta económica de 20 pulgadas princess city/bicicletas de carretera baratas para mujeres.\r\n', '2019-05-19 08:30:09', 'Usado', 'A', NULL),
(88, 5, 13, 32, '$ 300', 'Máquina de ejercicio', 'Gimnasio fitness ejercicio girando bicicleta ciclismo indoor 10 kg volante bicicleta \r\ncon el titular del teléfono , marca:  FOREX, distintos colores.', '2020-04-26 08:33:02', 'Nuevo', 'A', NULL),
(89, 5, 13, 32, '$ 8', 'Manta para yoga', 'Impresión personalizada de alta densidad antideslizante manta de PVC deporte estera de salud perder peso Fitness ejercicio de Yoga Mat, distintos colores, longitud: 183cm, Material: De PVC, Tamaño: 18', '2020-01-16 08:37:17', 'Nuevo', 'A', NULL),
(90, 6, 14, 40, '$ 10000', 'Cancha de tenis Padel', 'Cancha de tenis Padel de fábrica , Material:    De acero, Color:    Negro, Recubrimiento en polvo:    Revestimiento de Zinc y recubrimiento de polvo de plástico, Paquete: Espuma de PE + cubierta de fi', '2019-10-20 06:00:00', 'Nuevo', 'A', NULL),
(91, 6, 14, 40, '$ 18', 'Raqueta de tenis', 'Fabricante de China de entretenimiento deportes de interior de fibra de carbono 100% bate de tenis, tamaño: 58 inch2, equilibrio: 330 +/-10MM, peso: 290 +/-7,5.', '2020-01-30 08:43:36', 'Usado', 'A', NULL),
(92, 6, 15, 40, '$ 2', 'Señuelo de pesca', 'Lutac 50s hundimiento minnow señuelo de pesca de fundición larga, talla: 50mm,  peso: 5g, material:    ABS de plástico duro.', '2020-05-02 08:44:48', 'Nuevo', 'A', NULL),
(93, 6, 15, 40, '$ 20', 'Caña de pesca', 'Caña de pescar de fundición ligera BMAX M de 198-244cm de Abu Jose, longitud:    1,98m 2,13 m 2,44 m , marca: OEM, material:    De carbono, Con alto contenido de carbono, peso: 147-198g, color: negro.', '2019-11-14 06:00:00', 'Nuevo', 'A', NULL),
(94, 7, 16, 56, '$ 22', 'Escobillas limpiaparabrisas', 'Repuesto universal de la cuchilla del limpiaparabrisas del coche sin marco del parabrisas del automóvil, material caucho, Marca del vehículo compatible: universal. ', '2020-02-27 08:51:47', 'Nuevo', 'A', NULL),
(95, 7, 16, 56, '$ 25', 'Luces antinuebla para coche', '2 piezas h15 bombilla led de alta potencia 6000k blanco 18smd 3030 para luces de circulación diurna bombilla de repuesto 6000-6500k blanco puro 12v, Marca del vehículo compatible: universal.', '2019-10-16 06:00:00', 'Nuevo', 'A', NULL),
(96, 7, 17, 56, '$ 30', 'Radio para auto', '12v radio de coche reproductor de audio mp3 bluetooth aux usb sd mmc estéreo fm auto electrónica en el tablero autoradio 1 din para camión taxi windows ce 5.0. Ranura para Tarjeta GPS: Tarjeta TF. Sis', '2020-04-13 08:56:45', 'Usado', 'A', NULL),
(97, 7, 0, 56, '$ 120', 'swm 9702', 'swm 9702 + cámara 4led 7 pulgadas 1 din android 8.1 reproductor mp5 para automóvil reproductor mulitimedia para automóvil pantalla táctil gps bluetooth incorporado soporte rca / hdmi / fm2 mpeg / mpg.', '2019-08-04 06:00:00', 'Nuevo', 'A', NULL),
(98, 7, 19, 56, '$ 50', 'Fundas de asiento de auto', 'Fundas de asiento de automóvil antideslizantes transpirables de cuero de pu accesorios de  cojines funda de asiento individual sin reposacabezas y reposabrazos para universal, marca del vehículo compa', '2020-05-13 09:02:45', 'Nuevo', 'A', NULL),
(99, 7, 0, 56, '$ 6', 'Mando para llave', 'Mando a distancia para llave de 6 botones de repuesto negro para chevrole 2007/2008/2009 suburbano, modelo suburban, dimensiones netas (cm): 5, peso neto (kg): 0.014.', '2020-03-17 08:10:16', 'Restaurado', 'A', NULL),
(100, 8, 22, 66, 'L 50', 'Grapadoras', 'Pequeña grapadora de oficina mini grapadora de escritorio para oficina / estudiantes, material 	Carcasa de plástico, tipo: Sujetador, dimensiones (cm): 11.8*3.2*6.', '2020-05-23 09:09:29', 'Nuevo', 'A', NULL),
(101, 8, 22, 66, 'L 550', 'Disipador para laptop', 'Diy pc stand laptop disipador de calor estante escritorio, estante mesa inclinación 8 grados .\r\n', '2019-05-22 06:00:00', 'Nuevo', 'A', NULL),
(102, 9, 21, 78, 'L 400', 'Uniforme de militar', 'Uniformes de camuflaje táctico ejército militar personalizados baratos, venta al por mayor.\r\nGénero:    Unisex, Material:  Poliéster/algodón, Tipo de suministro:  Servicio de OEM, Característica:   An', '2019-06-16 06:00:00', 'Usado', 'A', NULL),
(103, 9, 21, 78, 'L 550', 'Chaleco militar', 'OEM militar táctico chaleco policía Airsoft de corte láser combate asalto Placa de peso del  portador chaleco, Material:  600D Oxford, Peso: 1,48 KG, Color: Grey, Embalaje:  1 pc/bolsa de plástico,\r\nT', '2020-05-19 09:18:54', 'Nuevo', 'A', NULL),
(104, 10, 23, 88, 'L 200', 'Cromo contemporáneo', 'Set de Accesorios de Baño / Cromo Contemporáneo, material de latón, acabado Cromo, estilo moderno, longitud Aprox. (cm) 66.5, profundidad total (cm) 21, peso neto (kg) 2.05.', '2020-01-29 09:22:45', 'Nuevo', 'A', NULL),
(105, 10, 23, 88, 'L 250', 'Percha para albornoz', 'Acabado Cromo, estilo moderno, peso neto (kg) 2.', '2020-04-10 09:24:18', 'Nuevo', 'A', NULL),
(106, 10, 24, 88, 'L 900', 'Relojes para mujer', 'Relojes nuevos, en empaque para mujeres, hermoso azul rosa púrpura cara diamante joyería reloj y juego de joyas de flores.\r\n', '2019-04-01 09:26:54', 'Nuevo', 'A', NULL),
(107, 10, 24, 88, 'L 950', 'Reloj mecánico', 'De moda de alta calidad de los hombres mecánicos reloj para Omegas Accesorios.\r\n', '2019-12-19 09:27:51', 'Nuevo', 'A', NULL),
(108, 11, 25, 94, 'L 300', 'Colageno para la piel', 'Colágeno para cuidado de la piel Booster 50ml dosificación forma C colágeno suplemento de salud.\r\n', '2020-02-15 09:30:47', 'Nuevo', 'A', NULL),
(109, 11, 25, 94, 'L 450', 'Equipo para la piel', 'Equipo de cuidado de la piel galvánico de iones, equipo de quemagrasas ems, instrumento ultrasónico de belleza y salud.\r\n', '2019-01-19 06:00:00', 'Nuevo', 'A', NULL),
(110, 11, 26, 94, 'L 400', 'Set de manicure y pedicure', 'Set de manicure y pedicure PRITECH, lima de uñas de pie recargable, Set eléctrico de manicura y pedicura.\r\n', '2019-11-29 09:33:49', 'Nuevo', 'A', NULL),
(111, 11, 26, 94, 'L 320', 'Kit de manicure', 'Kit de manicure, travel portable manicures accessories professional manicure pedicure set kit for girl, marca: LATTIS, Color personalizado.', '2020-01-19 09:35:05', 'Nuevo', 'A', NULL),
(112, 12, 28, 108, 'L 550', 'Juego infantil', 'Casa de juego multifuncional para niños y niñas, todo en buen estado, con todas las piezas, solo utilizado una semana.\r\n', '2019-12-19 09:37:44', 'Usado', 'A', NULL),
(113, 12, 28, 108, 'L 50', 'Pulseras de superheroes', 'Venta Regalo de Cumpleaños, transformación reloj de dibujos animados de niños. Precio por unidad. Material de plástico, variedad.', '2020-04-19 09:40:11', 'Nuevo', 'A', NULL),
(114, 13, 20, 122, 'L 2000', 'Pintura en 5 piezas', 'Venta al por mayor, triangulación de envío, 5 paneles, pintura en lienzo de árbol para decoración para las paredes del salón, paisaje, decoración del hogar, arte de pared, medidas: 20x30x20x40x2 20x50', '2020-02-19 09:45:45', 'Nuevo', 'A', NULL),
(115, 13, 20, 122, 'L 1000', 'Pintura de impresión digital', 'Impresión Digital 7 caballos corriendo al atardecer imagen HD pintura de pared sobre lienzo arte.\r\nTamaño Original:   40x80cm, materiales:  260-300g/sqm lienzo + pigmento tinta impermeable,  espesor d', '2019-11-19 09:47:26', 'Nuevo', 'A', NULL),
(116, 13, 29, 122, 'L 15000', 'Violin eléctrico', 'Violín eléctrico de colores a la venta Kinglos, profesional, alta calidad. Material frontal:    De arce\r\nMaterial trasero / Lateral:   Arce, material superior:  De arce, material del diapasón:    Ebon', '2020-04-19 09:49:55', 'Nuevo', 'A', NULL),
(117, 13, 29, 122, '$ 450', 'Cello cremon', 'Cello cremona 4/4 modelo sc100, año 2003, ideal para aprender a tapa de pino abeto y fondo y costados de arce, tastiera de maple.\r\nEl cello tiene recién instaladas cuerdas ddadario prelude. El cello recibio ajuste por luthier de iviolinni en el puente, mejorando la respuesta y altura de las cuerdas.Viene con un arco de Pernambuco de buena calidad. Trae también sus estuche y pecaztilla.\r\n', '2020-03-19 09:52:12', 'Usado', 'A', NULL),
(118, 13, 30, 122, '$ 24', 'Novela cien años de soledad', 'Libro nuevo de Gabriel Garcia Marquez, original.', '2020-05-19 09:53:15', 'Nuevo', 'A', NULL),
(119, 13, 30, 122, '$ 45', 'Divergente e insurgente', 'Libros Divergente e insurgente de Veronica Ruth\r\nPrimeros 2 libros de la trilogía Divergente de Veronica Roth.\r\nDescripción: Usados en perfecto estado, originales publicados por RBA, idioma Español', '2020-03-19 09:54:37', 'Usado', 'A', NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=318 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

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
(213, 68, 2),
(214, 69, 0),
(215, 70, 0),
(216, 71, 0),
(217, 72, 0),
(218, 73, 0),
(219, 74, 0),
(220, 75, 0),
(221, 76, 0),
(222, 77, 0),
(223, 78, 0),
(224, 79, 0),
(225, 80, 0),
(226, 81, 0),
(227, 82, 0),
(228, 83, 0),
(229, 84, 0),
(230, 85, 0),
(231, 86, 0),
(232, 87, 0),
(233, 88, 0),
(234, 89, 0),
(235, 90, 0),
(236, 91, 0),
(237, 92, 0),
(238, 93, 0),
(239, 94, 0),
(240, 95, 0),
(241, 96, 0),
(242, 97, 0),
(243, 98, 0),
(244, 99, 0),
(245, 100, 0),
(246, 101, 0),
(247, 102, 0),
(248, 103, 0),
(249, 104, 0),
(250, 105, 0),
(251, 106, 0),
(252, 107, 0),
(253, 108, 0),
(254, 109, 0),
(255, 110, 0),
(256, 111, 0),
(257, 112, 0),
(258, 113, 0),
(259, 114, 0),
(260, 115, 0),
(261, 116, 0),
(262, 117, 0),
(263, 118, 0),
(264, 119, 0),
(265, 69, 4),
(266, 75, 1),
(267, 79, 4),
(268, 98, 5),
(269, 97, 2),
(270, 103, 3),
(271, 86, 4),
(272, 85, 5),
(273, 76, 4),
(274, 69, 5),
(275, 70, 4),
(276, 57, 4),
(277, 107, 3),
(278, 107, 4),
(279, 82, 4),
(280, 77, 4),
(281, 119, 2),
(282, 117, 3),
(283, 116, 4),
(284, 114, 5),
(285, 101, 4),
(286, 93, 3),
(287, 78, 5),
(288, 68, 4),
(289, 79, 4),
(290, 91, 4),
(291, 97, 3),
(292, 115, 4),
(293, 117, 4),
(294, 105, 2),
(295, 101, 4),
(296, 94, 4),
(297, 86, 4),
(298, 79, 4),
(299, 118, 5),
(300, 116, 4),
(301, 110, 4),
(302, 108, 5),
(303, 106, 5),
(304, 84, 5),
(305, 81, 5),
(306, 80, 4),
(307, 66, 4),
(308, 65, 3),
(309, 75, 1),
(310, 76, 3),
(311, 69, 2),
(312, 69, 4),
(313, 77, 3),
(314, 81, 4),
(315, 100, 4),
(316, 112, 3),
(317, 108, 3);

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
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `calificacionesvendedor`
--

INSERT INTO `calificacionesvendedor` (`idCalificacionVendedor`, `cantidadEstrellas`, `idUsuario`) VALUES
(3, 3.9, 4),
(2, 3.7, 3),
(4, 2.8, 0),
(5, 1.3, 1),
(6, 2.5, 2),
(7, 1.4, 7),
(8, 1, 9),
(9, 1.3, 5),
(10, 1.8, 10),
(11, 2.2, 13),
(12, 2.4, 8),
(13, 1.2, 6),
(14, 1.7, 11),
(15, 1, 12);

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
(35, 'Artículos para animales', 8),
(36, 'Construcción', 9),
(37, 'Médicos', 9);

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
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `comentariosvendedor`
--

INSERT INTO `comentariosvendedor` (`idComentariosVendedor`, `comentario`, `idusuarioCalificador`, `idUsuarioCalificado`, `fechaRegistro`) VALUES
(1, 'Genial', 4, 0, '2020-05-17 12:00:00'),
(2, 'Me gusta.', 4, 3, '2020-05-18 17:06:12'),
(3, 'Buenos productos', 4, 3, '2020-05-20 19:17:12'),
(4, 'Deberia de poner más fotografias de algunos articulos', 2, 1, '0000-00-00 00:00:00'),
(5, 'Me han parecido excelentes algunos de tus articulos.', 2, 0, '0000-00-00 00:00:00'),
(6, 'Excelentes repuestos para coches.', 2, 7, '0000-00-00 00:00:00'),
(7, 'Me han gustado las bicicletas, espero sigas teniendo disponibles durante un tiempo.', 2, 5, '0000-00-00 00:00:00'),
(8, 'Me gusta el estilo de zapatos que ofreces.', 13, 2, '0000-00-00 00:00:00'),
(9, 'Puedo recomendar las lampras diagones, son excelentes, y se ven magnificas en las habitaciones.', 13, 1, '0000-00-00 00:00:00'),
(10, 'Los celulares que ofrece son bien comodos en cuanto a los precios que ofrece.', 13, 3, '0000-00-00 00:00:00'),
(11, 'Geniales trajes para hacer ejercicio.', 5, 2, '0000-00-00 00:00:00'),
(12, 'Es la primera vez que veo algunos de los celulares que ofreces.', 5, 3, '0000-00-00 00:00:00'),
(13, 'Que hermosos instrumentos!!', 1, 13, '0000-00-00 00:00:00'),
(14, 'Buenos utencilios para belleza, me gustan!!', 1, 11, '0000-00-00 00:00:00'),
(15, 'El colageno es un excelente producto para la piel, cien por ciento recomendado!', 1, 11, '0000-00-00 00:00:00'),
(16, 'Me han gustado muchos los diseños de los relojes que ofrece.', 1, 10, '0000-00-00 00:00:00'),
(17, 'Hermosos zapatos, deberias de ofrecer más variedad, estaré esperando por más.', 1, 2, '0000-00-00 00:00:00');

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `denuncias`
--

INSERT INTO `denuncias` (`idDenuncias`, `idrazonDenuncia`, `idAnuncios`, `comentarios`, `fechaRegistro`) VALUES
(1, 8, 58, 'Parece ser un articulo falso', '0000-00-00 00:00:00'),
(2, 8, 58, 'No es un artículo legítimo', '0000-00-00 00:00:00'),
(3, 8, 56, 'No es un artículo legítimo', '0000-00-00 00:00:00'),
(4, 8, 56, 'Parece no tener intención de vender una articulo pues no hay fotos, ni descripción del artículo', '0000-00-00 00:00:00'),
(5, 1, 75, 'Parece que los productos no los vende completos.', '0000-00-00 00:00:00'),
(6, 1, 75, 'Parece que le faltan piezas al producto que ofrece.', '0000-00-00 00:00:00');

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
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `favoritos`
--

INSERT INTO `favoritos` (`idFavoritos`, `idSeguidor`, `idSeguido`) VALUES
(1, 2, 0),
(2, 2, 7),
(3, 5, 13),
(4, 9, 13),
(5, 9, 10),
(6, 9, 8),
(7, 9, 7),
(8, 9, 5),
(9, 9, 2),
(10, 1, 13),
(11, 1, 11),
(12, 1, 10),
(13, 1, 2),
(14, 14, 0),
(15, 14, 1),
(16, 14, 2),
(17, 14, 12),
(19, 3, 10);

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
) ENGINE=MyISAM AUTO_INCREMENT=245 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `fotos`
--

INSERT INTO `fotos` (`idFotos`, `idAnuncios`, `nombre`, `localizacion`, `size`) VALUES
(244, 57, '3.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/3.jpg', 64779),
(237, 61, 'ps4.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/ps4.jpg', 26535),
(75, 69, '2.1.3.jpg', '../images/fotosAnuncio/lorenadiaz@gmail.com/2.1.3.jpg', 26090),
(73, 69, '2.1.1.jpg', '../images/fotosAnuncio/lorenadiaz@gmail.com/2.1.1.jpg', 148981),
(74, 69, '2.1.2.jpeg', '../images/fotosAnuncio/lorenadiaz@gmail.com/2.1.2.jpeg', 22248),
(241, 60, 'sm1.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/sm1.jpg', 71738),
(239, 60, 'sm2.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/sm2.jpg', 18044),
(61, 62, 'laptop.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/laptop.jpg', 408132),
(54, 62, 'laptop1.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/laptop1.jpg', 71738),
(62, 63, 'rx.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/rx.jpg', 859917),
(63, 63, 'rx1.jpg', '../images/fotosAnuncio/jaredcastro13@yahoo.es/rx1.jpg', 898090),
(66, 65, '5.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/5.jpg', 67278),
(67, 65, '6.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/6.jpg', 53671),
(68, 66, 'tv.webp', '../images/fotosAnuncio/lorenadiaz@gmail.com/tv.webp', 77540),
(69, 67, '8.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/8.jpg', 266115),
(70, 67, '9.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/9.jpg', 49091),
(71, 68, '11.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/11.jpg', 33539),
(72, 68, '10.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/10.jpg', 31790),
(76, 70, '2.2.1.jpg', '../images/fotosAnuncio/lorenadiaz@gmail.com/2.2.1.jpg', 349882),
(77, 70, '2.2.2.jpg', '../images/fotosAnuncio/lorenadiaz@gmail.com/2.2.2.jpg', 26815),
(78, 70, '2.2.3.png', '../images/fotosAnuncio/lorenadiaz@gmail.com/2.2.3.png', 227798),
(79, 71, '5.1.1.jpg', '../images/fotosAnuncio/lorenadiaz@gmail.com/5.1.1.jpg', 12418),
(80, 71, '5.1.2.webp', '../images/fotosAnuncio/lorenadiaz@gmail.com/5.1.2.webp', 5540),
(81, 71, '5.1.3.jpg', '../images/fotosAnuncio/lorenadiaz@gmail.com/5.1.3.jpg', 17231),
(82, 72, '4.1.1.png', '../images/fotosAnuncio/mago20@gmail.com/4.1.1.png', 989842),
(83, 72, '4.1.2.png', '../images/fotosAnuncio/mago20@gmail.com/4.1.2.png', 1049030),
(84, 73, '4.2.1.jpg', '../images/fotosAnuncio/mago20@gmail.com/4.2.1.jpg', 75661),
(85, 73, '4.2.2.jpg', '../images/fotosAnuncio/mago20@gmail.com/4.2.2.jpg', 39663),
(86, 73, '4.2.3.jpg', '../images/fotosAnuncio/mago20@gmail.com/4.2.3.jpg', 55371),
(87, 73, '4.2.4.jpg', '../images/fotosAnuncio/mago20@gmail.com/4.2.4.jpg', 32388),
(88, 74, '6.1.1.png', '../images/fotosAnuncio/mago20@gmail.com/6.1.1.png', 838816),
(89, 74, '6.1.2.png', '../images/fotosAnuncio/mago20@gmail.com/6.1.2.png', 195834),
(90, 74, '6.1.3.png', '../images/fotosAnuncio/mago20@gmail.com/6.1.3.png', 190994),
(91, 75, '6.2.1.jpg', '../images/fotosAnuncio/mago20@gmail.com/6.2.1.jpg', 72855),
(92, 76, '7.1.1.jpg', '../images/fotosAnuncio/mago20@gmail.com/7.1.1.jpg', 529072),
(93, 76, '7.1.2.jpg', '../images/fotosAnuncio/mago20@gmail.com/7.1.2.jpg', 307755),
(94, 76, '7.1.3.jpg', '../images/fotosAnuncio/mago20@gmail.com/7.1.3.jpg', 271969),
(95, 77, '7.2.1.jpg', '../images/fotosAnuncio/mago20@gmail.com/7.2.1.jpg', 30826),
(96, 77, '7.2.2.jpg', '../images/fotosAnuncio/mago20@gmail.com/7.2.2.jpg', 11880),
(97, 77, '7.2.3.jpg', '../images/fotosAnuncio/mago20@gmail.com/7.2.3.jpg', 18984),
(98, 77, '7.2.4.jpg', '../images/fotosAnuncio/mago20@gmail.com/7.2.4.jpg', 20327),
(99, 78, '8.1.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.1.1.jpg', 28211),
(100, 78, '8.1.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.1.2.jpg', 64360),
(101, 78, '8.1.3.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.1.3.jpg', 42560),
(102, 78, '8.1.4.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.1.4.jpg', 56433),
(103, 79, '8.2.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.2.1.jpg', 25918),
(104, 79, '8.2.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.2.2.jpg', 51853),
(105, 79, '8.2.3.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.2.3.jpg', 58252),
(106, 79, '8.2.4.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/8.2.4.jpg', 975500),
(107, 80, '9.1.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/9.1.1.jpg', 97565),
(108, 80, '9.1.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/9.1.2.jpg', 72419),
(109, 80, '9.1.3.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/9.1.3.jpg', 132292),
(110, 81, '9.2.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/9.2.1.jpg', 86033),
(111, 81, '9.2.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/9.2.2.jpg', 38404),
(112, 81, '9.2.3.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/9.2.3.jpg', 39674),
(113, 82, '10.1.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.1.1.jpg', 70326),
(114, 82, '10.1.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.1.2.jpg', 106692),
(115, 82, '10.1.3.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.1.3.jpg', 46559),
(116, 82, '10.1.4.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.1.4.jpg', 191699),
(117, 83, '10.2.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.2.1.jpg', 182614),
(118, 83, '10.2.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.2.2.jpg', 213802),
(119, 83, '10.2.3.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.2.3.jpg', 199629),
(120, 83, '10.2.4.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/10.2.4.jpg', 199358),
(121, 84, '11.1.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/11.1.1.jpg', 57156),
(122, 84, '11.1.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/11.1.2.jpg', 45728),
(123, 85, '11.2.1.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/11.2.1.jpg', 125385),
(124, 85, '11.2.2.jpg', '../images/fotosAnuncio/pmaynorpineda@yahoo.es/11.2.2.jpg', 42254),
(125, 86, '12.1.1.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/12.1.1.jpg', 330394),
(126, 86, '12.1.2.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/12.1.2.jpg', 361463),
(127, 87, '12.2.1.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/12.2.1.jpg', 251509),
(128, 87, '12.2.2.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/12.2.2.jpg', 270887),
(129, 87, '12.2.3.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/12.2.3.jpg', 225800),
(130, 87, '12.2.4.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/12.2.4.jpg', 245870),
(131, 88, '13.1.1.png', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.1.1.png', 410955),
(132, 88, '13.1.2.png', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.1.2.png', 314039),
(133, 88, '13.1.3.png', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.1.3.png', 619020),
(134, 88, '13.1.4.png', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.1.4.png', 348190),
(135, 89, '13.2.1.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.2.1.jpg', 212661),
(136, 89, '13.2.2.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.2.2.jpg', 223365),
(137, 89, '13.2.3.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.2.3.jpg', 195521),
(138, 89, '13.2.4.jpg', '../images/fotosAnuncio/rodri.jul@yahoo.es/13.2.4.jpg', 247658),
(139, 90, '14.1.1.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/14.1.1.jpg', 1061130),
(140, 90, '14.1.2.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/14.1.2.jpg', 1184490),
(141, 90, '14.1.3.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/14.1.3.jpg', 213543),
(142, 91, '14.2.1.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/14.2.1.jpg', 48247),
(143, 91, '14.2.2.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/14.2.2.jpg', 47595),
(144, 91, '14.2.3.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/14.2.3.jpg', 71759),
(145, 92, '15.1.1.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/15.1.1.jpg', 150348),
(146, 92, '15.1.2.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/15.1.2.jpg', 118414),
(147, 93, '15.2.1.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/15.2.1.jpg', 148261),
(148, 93, '15.2.2.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/15.2.2.jpg', 143580),
(149, 93, '15.2.3.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/15.2.3.jpg', 136669),
(150, 93, '15.2.4.jpg', '../images/fotosAnuncio/palacios.rob@gmail.com/15.2.4.jpg', 161411),
(151, 94, '16.1.1.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/16.1.1.jpg', 132443),
(152, 94, '16.1.2.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/16.1.2.jpg', 232070),
(153, 94, '16.1.3.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/16.1.3.jpg', 219505),
(154, 95, '16.2.1.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/16.2.1.jpg', 38708),
(155, 95, '16.2.2.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/16.2.2.jpg', 23586),
(156, 96, '17.1.1.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/17.1.1.jpg', 22294),
(157, 96, '17.1.2.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/17.1.2.jpg', 25642),
(158, 96, '17.1.3.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/17.1.3.jpg', 19646),
(159, 97, '17.2.1.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/17.2.1.jpg', 37662),
(160, 97, '17.2.2.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/17.2.2.jpg', 36774),
(161, 98, '19.1.1.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/19.1.1.jpg', 67774),
(162, 98, '19.1.2.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/19.1.2.jpg', 71316),
(163, 98, '19.1.3.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/19.1.3.jpg', 69862),
(164, 98, '19.1.4.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/19.1.4.jpg', 79864),
(165, 99, '19.2.1.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/19.2.1.jpg', 74110),
(166, 99, '19.2.2.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/19.2.2.jpg', 74210),
(167, 99, '19.2.3.jpg', '../images/fotosAnuncio/lobo_amen@yahoo.es/19.2.3.jpg', 78678),
(168, 100, '22.1.1.jpg', '../images/fotosAnuncio/phine_66@gmail.com/22.1.1.jpg', 75386),
(169, 100, '22.1.2.jpg', '../images/fotosAnuncio/phine_66@gmail.com/22.1.2.jpg', 29282),
(170, 100, '22.1.3.jpg', '../images/fotosAnuncio/phine_66@gmail.com/22.1.3.jpg', 42928),
(171, 101, '22.2.1.jpg', '../images/fotosAnuncio/phine_66@gmail.com/22.2.1.jpg', 9840),
(172, 101, '22.2.2.jpg', '../images/fotosAnuncio/phine_66@gmail.com/22.2.2.jpg', 47282),
(173, 101, '22.2.3.jpg', '../images/fotosAnuncio/phine_66@gmail.com/22.2.3.jpg', 28272),
(174, 101, '22.2.4.jpg', '../images/fotosAnuncio/phine_66@gmail.com/22.2.4.jpg', 18146),
(175, 102, '21.1.1.png', '../images/fotosAnuncio/car-man@yahoo.es/21.1.1.png', 512857),
(176, 102, '21.1.2.png', '../images/fotosAnuncio/car-man@yahoo.es/21.1.2.png', 519864),
(177, 102, '21.1.3.png', '../images/fotosAnuncio/car-man@yahoo.es/21.1.3.png', 419314),
(178, 102, '21.1.4.png', '../images/fotosAnuncio/car-man@yahoo.es/21.1.4.png', 505717),
(179, 103, '21.2.1.jpg', '../images/fotosAnuncio/car-man@yahoo.es/21.2.1.jpg', 305530),
(180, 103, '21.2.2.jpg', '../images/fotosAnuncio/car-man@yahoo.es/21.2.2.jpg', 161701),
(181, 103, '21.2.3.jpg', '../images/fotosAnuncio/car-man@yahoo.es/21.2.3.jpg', 125750),
(182, 103, '21.2.4.jpg', '../images/fotosAnuncio/car-man@yahoo.es/21.2.4.jpg', 118579),
(183, 104, '23.1.1.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/23.1.1.jpg', 8574),
(184, 104, '23.1.2.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/23.1.2.jpg', 15050),
(185, 104, '23.1.3.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/23.1.3.jpg', 67034),
(186, 104, '23.1.4.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/23.1.4.jpg', 54040),
(187, 105, '23.2.1.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/23.2.1.jpg', 40268),
(188, 105, '23.2.2.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/23.2.2.jpg', 9938),
(189, 105, '23.2.3.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/23.2.3.jpg', 41484),
(190, 106, '24.1.1.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/24.1.1.jpg', 160393),
(191, 106, '24.1.2.jpg', '../images/fotosAnuncio/salgado.emp@yahoo.com/24.1.2.jpg', 256807),
(192, 107, '24.2.1.png', '../images/fotosAnuncio/salgado.emp@yahoo.com/24.2.1.png', 1118700),
(193, 107, '24.2.2.png', '../images/fotosAnuncio/salgado.emp@yahoo.com/24.2.2.png', 1320840),
(194, 107, '24.2.3.png', '../images/fotosAnuncio/salgado.emp@yahoo.com/24.2.3.png', 1128020),
(195, 108, '25.1.1.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/25.1.1.jpg', 262998),
(196, 108, '25.1.2.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/25.1.2.jpg', 80927),
(197, 108, '25.1.3.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/25.1.3.jpg', 177693),
(198, 109, '25.2.1.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/25.2.1.jpg', 68072),
(199, 109, '25.2.2.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/25.2.2.jpg', 68452),
(200, 109, '25.2.3.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/25.2.3.jpg', 48874),
(201, 109, '25.2.4.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/25.2.4.jpg', 57609),
(202, 110, '26.1.1.png', '../images/fotosAnuncio/julia-ert@gmail.com/26.1.1.png', 376947),
(203, 110, '26.1.2.png', '../images/fotosAnuncio/julia-ert@gmail.com/26.1.2.png', 230409),
(204, 110, '26.1.3.png', '../images/fotosAnuncio/julia-ert@gmail.com/26.1.3.png', 190173),
(205, 111, '27.1.1.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/27.1.1.jpg', 78474),
(206, 111, '27.1.2.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/27.1.2.jpg', 64354),
(207, 111, '27.1.3.jpg', '../images/fotosAnuncio/julia-ert@gmail.com/27.1.3.jpg', 59135),
(208, 112, '28.1.1.jpg', '../images/fotosAnuncio/ardnaj.20@yahoo.com/28.1.1.jpg', 273804),
(209, 112, '28.1.2.jpg', '../images/fotosAnuncio/ardnaj.20@yahoo.com/28.1.2.jpg', 173859),
(210, 112, '28.1.3.jpg', '../images/fotosAnuncio/ardnaj.20@yahoo.com/28.1.3.jpg', 174638),
(211, 113, '28.2.1.jpg', '../images/fotosAnuncio/ardnaj.20@yahoo.com/28.2.1.jpg', 209342),
(212, 113, '28.2.2.jpg', '../images/fotosAnuncio/ardnaj.20@yahoo.com/28.2.2.jpg', 177550),
(213, 113, '28.2.3.jpg', '../images/fotosAnuncio/ardnaj.20@yahoo.com/28.2.3.jpg', 146751),
(214, 113, '28.2.4.jpg', '../images/fotosAnuncio/ardnaj.20@yahoo.com/28.2.4.jpg', 157766),
(215, 114, '20.1.1.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/20.1.1.jpg', 132333),
(216, 114, '20.1.2.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/20.1.2.jpg', 647087),
(217, 114, '20.1.3.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/20.1.3.jpg', 202522),
(218, 115, '20.2.1.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/20.2.1.jpg', 109280),
(219, 115, '20.2.2.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/20.2.2.jpg', 186580),
(220, 115, '20.2.3.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/20.2.3.jpg', 208533),
(221, 115, '20.2.4.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/20.2.4.jpg', 164455),
(222, 116, '29.1.1.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.1.1.jpg', 87326),
(223, 116, '29.1.2.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.1.2.jpg', 40690),
(224, 116, '29.1.3.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.1.3.jpg', 89533),
(225, 116, '29.1.4.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.1.4.jpg', 139072),
(226, 117, '29.2.1.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.2.1.jpg', 37112),
(227, 117, '29.2.2.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.2.2.jpg', 19164),
(228, 117, '29.2.3.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.2.3.jpg', 22401),
(229, 117, '29.2.4.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/29.2.4.jpg', 37443),
(230, 118, '30.1.1.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/30.1.1.jpg', 20997),
(231, 119, '30.2.1.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/30.2.1.jpg', 41795),
(232, 119, '30.2.2.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/30.2.2.jpg', 31810),
(233, 119, '30.2.3.jpg', '../images/fotosAnuncio/sargento9098@gmail.com/30.2.3.jpg', 44092),
(242, 57, 'iphone2.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/iphone2.jpg', 56583),
(238, 61, 'ps41.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/ps41.jpg', 142612),
(240, 60, 'sm3.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/sm3.jpg', 10216),
(243, 57, 'iphonex.jpg', '../images/fotosAnuncio/sbethuell@gmail.com/iphonex.jpg', 270241);

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
(8, 'Otras categorías'),
(9, 'Servicios');

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
-- Estructura de tabla para la tabla `razonborrado`
--

DROP TABLE IF EXISTS `razonborrado`;
CREATE TABLE IF NOT EXISTS `razonborrado` (
  `idRazon` int(11) NOT NULL AUTO_INCREMENT,
  `razon` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL,
  `fechaBorrado` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idRazon`),
  UNIQUE KEY `idRazon` (`idRazon`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `razonborrado`
--

INSERT INTO `razonborrado` (`idRazon`, `razon`, `fechaBorrado`) VALUES
(5, 'Vendido', '2020-05-15 04:52:08'),
(6, 'Vendido', '2020-05-16 04:52:08'),
(7, 'Vendido', '2020-05-15 04:52:08'),
(8, 'Vendido', '2020-05-18 04:52:08'),
(9, 'Vendido', '2020-05-18 04:52:08'),
(10, 'Cambié de parecer, no quiero ponerlo en venta', '2020-05-17 04:52:08'),
(11, 'Cambié de parecer, no quiero ponerlo en venta', '2020-05-17 04:52:08'),
(12, 'Cambié de parecer, no quiero ponerlo en venta', '2020-05-17 04:52:08'),
(13, 'Cambié de parecer, no quiero ponerlo en venta', '2020-05-17 04:52:08'),
(14, 'Cambié de parecer, no quiero ponerlo en venta', '2020-05-17 04:52:08'),
(15, 'Porque quiero', '2020-05-17 04:52:08'),
(16, 'Otra razón', '2020-05-17 04:52:08'),
(17, 'Porque quiero', '2020-05-17 04:52:08'),
(18, 'Otra razón', '2020-05-17 04:52:08'),
(19, 'Porque quiero', '2020-05-17 04:52:08'),
(20, 'Otra razón', '2020-05-17 04:52:08'),
(21, 'Porque quiero', '2020-05-17 04:52:08'),
(22, 'Otra razón', '2020-05-17 04:52:08'),
(23, 'Porque quiero', '2020-05-17 04:52:08'),
(24, 'Otra razón', '2020-05-17 04:52:08');

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
(4, 2, 110, 'Jared', 'Castro', 'jaredcastro13@yahoo.es', 'asd123', NULL, ' 504 9858-00-12', '2020-03-30', '1995-10-03', '', '../images/imgUsuarios/5e97defbe9b51user.jpg', 1),
(0, 2, 6, 'Lorena', 'Diaz', 'lorenadiaz@gmail.com', 'lore-d', NULL, '504 9698-30-41', '2019-01-10', '1992-08-34', NULL, '../images/imgUsuarios/user.png', 1),
(1, 2, 24, 'Margot', 'Gomez', 'mago20@gmail.com', 'ma.go20', NULL, '504 3331-20-21', '2019-02-14', '1996-11-29', NULL, '../images/imgUsuarios/user.png', 1),
(5, 2, 32, 'Julio', 'Rodríguez', 'rodri.jul@yahoo.es', 'july34_90', NULL, '504 3460-20-10', '2019-03-26', '1984-12-20', NULL, '../images/imgUsuarios/user.png', 1),
(6, 2, 40, 'Roberto', 'Palacios', 'palacios.rob@gmail.com', 'rob2141', NULL, '504 3232-96-80', '2019-04-30', '1987-11-07', NULL, '../images/imgUsuarios/user.png', 1),
(7, 2, 56, 'Carmen', 'Villalobos', 'lobo_amen@yahoo.es', 'loba4464', NULL, '504 9878-66-44', '2019-05-08', '1988-06-16', NULL, '../images/imgUsuarios/user.png', 1),
(8, 2, 66, 'Seraphine', 'Santos', 'phine_66@gmail.com', 'ser.tos_5456', NULL, '504 3112-15-16', '2019-06-28', '1974-06-30', NULL, '../images/imgUsuarios/user.png', 1),
(9, 2, 78, 'Oscar', 'Martinez', 'car-man@yahoo.es', 'godzilla.30', NULL, '504 9668-71-31', '2019-07-24', '1986-04-27', NULL, '../images/imgUsuarios/user.png', 1),
(10, 2, 88, 'Santiago', 'Salgado', 'salgado.emp@yahoo.com', 'pren.salsan21', NULL, '504 3354-48-88', '2019-08-22', '1990-06-27', NULL, '../images/imgUsuarios/user.png', 1),
(11, 2, 94, 'Julia', 'Robert', 'julia-ert@gmail.com', 'rob_aa.30', NULL, '504 9669-70-08', '2019-09-04', '1999-09-19', NULL, '../images/imgUsuarios/user.png', 1),
(12, 2, 108, 'Alejandra', 'Canales', 'ardnaj.20@yahoo.com', 'esla.dra-12', NULL, '504 3333-20-20', '2019-10-29', '1980-12-16', NULL, '../images/imgUsuarios/user.png', 1),
(13, 2, 122, 'Robert', 'Sarmiento', 'sargento9098@gmail.com', 'sarmi_rob.44', NULL, '504 3130-76-58', '2019-11-14', '1995-12-26', NULL, '../images/imgUsuarios/user.png', 1),
(14, 2, 136, 'Gissel', 'Lopez', 'gisselo16@gmail.com', 'selogi.16', NULL, '504 9897-34-76', '2019-12-24', '1990-11-23', NULL, '../images/imgUsuarios/user.png', 1),
(15, 2, 148, 'Daniela', 'Gutierrez', 'rrez.dani@yahoo.es', 'ela.rex-11', NULL, '504 3345-56-67', '2020-01-16', '1997-04-27', NULL, '../images/imgUsuarios/user.png', 1),
(16, 2, 188, 'Cinthya', 'Morales', 'morita-c@gmail.com', 'leh-45.m', NULL, '504 9594-43-23', '2020-02-21', '1988-07-17', NULL, '../images/imgUsuarios/user.png', 1);

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

DELIMITER $$
--
-- Eventos
--
DROP EVENT `BORRADO_PUBLICACIONES`$$
CREATE DEFINER=`root`@`localhost` EVENT `BORRADO_PUBLICACIONES` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-17 23:57:01' ON COMPLETION NOT PRESERVE ENABLE DO call SP_DURACION_PUBLICACIONES()$$

DROP EVENT `BORRADO_PUBLICACIONES_FLIMITE`$$
CREATE DEFINER=`root`@`localhost` EVENT `BORRADO_PUBLICACIONES_FLIMITE` ON SCHEDULE EVERY 1 DAY STARTS '2020-05-17 23:50:00' ON COMPLETION NOT PRESERVE ENABLE DO call SP_ELIMINAR_PUBLICACIONES_FLIMITE()$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
