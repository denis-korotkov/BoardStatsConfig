<?php

namespace App\Service;

use App\Entity\Field;
use App\Entity\Game;
use App\Repository\GameModeRepository;
use Doctrine\Common\Collections\Collection;

class FieldService
{
    public function __construct(protected readonly GameModeRepository $gameModeRepository)
    {
    }

    public function getFields(Game $game): Collection
    {
        $fields = $game->getFields();
        return $fields->map(function (Field $field) use ($game) {
            if ($field->getSlug() == 'gameMode') {
                $fieldPayload = $field->getPayload();
                if ($fieldPayload['valuesType'] == 'array') {
                    foreach ($game->getGameModes() as $gameMode) {
                        $fieldPayload['values'][$gameMode->getSlug()] = $gameMode->getName();
                    }
                }
                $field->setPayload($fieldPayload);
            }
            return $field;
        });
    }

}
