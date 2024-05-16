<?php

namespace App\Console\Commands;
use Laravel\Sanctum\PersonalAccessToken;

use Illuminate\Console\Command;

class PruneExpiredTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tokens:prune';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Prune expired Sanctum tokens';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $deletedTokens = PersonalAccessToken::where('expires_at', '<', now())->delete();
        $this->info($deletedTokens . ' expired tokens pruned.');    
    }
}
