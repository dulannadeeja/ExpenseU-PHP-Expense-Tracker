<?php

namespace App\Core\Models;

abstract class Model
{

    // load data to the model
    public function loadData(array $data):void
    {
        foreach($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    // validate data
    public abstract function validate():bool|array;

    // get validation requirements
    public abstract function getRequirements():array;

    // whether the attribute has an error
    public abstract function hasError(string $attribute):bool;

    // get the first error of the attribute
    public abstract function getFirstError(string $attribute):string;

    // get the table name
    public static abstract function tableName():string;

    // get the primary key
    public static abstract function primaryKey():string;

}