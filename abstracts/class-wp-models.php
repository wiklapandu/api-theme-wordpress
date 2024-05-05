<?php
/**
* Use for description
*
* @package HelloElementor
*/
namespace MI;

defined( 'ABSPATH' ) || die( "Can't access directly" );

abstract class WP_Model
{
    /** @var "user"|"post"|"term"| $type*/ 
    public $type = '';
    public $primaryKey = 'ID';
    public $acf_data = [];
    public $meta_data = [];
    public $attributes = [];
    private $post_columns = ['post_author', 'post_date', 'post_date_gmt', 'post_content', 'post_title', 'post_except', 'post_type'];
    private $user_columns = [];

    public function __construct(array $attributes = [])
    {
        if(!in_array($this->type, ['user', 'post', 'term'])) trigger_error('Model '. static::class . ' should be one of user, post, term.', E_USER_ERROR);

        $columns = $this->getTypeColumn();
        foreach ($attributes as $key => $value)
        {
            if(!in_array($key, $columns)) {
                trigger_error(
                    "variabel {$key} is not exists with type {$this->type}.",
                    E_USER_ERROR
                );
            }
        }

        $this->attributes = $attributes;
    }

    public function __get($name)
    {
        if (strpos($name, "acf_") !== false) {
            return $this->get_acf(str_replace('acf_', '', $name));
        }

        if (strpos($name, "meta_") !== false) {
            return $this->get_meta(str_replace('meta_', '', $name));
        }

        return $this->attributes[$name];
    }

    public function __set($name, $value)
    {
        if (strpos($name, "acf_") !== false) {
            $this->acf_data[$name] = $value;
            return;
        }

        if (strpos($name, "meta_") !== false) {
            $this->meta_data[$name] = $value;
            return;
        }

        $columns = [];

        switch ($this->type) {
            case 'user':
                $columns = $this->user_columns;
                break;
            case 'post':
            default:
                $columns = $this->post_columns;
                break;
        }

        if ($name === $this->primaryKey || in_array($name, $columns)) {
            $this->attributes[$name] = $value;
        }
    }

    private function get_acf(string $name)
    {
        if(!function_exists('get_field')) return $this->get_meta($name);

        $prefix = '';
        switch($this->type) {
            case 'user':
                $prefix = 'user_';
                break;
            case 'term':
                $prefix = 'term_';
                break;
            case 'post':
            default:
                $prefix = '';
                break;
        }

        return get_field($name, $prefix.$this->id);
    }

    private function get_meta(string $name)
    {
        switch ($this->type) {
            case 'user':
                return get_user_meta($this->id, $name, true);
            case 'term':
                return get_term_meta($this->id, $name, true);
            case 'post':
            default:
                return get_post_meta($this->id, $name, true);
        }
    }

    private function getTypeColumn()
    {
        switch ($this->type) {
            case 'user':
                return $this->user_column;
            case 'post':
                return $this->post_columns;
            default:
                return $this->post_columns;
        }
    }

    public function save_acf()
    {

    }

    public function save()
    {
        switch ($this->type) {
            case 'user':
                # code...
                break;
            
            default:
                # code...
                break;
        }
    }

    protected function save_post()
    {
        if($this->id) {
            $this->attributes['ID'] = $this->id;
            return wp_update_post($this->attributes);
        }

        $this->id = wp_insert_post($this->attributes);
    }

    protected function save_user()
    {
        if($this->id) {
            // wp_update_user();
        }

        $this->id = wp_insert_user($this->attributes);
        return $this->id;
    }

    protected function save_term()
    {
        $data = $this->attributes;
        unset($data['term'], $data['taxonomy']);
        $term_id = wp_insert_term($this->attributes['term'], $this->attributes['taxonomy'], $data);
        $this->id = $term_id;
    }
}