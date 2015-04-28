<?php
/**
* Класс PollBackendController:
*
*   @category YupeController
*   @package  yupe
*   @author   Yupe Team <team@yupe.ru>
*   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
*   @link     http://yupe.ru
**/
class PollBackendController extends yupe\components\controllers\BackController
{
    /**
    * Отображает Опрос по указанному идентификатору
    *
    * @param integer $id Идинтификатор Опрос для отображения
    *
    * @return void
    */
    public function actionView($id)
    {
        $this->render('view', array('model' => $this->loadModel($id)));
    }

    /**
    * Создает новую модель Опроса.
    * Если создание прошло успешно - перенаправляет на просмотр.
    *
    * @return void
    */
    public function actionCreate()
    {
        $model = new Poll;
        $choices = array();
        //$this->performAjaxValidation($model);

        if (isset($_POST['Poll'])) {
            $model->attributes = $_POST['Poll'];

            // Setup poll choices
            if (isset($_POST['PollChoice'])) {
                foreach ($_POST['PollChoice'] as $id => $choice) {
                    $pollChoice = new PollChoice;
                    $pollChoice->attributes = $choice;
                    $choices[$id] = $pollChoice;
                }
            }

            if ($model->save()) {
                // Save any poll choices too
                foreach ($choices as $choice) {
                    $choice->poll_id = $model->id;
                    $choice->save();
                }
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('poll', 'Запись добавлена!')
                );
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('create', array(
            'model' => $model,
            'choices' => $choices,
        ));
    }

    /**
    * Редактирование Опроса.
    *
    * @param integer $id Идинтификатор Опрос для редактирования
    *
    * @return void
    */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $choices = $model->choices;
        //$this->performAjaxValidation($model);

        if (isset($_POST['Poll'])) {
            $model->attributes = $_POST['Poll'];

            // Setup poll choices
            $choices = array();
            if (isset($_POST['PollChoice'])) {
                foreach ($_POST['PollChoice'] as $id => $choice) {
                    $pollChoice = $this->loadChoice($model, $choice['id']);
                    $pollChoice->attributes = $choice;
                    $choices[$id] = $pollChoice;
                }
            }

            if ($model->save()) {
                // Save any poll choices too
                foreach ($choices as $choice) {
                    $choice->poll_id = $model->id;
                    $choice->save();
                }
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('poll', 'Запись обновлена!')
                );

                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update',array(
            'model'=>$model,
            'choices'=>$choices,
        ));
    }

    /**
    * Удаляет модель Опроса из базы.
    * Если удаление прошло успешно - возвращется в index
    *
    * @param integer $id идентификатор Опроса, который нужно удалить
    *
    * @return void
    */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
        // поддерживаем удаление только из POST-запроса
        $this->loadModel($id)->delete();

        Yii::app()->user->setFlash(
            yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
            Yii::t('poll', 'Запись удалена!')
        );

        // если это AJAX запрос ( кликнули удаление в админском grid view), мы не должны никуда редиректить
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
        } else
            throw new CHttpException(400, Yii::t('poll', 'Неверный запрос. Пожалуйста, больше не повторяйте такие запросы'));
    }

    /**
    * Управление Опросами.
    *
    * @return void
    */
    public function actionIndex()
    {
        $model = new Poll('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Poll']))
            $model->attributes = $_GET['Poll'];
        $this->render('index', array('model' => $model));
    }

    /**
     * Export the results of a Poll.
     */
    public function actionExport($id)
    {
        $model = $this->loadModel($id);
        $exportForm = new PollExportForm($model);
        $cform = $exportForm->cform();

        if ($cform->submitted('submit') && $cform->validate()) {
            $exportForm->export(); 
        }

        $this->render('export', array(
            'model' => $model,
            'exportForm' => $exportForm, 
            'cform' => $cform,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=Poll::model()->with('choices','votes')->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Returns the PollChoice model based on primary key or a new PollChoice instance.
     * @param Poll the Poll model 
     * @param integer the ID of the PollChoice to be loaded
     */
    public function loadChoice($poll, $choice_id)
    {
        if ($choice_id) {
            foreach ($poll->choices as $choice) {
                if ($choice->id == $choice_id) return $choice;
            }
        }

        return new PollChoice;
    }

    /**
     * Returns the PollVote model based on primary key or a new PollVote instance.
     * @param object the Poll model 
     */
    public function loadVote($model)
    {
        $userId = (int) Yii::app()->user->id;
        $isGuest = Yii::app()->user->isGuest;

        foreach ($model->votes as $vote) {
            if ($vote->user_id == $userId) {
                if (Yii::app()->getModule('poll')->ipRestrict && $isGuest && $vote->ip_address != $_SERVER['REMOTE_ADDR'])
                    continue;
                else
                    return $vote;
            }
        }

        return new PollVote;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='poll-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
    
}
