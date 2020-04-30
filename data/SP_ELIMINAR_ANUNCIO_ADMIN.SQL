DELIMITER $$
DROP PROCEDURE IF EXISTS SP_ELIMINAR_ANUNCIO_ADMIN$$
CREATE PROCEDURE SP_ELIMINAR_ANUNCIO_ADMIN(
    IN      pnIdUsuario          INT,
    OUT     pbOcurrioError       BOOLEAN,
    OUT     pcMensaje      VARCHAR(1000)
 )
 SP:BEGIN
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