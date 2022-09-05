<?php

declare(strict_types=1);

if (!function_exists('paginator')) {
    function paginator(int $total_pages, int $start): array
    {
        if ($total_pages && $start) {
            return [
                'total_pages' => $total_pages,
                'current_page' => $start,
                'last_page' => $total_pages,
                'next_page' => ($total_pages >= $start + 1) ? $start + 1 : 0,
                'prev_page' => ($start !== 1) ? $start - 1 : 1
            ];
        }
        return [];
    }
}

if (!function_exists('sessions')) {
    function sessions()
    {
        return new App\Sessions\Session();
    }
}

if (!function_exists('response')) {
    function response(int $statusCode, string $message, array $data): array
    {
        return [
            "status" => $statusCode,
            "message" => $message,
            "data" => $data
        ];
    }
}

if (!function_exists('view')) {
    function view(string $view, array $variables = []): string
    {
        $filePath = VIEWS . "$view.view.php";
        $output = NULL;
        if (file_exists($filePath)) {
            extract($variables);
            ob_start();
            include $filePath;
            $output = ob_get_clean();
        }
        return $output;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $route, array $flashMessage = [], bool $redirectBack = false): void
    {
        if (count($flashMessage) > 0)
            sessions()->set('flashMessage', $flashMessage);

        $route = str_replace(env('APP_URL'), '', $route);
        if (!$redirectBack) {
            header("Location: " . env('APP_URL') . "$route", true, 301);
        } else {
            header("Location: " . $_SERVER['HTTP_REFERER'], true, 301);
        }
        exit();
    }
}