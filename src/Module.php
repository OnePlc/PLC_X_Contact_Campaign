<?php
/**
 * Module.php - Module Class
 *
 * Module Class File for Campaign Campaign Plugin
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

use Application\Controller\CoreEntityController;
use Laminas\Mvc\MvcEvent;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\EventManager\EventInterface as Event;
use Laminas\ModuleManager\ModuleManager;
use OnePlace\Contact\Campaign\Controller\CampaignController;
use OnePlace\Contact\Campaign\Model\CampaignEntityTable;
use OnePlace\Contact\Campaign\Model\CampaignTable;
use OnePlace\Contact\Model\ContactTable;

class Module {
    /**
     * Module Version
     *
     * @since 1.0.0
     */
    const VERSION = '1.0.0';

    /**
     * Load module config file
     *
     * @since 1.0.0
     * @return array
     */
    public function getConfig() : array {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(Event $e)
    {
        // This method is called once the MVC bootstrapping is complete
        $application = $e->getApplication();
        $container    = $application->getServiceManager();
        $oDbAdapter = $container->get(AdapterInterface::class);
        $tableGateway = $container->get(CampaignTable::class);

        # Register Filter Plugin Hook
        CoreEntityController::addHook('contact-view-before',(object)['sFunction'=>'attachCampaignForm','oItem'=>new CampaignController($oDbAdapter,$tableGateway,$container)]);
        CoreEntityController::addHook('contactcampaign-add-before-save',(object)['sFunction'=>'attachCampaignToContact','oItem'=>new CampaignController($oDbAdapter,$tableGateway,$container)]);
    }

    /**
     * Load Models
     */
    public function getServiceConfig() : array {
        return [
            'factories' => [
                # Campaign Plugin - Base Model
                Model\CampaignTable::class => function($container) {
                    $tableGateway = $container->get(Model\CampaignTableGateway::class);
                    return new Model\CampaignTable($tableGateway,$container);
                },
                Model\CampaignTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\Campaign($dbAdapter));
                    return new TableGateway('contact_campaign', $dbAdapter, null, $resultSetPrototype);
                },

                # Campaign Entity
                Model\CampaignEntityTable::class => function($container) {
                    $tableGateway = $container->get(Model\CampaignEntityTableGateway::class);
                    return new Model\CampaignEntityTable($tableGateway,$container);
                },
                Model\CampaignEntityTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Model\CampaignEntity($dbAdapter));
                    return new TableGateway('campaign', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    } # getServiceConfig()

    /**
     * Load Controllers
     */
    public function getControllerConfig() : array {
        return [
            'factories' => [
                Controller\CampaignController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    $tableGateway = $container->get(CampaignTable::class);

                    # hook start
                    # hook end
                    return new Controller\CampaignController(
                        $oDbAdapter,
                        $tableGateway,
                        $container
                    );
                },
                Controller\ApiController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    $tableGateway = $container->get(CampaignEntityTable::class);

                    # hook start
                    # hook end
                    return new Controller\ApiController(
                        $oDbAdapter,
                        $tableGateway,
                        $container
                    );
                },
                # Installer
                Controller\InstallController::class => function($container) {
                    $oDbAdapter = $container->get(AdapterInterface::class);
                    return new Controller\InstallController(
                        $oDbAdapter,
                        $container->get(Model\CampaignTable::class),
                        $container
                    );
                },
            ],
        ];
    } # getControllerConfig()
}
