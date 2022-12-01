<?php

namespace App\FrameworkTools\Implementations\Route;

use App\Controllers\UpdateDataController;
use App\Controllers\PedroController;

trait Put {

    private static function put() {
        switch (self::$processServerElements->getRoute()) {
            case '/update-data':
                return (new UpdateDataController)->exec();
            break;
            case '/goncalves3':
                return (new PedroController)->goncalves3();
            break;
        }
    }
}