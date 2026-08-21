<?php
  $options = get_desing_plus_option();
  $url_encode = urlencode(get_permalink($post->ID));
  $title_encode = urlencode(get_the_title());
$thumnail_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
if($thumnail_image){
  $pinterestimage = $thumnail_image;
}else{
  $noimage = array();
  $noimage[0] = esc_url(get_bloginfo('template_url')) . "/img/common/no_image_blog.gif";
  $pinterestimage = $noimage;
}
?>

<!--Type1-->
<?php if ( $options['sns_type_btm']=='type1' ) : ?>

<div id="share_top1">

<?php if(wp_is_mobile()) {  //for Mobile ?>

<div class="sns">
<ul class="type1 clearfix">

<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter"> 
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebook-シェアボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>"><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode; ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>

</ul>
</div>

<?php } else { //for PC ?> 

<div class="sns mt5">
<ul class="type1 clearfix">
<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter">
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebookボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=510');return false;" ><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2" target="blank"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>" target="blank"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" target="_blank" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>
</ul>
</div>

<?php } ?>
</div>

<?php endif; ?>

<!--Type2-->
<?php if ( $options['sns_type_btm']=='type2' ) : ?>

<div id="share_top2">

<?php if(wp_is_mobile()) {  //for Mobile ?>

<div class="sns">
<ul class="type2 clearfix">

<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter"> 
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebook-シェアボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>"><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode; ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>
</ul>
</div>

<?php } else { //for PC ?> 

<div class="sns mt15">
<ul class="type2 clearfix">
<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter">
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebookボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=510');return false;" ><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2" target="blank"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>" target="blank"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" target="_blank" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>
</ul>
</div>

<?php } ?>
</div>

<?php endif; ?>

<!--Type3-->
<?php if ( $options['sns_type_btm']=='type3' ) : ?>

<div id="share_btm1">

<?php if(wp_is_mobile()) {  //for Mobile ?>

<div class="sns mb15">
<ul class="type3">

<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter"> 
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebook-シェアボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>"><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode; ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>
</ul>
</div>

<?php } else { //for PC ?> 

<div class="sns mt15 mbn">
<ul class="type3">
<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter">
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebookボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=510');return false;" ><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2" target="blank"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>" target="blank"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" target="_blank" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>
</ul>
</div>

<?php } ?>
</div>

<?php endif; ?>

<!--Type4-->
<?php if ( $options['sns_type_btm']=='type4' ) : ?>

<div id="share_btm2">

