<?php

namespace Src\Features\Paie\Application\DTOs;

class StoreEmployeeDTO
{
    public function __construct(
        public readonly int $tenantId,
        public readonly string $nom,
        public readonly string $prenom,
        public readonly ?string $email,
        public readonly ?string $phone,
        public readonly ?string $dateNaissance,
        public readonly ?string $sexe,
        public readonly string $situationFamiliale,
        public readonly int $nbEnfants,
        public readonly ?string $poste,
        public readonly ?int $departmentId,
        public readonly string $dateEmbauche,
        public readonly string $typeContrat,
        public readonly ?string $dureeContrat,
        public readonly int $salaireBase,
        public readonly string $modePaiement,
        public readonly ?string $banque,
        public readonly ?string $rib,
        public readonly ?string $cnpsNumero,
        public readonly string $statut,
        public readonly ?string $notes,
    ) {}

    public static function fromArray(array $data): static
    {
        return new static(
            tenantId: $data['tenant_id'],
            nom: $data['nom'],
            prenom: $data['prenom'],
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            dateNaissance: $data['date_naissance'] ?? null,
            sexe: $data['sexe'] ?? null,
            situationFamiliale: $data['situation_familiale'] ?? 'celibataire',
            nbEnfants: (int) ($data['nb_enfants'] ?? 0),
            poste: $data['poste'] ?? null,
            departmentId: $data['department_id'] ?? null,
            dateEmbauche: $data['date_embauche'],
            typeContrat: $data['type_contrat'] ?? 'cdi',
            dureeContrat: $data['duree_contrat'] ?? null,
            salaireBase: (int) $data['salaire_base'],
            modePaiement: $data['mode_paiement'] ?? 'virement',
            banque: $data['banque'] ?? null,
            rib: $data['rib'] ?? null,
            cnpsNumero: $data['cnps_numero'] ?? null,
            statut: $data['statut'] ?? 'actif',
            notes: $data['notes'] ?? null,
        );
    }
}
