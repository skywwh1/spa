<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
 * @version   3.0.3
 */

namespace kartik\grid;

use kartik\base\AssetBundle;

/**
<<<<<<< HEAD
 * Asset bundle for [[EditableColumn]] functionality of the [[GridView]] widget.
=======
 * Asset bundle for GridView EditableColumn Widget
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class EditableColumnAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/kv-grid-editable']);
        parent::init();
    }
}
