CREATE OR REPLACE VIEW PUBLICACIONES_ANIO AS
    SELECT COUNT(idAnuncios) as publicaciones, CASE MONTH(fechaPublicacion)
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
    END mes
    FROM anuncios
    WHERE YEAR(fechaPublicacion)=YEAR(CURDATE())
    GROUP BY mes
    ORDER by fechaPublicacion;

CREATE OR REPLACE VIEW PUBLICACIONES_CATEGORIA AS
    SELECT COUNT(*) as publicaciones, nombregrupo
    FROM anuncios
    INNER JOIN categoria ON categoria.idCategoria=anuncios.idCategoria
    INNER JOIN grupoCategoria ON grupoCategoria.idgrupocategoria=categoria.idgrupocategoria
    WHERE YEAR(fechaPublicacion)=YEAR(CURDATE())
    GROUP BY nombregrupo
    ORDER by nombregrupo;

CREATE OR REPLACE VIEW PUBLICACIONES_LUGAR AS
    SELECT COUNT(*) as publicaciones, nombreDepartamento
    FROM anuncios
    INNER JOIN municipios ON municipios.idMunicipios=anuncios.idMunicipios
    INNER JOIN departamentos ON departamentos.idDepartamentos=municipios.idDepartamentos
    WHERE YEAR(fechaPublicacion)=YEAR(CURDATE())
    GROUP BY nombreDepartamento
    ORDER by nombreDepartamento;

CREATE OR REPLACE VIEW USUARIOS_MES AS
    SELECT COUNT(idUsuario) as publicaciones, CASE MONTH(fechaRegistro)
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
    END mes
    FROM usuario
    WHERE YEAR(fechaRegistro)=YEAR(CURDATE()) AND estado=1
    GROUP BY mes
    ORDER by fechaRegistro;