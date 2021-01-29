<?php
/**
 * module.config.php - Campaign Config
 *
 * Main Config File for Contact Campaign Plugin
 *
 * @category Config
 * @package Contact\Campaign
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Campaign;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Campaign Module - Routes
    'router' => [
        'routes' => [
            'contact-campaign' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/contact/campaign[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CampaignController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'contact-campaign-setup' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/contact/campaign/setup',
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'checkdb',
                    ],
                ],
            ],
        ],
    ], # Routes

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'contact-campaign' => __DIR__ . '/../view',
        ],
    ],
];
