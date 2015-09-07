<?php

namespace app\modules\job\widgets\backend;

use Yii;
use DateTime;
use MongoDate;

use letyii\diy\components\DiyWidget;

use app\assetbundle\BackendAsset;
use app\helpers\ArrayHelper;
use app\components\GridView;

use app\modules\job\models\StatsForm;
use app\modules\job\models\JobStats;

class JobReport extends DiyWidget
{

    /**
     *
     * @var datetime ngay bat dau
     */
    public $from_time;

    /**
     *
     * @var datetime ngay ket thuc
     */
    public $to_time;

    /**
     *
     * @var string Kieu hien thi: day | week | month
     */
    public $display_type = 'day';

    /**
     *
     * @var string Format date time
     */
    public $formatDate = 'd-m-Y';

    /**
     *
     * @var array Du lieu de build chart
     */
    private $chartData = [];

    private $colorKey = '';

    /**
     *
     * @var Form model form filter
     */
    private $model;

    /**
     *
     * @var array luu du lieu tong thong ke
     */
    private $overall_statistics = [];

    public function init()
    {
        parent::init();

        $this->widgetName = 'Chart report';
        $this->diyCategory = 'job';

        // Build data default chart
        $this->chartData = [
            'element' => 'morris-line-chart',
            'data' => [],
            'xkey' => 'x',
            'ykeys' => [],
            'labels' => [],
            'hideHover' => 'auto',
            'resize' => true,
            'lineColors' => [],
            'parseTime' => false
        ];
    }

    public function run()
    {
        $this->filter();
        $this->buildRange();
        $this->buildData();

        $overall = $this->buildOverAllStatistics();
        $datetime_range = ArrayHelper::getValue($this->from_time, 'date') . '/' . ArrayHelper::getValue($this->to_time, 'date');
        $this->model->datetime_range = $datetime_range;
        echo $this->render('member-report', [
            'model' => $this->model,
            'overall_statistics' => $overall,
            'gridview' => $this->buildGridview(),
        ]);

        $this->registerAssets();
    }

    private function filter()
    {
        // create model form and load get data
        $this->model = new StatsForm;
        if ($this->model->load(Yii::$app->request->get())) {
            if (!empty($this->model->datetime_range))
                list($this->from_time, $this->to_time) = explode('/', $this->model->datetime_range);
        }
    }

    private function buildRange()
    {
        // Kieu hien thi chart
        if (!empty($this->from_time) AND !empty($this->to_time)) {
            $this->from_time = strtotime(str_replace('/', '-', $this->from_time));
            $this->to_time = strtotime(str_replace('/', '-', $this->to_time));
        } else {
            // Ngay hien tai
            $now = new DateTime('NOW'); //date('Y-m-d 00:00:00'); // Ngay hien tai

            // Neu khong ton tai from_time thi gan cho no bang ngay dau tien cua thang
            if (empty($this->from_time))
                $this->from_time = (new DateTime('0:00 first day of this month'))->getTimestamp();

            // Neu khong ton tai to_time thi gan cho no bang ngay hien tai
            if (empty($this->to_time)) {
                $this->to_time = $now->getTimestamp();
            }
        }

        $this->from_time = $this->convertTimeToArray($this->from_time);
        $this->to_time = $this->convertTimeToArray($this->to_time);
    }

    private function convertTimeToArray($timestamp)
    {
        return [
            'timestamp' => $timestamp,
            'date' => date('Y-m-d', $timestamp), // Y-m-d
            'day' => (int)date('d', $timestamp), // d
            'week' => (int)date('W', $timestamp), // W
            'month' => (int)date('m', $timestamp), // m
            'year' => (int)date('Y', $timestamp), // Y
        ];
    }

