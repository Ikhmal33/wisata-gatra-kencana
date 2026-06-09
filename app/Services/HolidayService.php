<?php

namespace App\Services;

use Carbon\Carbon;

class HolidayService
{
    protected static array $holidays = [
        '01-01','01-29','02-28','03-29','03-31',
        '04-18','04-20','04-21','05-01','05-29',
        '06-01','06-06','06-27','08-17',
        '09-05','12-25','12-26',
    ];

    // Update these dates each year to match actual Eid window
    protected static array $lebaranDates = [
        '03-30','03-31','04-01','04-02','04-03',
    ];

    public static function isHoliday(Carbon $date): bool
    {
        return in_array($date->format('m-d'), self::$holidays);
    }

    public static function isWeekend(Carbon $date): bool
    {
        return $date->isWeekend();
    }

    public static function isWeekendOrHoliday(?Carbon $date = null): bool
    {
        $date = $date ?? now();
        return self::isWeekend($date) || self::isHoliday($date);
    }

    public static function isLebaran(?Carbon $date = null): bool
    {
        $date = $date ?? now();
        return in_array($date->format('m-d'), self::$lebaranDates);
    }

    public static function getLabel(?Carbon $date = null): string
    {
        $date = $date ?? now();
        if (self::isLebaran($date)) return 'Lebaran / Eid';
        return self::isWeekendOrHoliday($date) ? 'Weekend / Hari Libur' : 'Hari Kerja';
    }

    public static function getLoketMasukPrices(?Carbon $date = null): array
    {
        $date = $date ?? now();
        if (self::isLebaran($date)) {
            return ['adult'=>10000,'child'=>10000,'terusan'=>0,'mode'=>'lebaran'];
        }
        if (self::isWeekendOrHoliday($date)) {
            return ['adult'=>7000,'child'=>3000,'terusan'=>12000,'mode'=>'weekend'];
        }
        return ['adult'=>5000,'child'=>2000,'terusan'=>12000,'mode'=>'weekday'];
    }

    public static function getFlatPrice(): array
    {
        return ['adult'=>5000,'child'=>5000,'terusan'=>5000,'mode'=>'flat'];
    }

    public static function getPricesForDate(Carbon $date, string $boothType = 'loket_masuk'): array
    {
        if ($boothType === 'loket_masuk') {
            return self::getLoketMasukPrices($date);
        }
        return self::getFlatPrice();
    }

    public static function getLebaranDatesJson(): string
    {
        return json_encode(self::$lebaranDates);
    }

    public static function getHolidayDatesJson(): string
    {
        return json_encode(self::$holidays);
    }
}