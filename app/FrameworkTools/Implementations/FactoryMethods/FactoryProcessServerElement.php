<?php

namespace App\FrameworkTools\Implementations\FactoryMethods;

use App\FrameworkTools\Abstracts\FactoryMethods\AbstractFactoryMethods;
use App\FrameworkTools\ProcessServerElements;

class FactoryProcessServerElement extends AbstractFactoryMethods {

    private $processServerElements;

    public function __construct() {
        $this->processServerElements = ProcessServerElements::start();
    }

    public function operation() {
        $this->processServerElements->setDocumentRoot($_SERVER['DOCUMENT_ROOT']);
        $this->processServerElements->setServerName($_SERVER['SERVER_NAME']);
        dd($this->processServerElements);
    }
}