<?php

class m170101_000002_workflow_stage extends tecnocen\rmdb\migrations\CreatePersistentEntity
{
    /**
     * @inhertidoc
     */
    public function getTableName()
    {
        return 'workflow_stage';
    }

    /**
     * @inhertidoc
     */
    public function columns()
    {
        return [
            'id' => $this->primaryKey(),
            'workflow_id' => $this->normalKey(),
            'position_x' => $this->integer()->notNull()->defaultValue(0),
            'position_y' => $this->integer()->notNull()->defaultValue(0),
            'name' => $this->string(64)->notNull(),
            'initial' => $this->activable(false),
        ];
    }

    /**
     * @inhertidoc
     */
    public function foreignKeys()
    {
        return ['workflow_id' => 'workflow'];
    }

    /**
     * @inhertidoc
     */
    public function compositeUniqueKeys()
    {
        return [['workflow_id', 'name']];
    }
}
