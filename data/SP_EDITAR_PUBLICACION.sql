DELIMITER $$
CREATE PROCEDURE SP_EDITAR_ANUNCIO(
IN      pnIdAnuncios        INT,  
IN		pnIdUsuario		    INT,
IN		pcCategoria         VARCHAR(45),
IN		pnPrecio	        INT,
IN		pcNombreArticulo    VARCHAR(45),
IN		pcDescripcion	    VARCHAR(45),
IN		pcEstado		    VARCHAR(45),
OUT		pbOcurrioError		BOOLEAN,
OUT		pcMensaje		    VARCHAR(45)
)
SP:BEGIN
    DECLARE  vnConteo, vnIdUsuario, vnIdCategoria, vnIdAnuncios INT;
    DECLARE tempMensaje VARCHAR (2000);
SET autocommit=0;
START TRANSACTION;
SET tempMensaje='';
SET pbOcurrioError=TRUE;

IF pcNombreArticulo = '' OR pcNombreArticulo  IS NULL THEN
    SET tempMensaje= 'Nombre del articulo, ';
END IF;

IF pcCategoria = '' OR pcCategoria  IS NULL THEN
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
WHERE c.nombreCategoria=pcCategoria;

UPDATE anuncios SET idcategoria= vnIdCategoria, Nombre= pcNombreArticulo, precio=pnPrecio, descripcion=pcDescripcion, estadoArticulo=pcEstado
    WHERE idUsuario= vnIdUsuario and idAnuncios=vnIdAnuncios;
COMMIT;
SET pcMensaje = 'Anuncio  actualizado con exito.';
SET pbOcurrioError = FALSE;
LEAVE SP;
END$$