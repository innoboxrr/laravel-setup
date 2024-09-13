<?php

namespace App\Support\Traits;

use App\Support\Enums\Status;

trait StatusTrait
{
    public function isFree(): bool
    {
        return $this->status === Status::Free;
    }

    public function isPublished(): bool
    {
        return $this->status === Status::Published;
    }

    public function isDraft(): bool
    {
        return $this->status === Status::Draft;
    }

    public function isPending(): bool
    {
        return $this->status === Status::Pending;
    }

    public function isRejected(): bool
    {
        return $this->status === Status::Rejected;
    }

    public function isActive(): bool
    {
        return $this->status === Status::Active;
    }

    public function isInactive(): bool
    {
        return $this->status === Status::Inactive;
    }
}
