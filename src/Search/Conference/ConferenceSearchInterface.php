<?php

namespace App\Search\Conference;

use App\Entity\Conference;

interface ConferenceSearchInterface
{
    /**
     * @return list<Conference>
     */
    public function searchByName(string|null $name = null): array;
}
