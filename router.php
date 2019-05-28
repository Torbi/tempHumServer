<?php

class Router
{
  //Routing logik

    static public function parse($url, $request)
    {
      error_reporting(E_ALL);
        $url = trim($url);

        if ($url == "/tempHum/")
        {
            $request->controller = "tasks";
            $request->action = "index";
            $request->params = [];
        }
        else
        {
            $explode_url = explode('/', $url);
            $explode_url = array_slice($explode_url, 2);
            $request->controller = $explode_url[0];
            $request->action = $explode_url[1];
            $request->params = array_slice($explode_url, 2);
        }
    }
}
?>
