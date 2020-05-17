DROP PROCEDURE IF EXISTS SP_ELIMINAR_PUBLICACIONES_FLIMITE;
                    CREATE PROCEDURE SP_ELIMINAR_PUBLICACIONES_FLIMITE(
                        OUT     pcMensaje      VARCHAR(1000)
                    )
                    SP:BEGIN
                        
                        DELETE FROM calificacionanuncio
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d'));
                    
                        DELETE FROM denuncias
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d'));
                    
                        DELETE FROM fotos
                        WHERE idAnuncios IN (SELECT idAnuncios FROM anuncios WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d'));
                    
                        DELETE FROM anuncios
                        WHERE DATE_FORMAT(fechaLimite, '%Y-%m-%d')=DATE_FORMAT(CURDATE(), '%Y-%m-%d');
                        
                        SET pcMensaje = 'las publicaciones han expirado';
                    
                        LEAVE SP;
                    
                    END;