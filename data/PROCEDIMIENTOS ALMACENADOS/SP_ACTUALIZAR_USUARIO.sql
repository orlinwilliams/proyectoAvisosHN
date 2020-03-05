DELIMITER $$
CREATE PROCEDURE SP_ACTUALIZAR_USUARIO(
IN		pnIdUsuario		    INT,
IN		pcPrimerNombre	    VARCHAR(45),
IN		pcPrimerApellido	VARCHAR(45),
IN		pdFechaNacimiento	DATE,
IN		pcCorreo		    VARCHAR(45),
IN		pnTelefono		    VARCHAR(45),
IN		pcMunicipio		    VARCHAR(45),
IN		pcRTN			    VARCHAR(45),
IN		pcContrasenia		VARCHAR(45),
IN		pcRutaImagen		VARCHAR(45),
OUT		pbOcurrioError		BOOLEAN,
OUT		pcMensaje		    VARCHAR(45)
)        
SP:BEGIN
     DECLARE vnIdUsuario, vnConteo, vnIdTipoUsuario,vnIdMunicipio INT;
	DECLARE	vnFechaRegistro DATE;
     DECLARE tempMensaje VARCHAR(2000);
     SET autocommit=0;
	START TRANSACTION;
	SET tempMensaje='';
	SET pbOcurrioError=TRUE;

IF pcPrimerNombre = '' OR pcPrimerNombre  IS NULL THEN
                    SET tempMensaje = 'Primer nombre, ';
                END IF;
 IF pcPrimerApellido = '' OR pcPrimerApellido IS NULL THEN
                    SET tempMensaje = CONCAT(tempMensaje,'primer apellido, ');
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
IF pcRTN = '' OR pcRTN IS NULL THEN
                    SET tempMensaje = CONCAT(tempMensaje,'identidad, ');
                END IF;              
IF pcContrasenia = '' OR pcContrasenia IS NULL THEN
                    SET tempMensaje = CONCAT(tempMensaje,'contrasenia, ');
                END IF;
IF pcRutaImagen = '' OR pcRutaImagen IS NULL THEN
                    SET tempMensaje = CONCAT(tempMensaje,'ruta de la imagen, ');
                END IF;
IF tempMensaje <> '' THEN
                    SET pcMensaje = CONCAT('Faltan los siguientes campos: ', tempMensaje);
                    LEAVE SP;
                END IF;

/*SELECCIONARA EL USUARIO POR SU ID*/
IF pnIdUsuario = '' OR pnIdUsuario IS NULL THEN
                    SET tempMensaje =  'idUsuario, ';
                END IF;

SELECT u.idUsuario INTO vnIdUsuario FROM usuario u
                WHERE c.idUsuario=pnIdUsuario;


SELECT tu.idtipoUsuario INTO vnIdTipoUsuario FROM usuario u
INNER JOIN tipousuario tu ON tu.idtipoUsuario=u.idtipoUsuario
WHERE u.idUsuario=pnIdUsuario;

SELECT m.idMunicipios INTO vnIdMunicipio FROM municipios m
WHERE m.municipio=pcMunicipio;

SELECT u.fechaRegistro INTO vnFechaRegistro FROM usuario u
WHERE u.idUsuario=vnIdUsuario;

UPDATE usuario
SET 	idtipoUsuario=vnIdTipoUsuario,
	idMunicipio=vnIdMunicipio,
	pNombre= pcPrimerNombre,
	pApellido=pcPrimerApellido,
	correoElectronico=pcCorreo,
	numTelefono=pnTelefono,
	fechaRegistro=vnFechaRegistro,
	fechaNacimiento=pdFechaNacimiento,
	RTN=pcRTN,
		urlFoto=pcRutaImagen
	WHERE idUsuario= vnIdUsuario;
COMMIT;
                        SET pcMensaje = 'Usuario  actualizado con exito.';
                        SET pbOcurrioError = FALSE;
                        LEAVE SP;

END$$
