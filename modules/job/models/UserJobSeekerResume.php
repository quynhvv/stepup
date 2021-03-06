<?php

namespace app\modules\job\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use app\modules\category\models\Category;

class UserJobSeekerResume extends BaseUserJobSeekerResume {

    public $_ids;
    public $keyword; // Enter first_name, last_name, display_name...
    public $search_mode = 'AND'; // AND/OR

    public static function moduleName() {
        return 'job';
    }

    public function rules() {
        return array_merge(
                parent::rules(), [
                    [['nationality', 'location', 'phone_country', 'phone_number', 'experience', 'functions', 'industries', 'salary', 'education_name', 'education_degree'], 'required', 'on' => 'default'],
                ]
        );
    }

    public function scenarios() {
        return array_merge(Model::scenarios(), [
            'search' => ['latest_company', 'latest_position', 'nationality', 'location', 'phone_country', 'phone_number', 'social_linkedin', 'social_facebook', 'social_twitter', 'experience', 'functions', 'industries', 'salary', 'education_name', 'education_degree', 'education_study', 'education_month', 'education_year', 'language_ability', 'keyword', 'search_mode'],
        ]);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['_id' => '_id']);
    }

    public function search($params, $pageSize = 20) {
        $query = self::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $pageSize,
            ],
        ]);
            
        if (!($this->load($params) AND $this->validate())) {
            return $dataProvider;
        }

        if (!empty($this->keyword)){
            $query->orFilterWhere(['like', 'education_name', $this->keyword])
                ->orFilterWhere(['like', 'phone_number', $this->keyword])
                ->orFilterWhere(['like', 'social_facebook', $this->keyword])
                ->orFilterWhere(['like', 'social_twitter', $this->keyword])
                ->orFilterWhere(['like', 'latest_company', $this->keyword])
                ->orFilterWhere(['like', 'latest_position', $this->keyword])
                ->orFilterWhere(['like', 'education_study', $this->keyword]);
            
            //get user's _ids by keyword from user document
            $this->_ids = array_keys(ArrayHelper::map(User::find()
                    ->orFilterWhere(['like', 'email', $this->keyword])
                    ->orFilterWhere(['like', 'fullname', $this->keyword])
                    ->orFilterWhere(['like', 'displayname', $this->keyword])
                    ->orFilterWhere(['like', 'first_name', $this->keyword])
                    ->orFilterWhere(['like', 'last_name', $this->keyword])
                    ->orFilterWhere(['like', 'phone', $this->keyword])
                    ->asArray()->all(), '_id', '_id'));
        }
        
        if ($this->search_mode == 'AND') {
            if (!empty($this->_ids)) {
                $query->where(['in', '_id', $this->_ids]);
            }
            if (!empty($this->nationality)) {
                $query->andFilterWhere(['=', 'nationality', $this->nationality]);
            }
            if (!empty($this->location)) {
                $query->andFilterWhere(['=', 'location', $this->location]);
            }
            if (!empty($this->functions)) {
                $query->andFilterWhere(['in', 'functions', $this->functions]);
            }
            if (!empty($this->industries)) {
                $query->andFilterWhere(['industries' => [$this->industries]]);
            }
            
        } else {
            if (!empty($this->_ids)) {
                $query->orFilterWhere(['in', '_id', $this->_ids]);
            }
            if (!empty($this->nationality)) {
                $query->orFilterWhere(['=', 'nationality', $this->nationality]);
            }
            if (!empty($this->location)) {
                $query->orFilterWhere(['=', 'location', $this->location]);
            }
            if (!empty($this->functions)) {
                $query->orFilterWhere(['in', 'functions', $this->functions]);
            }
            if (!empty($this->industries)) {
                $query->orFilterWhere(['industries' => [$this->industries]]);
            }
        }
        
        if (\app\helpers\ArrayHelper::getValue($params, 'sort') == NULL) {
            $query->orderBy('candidate_id DESC');
        }

        return $dataProvider;
    }

    public function getLatestEmployerModel() {
        return $this->hasOne(\app\modules\job\models\UserJobSeekerEmployment::className(), ['seeker_id' => '_id']);
    }

    public function getLatestEmployer() {
        $model = $this->latestEmployerModel;
        return $model ? $model : null;
    }

    public function getLocationModel() {
        return $this->hasOne(\app\modules\job\models\JobLocation::className(), ['_id' => 'location']);
    }

    public function getLocationTitle() {
        $model = $this->locationModel;
        return $model ? $model->title : '';
    }

    public function getFunctionNames() {
        if (is_array($this->functions)) {
            $items = ArrayHelper::map(JobFunction::find()->where(['in', '_id', $this->functions])->asArray()->all(), '_id', 'title');
        } else {
            $items = ArrayHelper::map(JobFunction::find()->where(['_id' => $this->functions])->asArray()->all(), '_id', 'title');
        }

        return implode('; ', $items);
    }

    public function getIndustryNames() {
        if (is_array($this->industries)) {
            $items = ArrayHelper::map(JobIndustry::find()->where(['in', '_id', $this->industries])->asArray()->all(), '_id', 'title');
        } else {
            $items = ArrayHelper::map(JobIndustry::find()->where(['_id' => $this->industries])->asArray()->all(), '_id', 'title');
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

    public static function getSearchModeOptions() {
        return [
            'AND' => Yii::t('account', 'AND'),
            'OR' => Yii::t('account', 'OR'),
        ];
    }

}
