<?php
use yii\helpers\Url;
use app\modules\message\models\Message;

$paramType = (int) Yii::$app->request->getQueryParam('type');
$paramCategory = (int) Yii::$app->request->getQueryParam('category');
$action = Yii::$app->controller->action->id;

if ($paramType == 0 && $paramCategory == 0) {
    $paramType = Message::TYPE_INBOX;
}

$countMessageUnread = Message::countMessageByType(Message::TYPE_INBOX)
?>

<ul class="nav nav-pills nav-stacked" role="tablist">
    <li role="presentation" class="<?php if ($action == 'create') echo 'active' ?>">
        <a href="<?= Url::to(['/message/frontend/default/create']) ?>">Create</a>
    </li>
    <li role="presentation" class="<?php if ($action == 'index' && $paramType == Message::TYPE_INBOX) echo 'active' ?>">
        <a href="<?= Url::to(['/message/frontend/default/index']) ?>">Inbox <?= ($countMessageUnread > 0) ? " ({$countMessageUnread})" : '' ?></a>
    </li>
    <li role="presentation" class="<?php if ($action == 'sent') echo 'active' ?>">
        <a href="<?= Url::to(['/message/frontend/default/sent']) ?>">Sent</a>
    </li>
    <li role="presentation" class="<?php if ($action == 'index' && $paramCategory == Message::CATEGORY_GENERAL) echo 'active' ?>">
        <a href="<?= Url::to(['/message/frontend/default/index', 'category' => Message::CATEGORY_GENERAL]) ?>">General Messages ( <?= Message::countMessageByCategory(Message::CATEGORY_GENERAL) ?> )</a>
    </li>
    <li role="presentation" class="<?php if ($action == 'index' && $paramCategory == Message::CATEGORY_SCOUTS) echo 'active' ?>">
        <a href="<?= Url::to(['/message/frontend/default/index', 'category' => Message::CATEGORY_SCOUTS]) ?>">Scouts ( <?= Message::countMessageByCategory(Message::CATEGORY_SCOUTS) ?> )</a>
    </li>
    <li role="presentation" class="<?php if ($action == 'index' && $paramCategory == Message::CATEGORY_APPLICATIONS) echo 'active' ?>">
        <a href="<?= Url::to(['/message/frontend/default/index', 'category' => Message::CATEGORY_APPLICATIONS]) ?>">Applications ( <?= Message::countMessageByCategory(Message::CATEGORY_APPLICATIONS) ?> )</a>
    </li>
</ul>
