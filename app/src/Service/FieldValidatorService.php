<?php

namespace App\Service;

use App\Entity\Game;

class FieldValidatorService
{

    public function validate(array $value, Game $game): array
    {
        $fields = $game->getFields();
        $result = [];
        foreach ($fields as $field) {
            $fieldSlug = $field->getSlug();
            if (isset($value[$fieldSlug])) $result[$fieldSlug] = $value[$fieldSlug];
        }
        return $result;
    }
}
