<?php
use app\components\ActiveForm;
use yii\helpers\Html;
use app\helpers\ArrayHelper;
?>

<?php $form = ActiveForm::begin([
    'method' => 'GET',
    'action' => ['job-search'],
    'options' => [
        'id' => 'jobsearch-form',
        'name' => 'jobsearch-form'
    ]
]) ?>
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <tbody>
            <tr>
                <td colspan="3">
                    <?= $form->field($searchModel, 'keyword')->textInput(['class' => 'form-control full-width', 'placeholder' => 'Enter job title, company name / information etc.'])->label(false) ?>
                </td>
            </tr>
            <tr>
                <th>Select Job Category:</th>
                <td>
                    <?= $form->field($searchModel, 'category_ids')->dropDownList($searchModel->getCategoryOptions(), ['class' => 'form-control', 'prompt' => '---'])->label(false) ?>
                </td>
                <td class="text-center">
                    <input type="submit" class="button button-primary" name="jobsearch_submit1" id="candidate_home_search_button" value="Search">
                </td>
            </tr>
            </tbody>
        </table>
    </div>
<?php ActiveForm::end(); ?>