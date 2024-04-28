<?php

class Filter
{
    protected $entityList;

    protected $countryCounter;

    public function __construct(array $entityList)
    {
        $this->entityList = $entityList;
    }

    public function getEntityContainsSaintWord(array $entity): array {
        return array_filter($this->entityList, function($entity) {
            return stripos($entity[0], 'saint');
        });
    }

    public function getCityCountrySameCharacter(array $entity): array {
        return array_filter($this->entityList, function($entity) {
            return substr($entity[0], 0, 1) == substr($entity[3], 0, 1);
        });
    }


    protected function isCityAsia(array $entity): bool
    {
        $lat_east =  66.05;
        $lng_east =  169.4;
        $lat_north = 77.43;
        $lng_north = 104.18;
        $lat_west =  39.29;
        $lng_west =  26.04;
        $lat_south = 1.16;
        $lng_south = 103.30;

        $lat = (float) $entity[1];
        $lng = (float) $entity[2];

        if (($lat_north >= $lat) && ($lat >= $lat_south)) {
            if (($lng_east >= $lng) && ($lng >= $lng_west)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityEurope(array $entity): bool
    {
        $lat_east = 67.45;
        $lng_east = 66.13;
        $lat_north = 71.08;
        $lng_north = 27.39;
        $lat_west = 38.46;
        $lng_west = -9.29;
        $lat_south = 36.00;
        $lng_south = -5.36;

        $lat = (float) $entity[1];
        $lng = (float) $entity[2];

        if (($lat_north >= $lat) && ($lat >= $lat_south)) {
            if (($lng_east >= $lng) && ($lng >= $lng_west)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityAfrica(array $entity): bool
    {
        $lat_east = 10.25;
        $lng_east = 51.21;
        $lat_north = 77.43;
        $lng_north = 104.18;
        $lat_west = 39.29;
        $lng_west = 26.10;
        $lat_south = 1.16;
        $lng_south = -103.3;

        $lat = (float) $entity[1];
        $lng = (float) $entity[2];

        if (($lat_north >= $lat) && ($lat >= $lat_south)) {
            if (($lng_east >= $lng) && ($lng >= $lng_west)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityNorthAmerica(array $entity): bool
    {
        $lat_east = 52.24;
        $lng_east = -55.40;
        $lat_north = 71.50;
        $lng_north = -94.45;
        $lat_west = 65.35;
        $lng_west = -168.00;
        $lat_south = 7.13;
        $lng_south = -80.52;

        $lat = (float) $entity[1];
        $lng = (float) $entity[2];

        if (($lat_north >= $lat) && ($lat >= $lat_south)) {
            if (($lng_east >= $lng) && ($lng >= $lng_west)) {
                return true;
            }
        }

        return false;
    }

    protected function isCitySouthAmerica(array $entity): bool
    {
        $lat_east = -7.09;
        $lng_east = -34.47;
        $lat_north = 12.00;
        $lng_north = -72.00;
        $lat_west = -4.40;
        $lng_west = -81.20;
        $lat_south = -53.54;
        $lng_south = -71.18;

        $lat = (float) $entity[1];
        $lng = (float) $entity[2];

        if (($lat_north >= $lat) && ($lat >= $lat_south)) {
            if (($lng_east >= $lng) && ($lng >= $lng_west)) {
                return true;
            }
        }

        return false;
    }

    protected function isCityAustralia(array $entity): bool
    {
        $lat_east = -28.38;
        $lng_east = 153.38;
        $lat_north = -10.41;
        $lng_north = 142.31;
        $lat_west = -26.09;
        $lng_west = 113.09;
        $lat_south = -39.08;
        $lng_south = 146.22;

        $lat = (float) $entity[1];
        $lng = (float) $entity[2];

        if (($lat_north >= $lat) && ($lat >= $lat_south)) {
            if (($lng_east >= $lng) && ($lng >= $lng_west)) {
                return true;
            }
        }

        return false;
    }

    public function getAsianCity(array $entity): array
    {
        $asianCity = array_filter($this->entityList, [$this, 'isCityAsia']);
        $this->countryCounter[0] = count($asianCity);
        return $asianCity;
    }

    public function getEuCity(array $entity): array
    {
        $euCity = array_filter($this->entityList, [$this, 'isCityEurope']);
        $this->countryCounter[1] = count($euCity);
        return $euCity;
    }

    public function getAfrCity(array $entity): array
    {
        $afrCity = array_filter($this->entityList, [$this, 'isCityAfrica']);
        $this->countryCounter[2] = count($afrCity);
        return $afrCity;
    }

    public function getNaCity(array $entity): array
    {
        $naCity = array_filter($this->entityList, [$this, 'isCityNorthAmerica']);
        $this->countryCounter[3] = count($naCity);
        return $naCity;
    }

    public function getSaCity(array $entity): array
    {
        $saCity = array_filter($this->entityList, [$this, 'isCitySouthAmerica']);
        $this->countryCounter[4] = count($saCity);
        return $saCity;
    }

    public function getAuCity(array $entity): array
    {
        $auCity = array_filter($this->entityList, [$this, 'isCityAustralia']);
        $this->countryCounter[5] = count($auCity);
        return $auCity;
    }

    public function getCountryCounter(): array
    {
        return $this->countryCounter ?? [0,0,0,0,0];
    }
}
