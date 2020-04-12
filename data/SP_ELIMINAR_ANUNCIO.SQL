CREATE OR REPLACE SP_ELIMINAR_ANUNCIO(
    IN  pnIdAnuncio      INT;
    OUT pcMensaje        VARCHAR(500);
)
SP:BEGIN
    DECLARE vnConteo INT;
    DECLARE pcMensajeTemp VARCHAR(500);
    SET AUTOCOMMIT = 0;
    START TRANSACTION;
    SET pcMensajeTemp='';

    IF pcNombreArticulo = '' OR pcNombreArticulo  IS NULL THEN
        SET pcMensajeTemp= 'ID del articulo';
    END IF;