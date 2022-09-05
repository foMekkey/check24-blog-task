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

if (!function_exists('paginator_links')) {
    function paginator_links(?int $total_pages, ?int $start): void
    {
        for ($page = 1; $page <= $total_pages; $page++) {
            if ($page === $start) {
                echo "<li class='selected'><span>$page</span></li>";
            } else {
                echo "<li><a href='" . CURRENT_PATH . "/page/$page'>$page</a></li>";
            }
        }
    }
}

if (!function_exists('get_time_diff')) {
    function get_time_diff($dateTime): string
    {
        $creationDate = strtotime($dateTime);
        $today = strtotime(date('Y-m-d H:i:s'));
        $timeDiff = $today - $creationDate;
        $years = 60 * 60 * 24 * 365;
        $months = 60 * 60 * 24 * 30;
        $days = 60 * 60 * 24;
        $hours = 60 * 60;
        $minutes = 60;

        if (intval($timeDiff / $years) > 1) {
            return intval($timeDiff / $years) . " years ago";
        } else if (intval($timeDiff / $years) > 0) {
            return intval($timeDiff / $years) . " year ago";
        } else if (intval($timeDiff / $months) > 1) {
            return intval($timeDiff / $months) . " months ago";
        } else if (intval(($timeDiff / $months)) > 0) {
            return intval(($timeDiff / $months)) . " month ago";
        } else if (intval(($timeDiff / $days)) > 1) {
            return intval(($timeDiff / $days)) . " days ago";
        } else if (intval(($timeDiff / $days)) > 0) {
            return intval(($timeDiff / $days)) . " day ago";
        } else if (intval(($timeDiff / $hours)) > 1) {
            return intval(($timeDiff / $hours)) . " hours ago";
        } else if (intval(($timeDiff / $hours)) > 0) {
            return intval(($timeDiff / $hours)) . " hour ago";
        } else if (intval(($timeDiff / $minutes)) > 1) {
            return intval(($timeDiff / $minutes)) . " minutes ago";
        } else if (intval(($timeDiff / $minutes)) > 0) {
            return intval(($timeDiff / $minutes)) . " minute ago";
        } else if (intval(($timeDiff)) > 1) {
            return intval(($timeDiff)) . " seconds ago";
        } else {
            return "few seconds ago";
        }
    }
}

if (!function_exists('show_flash_message')) {
    function show_flash_message(): void
    {
        if (sessions()->has('flashMessage')) {
            echo '<div class="alert alert-danger text-center text-danger" style="color: red;">';
            foreach (sessions()->get('flashMessage')['data'] as $value) {
                echo "<p>$value</p>";
            }
            echo "</div>";
            sessions()->remove('flashMessage');
        }
    }
}