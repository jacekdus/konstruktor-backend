<?php


namespace App\Models;


use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array|mixed|string|null name
 * @property array|mixed|string|null data
 * @property mixed user_id
 * @method static leftJoin(string $string, string $string1, string $string2, string $string3)
 */
class Project extends \Illuminate\Database\Eloquent\Model
{
    use SoftDeletes;
}
