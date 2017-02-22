<?php
/**
 * Created by PhpStorm.
 * User: iven.wu
 * Date: 2/20/2017
 * Time: 11:57 PM
 */

namespace api\auth;


use yii\filters\auth\AuthMethod;
use yii\web\IdentityInterface;
use yii\web\Request;
use yii\web\Response;
use yii\web\UnauthorizedHttpException;
use yii\web\User;

class QueryParamAuth extends AuthMethod
{

    public $tokenParam = 'token';
    public $userName = 'u';

    /**
     * Authenticates the current user.
     * @param User $user
     * @param Request $request
     * @param Response $response
     * @return IdentityInterface the authenticated user identity. If authentication information is not provided, null will be returned.
     * @throws UnauthorizedHttpException if authentication information is provided but is invalid.
     */
    public function authenticate($user, $request, $response)
    {
        $userName = $request->get($this->userName);
        $accessToken = $request->get($this->tokenParam);
        if (is_string($accessToken) && is_string($userName)) {
            $channel = $user->loginByAccessToken($userName, get_class($this));
            if ($channel !== null) {
                $key = $channel->auth_token;
                if ($accessToken == md5($key)) {
                    return $channel;
                }

            }
        }
        if ($accessToken !== null || $userName !== null) {
            $this->handleFailure($response);
        }

        return null;
    }
}