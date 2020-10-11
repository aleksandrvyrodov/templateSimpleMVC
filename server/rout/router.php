<?php   

	namespace Rout;

	class Router{		
		private $_routes;	
		private $_started;
		
		function __construct(){
			$_ = include(ROOT.'/server/rout/route.php');
			$this -> _routes = $_[0];		
			$this -> _started = $_[1];		
		}
		
		private function splitRout($rout, $_){
			$root_and_rest=explode('/', $rout, 2);

			$revpath = explode('/', strrev($root_and_rest[1]), $_+1);

			return array(
				'root' => $root_and_rest[0],
				'expl' => array(
					'ltr' => explode('/', $root_and_rest[1], $_+1),
					'rtl' => array( $revpath[0], strrev($revpath[1]))
				),
				'rest' => explode('/', $root_and_rest[1])
			); 
		}

        private function getLaw(){
			$this_rout = mb_strtolower(trim($_GET['route'], '/'));
			
            foreach($this -> _routes as $mask => $law){
                if(preg_match('~'.$mask.'~i', $this_rout)){
					
					$law['pack']['path_param'] = $law['path_param'];					
					$law['pack']['path'] = $this_rout;
					$law['pack']['val'] = $law['val'];

					if( (int)$law['path_param'] > 0 ){
						$law['pack']['path_mod'] = $this->splitRout($this_rout, $law['path_param']);
					}
                    if( (bool)$law['from_client'] === true ){
						$law['pack']['get'] = $_GET;
						$law['pack']['post'] = $_POST;						
					}
					
					unset($law['val']);
					unset($law['from_client']);
					unset($_GET);
					unset($_POST);	

                    return $law;
                }
            }
            return array(
                'controler' => 'Index',
                'action' => 'NotFound'
            );
        }
		
		public function run(){	
            
            $law = $this->getLaw();
/*
			include_once( ROOT.'/controlers/AutorisationControl.php');			
			$controler = new Control\Autorisation\AutorisationControl();
			$result = $controler -> actionCheckAutorisation($law, $this -> _started);
*/          
			$controller = 'Controller\\'.$law['controller'];
			$action = $law['action'];

			$obj = new $controller;			
			$obj -> $action($law['pack']);
			
			return true;					
		}		
	}