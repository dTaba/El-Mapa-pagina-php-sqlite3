CREATE TABLE celda (
	x INT NOT NULL,
	y INT NOT NULL,
	color INT NOT NULL
);

CREATE UNIQUE INDEX celda_yx
ON celda(y, x);

CREATE VIEW mapa(x, y, color)
AS
	SELECT x, y, color FROM celda ORDER BY y, x;
