<?php
use yii\helpers\Url;
?>
        <!-- MAIN -->
        <main id="main" class="main-container">
            <!-- SECTION 1 -->
            <div class="section section-1">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="block block-banner banner-hover-style-1 banner-hover-dark-overlay">
                                <div class="block-content">
                                    <a href="<?= Url::to(['/job/seeker/index']) ?>" class="overlay">
                                        <img src="<?= $this->theme->baseUrl ?>/images/banner/left_v2.jpg" class="thumbnail-img" alt="banner image"/>
                                    </a>
                                    <div class="content-banner">
                                        <h4 class="subtitle">Job seeker</h4>
                                        <h2 class="title">Looking for<br><span class="text-uppercase">career</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="block block-banner banner-hover-style-1 banner-hover-dark-overlay">
                                <div class="block-content">
                                    <a href="<?= Url::to(['/job/recruiter/index']) ?>" class="overlay">
                                        <img src="<?= $this->theme->baseUrl ?>/images/banner/middle_v2.jpg" class="thumbnail-img" alt="banner image"/>
                                    </a>
                                    <div class="content-banner">
                                        <h4 class="subtitle">Recruitment Agency</h4>
                                        <h2 class="title">Looking for<br><span class="text-uppercase">talent</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="block block-banner banner-hover-style-1 banner-hover-dark-overlay">
                                <div class="block-content">
                                    <a href="<?= Url::to(['/job/employer/index']) ?>" class="overlay">
                                        <img src="<?= $this->theme->baseUrl ?>/images/banner/right_v2.jpg" class="thumbnail-img" alt="banner image"/>
                                    </a>
                                    <div class="content-banner">
                                        <h4 class="subtitle">Employer</h4>
                                        <h2 class="title">Looking for<br><span class="text-uppercase">staff</span></h2>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="section-heading heading-has-triangle-2sides">
                        <h2 class="heading-title">One step ahead of your competition</h2>
                    </div>
                </div>
            </div>
            <!-- # SECTION 1 -->

            <!-- SECTION 2 -->
            <div class="section section-2">
                <div class="container">
                    <div class="section-inner background-dark-gray">
                        <!-- TESTIMONIAL LIST -->
                        <div class="testimonial-list">
                            <!-- thumb navigation carousel items -->
                            <div class="col-md-12" id="slider-thumbs">
                                <ul class="thumbs-list">
                                    <li>
                                        <a id="carousel-selector-0" class="selected">
                                            <img src="<?= $this->theme->baseUrl ?>/images/testimonial/our_team_31.jpg" class="img-responsive" alt="testimonial thumbnail"/>
                                        </a>
                                    </li><li>
                                        <a id="carousel-selector-1">
                                            <img src="<?= $this->theme->baseUrl ?>/images/testimonial/our_team_22.jpg" class="img-responsive" alt="testimonial thumbnail"/>
                                        </a>
                                    </li><li>
                                        <a id="carousel-selector-2">
                                            <img src="<?= $this->theme->baseUrl ?>/images/testimonial/our_team_61.jpg" class="img-responsive" alt="testimonial thumbnail"/>
                                        </a>
                                    </li><li>
                                        <a id="carousel-selector-3">
                                            <img src="<?= $this->theme->baseUrl ?>/images/testimonial/our_team_41.jpg" class="img-responsive" alt="testimonial thumbnail"/>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                            <!-- main slider carousel -->
                            <div class="row">
                                <div class="col-md-12" id="slider">
                                    <div class="col-md-12" id="carousel-bounding-box">
                                        <div id="testimonialcarousel" class="carousel slide">
                                            <!-- main slider carousel items -->
                                            <div class="carousel-inner">
                                                <div class="active item" data-slide-number="0">
                                                    <div class="testimonial-item">
                                                        <div class="testimonial-content">
                                                            <blockquote>Lorem ipsum dolor sit amet enim. Etiam ullamcorper. Suspendisse a pellentesque dui, non felis. Maecenas malesuada elit lectus felis, malesuada ultricies. Curabitur et ligula. Ut molestie a, ultricies porta urna.</blockquote>
                                                        </div>
                                                        <div class="info">
                                                            <h5 class="author three-dots">Tom Johnson</h5>
                                                            <p class="text-gray">On Stage Studio</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item" data-slide-number="1">
                                                    <div class="testimonial-item">
                                                        <div class="testimonial-content">
                                                            <blockquote>Vestibulum commodo volutpat a, convallis ac, laoreet enim. Phasellus fermentum in, dolor. Pellentesque facilisis. Nulla imperdiet sit amet magna. Vestibulum dapibus, mauris nec malesuada fames ac turpis velit, rhoncus eu, luctus et interdum adipiscing wisi.</blockquote>
                                                        </div>
                                                        <div class="info">
                                                            <h5 class="author three-dots">Joan Avina</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item" data-slide-number="2">
                                                    <div class="testimonial-item">
                                                        <div class="testimonial-content">
                                                            <blockquote>Ut et iaculis ante, vel scelerisque tortor. Nulla dignissim, tellus sed aliquam ullamcorper, erat sem feugiat est, vitae dictum mi enim nec lectus.</blockquote>
                                                        </div>
                                                        <div class="info">
                                                            <h5 class="author three-dots">John Doe</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="item" data-slide-number="3">
                                                    <div class="testimonial-item">
                                                        <div class="testimonial-content">
                                                            <blockquote>Aliquam erat ac ipsum. Integer aliquam purus. Quisque lorem tortor fringilla sed, vestibulum id, eleifend justo vel bibendum sapien massa ac turpis faucibus orci luctus non, consectetuer lobortis quis, varius in, purus. Integer ultrices posuere cubilia.</blockquote>
                                                        </div>
                                                        <div class="info">
                                                            <h5 class="author three-dots">Gordon Dale</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- main slider carousel nav controls -->
                                            <a class="button button-prev" href="#testimonialcarousel" data-slide="prev"><i class="arrow_carrot-left"></i></a>
                                            <a class="button button-next" href="#testimonialcarousel" data-slide="next"><i class="arrow_carrot-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- # TESTIMONIAL LIST -->

                        <!-- CLIENT LIST -->
                        <div class="client-list">
                            <div class="row">
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_1.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_2.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_3.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_4.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_5.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_6.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_7.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_8.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-sm-3 col-lg-2">
                                    <div class="client-item">
                                        <a href="#">
                                            <img src="<?= $this->theme->baseUrl ?>/images/client/client_9.png" class="thumbnail-img" alt="client thumbnail image"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- # CLIENT LIST -->
                    </div>
                </div>
            </div>
            <!-- # SECTION 2 -->

        </main>
        <!-- # MAIN -->
