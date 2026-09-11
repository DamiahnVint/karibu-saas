<?php

namespace Src\Features\Paie\Application\Actions\Payslip;

use App\Models\Paie\Payslip;
use Src\Features\Paie\Domain\Contracts\PayslipRepositoryInterface;
use Src\Features\Paie\Domain\Entities\CnpsCalculator;
use Src\Features\Paie\Domain\Entities\ItsCalculator;

class SimulatePayslipAction
{
    public function __construct(
        private PayslipRepositoryInterface $repository,
    ) {}

    /**
     * Simule un bulletin sans le persister. Retourne le resume des calculs.
     */
    public function execute(array $data): array
    {
        $salaireBase = (int) $data['salaire_base'];
        $nbEnfants = (int) ($data['nb_enfants'] ?? 0);
        $situationFamiliale = $data['situation_familiale'] ?? 'celibataire';

        // Parts fiscales
        $partsFiscales = match ($situationFamiliale) {
            'marie' => 2.0 + ($nbEnfants * 0.5),
            default => 1.0 + ($nbEnfants * 0.5),
        };

        // Heures sup
        $tauxHoraire = (int) round($salaireBase / 173.33);
        $heuresSupJour = (int) ($data['heures_sup_jour'] ?? 0);
        $heuresSupNuit = (int) ($data['heures_sup_nuit'] ?? 0);
        $totalHeuresSup = (int) round($heuresSupJour * $tauxHoraire * 1.5) + (int) round($heuresSupNuit * $tauxHoraire * 2.0);

        // Primes
        $totalPrimes = (int) ($data['prime_anciennete'] ?? 0)
            + (int) ($data['prime_rendement'] ?? 0)
            + (int) ($data['prime_risque'] ?? 0)
            + (int) ($data['prime_13eme'] ?? 0);

        // Indemnites
        $totalIndemnites = (int) ($data['indemnite_transport'] ?? 0)
            + (int) ($data['indemnite_logement'] ?? 0)
            + (int) ($data['indemnite_responsabilite'] ?? 0);

        // Avantages
        $avantagesNature = (int) ($data['avantages_nature'] ?? 0);

        // Brut
        $totalBrut = $salaireBase + $totalHeuresSup + $totalPrimes + $totalIndemnites + $avantagesNature;

        // CNPS
        $cnpsCalc = new CnpsCalculator();
        $cnps = $cnpsCalc->calculate($totalBrut);

        // ITS
        $itsCalc = new ItsCalculator();
        $its = $itsCalc->calculate($totalBrut, $partsFiscales);

        // Net
        $netAPayer = $totalBrut - $cnps->totalSalarie - $its->itsNet;

        return [
            'salaire_base' => $salaireBase,
            'heures_sup_jour' => (int) round($heuresSupJour * $tauxHoraire * 1.5),
            'heures_sup_nuit' => (int) round($heuresSupNuit * $tauxHoraire * 2.0),
            'total_heures_sup' => $totalHeuresSup,
            'total_primes' => $totalPrimes,
            'total_indemnites' => $totalIndemnites,
            'avantages_nature' => $avantagesNature,
            'total_brut' => $totalBrut,
            'parts_fiscales' => $partsFiscales,
            ...$cnps->toArray(),
            ...$its->toArray(),
            'net_a_payer' => max(0, $netAPayer),
        ];
    }
}
