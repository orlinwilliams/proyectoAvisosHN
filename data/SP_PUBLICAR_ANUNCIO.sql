DELIMITER $$
DROP PROCEDURE IF EXISTS `SP_PUBLICAR_ANUNCIO`$$
CREATE PROCEDURE `SP_PUBLICAR_ANUNCIO` (
    IN `pcidUsuario` INT, 
    IN `pcCategoria` INT, 
    IN `pcMunicipios` INT, 
    IN `pcNombreArticulo` VARCHAR(50), 
    IN `pcPrecio` VARCHAR(200), 
    IN `pcEstado` VARCHAR(10), 
    IN `pcDescripcion` VARCHAR(200), 
    OUT `pcMensaje` VARCHAR(300))  
    
    SP:BEGIN

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

    IF pcMunicipios= "" OR pcMunicipios IS NULL THEN
		SET pcMunicipios = (SELECT idMunicipios FROM municipios WHERE idMunicipios=(SELECT idMunicipios FROM usuario WHERE idUsuario=pcidUsuario));
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