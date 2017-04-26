SELECT count(historique_membre.date) AS 'films' FROM historique_membre
WHERE (historique_membre.date >='2006-10-30 00:00:00' AND historique_membre.date < '2007-07-28 00:00:00')
OR (day(historique_membre.date) = 24 AND month(historique_membre.date) = 12);
