<?php

namespace app\api\models;

use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;
use yii\web\NotFoundHttpException;

/**
 * ROA contract to handle credit records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class Credit extends \app\models\Credit
    implements Linkable
{
    /**
     * @inheritdoc
     */
    protected $creditClass = Credit::class;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'credit',
            ],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return array_merge($this->getSlugLinks(), [
            'worklog' => $this->getSelfLink() . '/worklog',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function extraFields()
    {
        return [
            'workLogs',
            'activeWorkLog',
        ];
    } 
}
