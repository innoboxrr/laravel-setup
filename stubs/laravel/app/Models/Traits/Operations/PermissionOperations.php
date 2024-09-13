<?php

namespace App\Models\Traits\Operations;

use Illuminate\Support\Facades\File;
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

        // Get all policy files from the Policies directory
        $policyFiles = File::files(app_path('Policies'));

        foreach ($policyFiles as $policyFile) {
            $policyClass = 'App\\Policies\\' . $policyFile->getBasename('.php');
            $reflection = new ReflectionClass($policyClass);

            // Extract model name from policy class (e.g., UserPolicy -> User)
            $modelName = Str::beforeLast($reflection->getShortName(), 'Policy');

            // Convert model name to kebab-case (e.g., User -> user)
            $modelKebabCase = Str::kebab($modelName);

            // Get all public methods from the policy class
            foreach ($reflection->getMethods(ReflectionMethod::IS_PUBLIC) as $method) {
                if ($method->getName() !== 'before') { // Exclude the 'before' method
                    // Convert method name to kebab-case (e.g., viewAny -> view-any)
                    $permissionKebabCase = Str::kebab($method->getName());

                    $permissions[] = $modelKebabCase . '-' . $permissionKebabCase;
                }
            }
        }

        // Output or store the permissions array as needed
        return $permissions;
    }

}
