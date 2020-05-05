CREATE OR REPLACE VIEW PUBLICACIONES_ANIO AS
    SELECT CASE MONTH(fechaPublicacion)
    WHEN 1 THEN 'Enero'
    WHEN 2 THEN 'Febrero'
    WHEN 3 THEN 'Marzo'
    WHEN 4 THEN 'Abril'
    WHEN 5 THEN 'Mayo'
    WHEN 6 THEN 'Junio'
    WHEN 7 THEN 'Julio'
    WHEN 8 THEN 'Agosto'
    WHEN 9 THEN 'Septiembre'
    WHEN 10 THEN 'Octubre'
    WHEN 11 THEN 'Noviembre'
    WHEN 12 THEN 'Diciembre'
    END mes, COUNT(*) as publicaciones
    FROM anuncios
    WHERE YEAR(fechaPublicacion)=YEAR(CURDATE())
    GROUP BY mes
    ORDER BY fechaPublicacion ASC;

CREATE OR REPLACE VIEW PUBLICACIONES_CATEGORIA AS
    SELECT nombregrupo, COUNT(*) as publicaciones
    FROM anuncios
    INNER JOIN categoria ON categoria.idCategoria=anuncios.idCategoria
    INNER JOIN grupoCategoria ON grupoCategoria.idgrupocategoria=categoria.idgrupocategoria
    WHERE YEAR(fechaPublicacion)=YEAR(CURDATE())
    GROUP BY nombregrupo
    ORDER by nombregrupo ASC;

CREATE OR REPLACE VIEW PUBLICACIONES_LUGAR AS
    SELECT nombreDepartamento, COUNT(*) as publicaciones
    FROM anuncios
    INNER JOIN municipios ON municipios.idMunicipios=anuncios.idMunicipios
    INNER JOIN departamentos ON departamentos.idDepartamentos=municipios.idDepartamentos
    WHERE YEAR(fechaPublicacion)=YEAR(CURDATE())
    GROUP BY nombreDepartamento
    ORDER by departamentos.idDepartamentos ASC;

CREATE OR REPLACE VIEW USUARIOS_MES AS
    SELECT CASE MONTH(fechaRegistro)
    WHEN 1 THEN 'Enero'
    WHEN 2 THEN 'Febrero'
    WHEN 3 THEN 'Marzo'
    WHEN 4 THEN 'Abril'
    WHEN 5 THEN 'Mayo'
    WHEN 6 THEN 'Junio'
    WHEN 7 THEN 'Julio'
    WHEN 8 THEN 'Agosto'
    WHEN 9 THEN 'Septiembre'
    WHEN 10 THEN 'Octubre'
    WHEN 11 THEN 'Noviembre'
    WHEN 12 THEN 'Diciembre'
    END mes, COUNT(idUsuario) as publicaciones
    FROM usuario
    WHERE YEAR(fechaRegistro)=YEAR(CURDATE()) AND estado=1
    GROUP BY mes
    ORDER by fechaRegistro ASC;