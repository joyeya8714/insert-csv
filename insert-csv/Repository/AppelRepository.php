<?php

require_once(ROOT . 'Repository/Repository.php');

class AppelRepository extends Repository
{

    /**
     * @param AppelEntity $appel
     * @return bool
     */
    public function insert(AppelEntity $appel): bool
    {
        try {
            $this->dbh->beginTransaction();

            $objectData = [
                $appel->getDate(),
                $appel->getHeure(),
                $appel->getDureeReelle(),
                $appel->getDureeFacturee(),
                $appel->getNumeroAbonne(),
                $appel->getType(),
            ];
            $values = implode(',', $objectData);
            $sql = "INSERT INTO " . $appel->getTableName() . "
                (
                    apl_date,
                    apl_heure,
                    apl_duree_reelle,
                    apl_duree_facture,
                    apl_numero_abonne,
                    apl_type
                ) VALUES (" . $values . ")";
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $this->dbh->commit();
            $isInserted = true;
        } catch (Exception $e) {
            $this->dbh->rollBack();
            $isInserted = false;
        }

        return $isInserted;
    }

    /**
     * @param array $appels
     * @return bool
     */
    public function multipleInsert(array $appels): bool
    {
        try {
            $values = '';
            $this->dbh->beginTransaction();
            foreach ($appels as $key => $appel) {
                $objectData = [
                    $appel->getDate(),
                    $appel->getHeure(),
                    $appel->getDureeReelle(),
                    $appel->getDureeFacturee(),
                    $appel->getNumeroAbonne(),
                    $appel->getType(),
                ];
                $values .= "(" . implode(',', $objectData) . ")";
                if (array_key_last($appels) !== $key) {
                    $values .= ",";
                }
            }
            $sql = "INSERT INTO " . $appel->getTableName() . "
                (
                    apl_date,
                    apl_heure,
                    apl_duree_reelle,
                    apl_duree_facture,
                    apl_numero_abonne,
                    apl_type
                ) VALUES " . $values . ";";
            $query = $this->dbh->prepare($sql);
            $query->execute();
            $this->dbh->commit();
            $isInserted = true;
        } catch (PDOException $e) {
            $this->dbh->rollBack();
            $isInserted = false;
        }

        return $isInserted;
    }

    /**
     * @param string $date
     * @return int
     */
    public function queryTotalTimeAllCallsSinceGivenDateIncluded(string $date): ?int
    {
        $sql = sprintf("
            SELECT SUM(csv_parser.apl_appel.apl_duree_reelle) AS \"total_time\"
            FROM csv_parser.apl_appel
            WHERE csv_parser.apl_appel.apl_type = 'AUTRES' AND csv_parser.apl_appel.apl_date >= '%s';", $date);
        $query = $this->dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch();

        return !empty($result) && isset($result['total_time']) ? reset($result) : 0;
    }

    /**
     * @return int|null
     */
    public function queryTotalNumberOfSms(): ?int
    {
        $sql = "SELECT COUNT(csv_parser.apl_appel.apl_id) AS \"total_number\"
            FROM csv_parser.apl_appel
            WHERE csv_parser.apl_appel.apl_type = 'SMS';";
        $query = $this->dbh->prepare($sql);
        $query->execute();
        $result = $query->fetch();

        return !empty($result) && isset($result['total_number']) ? reset($result) : 0;
    }

    /**
     * @return array
     */
    public function queryTopTenDataBilledBySubscriber(): array
    {
        $sql = "SELECT csv_parser.apl_appel.apl_numero_abonne AS \"numero_abonne\", SUM(csv_parser.apl_appel.apl_duree_facture) AS \"duree_facturee\"
            FROM csv_parser.apl_appel
            WHERE csv_parser.apl_appel.apl_heure > '18:00:00' OR csv_parser.apl_appel.apl_heure < '08:00:00'
            GROUP BY csv_parser.apl_appel.apl_numero_abonne
            ORDER BY SUM(csv_parser.apl_appel.apl_duree_facture) DESC
            LIMIT 10;";
        $query = $this->dbh->prepare($sql);
        $query->execute();

        return $query->fetchAll();
    }

    /**
     * @return bool
     */
    public function truncateTable(): bool
    {
        $sql = "TRUNCATE csv_parser.apl_appel;";
        $query = $this->dbh->prepare($sql);

        return $query->execute();
    }
}