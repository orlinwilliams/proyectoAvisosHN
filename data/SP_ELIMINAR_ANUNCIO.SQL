CREATE PROCEDURE SP_ELIMINAR_ANUNCIO(
    IN  pnIdAnuncio      INT,
    IN  pnIdUsuario       INT,
    OUT pcMensaje        VARCHAR(500)
)
SP:BEGIN
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