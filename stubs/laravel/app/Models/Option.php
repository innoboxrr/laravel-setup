<?php

namespace App\Models;

use App\Models\Traits\Assignments\OptionAssignment;
use App\Models\Traits\Mutators\OptionMutators;
use App\Models\Traits\Operations\OptionOperations;
use App\Models\Traits\Relations\OptionRelations;
use App\Models\Traits\Storage\OptionStorage;
use App\Support\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
use Innoboxrr\Traits\MetaOperations;

class Option extends Model
{
    use Auditable,
        HasFactory,
        MetaOperations,
        OptionAssignment,
        OptionMutators,
        OptionOperations,
        OptionRelations,
        OptionStorage,
        SoftDeletes,
        TranslationTrait;

    protected $fillable = [
        'name',
        'key',
        'value',
    ];

    protected $creatable = [
        'name',
        'key',
        'value',
    ];

    protected $updatable = [
        'name',
        'key',
        'value',
    ];

    protected $translationable = [
        'name',
        'value',
        'lang',
    ];

    protected $casts = [];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'name',
        'key',
        'value',
    ];

    public static $loadable_relations = [];

    public static $loadable_counts = [];

    /*
    protected static function newFactory()
    {
        return \App\Database\Factories\OptionFactory::new();
    }
    */

}
