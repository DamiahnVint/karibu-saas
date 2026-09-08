<?php

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'super_admin';
    case TENANT_OWNER = 'tenant_owner';
    case TENANT_ADMIN = 'tenant_admin';
    case TENANT_MANAGER = 'tenant_manager';
    case TENANT_USER = 'tenant_user';

    public function label(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Super Administrateur',
            self::TENANT_OWNER => 'Propriétaire',
            self::TENANT_ADMIN => 'Administrateur',
            self::TENANT_MANAGER => 'Manager',
            self::TENANT_USER => 'Utilisateur',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Admin global Karibu Technologies — accès total à tous les tenants',
            self::TENANT_OWNER => 'Propriétaire de l\'entreprise — admin complet de son tenant',
            self::TENANT_ADMIN => 'RH / DRC — gestion employés et paie',
            self::TENANT_MANAGER => 'Manager — lecture employés de son équipe',
            self::TENANT_USER => 'Employé — profil personnel et bulletins',
        };
    }

    public function hierarchy(): int
    {
        return match($this) {
            self::SUPER_ADMIN => 100,
            self::TENANT_OWNER => 80,
            self::TENANT_ADMIN => 60,
            self::TENANT_MANAGER => 40,
            self::TENANT_USER => 20,
        };
    }

    public function canManage(self $other): bool
    {
        return $this->hierarchy() > $other->hierarchy();
    }
}
