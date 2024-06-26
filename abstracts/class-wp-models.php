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
    private $user_columns = ['user_login', 'user_pass', 'user_nicename', 'user_email', 'display_name'];
    private $term_columns = [];

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

        if($name === $this->primaryKey || in_array($name, $this->getColumnsType())) {
            return $this->attributes[$name];
        }
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

        $columns = $this->getColumnsType();

        if ($name === $this->primaryKey || in_array($name, $columns)) {
            $this->attributes[$name] = $value;
        }
    }

    private function getColumnsType(): array
    {
        switch ($this->type) {
            case 'user':
                return $this->user_columns;
            case 'post':
            default:
                return $this->post_columns;
        }
    }

    private function get_acf(string $name)
    {
        if(!function_exists('get_field')) return $this->get_meta($name);

        $prefix = $this->getACFPrefix();

        return get_field($name, $prefix.$this->{$this->primaryKey});
    }

    private function getACFPrefix()
    {
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
        return $prefix;
    }

    private function get_meta(string $name)
    {
        switch ($this->type) {
            case 'user':
                return get_user_meta($this->{$this->primaryKey}, $name, true);
            case 'term':
                return get_term_meta($this->{$this->primaryKey}, $name, true);
            case 'post':
            default:
                return get_post_meta($this->{$this->primaryKey}, $name, true);
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
        $prefix = $this->getACFPrefix();
        foreach($this->acf_data as $selector => $value) 
        {
            update_field($selector, $value, $prefix.$this->{$this->primaryKey});
        }
    }

    public function save_meta()
    {
        foreach ($this->meta_data as $name => $value) {
            switch ($this->type) {
                case 'user':
                    update_user_meta($this->attributes[$this->primaryKey], $name, $value); 
                    break;
                case 'term':
                    update_term_meta($this->attributes[$this->primaryKey], $name, $value);
                    break;
                case 'post':
                    update_post_meta($this->attributes[$this->primaryKey], $name, $value);
                    break;
            }
        }
    }

    public function save()
    {
        switch ($this->type) {
            case 'user':
                $this->save_user();
                break;
            case 'term':
                $this->save_term();
                break;
            case 'post':
                $this->save_post();
                break;
            default:
                throw new \Exception('Error in '. static::class . ', type ' . $this->type . ' is invalid it should be one of this (user, term, post).');
        }
    }

    protected function save_post()
    {
        if($this->{$this->primaryKey}) {
            return wp_update_post($this->attributes);
        }

        $this->{$this->primaryKey} = wp_insert_post($this->attributes);
        return $this->{$this->primaryKey};
    }

    protected function save_user()
    {
        if($this->{$this->primaryKey}) {
            return wp_update_user($this->attributes);
        }

        $this->{$this->primaryKey} = wp_insert_user($this->attributes);
        return $this->{$this->primaryKey};
    }

    protected function save_term()
    {
        $data = $this->attributes;
        if($this->{$this->primaryKey}) {
            return wp_update_term($this->attributes[$this->primaryKey], $this->attributes['taxonomy'], $data);
        }

        unset($data['term'], $data['taxonomy']);
        $term_id = wp_insert_term($this->attributes['term'], $this->attributes['taxonomy'], $data);
        $this->attributes[$this->primaryKey] = $term_id;
        return $this->{$this->primaryKey};
    }
}