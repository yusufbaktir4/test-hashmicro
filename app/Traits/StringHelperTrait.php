<?php

namespace App\Traits;

use Carbon\Carbon;

trait StringHelperTrait
{
    public static function dateFormat($date, $dateFormat = null) {
        if(!is_null($dateFormat)) {
                $date = Carbon::parse($date)->format($dateFormat);
        } else {
                $date = Carbon::parse($date)->format("d/m/Y H:i");
        }

        return $date;
    }
}
