<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\HelloWorldController;
use App\Controllers\PedroController;

trait Get {
    
    private static $processServerElements;

    private static function get() {
        switch (self::$processServerElements->getRoute()) {
                    
            case '/hello-world':
                return (new HelloWorldController)->execute();
            break;

            case '/goncalves1':
                return (new PedroController)->goncalves1();
            break;
        }
    }

}