<?php
/**
* Use for description
*
* @package HelloElementor
*/
namespace MI\Bootstrap;

use ReflectionFunction;

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * @method static Route prefix(string $path)
 * @method static Route post(string $path, callable $callback)
 * @method static Route get(string $path, callable $callback)
 * 
 * */ 
class Route
{
    protected $prefix = '';
    protected $path  = '';
    protected $method = '';
    protected $methods = ['post', 'get'];
    protected $callback;
    protected $middlewares = [];
    public function __construct($method = '', $prefix = '', $path = '', $action = null)
    {
        $this->callback = $action;
        $this->method = $method;
        $this->path = $path;
        $this->prefix = $prefix;
        $this->callback = $action;
    }

    public function registered(): void
    {
        add_action('rest_api_init', function () {
            register_rest_route('/api/'.$this->prefix, $this->path, [
                'methods' => $this->method,
                'callback' => [$this, 'handleCallback'],
            ]);
        });
    }

    public function handleCallback(\WP_REST_Request $request): void
    {
        $callback = $this->callback;

        $refflection = new ReflectionFunction($this->callback);
        $parameters = $refflection->getParameters();

        foreach ($parameters as $parameter)
        {
            $type = $parameter->getType()->getName();
            if(get_parent_class($type) === 'WP_REST_Request') {
                $request = new $type($request->get_method(), $request->get_route(), $request->get_attributes());
            }
        }
        call_user_func($callback, $request);
    }

    protected function registerMethod(string $method, string $path, callable $callback)
    {
        $this->method = $method;
        $this->path = $path;
        $this->callback = $callback;
        return $this;
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
}

/**
 * 
 * Route::prefix('')
 * 
 * */ 