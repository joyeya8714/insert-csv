/* Reel total time of calls since 15/02/2012 included */
SELECT SUM(csv_parser.apl_appel.apl_duree_reelle) AS "Durée totale réelle"
FROM csv_parser.apl_appel
WHERE csv_parser.apl_appel.apl_type = 'AUTRES' AND csv_parser.apl_appel.apl_date >= '2012-02-15';

/* Amount of all sms without filtering any date */
SELECT COUNT(csv_parser.apl_appel.apl_id)
FROM csv_parser.apl_appel
WHERE csv_parser.apl_appel.apl_type = 'SMS';

/* Top 10*/
SELECT csv_parser.apl_appel.apl_numero_abonne, SUM(csv_parser.apl_appel.apl_duree_facture) AS "duree_facturee"
FROM csv_parser.apl_appel
WHERE csv_parser.apl_appel.apl_heure > '18:00:00' OR csv_parser.apl_appel.apl_heure < '08:00:00'
GROUP BY csv_parser.apl_appel.apl_numero_abonne
ORDER BY SUM(csv_parser.apl_appel.apl_duree_facture) DESC
LIMIT 10;