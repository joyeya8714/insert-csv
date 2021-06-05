<?php

require_once(ROOT . 'Model/AppelEntity.php');
require_once(ROOT . 'Service/UploadFileContentService.php');
require_once(ROOT . 'Repository/AppelRepository.php');

class AppelController extends Controller
{
    public function index()
    {
        $repository = new AppelRepository();
        $totalTimeAllCalls = $repository->queryTotalTimeAllCallsSinceGivenDateIncluded('2012-02-15');
        $totalNumberSms = $repository->queryTotalNumberOfSms();
        $topTenDataBilled = $repository->queryTopTenDataBilledBySubscriber();

        $this->render('index', [
            'totalTimeAllCalls' => $totalTimeAllCalls,
            'totalNumberSms' => $totalNumberSms,
            'topTenDataBilled' => $topTenDataBilled,
        ]);
    }

    /**
     * Called Via JS
     */
    public function ajaxUploadFileChunk()
    {
        $code = 200;
        if ($this->isPost() && $this->isSubmitted() && $this->isAjax()) {
            try {
                $uploadFileContentService = new UploadFileContentService();
                //$success = $uploadFileContentService->uploadChuckInsertRowByRow($_POST['data']);
                // possibilité de passer en upload ligne à ligne
                // avantage : si erreur, le rollback de la transaction se fera sur une ligne au lieu de X
                // inconvénient : plus lent que de faire un seul insert de X lignes
                $success = $uploadFileContentService->uploadChuckOnlyOneInsert($_POST['data']);
                $code = $success ? 200 : 422;
            } catch (Exception $e) {
                $code = 500;
            }
        }

        echo $this->json_response($code);
    }

    /**
     * Called Via JS
     */
    public function ajaxTruncateDb()
    {
        $code = 200;
        if ($this->isPost() && $this->isAjax()) {
            try {
                $repository = new AppelRepository();
                $success = $repository->truncateTable();
                $code = $success ? 200 : 422;
            } catch (Exception $e) {
                $code = 500;
            }
        }

        echo $this->json_response($code);
    }
}