<?php

namespace app\fixtures;

use tecnocen\workflow\models\TransitionPermission;
use yii\test\ActiveFixture;

/**
 * Fixture to load default transition_permission.
 *
 * @author Carlos (neverabe) Llamosas <carlos@tecnocen.com>
 */
class TransitionPermissionFixture extends ActiveFixture
{
    /**
     * @inheritdoc
     */
    public $modelClass = TransitionPermission::class;

    /**
     * @inheritdoc
     */
    public $dataFile = __DIR__ . '/data/transition_permission.php';

    /**
     * @inheritdoc
     */
    public $depends = ['app\fixtures\TransitionFixture'];
}