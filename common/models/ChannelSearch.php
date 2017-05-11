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
            [['id', 'type', 'om', 'master_channel', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'status', 'traffic_source', 'pricing_mode', 'total_revenue', 'payable','os','recommended'], 'integer'],
            [['username', 'firstname', 'lastname', 'auth_key', 'password_hash', 'password_reset_token', 'payment_way', 'payment_term', 'beneficiary_name', 'bank_country', 'bank_name', 'bank_address', 'swift', 'account_nu_iban', 'company_address', 'note', 'system', 'contacts', 'email', 'cc_email', 'company', 'country', 'city', 'address', 'phone1', 'phone2', 'wechat', 'skype', 'alipay', 'lang', 'timezone', 'post_back', 'paid', 'strong_geo', 'strong_category'], 'safe'],
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
     * @return ActiveDataProvider
     */
    public function search()
    {
        $query = Channel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

//        $this->load($params);

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
            'master_channel' => $this->master_channel,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'qq' => $this->qq,
            'firstaccess' => $this->firstaccess,
            'lastaccess' => $this->lastaccess,
            'picture' => $this->picture,
            'confirmed' => $this->confirmed,
            'suspended' => $this->suspended,
            'deleted' => $this->deleted,
            'status' => $this->status,
            'traffic_source' => $this->traffic_source,
            'pricing_mode' => $this->pricing_mode,
            'total_revenue' => $this->total_revenue,
            'payable' => $this->payable,
            'os' => $this->os,
            'recommended' => $this->recommended,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'payment_way', $this->payment_way])
            ->andFilterWhere(['like', 'payment_term', $this->payment_term])
            ->andFilterWhere(['like', 'beneficiary_name', $this->beneficiary_name])
            ->andFilterWhere(['like', 'bank_country', $this->bank_country])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_address', $this->bank_address])
            ->andFilterWhere(['like', 'swift', $this->swift])
            ->andFilterWhere(['like', 'account_nu_iban', $this->account_nu_iban])
            ->andFilterWhere(['like', 'company_address', $this->company_address])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'system', $this->system])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'cc_email', $this->cc_email])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone1', $this->phone1])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'alipay', $this->alipay])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'post_back', $this->post_back])
            ->andFilterWhere(['like', 'paid', $this->paid])
            ->andFilterWhere(['like', 'strong_geo', $this->strong_geo])
            ->andFilterWhere(['like', 'strong_category', $this->strong_category]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchApplying($params)
    {
        $this->load($params);
        $this->status = 2;
        return $this->searchApplicants();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchIndex($params)
    {
        $this->load($params);
        return $this->search();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchMyChannels($params)
    {
        $this->load($params);
        $this->om = Yii::$app->user->id;
        return $this->search();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @return ActiveDataProvider
     */
    public function searchApplicants()
    {
        $query = Channel::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions

        $query->andFilterWhere(['!=', 'om',  Yii::$app->user->id]);
        $query->andFilterWhere(['=', 'status', 2]);

        return $dataProvider;
    }

    public function recommendSearch($params)
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
            'master_channel' => $this->master_channel,
            'created_time' => $this->created_time,
            'updated_time' => $this->updated_time,
            'qq' => $this->qq,
            'firstaccess' => $this->firstaccess,
            'lastaccess' => $this->lastaccess,
            'picture' => $this->picture,
            'confirmed' => $this->confirmed,
            'suspended' => $this->suspended,
            'deleted' => $this->deleted,
            'status' => $this->status,
            'traffic_source' => $this->traffic_source,
            'pricing_mode' => $this->pricing_mode,
            'total_revenue' => $this->total_revenue,
            'payable' => $this->payable,
            'os' => $this->os,
            'recommended' => $this->recommended,
        ]);

        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'firstname', $this->firstname])
            ->andFilterWhere(['like', 'lastname', $this->lastname])
            ->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'payment_way', $this->payment_way])
            ->andFilterWhere(['like', 'payment_term', $this->payment_term])
            ->andFilterWhere(['like', 'beneficiary_name', $this->beneficiary_name])
            ->andFilterWhere(['like', 'bank_country', $this->bank_country])
            ->andFilterWhere(['like', 'bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'bank_address', $this->bank_address])
            ->andFilterWhere(['like', 'swift', $this->swift])
            ->andFilterWhere(['like', 'account_nu_iban', $this->account_nu_iban])
            ->andFilterWhere(['like', 'company_address', $this->company_address])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'system', $this->system])
            ->andFilterWhere(['like', 'contacts', $this->contacts])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'cc_email', $this->cc_email])
            ->andFilterWhere(['like', 'company', $this->company])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'phone1', $this->phone1])
            ->andFilterWhere(['like', 'phone2', $this->phone2])
            ->andFilterWhere(['like', 'wechat', $this->wechat])
            ->andFilterWhere(['like', 'skype', $this->skype])
            ->andFilterWhere(['like', 'alipay', $this->alipay])
            ->andFilterWhere(['like', 'lang', $this->lang])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'post_back', $this->post_back])
            ->andFilterWhere(['like', 'paid', $this->paid])
            ->andFilterWhere(['like', 'strong_geo', $this->strong_geo])
            ->andFilterWhere(['like', 'strong_category', $this->strong_category]);
        return $dataProvider;
    }
}
