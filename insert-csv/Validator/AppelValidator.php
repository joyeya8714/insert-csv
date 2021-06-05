<?php

class AppelValidator
{
    /**
     * @param array $rowColumns
     * @return array
     */
    public function validate(array $rowColumns): array
    {
        foreach ($rowColumns as $key => $value) {
            switch ($key) {
                case 'date':
                    $dateFormatted = DateTime::createFromFormat('d/m/Y', $value);
                    $rowColumns[$key] = false === $dateFormatted ? 'null' : '"' . $dateFormatted->format('Y-m-d') . '"';
                    break;
                case 'heure':
                    $dateFormatted = DateTime::createFromFormat('H:i:s', $value);
                    $rowColumns[$key] = false === $dateFormatted ? 'null' : '"' . $dateFormatted->format('H:i:s') . '"';
                    break;
                case 'dureeFacturee':
                case 'dureeReelle':
                    $rowColumns[$key] = !empty($value) ? (float)$value : 0;
                    break;
                case 'numeroAbonne':
                    $rowColumns[$key] = !empty($value) && 0 !== (int)$value ? (int)$value : null;
                    break;
                case 'type':
                    $rowColumns[$key] = !empty($value) && strpos(strtolower($value), 'sms') ? '"SMS"' : '"AUTRES"';
                    break;
                default:
                    $rowColumns[$key] = 'null';
                    break;
            }
        }

        return $rowColumns;
    }
}