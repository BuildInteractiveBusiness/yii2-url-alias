<?php

namespace robot72\modules\urlalias;

use Yii;
use yii\base\Module as BaseModule;
use yii\base\BootstrapInterface;

/**
 * Module for UrlAlias
 */
class Module extends BaseModule implements BootstrapInterface
{
    /**
     * @var string
     */
    public $configPath = '/config/module.php';

    /**
     * @var string
     */
    public $connectionID = 'db';

    /**
     * @var string
     */
    public $routeCachePrefix = 'route_';

    /**
     * @var int
     */
    public $defaultRedirectCode = 302;

    /**
     * @var array
     */
    public $indexSlugMap = ['index', 'site/index'];

    /**
     * Route for enter admin part
     *
     * @var string
     */
    public $urlAliasAdminName = 'admin/urlalias';

    /**
     * Alias of the view for layout for backend side
     *
     * @var string
     */
    public $backendLayout = '@vendor/robot72/yii2-url-alias/views/layouts/main';

    /**
     * @inheritdoc
     * @param \yii\web\Application $app
     */
    public function bootstrap($app)
    {
        $app->getUrlManager()->addRules([
            $this->urlAliasAdminName . '/<controller:[\w\-]+>/<action:[\w\-]+>' => $this->id . '/<controller>/<action>',
        ], false);

    }
}
