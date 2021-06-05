<?php

require_once(ROOT . 'Mapper/InputAppelMapper.php');
require_once(ROOT . 'Mapper/OutputAppelMapper.php');
require_once(ROOT . 'Validator/AppelValidator.php');
require_once(ROOT . 'Repository/AppelRepository.php');

class UploadFileContentService
{
    /**
     * @param $rows
     * @return string
     */
    public function decodeData($rows): string
    {
        return utf8_encode(base64_decode($rows));
    }

    /**
     * @param $rows
     * @return array
     */
    public function splitRowsAsArray($rows): array
    {
        return explode(PHP_EOL, $this->decodeData($rows));
    }

    /**
     * @param $data
     * @return bool
     */
    public function uploadChuckInsertRowByRow($data): bool
    {
        $success = true;
        foreach ($this->splitRowsAsArray($data) as $row) {
            $rowWithAssociatedKeys = (new InputAppelMapper())->map($row);
            $validatedData = (new AppelValidator())->validate($rowWithAssociatedKeys);

            if (is_null($validatedData['numeroAbonne'])) {
                continue; // on ignore les lignes qui n'ont pas les infos importantes
            }
            $appel = new AppelEntity();
            $repository = new AppelRepository();
            $outputAppelMapper = (new OutputAppelMapper());

            $appel = $outputAppelMapper->map($validatedData, $appel);
            $success = $success && $repository->insert($appel);
        }

        return $success;
    }

    /**
     * @param $data
     * @return bool
     */
    public function uploadChuckOnlyOneInsert($data): bool
    {
        $repository = new AppelRepository();
        $appels = [];
        foreach ($this->splitRowsAsArray($data) as $row) {
            $rowWithAssociatedKeys = (new InputAppelMapper())->map($row);
            $validatedData = (new AppelValidator())->validate($rowWithAssociatedKeys);

            if (is_null($validatedData['numeroAbonne'])) {
                continue; // on ignore les lignes qui n'ont pas les infos importantes
            }
            $appel = new AppelEntity();
            $outputAppelMapper = (new OutputAppelMapper());

            $appel = $outputAppelMapper->map($validatedData, $appel);
            $appels[] = $appel;
        }

        return $repository->multipleInsert($appels);
    }
}