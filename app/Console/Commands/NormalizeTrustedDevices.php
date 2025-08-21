<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\TrustedDevice;

class NormalizeTrustedDevices extends Command
{
    protected $signature = 'trusted-devices:normalize {--dry-run}';
    protected $description = 'Normalize trusted device names to concise, user-friendly values.';

    public function handle()
    {
        $devices = TrustedDevice::all();
        $this->info('Found ' . $devices->count() . ' trusted devices.');
        $bar = $this->output->createProgressBar($devices->count());
        $bar->start();
        foreach($devices as $device){
            $new = $device->display_name;
            if($new && $new !== $device->device_name){
                $this->line("\nUpdating device {$device->id}: '{$device->device_name}' => '{$new}'");
                if(!$this->option('dry-run')){
                    $device->device_name = $new;
                    $device->save();
                }
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info('\nDone.');
        return 0;
    }
}
