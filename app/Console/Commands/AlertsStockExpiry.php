<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Medicine;
use Illuminate\Support\Facades\Mail;

class AlertsStockExpiry extends Command
{
    /**
     * The name and signature of the console command.
     *
     * This should match what you use in Kernel.php and in terminal.
     */
    protected $signature = 'alerts:stock-expiry';

    /**
     * The console command description.
     */
    protected $description = 'Send alerts for low stock or expiring medicines';

    /**
     * Execute the console command.
     */
    public function handle()
    {
         
        $lowStock = Medicine::whereColumn('quantity', '<=', 'stock_threshold')->get();

         
        $expiring = Medicine::whereBetween('expiry_date', [now(), now()->addDays(30)])->get();

         
        if ($lowStock->isNotEmpty()) {
            $this->info('Low stock medicines:');
            foreach ($lowStock as $medicine) {
                $this->line("- {$medicine->name} (Qty: {$medicine->quantity})");
            }
        }

        if ($expiring->isNotEmpty()) {
            $this->info('Medicines expiring soon:');
            foreach ($expiring as $medicine) {
                $this->line("- {$medicine->name} (Expires: {$medicine->expiry_date})");
            }
        }

        if ($lowStock->isEmpty() && $expiring->isEmpty()) {
            $this->info('No alerts to send.');
        }

        return Command::SUCCESS;
    }
}
