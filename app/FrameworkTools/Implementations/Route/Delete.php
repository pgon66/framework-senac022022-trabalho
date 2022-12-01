<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\HelloWorldController;
use App\Controllers\PedroController;

trait Delete {
    
    private static $processServerElements;

    private static function delete() {
        switch (self::$processServerElements->getRoute()) {
                    
            case '/hello-world':
                return (new HelloWorldController)->execute();
            break;

            case '/goncalves4':
                return (new PedroController)->goncalves4();
            break;
        }
    }

}