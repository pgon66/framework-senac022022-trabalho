<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\InsertDataController;
use App\Controllers\PedroController;

trait Post {
    
    private static $processServerElements;

    private static function post() {
        switch (self::$processServerElements->getRoute()) {
                    
            case '/insert-data':
                return (new InsertDataController)->exec();
            break;
            case '/goncalves2':
                return (new PedroController)->goncalves2();
            break;

        }
    }

}