DELIMITER $$ 
CREATE PROCEDURE SP_ELIMINAR_USUARIO(
  
    IN      pnIdUsuario         INT,
    IN      pcContrasenia        VARCHAR(50),
    OUT     pbOcurrioError       BOOLEAN,
    OUT     pcMensaje      VARCHAR(1000)

 )
 SP:BEGIN
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
