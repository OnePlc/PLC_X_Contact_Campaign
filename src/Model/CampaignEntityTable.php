<?php
/**
 * CampaignTable.php - Campaign Table
 *
 * Table Model for Campaign Campaign
 *
 * @category Model
 * @package Contact\Campaign
 * @author Verein onePlace
 * @copyright (C) 2020 Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Contact\Campaign\Model;

use Application\Controller\CoreController;
use Application\Model\CoreEntityTable;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\Sql\Select;
use Laminas\Db\Sql\Where;
use Laminas\Paginator\Paginator;
use Laminas\Paginator\Adapter\DbSelect;

class CampaignEntityTable extends CoreEntityTable {

    /**
     * CampaignTable constructor.
     *
     * @param TableGateway $tableGateway
     * @since 1.0.0
     */
    public function __construct(TableGateway $tableGateway) {
        parent::__construct($tableGateway);

        # Set Single Form Name
        $this->sSingleForm = 'campaign-single';
    }

    /**
     * Get Campaign Entity
     *
     * @param int $id
     * @return mixed
     * @since 1.0.0
     */
    public function getSingle($id) {
        # Use core function
        return $this->getSingleEntity($id,'Campaign_ID');
    }

    /**
     * Save Campaign Entity
     *
     * @param Campaign $oCampaign
     * @return int Campaign ID
     * @since 1.0.0
     */
    public function saveSingle(CampaignEntity $oCampaign) {
        $aData = [];

        $aData = $this->attachDynamicFields($aData,$oCampaign);

        $id = (int) $oCampaign->id;

        if ($id === 0) {
            # Add Metadata
            $aData['created_by'] = CoreController::$oSession->oUser->getID();
            $aData['created_date'] = date('Y-m-d H:i:s',time());
            $aData['modified_by'] = CoreController::$oSession->oUser->getID();
            $aData['modified_date'] = date('Y-m-d H:i:s',time());

            # Insert Campaign
            $this->oTableGateway->insert($aData);

            # Return ID
            return $this->oTableGateway->lastInsertValue;
        }

        # Check if Campaign Entity already exists
        try {
            $this->getSingle($id);
        } catch (\RuntimeException $e) {
            throw new \RuntimeException(sprintf(
                'Cannot update Campaign with identifier %d; does not exist',
                $id
            ));
        }

        # Update Metadata
        $aData['modified_by'] = CoreController::$oSession->oUser->getID();
        $aData['modified_date'] = date('Y-m-d H:i:s',time());

        # Update Campaign
        $this->oTableGateway->update($aData, ['Campaign_ID' => $id]);

        return $id;
    }

    /**
     * Generate new single Entity
     *
     * @return Campaign
     * @since 1.0.0
     */
    public function generateNew() {
        return new CampaignEntity($this->oTableGateway->getAdapter());
    }

    public function addLink($iContactID, $iCampaignID)
    {
        $oLinkTbl = new TableGateway('contact_contact_campaign', $this->oTableGateway->getAdapter());
        $oCheck = $oLinkTbl->select([
            'contact_idfs' => $iContactID,
            'campaign_idfs' => $iCampaignID
        ]);
        if(count($oCheck) == 0) {
            $oLinkTbl->insert([
                'contact_idfs' => $iContactID,
                'campaign_idfs' => $iCampaignID
            ]);
        }

        return true;
    }
}