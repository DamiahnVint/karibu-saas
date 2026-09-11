<?php

namespace Src\Features\Paie\Application\Actions\Payslip;

use App\Models\Paie\Employee;
use App\Models\Paie\Payslip;
use Src\Features\Paie\Application\DTOs\GeneratePayslipDTO;
use Src\Features\Paie\Domain\Contracts\PayslipRepositoryInterface;
use Src\Features\Paie\Domain\Entities\CnpsCalculator;
use Src\Features\Paie\Domain\Entities\ItsCalculator;

class GeneratePayslipAction
{
    public function __construct(
        private PayslipRepositoryInterface $repository,
    ) {}

    public function execute(GeneratePayslipDTO $dto): Payslip
    {
        // Verifier qu'aucun bulletin n'existe deja pour cette periode
        $existing = $this->repository->findExisting($dto->employeeId, $dto->mois, $dto->annee);
        if ($existing) {
            throw new \DomainException("Un bulletin existe déjà pour {$dto->mois}/{$dto->annee}.");
        }

        $employee = Employee::findOrFail($dto->employeeId);

        // Calculer le brut
        $salaireBase = $employee->salaire_base;

        // Heures supplementaires : 150% jour, 200% nuit
        $tauxHoraire = (int) round($salaireBase / 173.33); // 173.33h = mois standard
        $heuresSupJour = (int) round($dto->heuresSupJour * $tauxHoraire * 1.5);
        $heuresSupNuit = (int) round($dto->heuresSupNuit * $tauxHoraire * 2.0);
        $totalHeuresSup = $heuresSupJour + $heuresSupNuit;

        // Primes
        $primeAnciennete = $dto->primeAnciennete;
        $primeRendement = $dto->primeRendement;
        $primeRisque = $dto->primeRisque;
        $prime13eme = $dto->prime13eme;

        $totalPrimes = $primeAnciennete + $primeRendement + $primeRisque + $prime13eme;

        // Indemnites
        $indemniteTransport = $dto->indemniteTransport;
        $indemniteLogement = $dto->indemniteLogement;
        $indemniteResponsabilite = $dto->indemniteResponsabilite;
        $totalIndemnites = $indemniteTransport + $indemniteLogement + $indemniteResponsabilite;

        // Avantages nature
        $avantagesNature = $dto->avantagesNature;

        // Total brut
        $totalBrut = $salaireBase + $totalHeuresSup + $totalPrimes + $totalIndemnites + $avantagesNature;

        // CNPS
        $cnpsCalc = new CnpsCalculator();
        $cnps = $cnpsCalc->calculate($totalBrut);

        // ITS
        $itsCalc = new ItsCalculator();
        $its = $itsCalc->calculate($totalBrut, $employee->parts_fiscales);

        // Net à payer
        $netAPayer = $totalBrut - $cnps->totalSalarie - $its->itsNet;

        // Creer le bulletin
        $payslip = new Payslip();
        $payslip->tenant_id = $dto->tenantId;
        $payslip->employee_id = $dto->employeeId;
        $payslip->mois = $dto->mois;
        $payslip->annee = $dto->annee;
        $payslip->salaire_base = $salaireBase;
        $payslip->heures_sup_jour = $heuresSupJour;
        $payslip->heures_sup_nuit = $heuresSupNuit;
        $payslip->total_heures_sup = $totalHeuresSup;
        $payslip->prime_anciennete = $primeAnciennete;
        $payslip->prime_rendement = $primeRendement;
        $payslip->prime_risque = $primeRisque;
        $payslip->prime_13eme = $prime13eme;
        $payslip->total_primes = $totalPrimes;
        $payslip->indemnite_transport = $indemniteTransport;
        $payslip->indemnite_logement = $indemniteLogement;
        $payslip->indemnite_responsabilite = $indemniteResponsabilite;
        $payslip->total_indemnites = $totalIndemnites;
        $payslip->avantages_nature = $avantagesNature;
        $payslip->total_brut = $totalBrut;
        $payslip->cnps_retraite_salarie = $cnps->retraiteSalarie;
        $payslip->cnps_cmu_salarie = $cnps->cmuSalarie;
        $payslip->total_cnps_salarie = $cnps->totalSalarie;
        $payslip->cnps_retraite_employeur = $cnps->retraiteEmployeur;
        $payslip->cnps_maternite = $cnps->maternite;
        $payslip->cnps_pf = $cnps->prestationsFamiliales;
        $payslip->cnps_at = $cnps->accidentsTravail;
        $payslip->cnps_cmu_employeur = $cnps->cmuEmployeur;
        $payslip->total_cnps_employeur = $cnps->totalEmployeur;
        $payslip->its_base = $its->baseImposable;
        $payslip->its_tranche1 = $its->tranche1;
        $payslip->its_tranche2 = $its->tranche2;
        $payslip->its_tranche3 = $its->tranche3;
        $payslip->its_tranche4 = $its->tranche4;
        $payslip->its_tranche5 = $its->tranche5;
        $payslip->its_brut = $its->itsBrut;
        $payslip->its_credit = $its->creditImpot;
        $payslip->its_net = $its->itsNet;
        $payslip->net_a_payer = max(0, $netAPayer);
        $payslip->statut = 'brouillon';
        $payslip->notes = $dto->notes;

        $this->repository->save($payslip);

        return $payslip;
    }
}
