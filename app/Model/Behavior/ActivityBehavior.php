<?php

App::import("Model", "Activity");

class ActivityBehavior extends ModelBehavior {

  function setup(&$Model, $settings = array()) {
    // do any setup here
  }

  function afterSave(\Model $model, $created) {
    parent::afterSave($model, $created);

    $activity_type = 'U';
    if ($created) {
      $activity_type = 'C';
    } elseif ((isset($model->data[$model->alias]['delete']) && ($model->data[$model->alias]['delete'] == 1))
            || (isset($model->data[$model->alias]['deleted']) && ($model->data[$model->alias]['deleted'] == 1))) {
      $activity_type = 'D';
    }
    $data = array(
        'model' => $model->alias,
        'model_id' => $model->id,
        'activity_type' => $activity_type,
        'user_id' => $model->loginUser['id'],
    );
    $activity = new Activity();
    $activity->save($data);
  }

  function afterDelete(\Model $model) {
    parent::afterDelete($model);

    $data = array(
        'model' => $model->alias,
        'model_id' => $model->id,
        'activity_type' => 'D',
        'user_id' => $model->loginUser['id'],
    );
    $activity = new Activity();
    $activity->save($data);
  }

  function afterFind(\Model $model, $results, $primary) {
    parent::afterFind($model, $results, $primary);

    if ($model->id) {
      $data = array(
          'model' => $model->alias,
          'model_id' => $model->id,
          'activity_type' => 'R',
          'user_id' => $model->loginUser['id'],
      );
      $activity = new Activity();
      $activity->save($data);
    }
  }

}