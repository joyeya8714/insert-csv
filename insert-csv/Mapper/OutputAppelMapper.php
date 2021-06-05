<?php

class OutputAppelMapper
{
    /**
     * @param array $validatedData
     * @param AppelEntity $appel
     * @return AppelEntity
     */
    public function map(array $validatedData, AppelEntity $appel): AppelEntity
    {
        $appel->setDate($validatedData['date']);
        $appel->setHeure($validatedData['heure']);
        $appel->setDureeFacturee($validatedData['dureeFacturee']);
        $appel->setDureeReelle($validatedData['dureeReelle']);
        $appel->setNumeroAbonne($validatedData['numeroAbonne']);
        $appel->setType($validatedData['type']);

        return $appel;
    }
}