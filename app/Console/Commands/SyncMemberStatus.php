<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Member;

class SyncMemberStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'member:sync-status';

    /**
     * The command description.
     *
     * @var string
     */
    protected $description = 'Sync member status based on expired_at date';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $members = Member::all();
        $synced = 0;

        foreach ($members as $member) {
            $oldStatus = $member->is_active;
            $member->syncStatus();
            
            if ($oldStatus !== $member->is_active) {
                $synced++;
                $this->info("Updated {$member->nama} - Status: {$member->actual_status}");
            }
        }

        $this->info("\nSukses! Total member status di-update: {$synced}");
    }
}
