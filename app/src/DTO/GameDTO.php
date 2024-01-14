<?php

use Psr\Log\LoggerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraints as Assert;

class GameDTO
{
    /**
     * @var string A "H:i:s" formatted value
     */
    #[Assert\Time]
    public string $date;

    public function __construct(
        public bool   $result,
        public string  $players,
        public string $duration,
        string        $date
    )
    {
        $this->date = $date;
    }

    public static function factory(array $data) : self{
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return new self(
            $propertyAccessor->getValue($data, '[result]'),
            $propertyAccessor->getValue($data, '[players]'),
            $propertyAccessor->getValue($data, '[duration]'),
            $propertyAccessor->getValue($data, '[date]'),
        );
    }
}