<?php if(wp_is_mobile()) {  //for Mobile ?>

<div class="sns mb15">
<ul class="type4">

<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter"> 
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebook-シェアボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>"><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode; ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>
</ul>
</div>

<?php } else { //for PC ?> 

<div class="sns mt15 mbn">
<ul class="type4">
<?php if ( $options['show_twitter_btm'] ) : ?><!--Twitterボタン-->
<li class="twitter">
<a href="https://twitter.com/intent/tweet?text=<?php echo $title_encode ?>&url=<?php echo $url_encode ?>&via=<?php echo $options['twitter_info']; ?>&tw_p=tweetbutton&related=<?php echo $options['twitter_info']; ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=600');return false;"><i class="icon-twitter"></i><span class="ttl">Post</span><span class="share-count"><?php if(function_exists('scc_get_share_twitter')) echo (scc_get_share_twitter()==0)?'':scc_get_share_twitter(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!--Facebookボタン-->
<li class="facebook">
<a href="//www.facebook.com/sharer/sharer.php?u=<?php the_permalink() ?>&amp;t=<?php echo $title_encode ?>" class="facebook-btn-icon-link" target="blank" rel="nofollow"><i class="icon-facebook"></i><span class="ttl">Share</span><span class="share-count"><?php if(function_exists('scc_get_share_facebook')) echo (scc_get_share_facebook()==0)?'':scc_get_share_facebook(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!--Hatebuボタン-->
<li class="hatebu">
<a href="http://b.hatena.ne.jp/add?mode=confirm&url=<?php echo $url_encode ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=510');return false;" ><i class="icon-hatebu"></i><span class="ttl">Hatena</span><span class="share-count"><?php if(function_exists('scc_get_share_hatebu')) echo (scc_get_share_hatebu()==0)?'':scc_get_share_hatebu(); ?></span></a></li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <a aria-label="Lline" href="http://line.me/R/msg/text/?<?php echo $title_encode; ?><?php echo $url_encode; ?>"><i class="icon-line"></i><span class="ttl">LINE</span></a>
  </li>
  <?php }; ?>

<?php if ( $options['show_rss_btm'] ) : ?><!--RSSボタン-->
<li class="rss">
<a href="<?php echo home_url(); ?>/?feed=rss2" target="blank"><i class="icon-rss"></i><span class="ttl">RSS</span></a></li>
<?php endif; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!--Feedlyボタン-->
<li class="feedly">
<a href="http://feedly.com/index.html#subscription/feed/<?php bloginfo( 'rss2_url' ); ?>" target="blank"><i class="icon-feedly"></i><span class="ttl">feedly</span><span class="share-count"><?php if(function_exists('scc_get_follow_feedly')) echo (scc_get_follow_feedly()==0)?'':scc_get_follow_feedly(); ?></span></a></li>
<?php endif; ?>

<?php if ( $options['show_pinterest_btm'] ) : ?><!--Pinterestボタン-->
<li class="pinterest">
<a rel="nofollow" target="_blank" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>" data-pin-do="buttonPin" data-pin-custom="true"><i class="icon-pinterest"></i><span class="ttl">Pin&nbsp;it</span></a></li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/post?url=<?php echo $url_encode; ?>"><i class="icon-note"></i><span class="ttl">note</span></a>
  </li>
  <?php }; ?>
</ul>
</div>

<?php } ?>
</div>

<?php endif; ?>

<!--Type5-->
<?php if ( $options['sns_type_btm']=='type5' ) : ?>
<div id="share5_top">

<?php if(wp_is_mobile()) {  //for Mobile ?>

<div class="sns_default_top">
<ul class="clearfix">
<?php if ( $options['show_twitter_btm'] ) : ?><!-- Twitterボタン -->
<li class="default twitter_button">
<a href="https://twitter.com/share" class="twitter-share-button">Post</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</li>
<?php endif; ?>

<?php if ( $options['show_fblike_btm'] ) : ?><!-- Facebookいいねボタン -->
<li class="default facebook_button">
<div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-share=""></div>
</li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!-- Facebookシェアボタン -->
<li class="default facebook_button2">
<div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-layout="button_count"></div>
</li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!-- Hatebuボタン -->
<li class="default hatena_button">
<a href="//b.hatena.ne.jp/entry/<?php the_permalink();?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="<?php echo ( is_mobile() ) ? 'simple' : 'standard'; ?>-balloon" data-hatena-bookmark-lang="<?php echo get_locale() === 'ja' ? 'ja' : 'en' ?>" title="このエントリーをはてなブックマークに追加"><img src="//b.st-hatena.com/images/v4/public/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
</li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <div class="line-it-button" data-lang="ja" data-type="share-a" data-env="REAL" data-url="<?php the_permalink();?>" data-color="default" data-size="small" data-count="false" data-ver="3" style="display: none;"></div>
  </li>
  <?php }; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!-- Feedlyボタン -->
<li class="default feedly_button">
<a href='//feedly.com/i/subscription/feed%2F<?php bloginfo('rss2_url'); ?>' target='blank'><img id='feedlyFollow' src='//s1.feedly.com/legacy/feedly-follow-rectangle-flat-small_2x.png' alt='follow us in feedly' width='66' height='20'></a>
</li>
<?php endif; ?>

