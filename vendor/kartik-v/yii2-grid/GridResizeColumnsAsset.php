<?php

/**
 * @package   yii2-grid
 * @author    Kartik Visweswaran <kartikv2@gmail.com>
 * @copyright Copyright &copy; Kartik Visweswaran, Krajee.com, 2014 - 2016
<<<<<<< HEAD
 * @version   3.1.3
=======
 * @version   3.1.1
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 */

namespace kartik\grid;

use \kartik\base\AssetBundle;

/**
<<<<<<< HEAD
 * Asset bundle for resizable columns functionality for the [[GridView]] widget.
=======
 * Asset bundle for GridView Widget (for resizing columns)
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class GridResizeColumnsAsset extends AssetBundle
{
<<<<<<< HEAD
=======
    public $depends = [
        'kartik\grid\GridViewAsset'
    ];

>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
    /**
     * @inheritdoc
     */
    public function init()
    {
<<<<<<< HEAD
        $this->depends = array_merge($this->depends, ['kartik\grid\GridViewAsset']);
=======
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('js', ['js/jquery.resizableColumns']);
        $this->setupAssets('css', ['css/jquery.resizableColumns']);
        parent::init();
    }
}
