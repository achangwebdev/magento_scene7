<?php
class Achang_Scene7_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function createAttributeSet($setName, $copyGroupsFromID = -1)
    {
 
        $setName = trim($setName);
 
 
        if($setName == '')
        {
            $this->logError("Could not create attribute set with an empty name.");
            return false;
        }
 
        //>>>> Create an incomplete version of the desired set.
 
        $model = Mage::getModel('eav/entity_attribute_set');
 
        // Set the entity type.
 
        $entityTypeID = Mage::getModel('catalog/product')->getResource()->getTypeId();
 
        $model->setEntityTypeId($entityTypeID);
 
        // We don't currently support groups, or more than one level. See
        // Mage_Adminhtml_Catalog_Product_SetController::saveAction().
 
 
        $model->setAttributeSetName($setName);
 
        // We suspect that this isn't really necessary since we're just
        // initializing new sets with a name and nothing else, but we do
        // this for the purpose of completeness, and of prevention if we
        // should expand in the future.
        $model->validate();
 
        // Create the record.
 
        try
        {
            $model->save();
        }
        catch(Exception $ex)
        {
            return false;
        }
 
        if(($id = $model->getId()) == false)
        {
            return false;
        }
 
 
        //<<<<
 
        //>>>> Load the new set with groups (mandatory).
 
        // Attach the same groups from the given set-ID to the new set.
        if($copyGroupsFromID !== -1)
        {
           
            $model->initFromSkeleton($copyGroupsFromID);
        }
 
        // Just add a default group.
        else
        {
 
            $modelGroup = Mage::getModel('eav/entity_attribute_group');
            $modelGroup->setAttributeGroupName($this->groupName);
            $modelGroup->setAttributeSetId($id);
 
            // This is optional, and just a sorting index in the case of
            // multiple groups.
            // $modelGroup->setSortOrder(1);
 
            $model->setGroups(array($modelGroup));
        }
 
        //<<<<
 
        // Save the final version of our set.
 
        try
        {
            $model->save();
        }
        catch(Exception $ex)
        {
            return false;
        }
    }
}