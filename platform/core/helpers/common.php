<?php

use DG\Dissertation\Core\Facades\PageTitleFacade;

if (!function_exists('platform_path')) {

    /**
     * @param null $path
     * @return string
     */
    function platform_path($path = null)
    {
        return __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $path;
    }
}


if (!function_exists('get_page_title')) {

    /**
     * @return string
     */
    function get_page_title(): string
    {
        return PageTitleFacade::getTitle();
    }
}


if (!function_exists('set_page_title')) {

    /**
     * @param string $title
     */
    function set_page_title(string $title)
    {
        PageTitleFacade::setTitle($title);
    }
}

if (!function_exists('resolve_between_time')) {

    /**
     * @param null $from
     * @param null $to
     * @return array
     */
    function resolve_between_time($from = null, $to = null)
    {
        $from = empty($from) ? date('Y-m-d 00:00:00') : date('Y-m-d 00:00:00', strtotime($from));
        $to = empty($to) ? date('Y-m-d 23:59:59') : date('Y-m-d 23:59:59', strtotime($to));
        return [
            'from' => $from,
            'to' => $to
        ];
    }
}
