<?php 

namespace robot72\modules\urlalias\components;

use Yii;
use yii\web\UrlRule as BaseUrlRule;
use robot72\modules\urlalias\models\UrlRule as UrlRuleModel;

/**
 * Class assign url rule
 */
class UrlRule extends BaseUrlRule
{
    public $connectionID;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->name === null) {
            $this->name = __CLASS__;
        }
    }
    

    /**
     * @param \yii\web\UrlManager $manager
     * @param string $route
     * @param array $params
     * @return bool|mixed
     */
    public function createUrl($manager, $route, $params)
    {

        $dbSlugName = false;

        try {
            $dbRoute = $this->getRouteFromCacheOrWriteCacheThenRead($route, $params);

            if (is_object($dbRoute) && $dbRoute->hasAttribute('slug')) {
                $dbSlugName = $dbRoute->getAttribute('slug');
            }

        } catch (\yii\db\Exception $e) {

        }

        return $dbSlugName;
    }

    /**
     * @param \yii\web\UrlManager $manager
     * @param \yii\web\Request $request
     * @return array|bool
     */
    public function parseRequest($manager, $request)
    {

        try {
            $_slug = $this->getRouteFromSlug($request);
            $route  = UrlRuleModel::getRouteBySlug($_slug);

            if (!is_null($route)) {
                return [
                    $route->getAttribute('route'),
                    unserialize($route->getAttribute('params'))
                ];
            }
        } catch (\yii\db\Exception $e) {

        }

        return false;
    }

    /**
     * @param \yii\web\Request $request
     * @return string
     */
    public function getRouteFromSlug($request)
    {

        $_route = $request->getPathInfo();
        $_params = $request->get();

        $dbRoute = $this->getRouteFromCacheOrWriteCacheThenRead($_route, $_params);

        if (is_object($dbRoute) && $dbRoute->hasAttribute('redirect')) {
            if ($dbRoute->getAttribute('redirect')) {
                Yii::$app->response->redirect(
                    [$dbRoute->slug],
                    $dbRoute->getAttribute('redirect_code')
                );
            }
        }

        return $_route;
    }


    /**
     * Get a route from cached
     *
     * @param $route
     * @param $params
     * @return string
     */
    private function getCachedRoute($route, $params)
    {

        $params = array_filter($params);

        return Yii::$app->getModule('UrlAlias')->routeCachePrefix . md5($route . serialize($params));
    }

    /**
     * Get a route from cache or write cache then read
     *
     * @param $_route
     * @param $_params
     * 
     * @return false|\yii\db\ActiveRecord
     */
    private function getRouteFromCacheOrWriteCacheThenRead($_route, $_params)
    {

        unset($_params['/' . $_route]);

        $dbRoute = Yii::$app->cache->get($_route, $_route);

        if ($dbRoute == false) {
            $dbRoute = UrlRuleModel::getRoute($_route, $_params);

            Yii::$app->cache->set(
                $this->getCachedRoute($_route, $_params),
                $dbRoute
            );
        }

        return $dbRoute;
    }
}