SELECT titre, resum FROM film
WHERE titre RLIKE '42' OR resum RLIKE '42'
ORDER BY duree_min;
