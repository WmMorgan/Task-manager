<?php

namespace app\models\TaskModel;

use yii\base\Model;
use yii\data\ActiveDataProvider;


/**
 * SearchTask represents the model behind the search form of `app\models\TaskModel\Tasks`.
 */
class SearchTask extends Tasks
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'responsible', 'status', 'created_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['responsible'] = ['user_id', 'status']; //Scenario Values Only Accepted
        return $scenarios;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Tasks::find();

        // Отображение задач, назначенных пользователю
        if ($this->scenario == 'responsible') {
            $query->andFilterWhere([
                'responsible' => \Yii::$app->user->id
            ]);
        } else
        // Если у вас нет прав администратора, показывать только созданные вами сообщения
        if(!\Yii::$app->user->can('admin')) {
            $query->andFilterWhere([
                'user_id' => \Yii::$app->user->id
            ]);
        }


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'responsible' => $this->responsible,
            'deadline' => $this->deadline,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
