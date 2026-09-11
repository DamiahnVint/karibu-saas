<?php

namespace App\Console\Commands;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\Tenant;
use Illuminate\Console\Command;

class SubscriptionsCheck extends Command
{
    protected $signature = 'subscriptions:check';

    protected $description = 'Vérifie et met à jour les statuts des abonnements (expiration essais, abonnements expirés)';

    public function handle(): int
    {
        $this->info('Vérification des abonnements...');

        // 1. Expirer les essais dont la date est dépassée
        $expiredTrials = Subscription::where('status', 'trialing')
            ->where('trial_ends_at', '<', now())
            ->get();

        foreach ($expiredTrials as $subscription) {
            $subscription->update(['status' => 'expired']);
            $this->line("  Essai expiré: {$subscription->tenant->name} ({$subscription->tenant->slug})");

            // Désactiver le tenant
            $subscription->tenant->update(['is_active' => false]);
        }

        $this->info("  {$expiredTrials->count()} essai(s) expiré(s)");

        // 2. Expirer les abonnements actifs dont la date de fin est dépassée
        $expiredSubscriptions = Subscription::where('status', 'active')
            ->where('ends_at', '<', now())
            ->get();

        foreach ($expiredSubscriptions as $subscription) {
            $subscription->update(['status' => 'expired']);
            $this->line("  Abonnement expiré: {$subscription->tenant->name} ({$subscription->tenant->slug})");

            // Désactiver le tenant
            $subscription->tenant->update(['is_active' => false]);
        }

        $this->info("  {$expiredSubscriptions->count()} abonnement(s) expiré(s)");

        // 3. Réactiver les tenants avec un abonnement actif ou en essai
        $activeSubscriptions = Subscription::whereIn('status', ['active', 'trialing'])
            ->whereHas('tenant', fn ($q) => $q->where('is_active', false))
            ->get();

        foreach ($activeSubscriptions as $subscription) {
            if ($subscription->hasAccess()) {
                $subscription->tenant->update(['is_active' => true]);
                $this->line("  Tenant réactivé: {$subscription->tenant->name} ({$subscription->tenant->slug})");
            }
        }

        $this->info("  {$activeSubscriptions->count()} tenant(s) réactivé(s)");
        $this->info('Vérification terminée.');

        return self::SUCCESS;
    }
}
