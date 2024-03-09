<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Devices;
use Carbon\Carbon;

class DeactivateInactiveDevices extends Command
{
    protected $signature = 'devices:deactivate';
    protected $description = 'Deactivate inactive devices';

    public function handle()
    {
        $inactiveThreshold = now()->subSeconds(8);

        Devices::where('updated_at', '<=', $inactiveThreshold)
            ->update(['is_active' => false, 'current_ip' => null]);

        $this->info('Inactive devices deactivated successfully.');
    }
}