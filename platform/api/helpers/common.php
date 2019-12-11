<?php
if (!function_exists('replace_img_url')) {
    function replace_img_url($content)
    {
        $replacement = 'src="' . asset('$1') . '"';
        return preg_replace('/src=\"\/((?:.*)\.(?:jpg|jpeg|gif|png))\"/', $replacement, $content);
    }
}
