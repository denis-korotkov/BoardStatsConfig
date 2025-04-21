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
                $fieldPayload = $field->getPayload();
                if (array_key_exists('valuesType', $fieldPayload) && $fieldPayload['valuesType'] == 'relation') {
                    if ($fieldPayload['values'] == 'gameMode') {
                        $fieldPayload['values'] = $game->getGameModes()->map(function ($gameMode) {
                            return $gameMode->getName();
                        })->toArray();
                    }
                    if ($fieldPayload['values'] == 'player') {
                        $fieldPayload['values'] = $game->getPlayers()->map(function ($player) {
                            return $player->getName();
                        })->toArray();
                    }
                    $field->setPayload($fieldPayload);
                }
            return $field;
        });
    }

}
