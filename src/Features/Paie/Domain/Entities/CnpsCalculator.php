<?php

namespace Src\Features\Paie\Domain\Entities;

use Src\Features\Paie\Domain\ValueObjects\CnpsBreakdown;

/**
 * Calculateur CNPS — Caisse Nationale de Prevoyance Sociale (Cote d'Ivoire 2026).
 *
 * Branches de cotisation :
 * - Retraite : 7.70% employeur + 6.30% salarié (plafond 3 375 000 FCFA/mois)
 * - Maternité : 0.75% employeur (plafond 70 000 FCFA/mois)
 * - Prestations Familiales : 5.00% employeur (plafond 70 000 FCFA/mois)
 * - Accidents du Travail : 2-5% employeur (plafond 70 000 FCFA/mois)
 * - CMU : 1 000 FCFA/mois (500 employeur + 500 salarié)
 */
class CnpsCalculator
{
    private float $tauxRetraiteEmployeur;
    private float $tauxRetraiteSalarie;
    private int $plafondRetraite;
    private float $tauxMaternite;
    private int $plafondMaternite;
    private float $tauxPF;
    private int $plafondPF;
    private float $tauxAT;
    private int $plafondAT;
    private int $cmuMontant;
    private int $cmuPartEmployeur;
    private int $cmuPartSalarie;

    public function __construct(?array $config = null)
    {
        $defaults = $this->getDefaults();
        $config = $config ? array_merge($defaults, $config) : $defaults;

        $this->tauxRetraiteEmployeur = $config['retraite']['taux_employeur'];
        $this->tauxRetraiteSalarie = $config['retraite']['taux_salarie'];
        $this->plafondRetraite = $config['retraite']['plafond_mensuel'];
        $this->tauxMaternite = $config['maternite']['taux_employeur'];
        $this->plafondMaternite = $config['maternite']['plafond_mensuel'];
        $this->tauxPF = $config['prestations_familiales']['taux_employeur'];
        $this->plafondPF = $config['prestations_familiales']['plafond_mensuel'];
        $this->tauxAT = $config['accidents_travail']['default_taux'] ?? $config['accidents_travail']['taux_employeur_min'];
        $this->plafondAT = $config['accidents_travail']['plafond_mensuel'];
        $this->cmuMontant = $config['cmu']['montant_mensuel'];
        $this->cmuPartEmployeur = $config['cmu']['part_employeur'];
        $this->cmuPartSalarie = $config['cmu']['part_salarie'];
    }

    public static function getDefaults(): array
    {
        $path = database_path('baremes/cnps_2026.json');

        if (file_exists($path)) {
            return json_decode(file_get_contents($path), true) ?? [];
        }

        return [
            'retraite' => ['taux_employeur' => 7.70, 'taux_salarie' => 6.30, 'plafond_mensuel' => 3375000],
            'maternite' => ['taux_employeur' => 0.75, 'plafond_mensuel' => 70000],
            'prestations_familiales' => ['taux_employeur' => 5.00, 'plafond_mensuel' => 70000],
            'accidents_travail' => ['taux_employeur_min' => 2.00, 'taux_employeur_max' => 5.00, 'plafond_mensuel' => 70000, 'default_taux' => 2.50],
            'cmu' => ['montant_mensuel' => 1000, 'part_employeur' => 500, 'part_salarie' => 500],
        ];
    }

    /**
     * Calcule toutes les cotisations CNPS sur un salaire brut donné.
     *
     * @param int $salaireBrut Salaire brut mensuel en FCFA
     * @param float $tauxAT Taux accidents du travail (2-5%), null = défaut
     */
    public function calculate(int $salaireBrut, ?float $tauxAT = null): CnpsBreakdown
    {
        $taux = $tauxAT ?? $this->tauxAT;

        // Part salarié
        $retraiteSalarie = (int) round(min($salaireBrut, $this->plafondRetraite) * $this->tauxRetraiteSalarie / 100);
        $cmuSalarie = $this->cmuPartSalarie;

        // Part employeur
        $retraiteEmployeur = (int) round(min($salaireBrut, $this->plafondRetraite) * $this->tauxRetraiteEmployeur / 100);
        $maternite = (int) round(min($salaireBrut, $this->plafondMaternite) * $this->tauxMaternite / 100);
        $pf = (int) round(min($salaireBrut, $this->plafondPF) * $this->tauxPF / 100);
        $at = (int) round(min($salaireBrut, $this->plafondAT) * $taux / 100);
        $cmuEmployeur = $this->cmuPartEmployeur;

        $totalSalarie = $retraiteSalarie + $cmuSalarie;
        $totalEmployeur = $retraiteEmployeur + $maternite + $pf + $at + $cmuEmployeur;

        return new CnpsBreakdown(
            retraiteSalarie: $retraiteSalarie,
            cmuSalarie: $cmuSalarie,
            totalSalarie: $totalSalarie,
            retraiteEmployeur: $retraiteEmployeur,
            maternite: $maternite,
            prestationsFamiliales: $pf,
            accidentsTravail: $at,
            cmuEmployeur: $cmuEmployeur,
            totalEmployeur: $totalEmployeur,
            totalGeneral: $totalSalarie + $totalEmployeur,
        );
    }

    /**
     * Retourne les taux actuels pour affichage.
     */
    public function getRates(): array
    {
        return [
            'retraite_employeur' => $this->tauxRetraiteEmployeur,
            'retraite_salarie' => $this->tauxRetraiteSalarie,
            'plafond_retraite' => $this->plafondRetraite,
            'maternite' => $this->tauxMaternite,
            'plafond_maternite' => $this->plafondMaternite,
            'pf' => $this->tauxPF,
            'plafond_pf' => $this->plafondPF,
            'at' => $this->tauxAT,
            'plafond_at' => $this->plafondAT,
            'cmu' => $this->cmuMontant,
        ];
    }
}
