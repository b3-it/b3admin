<?php
/**
 * Erweitert die Speicherfunktion
 *
 * @category	B3it
 * @package		B3it_Admin
 * @copyright	Copyright (c) 2024 B3 IT Systeme GmbH
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

class B3it_Admin_Model_Resource_User extends Mage_Core_Model_Resource_Db_Abstract
{
    /**
     * Define main table
     *
     */
    protected function _construct()
    {
        $this->_init('admin/user', 'user_id');
    }

    public function saveAttribute(Mage_Admin_Model_User $object, string $field): self
    {
        return $this->saveAttributes($object, [$field]);
    }

    public function saveAttributes(Mage_Admin_Model_User $object, array $fields): self
    {
        if (empty($fields)) {
            return $this;
        }
        if (!$object->getId()) {
            return $this;
        }

        $writeAdapter = $this->_getWriteAdapter();

        $insertData = [];
        foreach ($fields as $field) {
            if (!$object->hasData($field)) {
                continue;
            }
            $insertData[$field] = $object->getData($field);
        }
        if (empty($insertData)) {
            return $this;
        }

        $writeAdapter->update($this->getMainTable(), $insertData, array("{$object->getIdFieldName()} = ?" => $object->getId()));

        return $this;
    }
}
