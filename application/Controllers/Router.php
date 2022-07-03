<?php

class Router
{
    private $routers = array();


    public function get($path, $controller)
    {
        array_push($this->routers, array($path, $controller, 'get'));
    }

    public function post($path, $controller)
    {
        array_push($this->routers, array($path, $controller, 'post'));
    }

    public function check()
    {

        $key = array_search($_SERVER['REQUEST_URI'], array_column($this->routers, 0));

        if ($key !== false) {
            if ($this->routers[$key][2] == 'get')
                return call_user_func($this->routers[$key][1]);
            else
                return call_user_func($this->routers[$key][1], $_POST);
        }

        $this->notFound();
    }

    function notFound()
    {
        $view = new View();
        $content = $view->generate_html('404/index.php', []);
        echo $view->generate_html('wrapper.php', ['title' => '404', 'content' => $content]);
    }
}