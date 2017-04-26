SELECT nom, prenom FROM fiche_personne
WHERE nom RLIKE '-' OR prenom RLIKE '-'
ORDER BY nom, prenom;
