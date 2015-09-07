<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

use app\modules\category\models\Category;

class UserJobSeekerResume extends BaseUserJobSeekerResume
{

    public static function moduleName(){
        return 'job';
    }

    public function rules()
    {
        return array_merge(
            parent::rules(), [
                [['nationality', 'location', 'phone_country', 'phone_number', 'experience', 'functions', 'industries', 'salary', 'education_name', 'education_degree'], 'required'],
            ]
        );
    }

    public function scenarios()
    {
        return array_merge(Model::scenarios(), [
            'search' => ['_id', 'nationality', 'location', 'phone_country', 'phone_number', 'social_linkedin', 'social_facebook', 'social_twitter', 'experience', 'functions', 'industries', 'salary', 'education_name', 'education_degree', 'education_study', 'education_month', 'education_year', 'language_ability'],
        ]);
    }

    public function search($params, $pageSize = 20)
    {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // condition here
        $query->andFilterWhere(['like', '_id', $this->_id])
            ->andFilterWhere(['like', 'nationality', $this->nationality])
            ->andFilterWhere(['like', 'location', $this->location])
            ->andFilterWhere(['like', 'phone_country', $this->phone_country])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'social_linkedin', $this->social_linkedin])
            ->andFilterWhere(['like', 'social_facebook', $this->social_facebook])
            ->andFilterWhere(['like', 'social_twitter', $this->social_twitter])
            ->andFilterWhere(['like', 'experience', $this->experience])
            ->andFilterWhere(['like', 'functions', $this->functions])
            ->andFilterWhere(['like', 'industries', $this->industries])
            ->andFilterWhere(['like', 'salary', $this->salary])
            ->andFilterWhere(['like', 'education_name', $this->education_name])
            ->andFilterWhere(['like', 'education_degree', $this->education_degree])
            ->andFilterWhere(['like', 'education_study', $this->education_study])
            ->andFilterWhere(['like', 'education_month', $this->education_month])
            ->andFilterWhere(['like', 'education_year', $this->education_year])
            ->andFilterWhere(['like', 'language_ability', $this->language_ability]);


        return $dataProvider;
    }

    public function getLatestEmployerModel()
    {
        return $this->hasOne(\app\modules\job\models\UserJobSeekerEmployment::className(), ['seeker_id' => '_id']);
    }

    public function getLatestEmployer()
    {
        $model = $this->latestEmployerModel;
        return $model ? $model : null;
    }

    public function getLocationModel()
    {
        return $this->hasOne(\app\modules\job\models\JobLocation::className(), ['_id' => 'location']);
    }

    public function getLocationTitle()
    {
        $model = $this->locationModel;
        return $model ? $model->title : '';
    }

    public function getFunctionNames(){
        if (is_array($this->functions)){
            $items = ArrayHelper::map(JobFunction::find()->where(['in', '_id', $this->functions])->asArray()->all(), '_id', 'title');
        } else {
            $items = ArrayHelper::map(JobFunction::find()->where(['_id' => $this->functions])->asArray()->all(), '_id', 'title');
        }

        return implode('; ', $items);
    }

    public function getIndustryNames(){
        if (is_array($this->industries)){
            $items = ArrayHelper::map(Category::find()->where(['in', '_id', $this->industries])->asArray()->all(), '_id', 'name');
        } else {
            $items = ArrayHelper::map(Category::find()->where(['_id' => $this->industries])->asArray()->all(), '_id', 'name');
        }

        return implode('; ', $items);
    }

    public function getCountryCodeOptions() {
        return [
            'HKG' => Yii::t('job', 'Hong Kong(852)'),
            'SGP' => Yii::t('job', 'Singapore(65)'),
            'AUS' => Yii::t('job', 'Australia(61)'),
        ];
    }

    public function getExperienceOptions() {
        $result = [];
        for ($i = 1; $i <= 40; $i++) {
            $result[$i] = $i;
        }
        return $result;
    }

    public function getEducationMonthOptions() {
        return [
            '1' => 'Jan',
            '2' => 'Feb',
            '3' => 'Mar',
            '4' => 'Apr',
            '5' => 'May',
            '6' => 'Jun',
            '7' => 'Jul',
            '8' => 'Aug',
            '9' => 'Sep',
            '10' => 'Oct',
            '11' => 'Nov',
            '12' => 'Dec',
        ];
    }

    public function getEducationYearOptions() {
        $result = [];
        $startYear = 1930;
        $endYear = date('Y');
        for ($i = $endYear; $i >= $startYear; $i--) {
            $result[$i] = $i;
        }
        return $result;
    }

    public function getDegreeEarnedOptions() {
        return [
          'H' => Yii::t('job', 'Postgraduate Degree - MD / PhD / Doctorate'),
          'G' => Yii::t('job', 'Postgraduate Degree - JD'),
          'F' => Yii::t('job', 'Postgraduate Degree - Masters'),
          'E' => Yii::t('job', 'Postgraduate Degree - MBA'),
          'D' => Yii::t('job', 'Postgraduate Degree'),
          'C' => Yii::t('job', 'Undergraduate Degree'),
          'B' => Yii::t('job', 'Associate Degree'),
          'A' => Yii::t('job', 'Other'),
        ];
    }

    public function getLanguageOptions() {
        return [
            'EN' => Yii::t('job', 'English'),
            'CT' => Yii::t('job', 'Cantonese'),
            'HI' => Yii::t('job', 'Hindi'),
        ];
    }

    public function getLanguageText($language) {
        if (array_key_exists($language, $this->getLanguageOptions()))
            return $this->getLanguageOptions()[$language];

        return '';
    }

    public function getLanguageLevelOptions() {
        return [
          'A' => Yii::t('job', 'Native'),
          'B' => Yii::t('job', 'Fluent'),
          'C' => Yii::t('job', 'Business'),
          'D' => Yii::t('job', 'Intermediate'),
          'X' => Yii::t('job', 'Novice'),
        ];
    }

}
