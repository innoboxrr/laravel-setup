<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Innoboxrr\Traits\MetaOperations;
use App\Models\Traits\Relations\TrackingEventRelations;
use App\Models\Traits\Storage\TrackingEventStorage;
use App\Models\Traits\Assignments\TrackingEventAssignment;
use App\Models\Traits\Operations\TrackingEventOperations;
use App\Models\Traits\Mutators\TrackingEventMutators;

class TrackingEvent extends Model
{

    use HasFactory,
        SoftDeletes,
        MetaOperations,
        TrackingEventRelations,
        TrackingEventStorage,
        TrackingEventAssignment,
        TrackingEventOperations,
        TrackingEventMutators;
        
    protected $fillable = [
        'uuid',
        'event_name',       // Nombre del evento
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'fbclid',
        'ttclid',
        'ip_address',
        'user_agent',
        'geo', // Puede usarse para almacenar la ubicación geográfica
        'platforms', // Puede usarse para almacenar la información del dispositivo
        'event_data', // Datos adicionales del evento
        'user_id', // ID del usuario, si aplica
        'cart_id', // ID del carrito, si aplica
    ];

    protected $creatable = [
        'uuid',
        'event_name',       // Nombre del evento
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'fbclid',
        'ttclid',
        'ip_address',
        'user_agent',
        'geo', // Puede usarse para almacenar la ubicación geográfica
        'platforms', // Puede usarse para almacenar la información del dispositivo
        'event_data', // Datos adicionales del evento
        'user_id', // ID del usuario, si aplica
        'cart_id', // ID del carrito, si aplica
    ];

    protected $updatable = [
        'uuid',
        'event_name',       // Nombre del evento
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'fbclid',
        'ttclid',
        'ip_address',
        'user_agent',
        'geo', // Puede usarse para almacenar la ubicación geográfica
        'platforms', // Puede usarse para almacenar la información del dispositivo
        'event_data', // Datos adicionales del evento
        'user_id', // ID del usuario, si aplica
        'cart_id', // ID del carrito, si aplica
    ];

    protected $casts = [
        'geo' => 'json',
        'platforms' => 'array',
        'event_data' => 'json',
    ];

    protected $protected_metas = [];

    protected $editable_metas = [];

    public static $export_cols = [
        'uuid',
        'event_name',       // Nombre del evento
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'utm_term',
        'utm_content',
        'gclid',
        'fbclid',
        'ttclid',
        'ip_address',
        'user_agent',
        'user_id', // ID del usuario, si aplica
        'cart_id', // ID del carrito, si aplica
    ];

    public static $loadable_relations = [];

    public static $loadable_counts = [];

    /*
    protected static function newFactory()
    {
        return \App\Database\Factories\TrackingEventFactory::new();
    }
    */

}
