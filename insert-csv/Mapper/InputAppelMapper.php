<?php

class InputAppelMapper
{
    /**
     * @param string $row
     * @return array
     */
    private function splitRowAsColumns(string $row): array
    {
        return explode(';', $row);
    }

    /**
     * @param string $row
     * @return array|string[]
     */
    public function map(string $row): array
    {
        $rowData = $this->splitRowAsColumns($row);

        return [
            'date' => $rowData[3] ?? 'null',
            'heure' => $rowData[4] ?? 'null',
            'dureeFacturee' => $rowData[6] ?? 'null',
            'dureeReelle' => $rowData[5] ?? 'null',
            'numeroAbonne' => $rowData[2] ?? 'null',
            'type' => $rowData[7] ?? 'null',
        ];
    }
}