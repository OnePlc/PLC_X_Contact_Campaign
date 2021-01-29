<?php
/**
 * CampaignController.php - Main Controller
 *
 * Main Controller for Contact Campaign Plugin
 *
 * @category Controller
 * @package Contact\Campaign
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

declare(strict_types=1);

namespace OnePlace\Contact\Campaign\Controller;

use Application\Controller\CoreEntityController;
use Application\Model\CoreEntityModel;
use OnePlace\Contact\Campaign\Model\CampaignTable;
use Laminas\View\Model\ViewModel;
use Laminas\Db\Adapter\AdapterInterface;

class CampaignController extends CoreEntityController {
    /**
     * Contact Table Object
     *
     * @since 1.0.0
     */
    protected $oTableGateway;

    /**
     * ContactController constructor.
     *
     * @param AdapterInterface $oDbAdapter
     * @param ContactTable $oTableGateway
     * @since 1.0.0
     */
    public function __construct(AdapterInterface $oDbAdapter,CampaignTable $oTableGateway,$oServiceManager) {
        $this->oTableGateway = $oTableGateway;
        $this->sSingleForm = 'contactcampaign-single';
        parent::__construct($oDbAdapter,$oTableGateway,$oServiceManager);

        if($oTableGateway) {
            # Attach TableGateway to Entity Models
            if(!isset(CoreEntityModel::$aEntityTables[$this->sSingleForm])) {
                CoreEntityModel::$aEntityTables[$this->sSingleForm] = $oTableGateway;
            }
        }
    }

    public function attachCampaignForm($oItem = false) {
        $oForm = CoreEntityController::$aCoreTables['core-form']->select(['form_key'=>'contactcampaign-single']);

        $aFields = [];
        $aUserFields = CoreEntityController::$oSession->oUser->getMyFormFields();
        if(array_key_exists('contactcampaign-single',$aUserFields)) {
            $aFieldsTmp = $aUserFields['contactcampaign-single'];
            if(count($aFieldsTmp) > 0) {
                # add all contact-base fields
                foreach($aFieldsTmp as $oField) {
                    if($oField->tab == 'campaign-base') {
                        $aFields[] = $oField;
                    }
                }
            }
        }

        $aFieldsByTab = ['campaign-base'=>$aFields];

        # Try to get adress table
        try {
            $oCampaignTbl = CoreEntityController::$oServiceManager->get(CampaignTable::class);
        } catch(\RuntimeException $e) {
            //echo '<div class="alert alert-danger"><b>Error:</b> Could not load address table</div>';
            return [];
        }

        if(!isset($oCampaignTbl)) {
            return [];
        }

        $aHistories = [];
        $oPrimaryCampaign = false;
        if($oItem) {
            # load contact addresses
            $oHistories = $oCampaignTbl->fetchAll(false, ['contact_idfs' => $oItem->getID()]);
            # get primary address
            if (count($oHistories) > 0) {
                foreach ($oHistories as $oAddr) {
                    $aHistories[] = $oAddr;
                }
            }
        }

        # Pass Data to View - which will pass it to our partial
        return [
            # must be named aPartialExtraData
            'aPartialExtraData' => [
                # must be name of your partial
                'contact_campaign'=> [
                    'oHistories'=>$aHistories,
                    'oForm'=>$oForm,
                    'aFormFields'=>$aFieldsByTab,
                ]
            ]
        ];
    }

    public function attachCampaignToContact($oItem,$aRawData) {
        $oItem->contact_idfs = $aRawData['ref_idfs'];

        return $oItem;
    }

    public function addAction() {
        /**
         * You can just use the default function and customize it via hooks
         * or replace the entire function if you need more customization
         *
         * Hooks available:
         *
         * contact-add-before (before show add form)
         * contact-add-before-save (before save)
         * contact-add-after-save (after save)
         */
        $iContactID = $this->params()->fromRoute('id', 0);

        return $this->generateAddView('contactcampaign','contactcampaign-single','contact','view',$iContactID,['iContactID'=>$iContactID]);
    }
}
