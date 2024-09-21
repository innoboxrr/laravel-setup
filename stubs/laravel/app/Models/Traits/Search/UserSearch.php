<?php

namespace App\Models\Traits\Search;

trait UserSearch
{
    public function getSearchImage(): ?string
    {
        return $this->avatar_url;
    }

    public function getSearchTerm(): string
    {
        return $this->full_name;
    }

    public function getSearchDescription(): ?string
    {
        return $this->bio_about;
    }

    public function getSearchLink(): ?string
    {
        return url('app/user/' . $this->id . '/profile');
    }

    public function getSearchSearchableType(): string
    {
        return self::class;
    }

    public function getSearchSearchableId(): int
    {
        return $this->id;
    }

    public function getSearchOther(): ?array
    {
        return [
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}