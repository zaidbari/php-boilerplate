<?php

namespace App\Traits;

trait Request
{
    protected function response( array $data = [], int $status = 200 )
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }


    protected function back(string|array $message = null)
    {
        if ($message) { 
            $_SESSION['FLASH'] = $message;
        }
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }

    protected function redirect( string $url, string $message = null )
    {
        if ($message) { 
            $_SESSION['FLASH'] = $message;
        }
        header('Location: ' . $url);
        exit();
    }

    protected function requestBody() : array
    {
        return $_POST;
    }

    protected function param( string $key ) : mixed
    {
        return $_POST[ $key ] ?? null;
    }

    protected function method(string $type) : bool
    {
        return $_SERVER['REQUEST_METHOD'] == $type;
    }

    protected function getRequestPath()
    {
        return $_SERVER['REQUEST_URI'];
    }
}
