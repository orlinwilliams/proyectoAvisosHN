DELIMITER $$
DROP PROCEDURE IF EXISTS SP_DURACION_PUBLICACIONES$$
CREATE PROCEDURE SP_DURACION_PUBLICACIONES(
   
    OUT     pcMensaje      VARCHAR(1000)

 )
 SP:BEGIN
    
    DELETE FROM calificacionanuncio
    WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATEDIFF(CURDATE(), fechaPublicacion)>14);

    DELETE FROM denuncias
    WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATEDIFF(CURDATE(), fechaPublicacion)>14);

    DELETE FROM fotos
    WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATEDIFF(CURDATE(), fechaPublicacion)>14);

    DELETE FROM anuncios
    WHERE DATEDIFF(CURDATE(), fechaPublicacion)>14;
      
    SET pcMensaje = 'las publicaciones han expirado';

    LEAVE SP;

 END$$



   