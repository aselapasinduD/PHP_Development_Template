<?php

namespace Core;
use Core\Views;

/**
 * Router Core Model - Handle Every Routers
 * Warning - Do not delete this file.
 * @since 1.0.0
 */
class Router{
    private array $routes;
    private array $callback;
    private bool $installed;
    private $routeFound;

    /**
     * This function is used for create newRouters in router.php file.
     * 
     * @param string $route - provide you pathnames to this param and only accept strings
     * @param callable|string $callback - provide the controller callback function here and accept callable function or string format (FunctionName@ControllerClassName)
     * @return Void - This function return nothing
     * @since 1.0.0
     */
    public function newRoute(string $route, array|callable|string $callback)
    {
        /* (\d+)/? */
        if(strpos(strtolower($route), "{id}")){
            $route = str_replace('{id}','(\d+)/?', strtolower($route));
        }
        if(strpos(strtolower($route), "{slug}")){
            $route = str_replace('{slug}','([0-9-a-z]+)/?', strtolower($route));
        }
        if(strpos(strtolower($route), "{uuid}")){
            $route = str_replace('{uuid}','([0-9-a-z]+)/?', strtolower($route));
        }
        echo $route;
        $this->routes[] = strtolower($route);
        $this->callback[] = $callback;
    }

    public function handler($urlPath)
    {
        $this->routeFound = null;
        // if(file_exists(ROOT_DIR . 'app/models/DataBase.Model.php')){
        //     if(class_exists('DataBase')){
        //         $this->installed = true;
        //     }else{
        //         $this->installed = false;
        //         exit();
        //     }
        // }else{
        //     $this->installed = false;
        //     exit();
        // }

        foreach ($this->routes as $key => $value) {
            if(preg_match("@^{$value}$@D", $urlPath, $matches)){
                if(count($matches) > 1){
                    unset($matches[0]);
                    $matches = array_values($matches);
                }
                $this->routeFound = $value;

                if(is_string($this->callback[$key]) || is_array($this->callback[$key]) ){
                    $is_array = is_array($this->callback[$key]);

                    if($is_array){
                        $className = $this->callback[$key][0];
                        $functionName = $this->callback[$key][1];
                    } else {
                        $handlerClass = explode('@', $this->callback[$key]);
                        $handlerClass = array_values(array_filter($handlerClass));
                        $className = $handlerClass[1];
                        $functionName = $handlerClass[0];
                    }

                    $controllerFilePath = $is_array ? ROOT_DIR . strtolower($className) . '.controller.php' : ROOT_DIR . 'app/controllers/' . $className . '.controller.php';

                    // echo $controllerFilePath . "<br />";
                    // echo file_exists($controllerFilePath) . "<br />";

                    if(file_exists($controllerFilePath)){
                        if($is_array){
                            $fullyQualifiedClassName = $className;
                        } else {
                            $fileContent = file_get_contents($controllerFilePath);
                            $namespaceUsed = preg_match('/namespace\s+([\w\\\\]+);/', $fileContent, $namespaceMatch);
                            // echo $namespaceUsed . "<br />";

                            if (!$namespaceUsed) {
                                require_once $controllerFilePath;
                            }

                            $fullyQualifiedClassName = $namespaceUsed ? $namespaceMatch[1] . '\\' . $className : $className;

                            // echo $controllerFilePath . "<br />";
                            // echo $className . "<br />";
                        }

                        // echo $fullyQualifiedClassName . "<br />";

                        if(class_exists($fullyQualifiedClassName)){
                            $class = new $fullyQualifiedClassName;
                            if(method_exists($class, $functionName)){
                                echo $class->$functionName($matches);
                            } else {
                                throw new \Exception($functionName . ' method does not exist in ' . $fullyQualifiedClassName . ' class.');
                            }
                        } else {
                            throw new \Exception($fullyQualifiedClassName . ' class does not exist.');
                        }
                    }else{
                        throw new \Exception($className . ' class not found in classes folder.');
                    }
                }else if(is_callable($this->callback[$key])){
                    echo $this->callback[$key]($matches);
                }
            }
        }
    }

    public function __invoke()
    {
        $requestUrl = parse_url($_SERVER['REQUEST_URI']);
        $urlPath = strtolower($requestUrl['path']);
        $this->handler(urlPath: $urlPath);
    }

    /**
     * 
     */
    public function __destruct(){
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $uriPath = strtolower($requestUri['path']);

        if(!$this->routeFound){
            // if(file_exists(ROOT_DIR . '/views/404.php')){
            //     include ROOT_DIR . '/views/404.php';
            // }else if(!file_exists(ROOT_DIR . '/views/404.php') && $_SERVER['HTTP_HOST'] === 'localhost'){
            //     echo '<span style="text-align:center">
            //             <h1>404: Page not found.</h1> <p>The requested URL was not found on this server.</p><hr>
            //             <p><i>You can customize the 404 page by add your custom 404 page file </i><b>(NB: name the file 404.php)</b> <i>to "views" folder</i></p>
            //         </span>
            //     ';
            //     exit();
            // }else{
            //     echo '<span style="text-align:center">
            //         <h1>404: Page not found.</h1> <p>The requested URL was not found on this server.</p><hr>
            //     </span>';
            // exit();
            // }
            Views::_404();
            exit();
        }

        // if(!$this->installed){
        //     if($uriPath === '/installation'){
        //         foreach ($this->routes as $key => $value) {
        //             if($value === $uriPath){
        //                 $this->callback[$key]();
        //                 return;
        //             }
        //         }
        //     }
        //     include $_SERVER['DOCUMENT_ROOT'].'/views/install.php';
        
        // }else if(!$this->routeFound){
        //     if(file_exists(ROOT_DIR . '/views/404.php')){
        //         include ROOT_DIR . '/views/404.php';
        //     }else if(!file_exists(ROOT_DIR . '/views/404.php') && $_SERVER['HTTP_HOST'] === 'localhost'){
        //         echo '<span style="text-align:center">
        //                 <h1>404: Page not found.</h1> <p>The requested URL was not found on this server.</p><hr>
        //                 <p><i>You can customize the 404 page by add your custom 404 page file </i><b>(NB: name the file 404.php)</b> <i>to "views" folder</i></p>
        //             </span>
        //         ';
        //         exit();
        //     }else{
        //         echo '<span style="text-align:center">
        //             <h1>404: Page not found.</h1> <p>The requested URL was not found on this server.</p><hr>
        //         </span>
        //     ';
        //     exit();
        //     }
        // }
    }
}