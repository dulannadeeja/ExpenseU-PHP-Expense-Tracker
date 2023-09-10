<?php

namespace App\Core\Forms;

use App\Core\Models\Model;

class Form
{

    public function __construct(private string $method, private string $action, private string $name, private string $id)
    {

    }

    // start form
    public function begin(): void
    {
        echo sprintf("<form method='%s' action='%s' name='%s' id='%s'>",
            $this->method,
            $this->action,
            $this->name,
            $this->id
        );
    }

    // end form
    public function end(): void
    {
        echo "</form>";
    }

    // input field
    public function inputField(Model $model, string $attribute, array $properties): InputField
    {
        return new InputField($model, $attribute, $properties);
    }

    // text area
    public function textArea(Model $model, string $attribute): TextArea
    {
        return new TextArea($model, $attribute);
    }

}