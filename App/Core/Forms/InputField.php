<?php

namespace App\Core\Forms;

use App\Core\Models\Model;

class InputField extends Field
{
    public function __construct(Model $model, string $attribute, array $properties)
    {
        parent::__construct($model, $attribute, $properties);
    }

    // render input field
    public function render(): string
    {
        return sprintf('<input type="%s" name="%s" value="%s" class="form-control %s" %s placeholder="%s">',
            $this->properties['type'] ?? 'text',
            $this->properties['name'] ?? $this->attribute,
            $this->model->{$this->attribute},
            $this->model->hasError($this->attribute) ? 'is-invalid' : '',
            $this->properties['required'] ?? '',
            $this->properties['placeholder'] ?? ''
        );
    }
}