<?php

declare(strict_types=1);

namespace Src\Features\Common\Application\Concerns;

/**
 * Contrat pour tous les Use Cases / Actions de l'application.
 *
 * Chaque Action implémente cette interface pour garantir
 * un point d'entrée unique et testable par opération métier.
 */
interface ActionInterface
{
    /**
     * Exécute l'action métier.
     *
     * @param mixed $dto DTO contenant les données de la requête
     * @return mixed Résultat de l'action (DTO de réponse ou autre valeur)
     */
    public function execute(mixed $dto): mixed;
}
