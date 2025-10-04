<?php

namespace App\Services;

use App\Models\Activity;

class ActivityService
{
    public function getActivityWithDescendantsIds(Activity $activity)
    {
        $ids = [$activity->id];

        if ($activity->level < 3) {
            foreach ($activity->children as $child) {
                $ids = array_merge($ids, $this->getActivityWithDescendantsIds($child));
            }
        }

        return $ids;
    }
}
