<?php

namespace DG\Dissertation\Core\Supports;

class Helper
{
    /**
     * Load all file from directory
     * @param string $path
     */
    public static function autoload(string $path)
    {
        $files = \File::glob($path . '/*.php');
        foreach ($files as $file) {
            \File::requireOnce($file);
        }
    }
}
