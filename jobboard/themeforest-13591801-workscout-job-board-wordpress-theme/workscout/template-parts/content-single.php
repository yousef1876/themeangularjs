<article id="post-<?php the_ID(); ?>" <?php post_class('post-container'); ?>>
  
  <?php 
  if ( ! post_password_required() ) { 
      if(has_post_thumbnail()) { ?>
      <div class="post-img">
        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail();  ?><div class="hover-icon"></div></a>
      </div>
      <?php } 
  }?>

  <section class="post-content">

    <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
   
    <div class="meta-tags">
      <?php workscout_posted_on(); ?>
    </div>
    <div class="clearfix"></div>
    <div class="margin-bottom-25"></div>
    
    <?php the_content(); ?>

  </section>

</article>
