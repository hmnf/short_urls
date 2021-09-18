<?php

class Response {
    public function json(mixed $args): void 
    {
        if(count($args) > 1){
            foreach($args as $arg){
                if(!is_object($arg) && !is_array($arg)){
                    echo json_encode($arg);
                }else{
                    if(count($arg) > 1){
                        foreach($arg as $elem){
                            echo json_encode($elem->getData(), JSON_FORCE_OBJECT);
                        }
                    }else{
                        echo json_encode($arg->getData(), JSON_FORCE_OBJECT);
                    }
                } 
            }
        }else{
            foreach($args[key($args)] as $elem){
                if(is_object($elem)){
                    echo json_encode($elem->getData(), JSON_FORCE_OBJECT);
                }else{
                    echo json_encode($elem);
                }
            }
        }
    }
}