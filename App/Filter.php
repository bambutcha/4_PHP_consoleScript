<?php

namespace App;
class Filter
{
    protected $entityList;

    public function __construct(array $entityList)
    {
        $this->entityList = $entityList;
    }

    public function getEntityContainsSaintWord(array $entity): array
    {
        return array_filter($this->entityList, function ($entity) {
            return stripos($entity[0], 'saint');
        });
    }

    public function getCityCountrySameCharacter(array $entity): array
    {
        return array_filter($this->entityList, function ($entity) {
            return substr($entity[0], 0, 1) == substr($entity[3], 0, 1);
        });
    }


    protected function isCityAsia(array $entity): bool
    {
        $latEast = 66.05;
        $lngEast = 169.4;
        $latNorth = 77.43;
        $lngNorth = 104.18;
        $latWest = 39.29;
        $lngWest = 26.04;
        $latSouth = 1.16;
        $lngSouth = 103.30;

        $lat = (float)$entity[1];
        $lng = (float)$entity[2];

        if (($latNorth >= $lat) && ($lat >= $latSouth)) {
            if (($lngEast >= $lng) && ($lng >= $lngWest)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityEurope(array $entity): bool
    {
        $latEast = 67.45;
        $lngEast = 66.13;
        $latNorth = 71.08;
        $lngNorth = 27.39;
        $latWest = 38.46;
        $lngWest = -9.29;
        $latSouth = 36.00;
        $lngSouth = -5.36;

        $lat = (float)$entity[1];
        $lng = (float)$entity[2];

        if (($latNorth >= $lat) && ($lat >= $latSouth)) {
            if (($lngEast >= $lng) && ($lng >= $lngWest)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityAfrica(array $entity): bool
    {
        $latEast = 10.25;
        $lngEast = 51.21;
        $latNorth = 77.43;
        $lngNorth = 104.18;
        $latWest = 39.29;
        $lngWest = 26.10;
        $latSouth = 1.16;
        $lngSouth = -103.3;

        $lat = (float)$entity[1];
        $lng = (float)$entity[2];

        if (($latNorth >= $lat) && ($lat >= $latSouth)) {
            if (($lngEast >= $lng) && ($lng >= $lngWest)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityNorthAmerica(array $entity): bool
    {
        $latEast = 52.24;
        $lngEast = -55.40;
        $latNorth = 71.50;
        $lngNorth = -94.45;
        $latWest = 65.35;
        $lngWest = -168.00;
        $latSouth = 7.13;
        $lngSouth = -80.52;

        $lat = (float)$entity[1];
        $lng = (float)$entity[2];

        if (($latNorth >= $lat) && ($lat >= $latSouth)) {
            if (($lngEast >= $lng) && ($lng >= $lngWest)) {
                return true;
            }
        }

        return false;
    }

    protected function isCitySouthAmerica(array $entity): bool
    {
        $latEast = -7.09;
        $lngEast = -34.47;
        $latNorth = 12.00;
        $lngNorth = -72.00;
        $latWest = -4.40;
        $lngWest = -81.20;
        $latSouth = -53.54;
        $lngSouth = -71.18;

        $lat = (float)$entity[1];
        $lng = (float)$entity[2];

        if (($latNorth >= $lat) && ($lat >= $latSouth)) {
            if (($lngEast >= $lng) && ($lng >= $lngWest)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityAustralia(array $entity): bool
    {
        $latEast = -28.38;
        $lngEast = 153.38;
        $latNorth = -10.41;
        $lngNorth = 142.31;
        $latWest = -26.09;
        $lngWest = 113.09;
        $latSouth = -39.08;
        $lngSouth = 146.22;

        $lat = (float)$entity[1];
        $lng = (float)$entity[2];

        if (($latNorth >= $lat) && ($lat >= $latSouth)) {
            if (($lngEast >= $lng) && ($lng >= $lngWest)) {
                return true;
            }
        }

        return false;
    }

    public function getAsianCity(): array
    {
        return array_filter($this->entityList, [$this, 'isCityAsia']);
    }

    public function getEuCity(): array
    {
        return array_filter($this->entityList, [$this, 'isCityEurope']);
    }

    public function getAfrCity(): array
    {
        return array_filter($this->entityList, [$this, 'isCityAfrica']);
    }

    public function getNaCity(): array
    {
        return array_filter($this->entityList, [$this, 'isCityNorthAmerica']);
    }

    public function getSaCity(): array
    {
        return array_filter($this->entityList, [$this, 'isCitySouthAmerica']);
    }

    public function getAuCity(): array
    {
        return array_filter($this->entityList, [$this, 'isCityAustralia']);
    }
}
