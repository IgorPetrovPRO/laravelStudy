<?php

namespace Support\Traits\Models;

use Illuminate\Database\Eloquent\Model;

trait HasSlug
{

    protected static function bootHasSlug()
    {
        static::creating(function (Model $item) {
            $item->makeSlug();
        });
    }

    public static function slugFrom(): string
    {
        return 'title';
    }

    protected function makeSlug():void
    {
        $slug = $this->slugUnique(
            str($this->{$this->slugFrom()})
            ->slug()
            ->value()
        );

        $this->{$this->slugColumn()} = $slug;
    }

    protected function slugColumn() :string
    {
        return 'slug';
    }

    private function slugUnique(string $slug):string
    {
        $originalSlug = $slug;
        $i =0;

        while($this->isSlugExists($slug)){
            $i++;
            $slug = $originalSlug .'-'.$i;
        }

        return $slug;
    }

    private function isSlugExists(string $slug):bool
    {
        $query = $this->newQuery()
            ->where(self::slugColumn(),$slug)
            ->where($this->getKeyName(),'!=',$this->getKey())
            ->withoutGlobalScopes();

        return $query->exists();
    }
}
