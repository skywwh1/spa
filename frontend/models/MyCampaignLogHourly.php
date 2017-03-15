<?php

namespace frontend\models;

use common\models\CampaignLogHourly;


class MyCampaignLogHourly extends CampaignLogHourly
{
    public $start;
    public $end;
    public $timezone;
    public $cvr0;
    public $campaign_name;
}
