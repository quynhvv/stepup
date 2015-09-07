<?php 
    use yii\helpers\Html;
?>
<!-- Render markup by position -->
<?php if ($position == 'top'):?>
    <div class="main-navigation">
        <span class="visible-sm visible-xs toggle-main-navigation menu-btn" id="toggle-main-menu">
            <i class="fa fa-bars"></i>
        </span>
        <nav class="main-menu">
            <?php
                $currentRole = Yii::$app->session->get('jobAccountRole', 'default');
                echo $this->render("navigation/nav-{$currentRole}");
            ?>
        </nav>
    </div>

<?php elseif ($position == 'bottom'): ?>
    <ul class="list-icon">
        <li class="icon-idea"><a href="#">Privacy Policy</a></li>
        <li class="icon-star"><a href="#">About Step Up</a></li>
        <li class="icon-star"><a href="#">Contact Us</a></li>
        <li class="icon-check"><a href="#">StepUp Careers</a></li>
        <li class="icon-check"><?= Html::a(Yii::t('job', 'Recruiter sign in'), ['/job/account/login', 'role' => 'recruiter']) ?></li>
        <li class="icon-check"><?= Html::a(Yii::t('job', 'Recruiter sign up'), ['/job/account/register', 'role' => 'recruiter']) ?></li>
    </ul>
<?php endif; ?>
