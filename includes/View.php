<?php
namespace Selzy\ViewWrapper;

class View
{
    public static function render($viewName, $data = array())
    {
        $filePath = WPSELZY_PLUGIN_DIR . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "$viewName.php";
        if ($viewName && file_exists($filePath)) {
            extract($data);
            ob_start();
            require $filePath;
            return ob_get_clean();
        } else {
            throw new \Exception("View $viewName not found!");
        }
    }
}