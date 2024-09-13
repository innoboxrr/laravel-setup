<?php

namespace App\Console\Commands\App;

use Illuminate\Console\Command;
use App\Models\Permission;

class GeneratePermissionsList extends Command
{
    protected $signature = 'app:permissions-generate';
    protected $description = 'Generate a list of permissions from model policies';

    public function handle()
    {
        $permissions = Permission::generatePermissionsList();
        $this->info(json_encode($permissions, JSON_PRETTY_PRINT)); 
    }
}
