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
            [['id', 'type', 'om', 'master_channel', 'created_time', 'updated_time', 'qq', 'firstaccess', 'lastaccess', 'picture', 'confirmed', 'suspended', 'deleted', 'status', 'traffic_source', 'pricing_mode', 'total_revenue', 'payable','recommended'], 'integer'],
            [['username', 'firstname', 'lastname', 'auth_key', 'password_hash', 'password_reset_token',
                'payment_way', 'payment_term', 'beneficiary_name', 'bank_country',
                'bank_name', 'bank_address', 'swift', 'account_nu_iban', 'company_address', 'note', 'system', 'contacts', 'email', 'cc_email',
                'company', 'country', 'city', 'address', 'phone1', 'phone2', 'wechat', 'skype', 'alipay',
                'lang', 'timezone', 'post_back', 'paid', 'strong_geo', 'strong_category','os','om_name','master_channel_name'], 'safe'],
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
        $query->alias('ch');
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
            'ch.id' => $this->id,
            'ch.type' => $this->type,
            'ch.om' => $this->om,
            'ch.master_channel' => $this->master_channel,
            'ch.created_time' => $this->created_time,
            'ch.updated_time' => $this->updated_time,
            'ch.qq' => $this->qq,
            'ch.firstaccess' => $this->firstaccess,
            'ch.lastaccess' => $this->lastaccess,
            'ch.picture' => $this->picture,
            'ch.confirmed' => $this->confirmed,
            'ch.suspended' => $this->suspended,
            'ch.deleted' => $this->deleted,
            'ch.status' => $this->status,
            'ch.traffic_source' => $this->traffic_source,
            'ch.pricing_mode' => $this->pricing_mode,
            'ch.total_revenue' => $this->total_revenue,
            'ch.payable' => $this->payable,
//            'os' => $this->os,
            'ch.recommended' => $this->recommended,
        ]);

        $query->leftJoin('channel cch', 'ch.master_channel = cch.id');
        $query->leftJoin('user o', 'ch.om = o.id');

        $query->andFilterWhere(['like', 'ch.username', $this->username])
            ->andFilterWhere(['like', 'ch.firstname', $this->firstname])
            ->andFilterWhere(['like', 'ch.lastname', $this->lastname])
            ->andFilterWhere(['like', 'ch.auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'ch.password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'ch.password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'ch.payment_way', $this->payment_way])
            ->andFilterWhere(['like', 'ch.payment_term', $this->payment_term])
            ->andFilterWhere(['like', 'ch.beneficiary_name', $this->beneficiary_name])
            ->andFilterWhere(['like', 'ch.bank_country', $this->bank_country])
            ->andFilterWhere(['like', 'ch.bank_name', $this->bank_name])
            ->andFilterWhere(['like', 'ch.bank_address', $this->bank_address])
            ->andFilterWhere(['like', 'ch.swift', $this->swift])
            ->andFilterWhere(['like', 'ch.account_nu_iban', $this->account_nu_iban])
            ->andFilterWhere(['like', 'ch.company_address', $this->company_address])
            ->andFilterWhere(['like', 'ch.note', $this->note])
            ->andFilterWhere(['like', 'ch.system', $this->system])
            ->andFilterWhere(['like', 'ch.contacts', $this->contacts])
            ->andFilterWhere(['like', 'ch.email', $this->email])
            ->andFilterWhere(['like', 'ch.cc_email', $this->cc_email])
            ->andFilterWhere(['like', 'ch.company', $this->company])
            ->andFilterWhere(['like', 'ch.country', $this->country])
            ->andFilterWhere(['like', 'ch.city', $this->city])
            ->andFilterWhere(['like', 'ch.address', $this->address])
            ->andFilterWhere(['like', 'ch.phone1', $this->phone1])
            ->andFilterWhere(['like', 'ch.phone2', $this->phone2])
            ->andFilterWhere(['like', 'ch.wechat', $this->wechat])
            ->andFilterWhere(['like', 'ch.skype', $this->skype])
            ->andFilterWhere(['like', 'ch.alipay', $this->alipay])
            ->andFilterWhere(['like', 'ch.lang', $this->lang])
            ->andFilterWhere(['like', 'ch.timezone', $this->timezone])
            ->andFilterWhere(['like', 'ch.post_back', $this->post_back])
            ->andFilterWhere(['like', 'ch.paid', $this->paid])
            ->andFilterWhere(['like', 'ch.strong_geo', $this->strong_geo])
            ->andFilterWhere(['like', 'ch.strong_category', $this->strong_category])
            ->andFilterWhere(['like', 'ch.os', $this->os])
            ->andFilterWhere(['like', 'cch.username', $this->master_channel_name])
            ->andFilterWhere(['like', 'o.username', $this->om_name]);
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
//            'id' => $this->id,
//            'type' => $this->type,
//            'om' => $this->om,
//            'master_channel' => $this->master_channel,
//            'created_time' => $this->created_time,
//            'updated_time' => $this->updated_time,
//            'qq' => $this->qq,
//            'firstaccess' => $this->firstaccess,
//            'lastaccess' => $this->lastaccess,
//            'picture' => $this->picture,
//            'confirmed' => $this->confirmed,
//            'suspended' => $this->suspended,
//            'deleted' => $this->deleted,
//            'status' => $this->status,
//            'traffic_source' => $this->traffic_source,
//            'pricing_mode' => $this->pricing_mode,
//            'total_revenue' => $this->total_revenue,
//            'payable' => $this->payable,
//            'os' => $this->os,
            'recommended' => 1,
        ]);
        if(isset($this->os)){
            $os = explode(',',$this->os);
            $query->andWhere(['or like', 'os', $os]);
        }
        if(isset($this->strong_category)){
            $category = explode(',',$this->strong_category);
            $query->andWhere(['or like', 'strong_category', $category]);
        }
        if(isset($this->strong_geo)){
            $geo = explode(',',$this->strong_geo);
            $query->andWhere(['or like', 'strong_geo', $geo]);
        }
        return $dataProvider;
    }
}
