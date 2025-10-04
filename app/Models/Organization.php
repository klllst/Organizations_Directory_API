<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property int $id
 * @property string $name
 * @property int $building_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Building $building
 * @property-read Collection|OrganizationPhone[] $phones
 * @property-read Collection|Activity[] $activities
 *
 * @method static Builder filter(array $fields, mixed $filter = null)
 */
class Organization extends Model
{
    use Filterable, HasFactory;

    protected $fillable = [
        'name',
        'building_id',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function phones(): HasMany
    {
        return $this->hasMany(OrganizationPhone::class);
    }

    public function activities(): BelongsToMany
    {
        return $this->belongsToMany(Activity::class);
    }
}
