<?php

namespace Src\Features\Paie\Domain\Entities;

use Src\Features\Paie\Domain\ValueObjects\ItsCalculation;

/**
 * Calculateur ITS — Impot sur les Traitements et Salaires (Cote d'Ivoire 2026).
 *
 * Tranches progressives :
 * - 0 - 150 000      → 0% (exonéré)
 * - 150 001 - 300 000 → 10%
 * - 300 001 - 500 000 → 15%
 * - 500 001 - 1 000 000 → 30%
 * - 1 000 001 - 3 000 000 → 32%
 * - > 3 000 000       → 32%
 *
 * Abattement standard : 20%
 * Crédit d'impôt : 5 500 FCFA par part fiscale
 */
class ItsCalculator
{
    private int $abattementPct;
    private float $creditPartFiscale;
    private array $tranches;

    public function __construct(?array $config = null)
    {
        $defaults = $this->getDefaults();
        $config = $config ? array_merge($defaults, $config) : $defaults;

        $this->abattementPct = $config['abattement_standard_pct'];
        $this->creditPartFiscale = $config['credits']['part_fiscale'];
        $this->tranches = $config['tranches'];
    }

    public static function getDefaults(): array
    {
        $path = database_path('baremes/its_2026.json');

        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }

        return [
            'abattement_standard_pct' => 20,
            'tranches' => [
                ['min' => 0, 'max' => 150000, 'taux' => 0],
                ['min' => 150001, 'max' => 300000, 'taux' => 10],
                ['min' => 300001, 'max' => 500000, 'taux' => 15],
                ['min' => 500001, 'max' => 1000000, 'taux' => 30],
                ['min' => 1000001, 'max' => 3000000, 'taux' => 32],
                ['min' => 3000001, 'max' => null, 'taux' => 32],
            ],
            'credits' => ['part_fiscale' => 5500],
        ];
    }

    /**
     * Calcule l'ITS net sur un salaire brut donné.
     *
     * @param int $salaireBrut Salaire brut mensuel en FCFA
     * @param float $partsFiscales Nombre de parts fiscales (célibataire=1, marié=2, +0.5/enfant)
     */
    public function calculate(int $salaireBrut, float $partsFiscales = 1.0): ItsCalculation
    {
        // Abattement de 20%
        $baseImposable = (int) round($salaireBrut * (1 - $this->abattementPct / 100));

        // Calcul par tranche progressive
        $tranches = [0, 0, 0, 0, 0];
        $restant = $baseImposable;

        foreach ($this->tranches as $index => $tranche) {
            if ($restant <= 0) {
                break;
            }

            $min = $tranche['min'];
            $max = $tranche['max'] ?? PHP_INT_MAX;
            $taux = $tranche['taux'];

            if ($taux === 0) {
                continue;
            }

            $trancheMin = $min;
            $trancheMax = $max;

            // Montant imposable dans cette tranche
            $montantDansTranche = min($restant, $trancheMax - $trancheMin + 1);
            $impotTranche = (int) round($montantDansTranche * $taux / 100);

            if ($index < 5) {
                $tranches[$index] = $impotTranche;
            }

            $restant -= $montantDansTranche;
        }

        $itsBrut = array_sum($tranches);

        // Crédit d'impôt (5 500 FCFA × nombre de parts)
        $creditImpot = (int) round($this->creditPartFiscale * $partsFiscales);

        // ITS net (pas en dessous de 0)
        $itsNet = max(0, $itsBrut - $creditImpot);

        return new ItsCalculation(
            baseImposable: $baseImposable,
            tranche1: $tranches[0],
            tranche2: $tranches[1],
            tranche3: $tranches[2],
            tranche4: $tranches[3],
            tranche5: $tranches[4],
            itsBrut: $itsBrut,
            creditImpot: $creditImpot,
            itsNet: $itsNet,
        );
    }

    /**
     * Retourne les tranches pour affichage.
     */
    public function getTranches(): array
    {
        return $this->tranches;
    }

    /**
     * Retourne les paramètres ITS pour affichage.
     */
    public function getParams(): array
    {
        return [
            'abattement' => $this->abattementPct,
            'credit_part_fiscale' => $this->creditPartFiscale,
            'tranches' => $this->tranches,
        ];
    }
}
