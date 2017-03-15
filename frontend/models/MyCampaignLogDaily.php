<?php

namespace frontend\models;

use common\models\CampaignLogDaily;

class MyCampaignLogDaily extends CampaignLogDaily
{
    public $start;
    public $end;
    public $timezone;
    public $cvr0;
    public $campaign_name;
}
