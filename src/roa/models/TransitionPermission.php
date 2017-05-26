<?php

namespace tecnocen\workflow\roa\models;

use Yii;
use tecnocen\roa\behaviors\Slug;
use yii\web\Linkable;

/**
 * ROA contract to handle workflow transition permissions records.
 *
 * @method string[] getSlugLinks()
 * @method string getSelfLink()
 */
class TransitionPermission
    extends \tecnocen\workflow\models\TransitionPermission
    implements Linkable
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            'slug' => [
                'class' => Slug::class,
                'resourceName' => 'permission',
                'parentSlugRelation' => 'transition',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getLinks()
    {
        return $this->getSlugLinks();
    }
}