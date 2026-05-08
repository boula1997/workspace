<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;

$role = Role::find(1);
if ($role) {
    echo "ID: " . $role->id . "\n";
    echo "Name (property): " . $role->name . "\n";
    echo "Name (attribute): " . $role->getAttribute('name') . "\n";
    echo "All Attributes: " . json_encode($role->getAttributes()) . "\n";
    echo "Model class: " . get_class($role) . "\n";
} else {
    echo "Role 1 not found\n";
}
