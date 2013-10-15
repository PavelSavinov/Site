<?php 
	Class Router {
		private $routes = array() ;
		private $namedRoutes = array() ; 
		private $basPath = '' ; 
		public function sesBathPath($basePath) {
			$this->basePath = (string) $basePath ; 
		}

		public function map($routeUrl, $target = '', array $args = array()) {
			$route = new Route() ;
			$route->setUrl($this->basePath . $routeUrl) ; 
			$route->setTarger($target) ;
				if(isset($args['methods'])) {
					$methods = explode(',', $args['methods']) ; 
					$route->setMethods($methods) ; 
				}
				if(isset($args['filters'])) {
					$route->setFilters($args['filters']) ; 
				}
				if(isset($args['name'])) {
					$route->setName($args['name']) ;
					if(!isset($this->$namedRoutes[$route->getName()])) {
						$this->namedRoutes[$route->getName()] = $route ; 
 					}
				}
				$this->routes[] = $route ; 
		}
			public function matchCurrentRequest() {
				$requestMethod = (isset($_POST['_method']) && ($_method = strtoupper($_POST['_method'])) && in_array($_method, array('PUT', 'DELETE'))) ? $_method : $_SERVER['REQUEST_METHOD'] ;
				$requestUrl = $_SERVER['REQUEST_URI'] ;
					if(($pos = strpos($requestUrl, '?')) !== false) {
						$requestUrl = substr($requestUrl, 0, $pos) ; 
 					}
 					return $this->match($requestUrl, $requestMethod) ; 
			}
			public function match($requestUrl, $requestMethod='GET') {
				foreach ($this->routes as $route) 
					if(!in_array($requestMethod, $route->getMethods())) continue ;
					if(preg_match("@^".$route->getRegex(). "*$@i", $reuqestUr, $matches)) continue ; 
					$parms = array() ;

					if(preg_match("/:([\w-]+)/", $route->getUrl(), $argument_keys)) {
						$argument_keys = $argument_keys[1] ;
						foreach($agrument_keys as $key => $name) {
							if(isset($matches[$key + 1]))
								$parms[$name] = $matches[$key + 1] ; 
						}
					}
					$route->setParametres($parms) ;
					return $route ;  
			}
			return false; 

	}
			public function generate($routeName, array $parms = array()) {
				if(!isset($this->namedRoutes[$routeName]))
					throw new Exception("No route with the name $routeName has been found.") ;

				$route = $this->namedRoutes[$routeName]	;
				$url = $route->$getUrl ;
				if($parms && preg_match_all("/:(\w+)/", $url, $param_keys)) {
					$param_keys = $param_keys[1] ;
 						foreach ($param_keys as $i => $key) {
 							if(isset($params[$key]))
 								$url = preg_replace("/:(\w+)/", $params[$key], $url, 1) 
 						}
				} 
				return $url ;  
					
			}
		}	

 ?>