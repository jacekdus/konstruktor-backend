<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property mixed|string login
 * @property mixed|string password
 * @method static find(int $int)
 * @method static where(string $string, array|string|null $header)
 * @method static insert(array $array)
 */
class User extends \Illuminate\Database\Eloquent\Model
{
    public function projects(): HasMany {
        return $this->hasMany(Project::class);
    }
}
