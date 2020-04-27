DELIMITER $$
CREATE PROCEDURE SP_CALIFICACION_VENDEDOR(
    IN pnIdAnuncio INT,
    OUT MensajeError VARCHAR(200)
)
SP:BEGIN
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