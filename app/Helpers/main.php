<?php
if ( ! function_exists('lang_path'))
{
    /**
     * Get the Language path.
     *
     * @param  string $path
     * @return string
     */
    function lang_path($path = '')
    {
        return app()->basePath() . '/resources/lang' . ($path ? '/' . $path : $path);
    }
}
