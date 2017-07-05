<?php

namespace common\models;

use common\utility\TimeZoneUtil;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Deliver;

/**
 * DeliverSearch represents the model behind the search form about `common\models\Deliver`.
 */
class DeliverSearch extends Deliver
{
    public $channel_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['daily_cap', 'status', 'creator', 'end_time', 'create_time', 'is_run', 'is_redirect', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def', 'is_send_create'], 'integer'],
            [['campaign_id', 'channel_id', 'campaign_uuid', 'pricing_mode', 'track_url', 'note', 'campaign_name', 'channel_name', 'bd', 'om', 'pm'], 'safe'],
            [['adv_price', 'pay_out', 'actual_discount', 'discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
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
        $query = Deliver::find();
        $query->alias('de');
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
        $query->joinWith('campaign cp');
        $query->joinWith('channel ch');
        $query->leftJoin('advertiser adv', 'cp.advertiser = adv.id');
        $query->leftJoin('user u', 'adv.bd = u.id');
        $query->leftJoin('user u2', 'adv.pm = u2.id');
        $query->leftJoin('user u3', 'ch.om = u3.id');
        $query->leftJoin('campaign_channel_log_redirect re', 're.campaign_id = de.campaign_id and re.channel_id=de.channel_id and re.status=1');

        $query->select("de.*, u3.username om, u.username bd,u2.username pm,re.create_time redirect_time");
        // grid filtering conditions
        $query->andFilterWhere([
            'de.campaign_id' => $this->campaign_id,
            'de.channel_id' => $this->channel_id,
            'adv_price' => $this->adv_price,
            'pay_out' => $this->pay_out,
            'daily_cap' => $this->daily_cap,
            'actual_discount' => $this->actual_discount,
            'discount' => $this->discount,
            'de.status' => $this->status,
            'creator' => $this->creator,
            'end_time' => $this->end_time,
            'create_time' => $this->create_time,
            'is_run' => $this->is_run,
            'is_redirect' => $this->is_redirect,
            'update_time' => $this->update_time,
            'click' => $this->click,
            'unique_click' => $this->unique_click,
            'install' => $this->install,
            'cvr' => $this->cvr,
            'cost' => $this->cost,
            'match_install' => $this->match_install,
            'match_cvr' => $this->match_cvr,
            'revenue' => $this->revenue,
            'def' => $this->def,
            'deduction_percent' => $this->deduction_percent,
            'profit' => $this->profit,
            'margin' => $this->margin,
            'is_send_create' => $this->is_send_create,
        ]);

        $query->andFilterWhere(['like', 'de.campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'de.pricing_mode', $this->pricing_mode])
            ->andFilterWhere(['like', 'track_url', $this->track_url])
            ->andFilterWhere(['like', 'cp.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'u.username', $this->bd])
            ->andFilterWhere(['like', 'u2.username', $this->pm])
            ->andFilterWhere(['like', 'u3.username', $this->om])
            ->andFilterWhere(['like', 'note', $this->note]);

//        var_dump(\Yii::$app->user->can('admin'));
//        die();
        if (\Yii::$app->user->can('admin')) {

        } else {
            if (\Yii::$app->user->can('pm')) {
                $query->andFilterWhere(['adv.pm' => \Yii::$app->user->id]);
            } else if (\Yii::$app->user->can('om')) {
                $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
            } else if (\Yii::$app->user->can('bd')) {
                $query->andFilterWhere(['adv.bd' => \Yii::$app->user->id]);
            }
        }

        $query->orderBy('create_time desc');
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function lowCvrSearch()
    {
        $query = LogCheckClicksDaily::find();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        // grid filtering conditions
        $beginTheDay = TimeZoneUtil::setTimeZoneGMT8Before();

        $query->where(['>=','time',$beginTheDay])->all();

        return $dataProvider;
    }
}
