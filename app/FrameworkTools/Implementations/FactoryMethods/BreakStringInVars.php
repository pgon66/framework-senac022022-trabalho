<?php

namespace App\FrameworkTools\Implementations\FactoryMethods;

trait BreakStringInVars {

    public function breakStringInVars($requestUri) {
        $urlAndVars = explode("?",$requestUri);

        if (!isset($urlAndVars[1])) {
            return;
        }
    
        $stringWithVars = $urlAndVars[1];

        $arrayWithVars = explode("&",$stringWithVars);
        
        $varsOfUrl = array_map(function($element) { 
            return explode("=",$element);
        },$arrayWithVars);

        DD($varsOfUrl);
    }
}