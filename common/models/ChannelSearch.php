<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Channel;

/**
 * ChannelSearch represents the model behind the search form about `common\models\Channel`.
 */
class ChannelSearch extends Channel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'type', 'om', 'main_channel', 'card_number', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'bd', 'status', 'traffic_source', 'pricing_mode', 'total_revenue', 'need_pay'], 'integer'],
            [['username', 'team', 'firstname', 'lastname', 'auth_key', 'password_hash', 'password_reset_token', 'settlement_type', 'account_name', 'branch_name', 'contacts', 'email', 'country', 'city', 'address', 'company', 'phone1', 'phone2', 'wechat', 'skype', 'alipay', 'lang', 'timezone', 'system', 'cc_email', 'note', 'app_id', 'post_back', 'click_pram_name', 'click_pram_length', 'already_pay'], 'safe'],
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
        $query = Channel::find();

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

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'type' => $this->type,
            'om' => $this->om,
            'main_channel' => $this->main_channel,
            'card_number' => $this->card_number,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'qq' => $this->qq,
            'firstaccess' => $this->firstaccess,
            'lastaccess' => $this->lastaccess,
            'picture' => $this->picture,
            'confirmed' => $this->confirmed,
            'suspended' => $this->suspended,
            'deleted' => $this->deleted,
            'bd' => $this->bd,
            'status' => $this->status,
            'traffic_source' => $this->traffic_source,
            'pricing_mode' => $this->pricing_mode,
            'total_revenue' => $this->total_revenue,
            'need_pay' => $this->need_pay,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'team', $this->team])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'settlement_type', $this->settlement_type])
            ->andFilterWhere(['like', 'account_name', $this->account_name])
            ->andFilterWhere(['like', 'branch_name', $this->branch_name])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'phone1', $this->phone1])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'alipay', $this->alipay])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'system', $this->system])
            ->andFilterWhere(['like', 'cc_email', $this->cc_email])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'app_id', $this->app_id])
            ->andFilterWhere(['like', 'post_back', $this->post_back])
            ->andFilterWhere(['like', 'click_pram_name', $this->click_pram_name])
            ->andFilterWhere(['like', 'click_pram_length', $this->click_pram_length])
            ->andFilterWhere(['like', 'already_pay', $this->already_pay]);

        return $dataProvider;
    }
}
