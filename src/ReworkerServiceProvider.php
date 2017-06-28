<?php

namespace Depakespedro\Reworker;

use Illuminate\Support\ServiceProvider;

class ReworkerServiceProvider extends ServiceProvider {

    public function boot(){

    }

    public function register(){
        $this->app['reworker'] = $this->app->share(function(){
            return new Reworker();
        });
    }

}
