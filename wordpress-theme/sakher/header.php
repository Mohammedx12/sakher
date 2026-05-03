<?php
/**
 * Theme header
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="صخر للضيافة والتموين — نُعيد تعريف الضيافة في بيئة العمل من خلال خدمات تموين منتظمة وباقات قهوة استراحة احترافية للشركات في الرياض.">
<meta name="keywords" content="ضيافة, تموين, قهوة استراحة, شركات, الرياض, صخر">
<meta property="og:title" content="<?php bloginfo( 'name' ); ?>">
<meta property="og:description" content="تجربة ضيافة راقية للشركات — تموين منتظم + قهوة استراحة بثلاث فئات.">
<meta property="og:type" content="website">
<meta property="og:locale" content="ar_SA">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a href="#main" class="skip-link">انتقل إلى المحتوى</a>

<header class="header">
  <div class="header-inner">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
      <?php if ( has_custom_logo() ) : ?>
        <?php the_custom_logo(); ?>
      <?php else : ?>
        <div class="logo-mark"></div>
        <div class="logo-text">
          صخر
          <small>للضيافة والتموين</small>
        </div>
      <?php endif; ?>
    </a>

    <nav class="nav" aria-label="<?php esc_attr_e( 'Primary', 'sakher' ); ?>">
      <?php if ( has_nav_menu( 'primary' ) ) : ?>
        <?php wp_nav_menu( [
          'theme_location' => 'primary',
          'container'      => false,
          'items_wrap'     => '%3$s',
          'fallback_cb'    => false,
        ] ); ?>
      <?php else : ?>
        <a href="#services">الخدمات</a>
        <a href="#tiers">قهوة الاستراحة</a>
        <a href="#pricing">الأسعار</a>
        <a href="#how">كيف نعمل</a>
        <a href="#partners">عملاؤنا</a>
        <a href="#contact">تواصل</a>
      <?php endif; ?>
    </nav>

    <a href="<?php echo esc_url( sakher_whatsapp_url() ); ?>" class="btn btn-primary header-cta">
      اطلب الآن
      <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
    </a>

    <button class="menu-toggle" aria-label="القائمة" aria-expanded="false">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
    </button>
  </div>
</header>
