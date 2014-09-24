<?php

class ViewController extends \BaseController {

    public function getView($name = '') {
        $white_list = [
            'navigation' => 'home.nav',
            'about'      => 'home.tab_about',
            'map'        => 'home.tab_map',
            'apply'      => 'home.tab_apply',
            'records'    => 'home.tab_records',
            'login'      => 'home.modal_login',
            'register'   => 'home.modal_register',
        ];

        $view = empty($name) ? Input::get('name') : $name;

        if ( empty($view) ) {
            throw new Exception("Missing argument of view's name", 1);
        }

        if ( !array_key_exists($view, $white_list) ) {
            throw new Exception("Invalid name of view", 1);
        }

        return View::make($white_list[$view]);
    }

    public function getMap($name = '') {
        $white_list = [
            'nchu' => 'home.map.nchu',
        ];

        $map = empty($name) ? Input::get('name') : $name;

        if ( empty($map) ) {
            throw new Exception("Missing argument of map's name", 1);
        }

        if ( !array_key_exists($map, $white_list) ) {
            throw new Exception("Invalid name of map", 1);
        }

        return View::make($white_list[$map]);
    }

}
