<?php
/**
* Use for description
* Author: Wikla
*
*
* @package HelloElementor
*/
namespace MI\Controllers;
use MI\Controllers;
use MI\Models\NewsModel;

defined( 'ABSPATH' ) || die( "Can't access directly" );

class NewsController extends Controllers {
    protected NewsModel $model;
    public function __construct(){
        $this->model = new NewsModel;
    }
    public function index()
    {
        $data = $this->model->limit(1)->get();
        return wp_send_json([
            'status'    => 'success',
            'data'      => $data,
        ], 200);
    }

    public function show()
    {
        $data = $this->model->first(false);
        return wp_send_json([
            'status'    => 'success',
            'data'      => $data,
        ], 200);
    }
}