<?php $__env->startSection('content'); ?>
<section id="staticpages" class="bg-white">
    <div class="staticpages-title-bg flex justify-center text-center items-center">
        <div class="title">
            <h2><?= $page_title; ?></h2>
            <hr>
        </div>
    </div>
    <div class="staticpages-content flex flex-col justify-center text-center items-center">
        <div class="container details">
            <div class="summary mb-62">
                    <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                    the_content();
                    endwhile; endif; ?>
            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>