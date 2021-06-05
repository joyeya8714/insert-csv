<?php

class Controller
{
    /**
     * @param string $filePath
     * @param array $data
     */
    public function render(string $filePath, array $data = [])
    {
        extract($data);
        require_once(ROOT . 'View/' . $filePath . '.html.php');
    }

    /**
     * @return bool
     */
    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }

    /**
     * @return bool
     */
    public function isSubmitted(): bool
    {
        return isset($_POST['submit']);
    }

    /**
     * @return bool
     */
    public function isAjax(): bool
    {
        return $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * @param int $code
     * @param string|null $message
     * @return false|string
     */
    function json_response(int $code = 200, ?string $message = null)
    {
        header_remove();
        http_response_code($code);
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        header('Content-Type: application/json');
        $status = array(
            200 => '200 OK',
            400 => '400 Bad Request',
            422 => 'Unprocessable Entity',
            500 => '500 Internal Server Error'
        );
        header('Status: ' . $status[$code]);

        return json_encode(array(
            'status' => $code < 300,
            'message' => $message
        ));
    }
}