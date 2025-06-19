<?php
namespace App\Models\Traits;

Trait QueryBuilderBindable
{
    public function resolveRouteBinding($value, $field = null)
    {
        /*
         *     public function resolveRouteBinding($value, $field = null)
    {
        return $this->resolveRouteBindingQuery($this, $value, $field)->first();
    }
         */
        if ($field !== null) {
            return parent::resolveRouteBinding($value, $field);
        }
        $queryClass = property_exists($this, 'queryClass')
            ? $this->queryClass
            : '\\App\\Http\\Queries\\'.class_basename(self::class).'Query';

        if (!class_exists($queryClass)) {
            return parent::resolveRouteBinding($value, $field);
        }

        return (new $queryClass($this))
            ->where($this->getRouteKeyName(), $value)
            ->first();
    }
}
