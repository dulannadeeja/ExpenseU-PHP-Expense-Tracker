<?php

namespace App\Core\Forms;

use App\Core\Models\Model;
use App\Core\Traits\ResolveLabel;

abstract class Field
{
    use ResolveLabel;
    function __construct(protected Model $model, protected string $attribute, protected array $properties)
    {
    }

    public abstract function render(): string;

    public function __toString(): string
    {
        return sprintf(
            "
            <div class='mb-3'>
                <label for='%s' class='form-label'>%s</label>
                %s
                <div id='field-error' class='form-text invalid-feedback'>%s</div>
            </div>
            ",
            $this->attribute,
            $this->ResolveLabel($this->attribute),
            $this->render(),
            $this->model->hasError($this->attribute) ? $this->model->getFirstError($this->attribute) : ''
        );
    }


}