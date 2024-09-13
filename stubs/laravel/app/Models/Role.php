<?php

namespace App\Models;

use App\Models\Traits\Assignments\RoleAssignment;
use App\Models\Traits\Mutators\RoleMutators;
use App\Models\Traits\Operations\RoleOperations;
use App\Models\Traits\Relations\RoleRelations;
use App\Models\Traits\Storage\RoleStorage;
use App\Support\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\LaravelAudit\Support\Traits\Auditable;
use Innoboxrr\Traits\MetaOperations;

class Role extends Model
{
    use Auditable,
        HasFactory,
        MetaOperations,
        RoleAssignment,
        RoleMutators,
        RoleOperations,
        RoleRelations,
        RoleStorage,
        SoftDeletes,
        TranslationTrait;

    const ADMIN = 'admin';
    const COURSE_CREATOR = 'course-creator';
    const MODERATOR = 'moderator';
    const TRANSLATOR = 'translator';
    const USER = 'user';
    const STUDENT = 'student';
    const TEACHER = 'teacher';
    const EDIT_TEACHER = 'edit-teacher';
    const HEAD_TEACHER = 'head-teacher';
    const TEACHER_ROLES = ['teacher', 'edit-teacher', 'head-teacher'];

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $creatable = [
        'name',
        'slug',
    ];

    protected $updatable = [
        'name',
    ];

    protected $translationable = [
        'name',
        'lang',
    ];

    protected $casts = [];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'name',
        'slug',
    ];

    public static $loadable_relations = [
        'roles',
    ];

    public static $loadable_counts = [
        'roles',
    ];

    /*
    protected static function newFactory()
    {
        return \App\Database\Factories\RoleFactory::new();
    }
    */

}
