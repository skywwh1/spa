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

use kartik\base\AssetBundle;

/**
<<<<<<< HEAD
 * Asset bundle for perfect scrollbar functionality for the [[GridView]] widget.
=======
 * Asset bundle for GridView Widget (for perfect scrollbar)
>>>>>>> 1573a9060b7902eed903c868288fbd5421b8399b
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @since 1.0
 */
class GridPerfectScrollbarAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->setSourcePath(__DIR__ . '/assets');
        $this->setupAssets('css', ['css/perfect-scrollbar', 'css/perfect-scrollbar-kv']);
        $this->setupAssets('js', ['js/perfect-scrollbar.jquery']);
        parent::init();
    }
}
