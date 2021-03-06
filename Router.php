<?php

class Router
{
    protected static $allow_query = true;
    protected static $routes = array();
    public static function add($src, $dest = null)
    {
       
        if(is_array($src)) {
            foreach ($src as $key => $val) {
                static::$routes[$key] = $val;
            }
        } elseif ($dest) {
            static::$routes[$src] = $dest;
        }
    }
    public static function ($src, $uri, $dest = null)
    {
        self::add($src);
        $qs = '';
        if(static::$allow_query && strpos($uri, '?') !== false) {
            // Break the query string off and attach later
            $qs = '?' . parse_url($uri, PHP_URL_QUERY);
            $uri = str_replace($qs, '', $uri);
        }
        // Is there a literal match?
        if(isset(static::$routes[$uri])) {
           
            return(self::createSegments(static::$routes[$uri] . $qs));
        }
        // Loop through the route array looking for wild-cards
        foreach (static::$routes as $key => $val) {
            // Convert wild-cards to RegEx
            $key = str_replace(':any', '.+', $key);
            $key = str_replace(':num', '[0-9]+', $key);
            $key = str_replace(':nonum', '[^0-9]+', $key);
            $key = str_replace(':alpha', '[A-Za-z]+', $key);
            $key = str_replace(':alnum', '[A-Za-z0-9]+', $key);
            $key = str_replace(':hex', '[A-Fa-f0-9]+', $key);
            // Does the RegEx match?
            if(preg_match('#^' . $key . '$#', $uri)) {
                // Do we have a back-reference?
                if(strpos($val, '$') !== false && strpos($key, '(') !== false) {
                    $val = preg_replace('#^' . $key . '$#', $val, $uri);
                }
             
                return(self::createSegments($val . $qs));

            }
        }
      
        return(self::createSegments($uri . $qs));


    }

    public static function createSegments($routed_item)
    {
        return (explode('/', $routed_item));
    }
    
    public static function reverseRoute($controller, $root = "/")
    {
        $index = array_search($controller, static::$routes);
        if($index === false)
            return null;
        return $root . static::$routes[$index];
    }

    public static function testRouter()
    {
        echo 'testing router';
    }
}
