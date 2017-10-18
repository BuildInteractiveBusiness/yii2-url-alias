<?php

namespace robot72\modules\urlalias\components;

use Yii;
use yii\base\Component;

/**
 * UrlHelper help your get, create url-addresses from short call in your code
 *
 * @author Robert Kuznetsov
 */
class UrlHelper extends Component
{

    public function createUrlFromRoute($route, $params = [])
    {
        $urlRule = new UrlRule();
        $dbRoute = $urlRule->getRouteFromCacheOrWriteCacheThenRead($route, $params);

        if (is_object($dbRoute) && $dbRoute->hasAttribute('slug')) {
            $dbSlugName = $dbRoute->getAttribute('slug');
        }
        
        return $dbSlugName;
    }
    
}
