<?php

namespace App\Controllers;

use App\FrameworkTools\Abstracts\Controllers\AbstractControllers;

class UpdateDataController extends AbstractControllers {

    public function exec() {
        $userId;
        $missingAttribute;
        $response = [
            'success' => true
        ];

        try {
            $requestsVariables = $this->processServerElements->getVariables();

            if ((!$requestsVariables) || (sizeof($requestsVariables) === 0)) {
                $missingAttribute = 'variableIsEmpty';
                throw new \Exception("You need to insert variables in url");
            }

            foreach ($requestsVariables as $requestVariable) {
                if ($requestVariable['name']  === 'userId') {
                    $userId = $requestVariable['value'];
                }
            }

            if (!$userId) {
                $missingAttribute = 'userIdIsNull';
                throw new \Exception("You need to inform userId variable");
            }

            $users = $this->pdo->query("SELECT * FROM user WHERE id_user = '{$userId}';")
                ->fetchAll();

            if (sizeof($users) === 0) {
                $missingAttribute = 'thisUserNoExist';
                throw new \Exception("There is not record of this user in db");
            }

            $params = $this->processServerElements->getInputJSONData();

            if ((!$params) || sizeof($params) === 0) {
                $missingAttribute = 'paramsNotExist';
                throw new \Exception("You have to inform the params attr to update");
            }

            $updateStructureQuery = '';


            foreach ($params as $key => $value) {
                if (!in_array($key,['name','last_name','age'])) {
                    $missingAttribute = "keyNotAcceptable";
                    throw new \Exception($key);
                }

                if ($key === 'name') {
                    $updateStructureQuery .= "name = :name,";

                }

                if ($key === 'last_name') {

                    $updateStructureQuery .= " last_name = :last_name,";

                }

                if ($key === 'age') {
                    $updateStructureQuery .= "age = :age,";
                }

            }

            $updateStringInArray = str_split($updateStructureQuery);
            
            array_pop($updateStringInArray);

            $newStringElementsSQL = implode($updateStringInArray);

            $sql = "UPDATE 
                        user 
                    SET
                        {$newStringElementsSQL}
                    WHERE
                        id_user = {$userId}
                    ";

            $statement = $this->pdo->prepare($sql);
            
            $statement->execute([
                ':name' => $params["name"],
                ':last_name' => $params["last_name"],
                ':age' => $params["age"]
            ]);

            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'missingAttribute' => $missingAttribute
            ];
        }

        view($response);
    }
}