<?php

namespace Modules\ContactUs\Models;

use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ContactUs\Database\Factories\ContactUsMessageFactory;

#[UseFactory(ContactUsMessageFactory::class)]
class ContactUsMessage extends Model
{
    /** @use HasFactory<ContactUsMessageFactory> */
    use HasFactory, HasUlids, SoftDeletes;

    /**
     * cast fields
     */
    protected function casts(): array
    {
        return [
            "is_seen" => "boolean",
            "replied_at" => "datetime",
        ];
    }
}
