<?php

namespace App\Models\Traits\Operations;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;

trait PermissionOperations
{

    /*
    public function buildPayload()
    {

        return [];

    }

    public function updatePayload()
    {

        $this->payload = $this->buildPayload();

        return $this->save();

    }
    */

    public static function generatePermissionsList(): array
    {
        $permissions = [];

        // Obtener todas las políticas registradas en la aplicación
        $policies = Gate::policies();

        foreach ($policies as $modelClass => $policyClass) {
            $reflection = new ReflectionClass($policyClass);

            // Obtener el nombre completo de la clase del modelo y convertirlo a kebab-case
            $modelNamespace = str_replace('\\', '-', $modelClass); // Convertir los backslashes a guiones
            $modelKebabCase = Str::kebab($modelNamespace); // Convertir a kebab-case

            // Obtener todos los métodos públicos de la clase de la política
            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getName() !== 'before') { // Excluir el método 'before'
                    // Convertir el nombre del método a kebab-case (e.g., viewAny -> view-any)
                    $permissionKebabCase = Str::kebab($method->getName());

                    $permissions[] = $modelKebabCase . '-' . $permissionKebabCase;
                }
            }
        }

        // Devolver la lista de permisos generada
        return $permissions;
    }
}
