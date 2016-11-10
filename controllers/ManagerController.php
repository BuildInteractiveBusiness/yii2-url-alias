<?php

namespace robot72\modules\urlalias\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use robot72\modules\urlalias\models\UrlRule;

/**
 * Manage Url aliases(Create, Read, Update and Delete)
 *
 * @author Robert Kuznetsov
 */
class ManagerController extends Controller
{

    /**
     * List UrlRule models
     *
     * @return mixed
     */
    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => UrlRule::find(),
            'pagination' => [
                'pageSize' => 30
            ]
        ]);

        return $this->render('list', [
            'dataProvider' => $dataProvider,
            'model' => $dataProvider->getModels()
        ]);
    }

    /**
     * Create and Update UrlRule model
     *
     * @return mixed
     */
    public function actionUpdate()
    {
        $id = Yii::$app->getRequest()->get('id', false);

        $model = new UrlRule();

        if ($id) {
            $model = $this->findModel($id);
        }

        if( $model->load(Yii::$app->request->post()) && $model->save() ) {
            Yii::$app->session->setFlash('success', $id ? 'Элемент сохранен' : 'Элемент создан');

            $this->redirect('list');
        }

        return $this->render('form', [
            'id' => $id,
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing UrlRule model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['list']);
    }

    /**
     * Finds the UrlRule model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return UrlRule the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = UrlRule::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}