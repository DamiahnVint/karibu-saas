<?php

namespace Database\Seeders;

use App\Models\CmsPage;
use App\Models\CmsSection;
use App\Models\CmsSetting;
use App\Models\CmsNavigation;
use Illuminate\Database\Seeder;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        // === PAGE: LANDING ===
        $landing = CmsPage::updateOrCreate(
            ['slug' => 'landing'],
            [
                'title' => 'Accueil',
                'meta_title' => 'Karibu Technologies — La technologie au service de votre business',
                'meta_description' => 'Suite logicielle SaaS pour entreprises ivoiriennes. Paie, Scolaire, VTC — conforme aux normes locales.',
                'is_active' => true,
                'sort_order' => 0,
            ]
        );

        CmsSection::updateOrCreate(
            ['page_id' => $landing->id, 'type' => 'hero', 'sort_order' => 0],
            [
                'title' => 'Hero',
                'is_active' => true,
                'content' => [
                    'badge' => 'Made in Côte d\'Ivoire',
                    'title' => 'La technologie<br><span class="gradient-text">au service</span><br>de votre business',
                    'subtitle' => 'Suite logicielle SaaS pour entreprises ivoiriennes. Paie, Scolaire, VTC — conforme aux normes locales.',
                    'cta_text' => 'Découvrir nos solutions',
                    'cta_url' => '#produits',
                    'cta2_text' => 'Nous contacter',
                    'cta2_url' => '#contact',
                    'stats' => [
                        ['value' => '3', 'label' => 'Solutions SaaS'],
                        ['value' => '100%', 'label' => 'Made in CI'],
                        ['value' => '24/7', 'label' => 'Disponible'],
                    ],
                ],
            ]
        );

        CmsSection::updateOrCreate(
            ['page_id' => $landing->id, 'type' => 'features', 'sort_order' => 1],
            [
                'title' => 'Nos Produits',
                'is_active' => true,
                'content' => [
                    'subtitle' => 'Des solutions pensées pour le marché ouest-africain',
                    'items' => [
                        ['icon' => '💰', 'title' => 'Karibu Paie', 'description' => 'Logiciel de paie conforme CNPS/ITS. Calcul automatique, bulletins PDF, déclarations sociales.', 'url' => '#pricing'],
                        ['icon' => '🎓', 'title' => 'Karibu Scolaire', 'description' => 'Gestion scolaire complète. Inscriptions, notes, emplois du temps, communication parents.', 'url' => '#'],
                        ['icon' => '🚗', 'title' => 'Karibu VTC', 'description' => 'Mise en relation clients/chauffeurs. Réservation, suivi en temps réel, paiement intégré.', 'url' => 'https://karibu.co.ci'],
                    ],
                ],
            ]
        );

        CmsSection::updateOrCreate(
            ['page_id' => $landing->id, 'type' => 'pricing', 'sort_order' => 2],
            [
                'title' => 'Tarification',
                'is_active' => true,
                'content' => [
                    'subtitle' => 'Des prix adaptés à votre budget',
                    'description' => 'Commencez grâtuitement. Passez au niveau supérieur quand vous êtes prêt.',
                    'plans' => [
                        [
                            'name' => 'Essentiel',
                            'price' => '20 000',
                            'period' => 'FCFA/mois',
                            'description' => 'Jusqu\'à 15 salariés',
                            'is_popular' => false,
                            'cta_text' => 'Commencer',
                            'slug' => 'essentiel',
                            'features' => ['Calcul CNPS & ITS', 'Bulletin de paie PDF', '1 utilisateur', 'Support par email'],
                        ],
                        [
                            'name' => 'Professionnel',
                            'price' => '35 000',
                            'period' => 'FCFA/mois',
                            'description' => 'Jusqu\'à 50 salariés',
                            'is_popular' => true,
                            'cta_text' => 'Commencer',
                            'slug' => 'professionnel',
                            'features' => ['Tout dans Essentiel', 'Multi-utilisateurs', 'Exports comptables', 'Support prioritaire'],
                        ],
                        [
                            'name' => 'Enterprise',
                            'price' => 'Sur mesure',
                            'period' => '',
                            'description' => 'Sans limite',
                            'is_popular' => false,
                            'cta_text' => 'Nous contacter',
                            'slug' => 'enterprise',
                            'cta_url' => '#contact',
                            'features' => ['Tout dans Pro', 'API & intégrations', 'Deployment on-premise', 'Support dédié 24/7'],
                        ],
                    ],
                ],
            ]
        );

        CmsSection::updateOrCreate(
            ['page_id' => $landing->id, 'type' => 'cta', 'sort_order' => 3],
            [
                'title' => 'Contact',
                'is_active' => true,
                'content' => [
                    'title' => 'Prêt à démarrer ?',
                    'description' => 'Rejoignez les entreprises ivoiriennes qui font confiance à Karibu Technologies.',
                    'cta_text' => 'Nous contacter',
                    'cta_url' => '#contact',
                ],
            ]
        );

        // === PAGE: PRICING ===
        $pricing = CmsPage::updateOrCreate(
            ['slug' => 'pricing'],
            ['title' => 'Tarifs', 'meta_title' => 'Tarifs — Karibu Paie', 'is_active' => true, 'sort_order' => 1]
        );

        CmsSection::updateOrCreate(
            ['page_id' => $pricing->id, 'type' => 'pricing', 'sort_order' => 0],
            ['title' => 'Nos offres', 'is_active' => true, 'content' => $landing->sections()->where('type', 'pricing')->first()->content ?? []]
        );

        // === PAGE: DEMO ===
        $demo = CmsPage::updateOrCreate(
            ['slug' => 'demo'],
            ['title' => 'Démo', 'meta_title' => 'Réserver une démo — Karibu Paie', 'is_active' => true, 'sort_order' => 2]
        );

        CmsSection::updateOrCreate(
            ['page_id' => $demo->id, 'type' => 'hero', 'sort_order' => 0],
            [
                'is_active' => true,
                'content' => [
                    'title' => 'Réserver une démo',
                    'subtitle' => 'Découvrez Karibu Paie en action. Choisissez un créneau et notre équipe vous guidera.',
                ],
            ]
        );

        // === PAGE: CONTACT ===
        $contact = CmsPage::updateOrCreate(
            ['slug' => 'contact'],
            ['title' => 'Contact', 'meta_title' => 'Contact — Karibu Technologies', 'is_active' => true, 'sort_order' => 3]
        );

        CmsSection::updateOrCreate(
            ['page_id' => $contact->id, 'type' => 'contact', 'sort_order' => 0],
            ['title' => 'Contactez-nous', 'is_active' => true, 'content' => ['submit_text' => 'Envoyer le message']]
        );

        // === SETTINGS ===
        $settings = [
            ['key' => 'site_name', 'value' => 'Karibu Technologies', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_slogan', 'value' => 'La technologie au service de votre business', 'group' => 'general', 'type' => 'text'],
            ['key' => 'site_description', 'value' => 'Suite logicielle SaaS pour entreprises ivoiriennes.', 'group' => 'general', 'type' => 'textarea'],
            ['key' => 'site_color', 'value' => '#1e5fa8', 'group' => 'colors', 'type' => 'color'],
            ['key' => 'contact_email', 'value' => 'contact@karibu.co.ci', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_phone', 'value' => '+225 XX XX XX XX XX', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'contact_address', 'value' => 'Abidjan, Côte d\'Ivoire', 'group' => 'contact', 'type' => 'text'],
            ['key' => 'social_twitter', 'value' => '', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_linkedin', 'value' => '', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_facebook', 'value' => '', 'group' => 'social', 'type' => 'text'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social', 'type' => 'text'],
        ];

        foreach ($settings as $s) {
            CmsSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // === NAVIGATION ===
        CmsNavigation::setItems('header', [
            ['label' => 'Produits', 'url' => '#produits', 'order' => 0],
            ['label' => 'Avantages', 'url' => '#avantages', 'order' => 1],
            ['label' => 'Tarifs', 'url' => '#pricing', 'order' => 2],
            ['label' => 'Contact', 'url' => '#contact', 'order' => 3],
        ]);

        CmsNavigation::setItems('footer', [
            ['label' => 'Produits', 'url' => '#produits', 'order' => 0],
            ['label' => 'Tarifs', 'url' => '#pricing', 'order' => 1],
            ['label' => 'Contact', 'url' => '#contact', 'order' => 2],
            ['label' => 'Connexion', 'url' => '/orion/login', 'order' => 3],
        ]);

        CmsNavigation::setItems('mobile', [
            ['label' => 'Produits', 'url' => '#produits', 'order' => 0],
            ['label' => 'Avantages', 'url' => '#avantages', 'order' => 1],
            ['label' => 'Tarifs', 'url' => '#pricing', 'order' => 2],
            ['label' => 'Contact', 'url' => '#contact', 'order' => 3],
        ]);
    }
}
