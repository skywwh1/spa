<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Advertiser;

/**
 * AdvertiserSearch represents the model behind the search form about `common\models\Advertiser`.
 */
class AdvertiserSearch extends Advertiser
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'pm', 'status', 'pricing_mode', 'type', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted'], 'integer'],
            [['bd', 'username', 'firstname', 'lastname', 'settlement_type', 'system', 'contacts', 'auth_key', 'password_hash', 'password_reset_token', 'post_parameter', 'email', 'cc_email', 'company', 'country', 'city', 'address', 'phone1', 'phone2', 'weixin', 'skype', 'alipay', 'lang', 'timezone', 'note'], 'safe'],
            [['total_revenue', 'receivable', 'received'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
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
        $query = Advertiser::find();
        $query->alias('a');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('bd0');
        // grid filtering conditions
        $query->andFilterWhere([
            'a.id' => $this->id,
            'pm' => $this->pm,
            'a.status' => $this->status,
            'total_revenue' => $this->total_revenue,
            'receivable' => $this->receivable,
            'received' => $this->received,
            'pricing_mode' => $this->pricing_mode,
            'type' => $this->type,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'qq' => $this->qq,
            'firstaccess' => $this->firstaccess,
            'lastaccess' => $this->lastaccess,
            'picture' => $this->picture,
            'confirmed' => $this->confirmed,
            'suspended' => $this->suspended,
            'deleted' => $this->deleted,
        ]);

        $query->andFilterWhere(['like', 'a.username', $this->username])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
//            ->andFilterWhere(['like', 'bd', Yii::$app->user->id])
            ->andFilterWhere(['like', 'system', $this->system])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'post_parameter', $this->post_parameter])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'cc_email', $this->cc_email])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone1', $this->phone1])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'weixin', $this->weixin])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'alipay', $this->alipay])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'user.username', $this->bd,])
            ->andFilterWhere(['like', 'note', $this->note]);

        if (\Yii::$app->user->can('admin')) {
            $query->andFilterWhere(['like', 'u.username', $this->bd]);
        } else {
            $query->andFilterWhere(['a.bd' => \Yii::$app->user->id]);

        }
        $query->orderBy('created_time desc');

        return $dataProvider;
    }
}