    /**
     * Build data cho chart
     */
    private function buildData()
    {
        // build data default
        $data = [
            'collection' => JobStats::getCollection()->name,
            'format' => $this->formatDate,
            'chartReport' => JobStats::find()->where([
                'date_time' => [
                    '$gte' => new MongoDate($this->from_time['timestamp']),
                    '$lte' => new MongoDate($this->to_time['timestamp']),
                ],
            ])->orderBy('date_time')->all(),
            'query' => [
                '$group' => [
                    '_id' => null,
                ],
            ],
            'where' => [
                '$match' => [
                    'date_time' => [
                        '$gte' => new MongoDate($this->from_time['timestamp']),
                        '$lte' => new MongoDate($this->to_time['timestamp']),
                    ],
                ]
            ],
        ];

        // Tao data cho chart
        foreach ($data['chartReport'] as $day_report) {
            // Build x
            $x = ['x' => date($this->formatDate, $day_report->date_time->sec)];

            foreach ($day_report->data as $key => $value) {
                // Build ykeys, labels and colors
                if (!in_array($key, $this->chartData['ykeys'])) {
                    $this->chartData['ykeys'][] = $key;
                    $this->chartData['labels'][] = $key; //parseKey

                    // Build Colors
                    $this->chartData['lineColors'][] = $this->genColor();

                    // Build query
                    if (isset($data['query']))
                        $data['query']['$group'][$key] = ['$sum' => '$data.' . $key];
                }

                // Build a,b,c
                $x[$key] = $value;
            }
            $this->chartData['data'][] = $x;
        }

        $collection = Yii::$app->mongodb->getCollection($data['collection']);
        $result = $collection->aggregate($data['where'], $data['query']);
        if (isset($result[0]) AND is_array($result[0])) {
            unset($result[0]['_id']);
            $this->overall_statistics = $result[0];
        }
    }

    /**
     * Ham render gridview thong ke theo tung ngay, tuan, thang
     * @return gridview
     */
    private function buildGridview()
    {
        // Colum mac dinh
        $columns = [
//            '_id',
        ];

        $searchModel = new JobStats();
        array_push($columns, [
            'attribute' => 'date_time',
            'filterType' => GridView::FILTER_DATE_RANGE,
            'format' => 'raw',
            'width' => '270px',
            'filterWidgetOptions' => [
                'pluginOptions' => [
                    'format' => 'Y-m-d',
                    'separator' => ' to ',
                    'opens' => 'left'
                ],
                'presetDropdown' => true,
                'hideInput' => true,
                'convertFormat' => true,
            ],
            'value' => function ($model, $key, $index, $widget) {
                return date('d/m/Y', $model->date_time->sec);
            },
        ]);
        $where = [
            'date_time' => [
                '$gte' => new MongoDate($this->from_time['timestamp']),
                '$lte' => new MongoDate($this->to_time['timestamp']),
            ],
        ];

        foreach ($this->overall_statistics as $key => $count) {
            array_push($columns, [
                'attribute' => 'data.' . $key,
                'header' => $key, // parseKey
            ]);
        }

        $queryParams = Yii::$app->request->getQueryParams();
        $searchModel->scenario = 'search';
        $dataProvider = $searchModel->search($queryParams, 20, $where);

        $gridview = GridView::widget([
            'panel' => [
                'heading' => Yii::t('job', 'Job'),
                'tableOptions' => [
                    'id' => 'listDefault',
                ],
            ],
            'pjax' => TRUE,
            'dataProvider' => $dataProvider,
            //'filterModel' => $searchModel,
            'columns' => $columns
        ]);

        return $gridview;
    }

    private function buildOverAllStatistics()
    {
        $result = [];
        foreach ($this->overall_statistics as $role => $count) {
            $result[] = $role . ': ' . $count;
        }
        return $result;
    }

    private function registerAssets()
    {
        $data = \yii\helpers\Json::encode($this->chartData);
        Yii::$app->getView()->registerJsFile(Yii::$app->view->theme->baseUrl . '/js/plugins/morris/raphael-2.1.0.min.js', ['depends' => BackendAsset::className()]);
        Yii::$app->getView()->registerJsFile(Yii::$app->view->theme->baseUrl . '/js/plugins/morris/morris.js', ['depends' => BackendAsset::className()]);
        Yii::$app->getView()->registerCssFile(Yii::$app->view->theme->baseUrl . '/css/plugins/morris/morris-0.4.3.min.css', ['depends' => BackendAsset::className()]);
        $this->getView()->registerJs("
            $(function () {
                Morris.Line(" . $data . ");
            });
        ", \yii\web\View::POS_READY);
    }

    private function genColor()
    {
        $this->colorKey++;
        $color = sprintf('#%06X', $this->colorKey * 501541 + 0x123456);
        return $color;
    }

}

