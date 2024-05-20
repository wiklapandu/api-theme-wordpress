<?php
/**
* Use for description
*
* @package HelloElementor
*/
namespace MI\Bootstrap;

use ReflectionFunction;
use ReflectionMethod;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * @method static Route prefix(string $path)
 * @method static Route post(string $path, \Closure $callback)
 * @method static Route get(string $path, \Closure $callback)
 * 
 * */ 
class Route
{
    protected $prefix = '';
    protected $path  = '';
    protected $method = '';
    protected $methods = ['POST', 'GET'];
    protected $callback;
    protected $routes = [];
    protected $middlewares = [];
    public function __construct($method = '', $prefix = '', $path = '', $action = null)
    {
        if($prefix) {
            $this->prefix = $prefix;
        }

        if($method && $path) {
            $this->registerMethod($method, $path, $action);
        }
    }

    public function registered(): void
    {
        add_action('rest_api_init', function () {
            foreach($this->routes as $data) {
                $prefix = $this->prefix;
                $prefix = str_replace('//','/', $prefix);
                
                $path = $data['path'];
                $path = $path != "" ? $path : $prefix;
                $prefix = $data['path'] != "" ? $prefix : "";

                register_rest_route("api", $prefix."/".$path, [
                    'methods' => $data['method'],
                    'callback' => function(\WP_REST_Request $request) use($data) {
                        /**
                         * @var callable|array
                         * */ 
                        $callback = $data['callback'];

                        if(is_array($callback)) {
                            $reflection = new ReflectionMethod(...$callback);
                        } else {
                            $reflection = new ReflectionFunction($data['callback']);
                        }
                        $parameters = $reflection->getParameters();

                        $arguments = [];
                        foreach ($parameters as $parameter)
                        {
                            $type = $parameter->getType()->getName();
                            if(get_parent_class($type) === 'WP_REST_Request') {
                                $arguments[] = new $type($request->get_method(), $request->get_route(), $request->get_attributes());
                            } elseif(is_callable($type)) {
                                $arguments[] = new $type;
                            } else {
                                $arguments[] = $request;
                            }
                        }

                        if(is_callable($callback)) {
                            call_user_func($callback, ...$arguments);
                        } else {
                            if ($reflection->isStatic()) {
                                $result = $reflection->invokeArgs($arguments);
                            } else {
                                // If the callback is not static, you need to handle it differently
                                // You would typically need an object instance to invoke a non-static method
                                // You can create an instance of the class and then invoke the method
                                $object = new $callback[0]();
                                $result = $reflection->invokeArgs($object, $arguments);
                            }
                        }
                    },
                ]);
            }
        });
    }

    protected function registerMethod(string $method, string $path, callable|array $callback)
    {
        $this->routes[] = [
            "method" => $method,
            "path"   => $path,
            "callback" => $callback,
        ];

        return $this->registered();
    }
    
    public function __call($method, $args)
    {
        if (in_array(strtoupper($method), $this->methods)) {
            $path = $args[0];
            $action = $args[1];
            return $this->registerMethod(strtoupper($method), $path, $action);
        }

        if ($method === 'prefix') {
            $this->prefix = $args[0];
            return $this;
        }
    }

     // This method handles static method calls
    public static function __callStatic($name, $args)
    {
        if ($name === 'prefix') {
            $instance = new self(prefix: $args[0] ?? "");
            return $instance;
        }

        if ($name === 'post') {
            $instance = new self('POST', path: $args[0], action: $args[1]);
            return $instance;
        }
        
        if ($name === 'get') {
            $instance = new self('GET', path: $args[0], action: $args[1]);
            return $instance;
        }
    }

    public function group($callback)
    {
        if(is_callable($callback)) {
            call_user_func($callback, $this);
        }
    }
}

/**
 * 
 * Route::prefix('')
 * 
 * */ 