<?php

class mspPrivatePartsOfficeItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'mspPrivatePartsItem';
    public $classKey = 'mspPrivatePartsItem';
    public $languageTopics = array('mspprivateparts');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('mspprivateparts_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('mspprivateparts_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'mspPrivatePartsOfficeItemCreateProcessor';