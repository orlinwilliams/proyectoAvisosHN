DELIMITER $$
CREATE PROCEDURE SP_EDITAR_USUARIO(
IN		pnIdUsuario		            INT,
IN		pcContraseniaActual	        VARCHAR(45),
IN		pcContraseniaNueva	        VARCHAR(45),
OUT		pbOcurrioError		        BOOLEAN,
OUT		pcMensaje		            VARCHAR(45)
)        
SP:BEGIN
     DECLARE vnIdUsuario INT;
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

IF pcContraseniaActual=pcContraseniaNueva THEN
                SET pcMensaje = 'Contraseña Nueva es igual a contraseña Actual';
                 LEAVE SP;
END if;


SELECT u.idUsuario INTO vnIdUsuario FROM usuario u
                WHERE c.idUsuario=pnIdUsuario;
UPDATE usuario
SET 	contrasenia=pcContraseniaNueva
	WHERE idUsuario= vnIdUsuario;
COMMIT;
                        SET pcMensaje = 'Contraseña nueva agregada con exito.';
                        SET pbOcurrioError = FALSE;
                        LEAVE SP;

END$$
