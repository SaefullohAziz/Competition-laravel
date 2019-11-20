<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\Pivot;

trait Uuids
{
    /**
     * Set primary key with random UUID
     */
    protected static function bootUuids()
    {
        static::creating(function ($model) {
            if ( ! $model->getKey()) {
                $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    /**
     * Disable auto-increment for parimary key
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Change primary key type as string
     */
    public function getKeyType()
    {
        return 'string';
    }
}