<?php if ( ($options['show_pinterest_btm'] && $options['sns_type_btm'] == 'type5') ): ?><!-- Pinterestボタン -->
<li class="default pinterest_button">
<a data-pin-do="buttonPin" data-pin-color="red" data-pin-count="beside" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
</li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/social_button" class="note-social-button" data-url="<?php echo get_permalink( $post->ID ); ?>"></a>
   <script async src="https://cdn.st-note.com/js/social_button.min.js"></script>
  </li>
  <?php }; ?>

</ul>
</div>

<?php } else { //for PC ?>

<div class="sns_default_top">
<ul class="clearfix">
<?php if ( $options['show_twitter_btm'] ) : ?><!-- Twitterボタン -->
<li class="default twitter_button">
<a href="https://twitter.com/share" class="twitter-share-button">Post</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
</li>
<?php endif; ?>

<?php if ( $options['show_fblike_btm'] ) : ?><!-- Facebookいいねボタン -->
<li class="default fblike_button">
<div class="fb-like" data-href="<?php the_permalink(); ?>" data-width="" data-layout="button" data-action="like" data-size="small" data-share=""></div>
</li>
<?php endif; ?>

<?php if ( $options['show_fbshare_btm'] ) : ?><!-- Facebookシェアボタン -->
<li class="default fbshare_button2">
<div class="fb-share-button" data-href="<?php the_permalink(); ?>" data-layout="button_count"></div>
</li>
<?php endif; ?>

<?php if ( $options['show_hatena_btm'] ) : ?><!-- Hatebuボタン -->
<li class="default hatena_button">
<a href="//b.hatena.ne.jp/entry/<?php the_permalink();?>" class="hatena-bookmark-button" data-hatena-bookmark-layout="<?php echo ( is_mobile() ) ? 'simple' : 'standard'; ?>-balloon" data-hatena-bookmark-lang="<?php echo get_locale() === 'ja' ? 'ja' : 'en' ?>" title="このエントリーをはてなブックマークに追加"><img src="//b.st-hatena.com/images/v4/public/entry-button/button-only@2x.png" alt="このエントリーをはてなブックマークに追加" width="20" height="20" style="border: none;" /></a>
<script type="text/javascript" src="http://b.st-hatena.com/js/bookmark_button.js" charset="utf-8" async="async"></script>
</li>
<?php endif; ?>

  <?php if ( $options['show_line_btm'] ) { ?>
  <li class="line_button">
   <div class="line-it-button" data-lang="ja" data-type="share-a" data-env="REAL" data-url="<?php the_permalink();?>" data-color="default" data-size="small" data-count="false" data-ver="3" style="display: none;"></div>
  </li>
  <?php }; ?>

<?php if ( $options['show_feedly_btm'] ) : ?><!-- Feedlyボタン -->
<li class="default feedly_button">
<a href='//feedly.com/i/subscription/feed%2F<?php bloginfo('rss2_url'); ?>' target='blank'><img id='feedlyFollow' src='//s1.feedly.com/legacy/feedly-follow-rectangle-flat-small_2x.png' alt='follow us in feedly' width='66' height='20'></a>
</li>
<?php endif; ?>

<?php if ( ($options['show_pinterest_btm'] && $options['sns_type_btm'] == 'type5') ): ?><!-- Pinterestボタン -->
<li class="default pinterest_button">
<a data-pin-do="buttonPin" data-pin-color="red" data-pin-count="beside" href="https://www.pinterest.com/pin/create/button/?url=<?php echo $url_encode ?>&media=<?php echo $pinterestimage[0]; ?>&description=<?php echo $title_encode ?>"><img src="//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png" /></a>
<script async defer src="//assets.pinterest.com/js/pinit.js"></script>
</li>
<?php endif; ?>

  <?php if ( $options['show_note_btm'] ) { ?>
  <li class="note_button">
   <a href="https://note.com/intent/social_button" class="note-social-button" data-url="<?php echo get_permalink( $post->ID ); ?>"></a>
   <script async src="https://cdn.st-note.com/js/social_button.min.js"></script>
  </li>
  <?php }; ?>
</ul>  
</div>

<?php } ?>
</div>

<?php endif; ?>
