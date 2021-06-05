<?php

class AppelEntity
{
    /**
     * @var int $id
     */
    public int $id;

    /**
     * @var $date
     */
    public $date;

    /**
     * @var $heure
     */
    public $heure;

    /**
     * @var $dureeReelle
     */
    public $dureeReelle;

    /**
     * @var $dureeFacturee
     */
    public $dureeFacturee;

    /**
     * @var $numeroAbonne
     */
    public $numeroAbonne;

    /**
     * @var string $type
     */
    public string $type;

    /**
     * @var string $tableName
     */
    private string $tableName;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->tableName;
    }

    /**
     * @param string $tableName
     */
    public function setTableName(string $tableName): void
    {
        $this->tableName = $tableName;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }


    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    /**
     * @return mixed
     */
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * @param mixed $heure
     */
    public function setHeure($heure): void
    {
        $this->heure = $heure;
    }

    /**
     * @return mixed
     */
    public function getDureeReelle()
    {
        return $this->dureeReelle;
    }

    /**
     * @param mixed $dureeReelle
     */
    public function setDureeReelle($dureeReelle): void
    {
        $this->dureeReelle = $dureeReelle;
    }

    /**
     * @return mixed
     */
    public function getDureeFacturee()
    {
        return $this->dureeFacturee;
    }

    /**
     * @param mixed $dureeFacturee
     */
    public function setDureeFacturee($dureeFacturee): void
    {
        $this->dureeFacturee = $dureeFacturee;
    }

    /**
     * @return mixed
     */
    public function getNumeroAbonne()
    {
        return $this->numeroAbonne;
    }

    /**
     * @param mixed $numeroAbonne
     */
    public function setNumeroAbonne($numeroAbonne): void
    {
        $this->numeroAbonne = $numeroAbonne;
    }

    public function __construct()
    {
        $this->setTableName("apl_appel");
    }
}