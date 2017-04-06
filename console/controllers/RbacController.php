<?php
/**
 * Created by PhpStorm.
 * User: iven
 * Date: 2017/4/6
 * Time: 11:14
 */

namespace console\controllers;


use Yii;
use yii\console\Controller;

class RbacController extends Controller
{

    public function actionInit()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $createPost = $auth->createPermission('createPost');
        $createPost->description = 'Create a post';
//        $auth->add($createPost);

        // add "updatePost" permission
        $updatePost = $auth->createPermission('updatePost');
        $updatePost->description = 'Update post';
//        $auth->add($updatePost);

        // add "author" role and give this role the "createPost" permission
        $bd = $auth->getRole('bd');
//        $auth->add($bd);
//        $auth->addChild($author, $createPost);

        $om = $auth->getRole('om');
//        $auth->add($om);

        $pm = $auth->getRole('pm');
//        $auth->add($pm);
        $auth->addChild($pm, $bd);
        $auth->addChild($pm, $om);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->getRole('admin');
//        $auth->add($admin);
//        $auth->addChild($admin, $updatePost);
//        $auth->addChild($admin, $bd);
//        $auth->addChild($admin, $pm);
//        $auth->addChild($admin, $om);

        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
//        $auth->assign($author, 2);
//        $auth->assign($admin, 1);
    }
}