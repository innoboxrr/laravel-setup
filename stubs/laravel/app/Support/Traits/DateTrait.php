<?php

namespace App\Support\Traits;

use Carbon\Carbon;

trait DateTrait 
{
    /**
     * Get a random past date within the provided maxPast days.
     */
    public function getRandomPastDate($maxPast)
    {
        $now = Carbon::now();
        $randomDaysAgo = rand(0, $maxPast);

        // Restar días
        $randomDate = (clone $now)->subDays($randomDaysAgo);

        // Agregar horas, minutos y segundos aleatorios
        $randomHours = rand(0, 23);
        $randomMinutes = rand(0, 59);
        $randomSeconds = rand(0, 59);

        return $randomDate->setTime($randomHours, $randomMinutes, $randomSeconds);
    }
}