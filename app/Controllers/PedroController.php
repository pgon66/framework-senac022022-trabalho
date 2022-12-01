<?php

namespace App\Controllers;

use App\FrameworkTools\Abstracts\Controllers\AbstractControllers;

use App\FrameworkTools\Database\DatabaseConnection;

class PedroController extends AbstractControllers{

    private $params;
    private $attrName;

    public function goncalves1() {
        $pdo = DatabaseConnection::start()->getPDO();

        $petshop = $pdo->query("SELECT * FROM petshop;")->fetchAll();

        view($petshop);
    }

    public function goncalves2() {

        try {

            $response = ['success'=> true];

            $this->params = $this->processServerElements->getInputJSONData();
    
            $this->verificationInputVar();
    
            $query = "INSERT INTO petshop (name_pet,type_service) VALUES (:name_pet,:type_service)";
            
            $statement = $this->pdo->prepare($query); 

            $statement->execute([
                ':name_pet' => $this->params["name_pet"],
                ':type_service' => $this->params["type_service"]
            ]);

        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'missingAttribute' => $this->attrName
            ];
        }

        view($response);

    }

    public function goncalves3() {
        
        $id_pet;
        $missingAttribute;
        $response = [
            'success' => true
        ];

        try {

            $requestVariables = $this->processServerElements->getVariables();

            if ((!$requestVariables) || (sizeof($requestVariables) === 0)) {
                $missingAttribute = 'variableIsEmpty';
                throw new \Exception("You need to insert variables in url.");
            }

            foreach ($requestVariables as $requestVariable) {
                if ($requestVariable['name'] === 'id_pet') {
                    $id_pet = $requestVariable['value'];
                }
            }

            if (!$id_pet) {
                $missingAttribute = 'petIdIsNull';
                throw new \Exception("You need to inform id_pet variable.");
            }

            $petshop = $this->pdo->query("SELECT * FROM petshop WHERE id_petshop = '{$id_pet}';")
                ->fetchAll();

            if (sizeof($petshop) === 0) {
                $missingAttribute = 'thisPetNoExist';
                throw new \Exception("There is not record of this pet in db.");
            }

            $params = $this->processServerElements->getInputJSONData();

            if((!$params) || sizeof($params) === 0) {
                $missingAttribute = 'paramsNotExist';
                throw new \Exception("You have to inform the params attr to update.");
            }

            $updateStructureQuery = '';

            $toStatement = [];

            foreach ($params as $key => $value) {
                if (!in_array($key,['name_pet', 'type_service'])) {
                    $missingAttribute = 'keyNotAcceptable';
                    throw new \Exception($key);
                }

                if ($key === 'name_pet') {
                    $updateStructureQuery .= "name_pet = :name_pet,";
                    $toStatement[':name_pet'] = $value;
                }

                if ($key === 'type_service') {
                    $updateStructureQuery .= "type_service = :type_service,";
                    $toStatement[':type_service'] = $value;
                }
            }
            
            $newStringElementsSQL = substr($updateStructureQuery,0,-1);

            $sql = "UPDATE
                        petshop
                    SET
                        {$newStringElementsSQL}
                    WHERE
                        id_petshop = {$id_pet}
            ";

            $statement = $this->pdo->prepare($sql);

            $statement->execute($toStatement);
            
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => $e->getMessage(),
                'missingAttribute' => $missingAttribute
            ];
        }

        view($response);
    }

    public function goncalves4() {
        
        $id_pet;
        $response = ['success' => true];

        $requestVariables = $this->processServerElements->getVariables();

        try {

            foreach ($requestVariables as $valueVariable) {
                if ($valueVariable["name"] === "id_pet") {
                    $id_pet = $valueVariable["value"];
                }
            }

            if(!$id_pet) {
                $missingAttribute = 'petIdIsNull';
                throw new \Exception("You need to inform petId variable");
            }
    
            $petshop = $this
                        ->pdo
                        ->query("SELECT * FROM petshop WHERE id_petshop = '{$id_pet}';")
                        ->fetchAll();

            if (sizeof($petshop) === 0) {
                $missingAttribute = 'thisPetNoExist';
                throw new \Exception("There is not record of this pet in db");
            }

            $sql = "DELETE FROM petshop WHERE id_petshop= :id_pet";
    
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['id_pet' => $id_pet]);

        } catch (\Exception $e) {

            $response = [
                'sucess' => false,
                'message' => $e->getMessage(),
                'missingAttribute' => $missingAttribute
            ];

        }

        view($response);
    }


    private function verificationInputVar() {
        
        if (!$this->params['name_pet']) {
            $this->attrName = 'name_pet';
            throw new \Exception('the name_pet has to ben send in the request');
        }

        if (!$this->params['type_service']) {
            $this->attrName = 'type_service';
            throw new \Exception('the type_service has to be send in the request');
        }

    }

}
