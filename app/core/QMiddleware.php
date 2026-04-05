<?php

	namespace app\core;


	class QMiddleware{
        public QRouting $route;
        public function __construct(QRouting $routeObj){

            $this->route = $routeObj;

            $pageFound = false;

            foreach ($this->route->urlparttens as $route) {
                  $requestUri = explode('?',$this->route->request['requestUri']);
                $uri = str_replace('/rdc', '', rtrim($requestUri[0],'/'));
                if(empty($uri)){
                    $uri = '/';
                }
                //print_r($uri);
                if (preg_match($this->generatePattern($route['url']),$uri, $matches)) {
                    // Process middleware stack here
                    $this->hookInterceptor($route, $this->route->request, $matches);
                    $pageFound = true;
                    break;
                }


            }
            if(!$pageFound){
                http_response_code(404);
                echo "404 Not Found";
            }
        }
        private function hookInterceptor($route, $request, $matches){
            if(
                method_exists($route['view_func'],$request['requestMethod']) &&
                in_array($request['requestMethod'],$route['methods'])
            ){
                $route['view_func']-> route = $this->route;
                if(property_exists($route['view_func'], 'db')){
                    $route['view_func']->db = new QDatabase('rdc_app');
                }
                $route['view_func']->{$request['requestMethod']}($this->getParams($matches));
            }else{
                http_response_code(405);
            }

        }
        private function getParams(array $matches){
            $params = [];

            foreach ($matches as $key => $value) {
                if(gettype($key) == "string"){
                    $params[$key] = $value;
                }
            }
            return $params;
        }

        private function generatePattern(string $route): string{
            // Convert route placeholders like {id} to regular expression capturing groups
            $pattern = preg_quote($route, '/');
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
            return $pattern;
        }

   }