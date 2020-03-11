DELIMITER $$
CREATE PROCEDURE SP_EDITAR_USUARIO(
IN		pnIdUsuario		    INT,
IN		pcNombre	       VARCHAR(45),
IN		pcApellido	        VARCHAR(45),
IN		pdFechaNacimiento	VARCHAR(45),
IN		pcCorreo		    VARCHAR(45),
IN		pnTelefono		    VARCHAR(45),
IN		pcMunicipio		    VARCHAR(45),
IN		pcRTN			    VARCHAR(45),
IN		pcRutaImagen		VARCHAR(45),
OUT		pbOcurrioError		BOOLEAN,
OUT		pcMensaje		    VARCHAR(45)
)        
SP:BEGIN
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

SELECT COUNT(*) INTO vnConteo FROM usuario u
                WHERE c.idUsuario=pnIdUsuario;
     IF vnConteo = 0 THEN
                SET pcMensaje = 'Usuario no existe';
                 LEAVE SP;
     END if;
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
	    pNombre= pcNombre,
	    pApellido=pcApellido,
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
