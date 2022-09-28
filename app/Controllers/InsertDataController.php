<?php

namespace App\Controllers;

use App\FrameworkTools\Abstracts\Controllers\AbstractControllers;
use App\FrameworkTools\Database\DatabaseConnection;

class InsertDataController extends AbstractControllers{

    public function exec() {
        $pdo = DatabaseConnection::start()->getPDO();
        $params = $this->processServerElements->getInputJSONData();
        $response = ['success'=> true];
        $attrName;

        try {
            
            if (!$params['name']) {
                $attrName = 'name';
                throw new \Exception('the name has to be send in the request');
            }   
    
            if (!$params['last_name']) {
                $attrName = 'last_name';
                throw new \Exception('the last_name has to be send in the request');
            }

            if (!$params['age']) {
                $attrName = 'age';
                throw new \Exception('the age has to be send in the request');
            }
    
            $query = "INSERT INTO user (name,last_name,age) VALUES (:name,:last_name,:age)";
            
            $statement = $pdo->prepare($query);
     
            $statement->execute([
                ':name' => $params["name"],
                ':last_name' => $params["lastName"],
                ':age' => $params["age"]
            ]);

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'missingAttribute' => $attrName
            ];
        }

        view($response);
    }

}
