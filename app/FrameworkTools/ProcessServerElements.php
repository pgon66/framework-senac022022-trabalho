<?php

namespace App\FrameworkTools;

class ProcessServerElements {

    private static $instance;

    private $documentRoot;
    private $serverName;

    private function __construct() {
        // SINGLETON 
    }

    public static function start() {
        if (!ProcessServerElements::$instance) {
            ProcessServerElements::$instance = new ProcessServerElements();
        }

        return ProcessServerElements::$instance;
    }

    public function setDocumentRoot($documentRoot) {
        $this->documentRoot = $documentRoot;
    }

    public function getDocumentRoot() {
        return $this->documentRoot;
    }

    public function setServerName($serverName) {
        $this->serverName = $serverName;
    }

    public function getServerName() {
        return $this->serverName;
    }
}