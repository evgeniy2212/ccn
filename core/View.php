<?php
/**
 * Created by PhpStorm.
 * User: vlad
 * Date: 25.08.16
 * Time: 16:20
 */

namespace Core;

class View
{
    static public function render($file, $data = array())
    {
        ob_start();
        extract($data);
        require_once(ROOT . 'views/layouts/header.php');
        require_once('views/templates/' . $file . '.php');
        require_once(ROOT . 'views/layouts/footer.php');
        $renderView = ob_get_clean();
        return $renderView;
    }

    static public function insert($file, $data = array())
    {
        ob_start();
        extract($data);
        require_once('views/' . $file . '.php');
        $renderView = ob_get_clean();
        return $renderView;
    }
}