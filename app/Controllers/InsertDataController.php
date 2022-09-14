<?php

namespace App\Controllers;

use App\FrameworkTools\Abstracts\Controllers\AbstractControllers;

use App\FrameworkTools\Database\DatabaseConnection;

class InsertDataController extends AbstractControllers{

    public function exec() {
        $params = (array) json_decode(file_get_contents('php://input'), TRUE);
        dd($params);

        view([
            'success'=> true 
        ]);
    }

}
