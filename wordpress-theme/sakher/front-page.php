<?php
/**
 * Sakher — Front Page
 * Renders all marketing sections: hero, trust bar, services, why,
 * tier packages, pricing, how it works, partners, CTA banner.
 */
$wa = sakher_whatsapp_url();
get_header();
?>

<!-- ============== Hero ============== -->
<section class="hero" id="main">
  <div class="container">
    <div class="hero-grid">
      <div class="hero-content reveal">
        <span class="section-eyebrow">ضيافة الشركات في الرياض</span>
        <h1 class="hero-title">
          نُعيد تعريف <span class="accent">الضيافة</span><br>
          في بيئة العمل
        </h1>
        <p class="hero-desc">
          تجربة راقية تعكس هوية مكانك وتميزه — تموين منتظم لاحتياجات شركتك،
          وباقات ضيافة احترافية تجعل من كل اجتماع لحظة لا تُنسى.
        </p>
        <div class="hero-cta">
          <a href="<?php echo esc_url( $wa ); ?>" class="btn btn-primary">
            اطلب خدمة التموين
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg>
          </a>
          <a href="#tiers" class="btn btn-ghost">استكشف قهوة الاستراحة</a>
        </div>
        <div class="hero-stats">
          <div><div class="stat-num">+400</div><div class="stat-label">منتج متاح</div></div>
          <div><div class="stat-num">+50</div><div class="stat-label">شركة تثق بنا</div></div>
          <div><div class="stat-num">25%</div><div class="stat-label">أقل من السوق</div></div>
          <div><div class="stat-num">9h</div><div class="stat-label">خدمة يومية</div></div>
        </div>
      </div>
      <div class="hero-visual reveal">
        <div class="logo-art" id="logoArt" role="button" tabindex="0" aria-label="شعار صخر — مرّر فوقه لاكتشاف منتجاتنا">
          <div class="lp lp-2" aria-hidden="true"></div>
          <div class="lp lp-1" aria-hidden="true"></div>
          <div class="lp lp-5" aria-hidden="true"></div>
          <div class="lp lp-6" aria-hidden="true"></div>
          <div class="lp lp-3" aria-hidden="true"></div>
          <div class="lp lp-4" aria-hidden="true"></div>
          <div class="lp lp-7" aria-hidden="true"></div>
          <span class="reveal-hint" aria-hidden="true">
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            مرّر لاكتشاف منتجاتنا
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============== Trust Bar (marquee) ============== -->
<div class="trust-bar" aria-label="عملاؤنا">
  <div class="container trust-inner">
    <span class="trust-label">يثق بنا</span>
    <div class="trust-marquee">
      <div class="trust-track" id="trustTrack">
        <?php
        $trust_logos = [ 'Nespresso', 'Subway', "Dunkin'", 'Juice Time', 'دوار السعادة', 'TAMR', 'حكيمة', 'Edison', 'Repository' ];
        // Print twice for seamless loop
        for ( $i = 0; $i < 2; $i++ ) {
          $hide = $i === 1 ? ' aria-hidden="true"' : '';
          foreach ( $trust_logos as $l ) {
            printf( '<span class="trust-logo"%s>%s</span>', $hide, esc_html( $l ) );
          }
        }
        ?>
      </div>
    </div>
  </div>
</div>

<!-- ============== Services ============== -->
<section class="services" id="services">
  <div class="container">
    <div class="services-head reveal">
      <div>
        <span class="section-eyebrow">خدماتنا</span>
        <h2 class="section-title">مساران رئيسيان لخدمتك</h2>
      </div>
      <p class="section-sub">نهتم بتعبئة كامل احتياجات المكاتب بشكل دوري ومتكامل، ونصمّم تجارب ضيافة تترك أثراً.</p>
    </div>
    <div class="services-grid">
      <div class="service-card service-1 reveal">
        <div class="service-img"><span class="service-tag">المسار الأول</span></div>
        <div class="service-body">
          <h3>خدمات التموين</h3>
          <p>تموين احتياجات المكاتب والشركات بشكل دوري — أغذية، أدوات نظافة، ومستلزمات مكتبية. فريقنا يحسب معدلات استهلاك منشأتك للتأكد من توفير المنتجات حسب الاحتياج الفعلي.</p>
          <ul class="service-features">
            <li>+400 منتج متاح للاختيار</li>
            <li>أسعار أقل من متوسط السوق بـ 25%</li>
            <li>إدارة الطلبات تلقائياً</li>
            <li>توصيل دوري ومنتظم</li>
          </ul>
          <a href="#contact" class="service-cta">اعرف أكثر <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg></a>
        </div>
      </div>
      <div class="service-card service-2 reveal">
        <div class="service-img"><span class="service-tag">المسار الثاني</span></div>
        <div class="service-body">
          <h3>قهوة الاستراحة</h3>
          <p>تجربة كوفي بريك مصممة بعناية لتمنح فريق العمل لحظات من الانتعاش والتركيز بين الاجتماعات — استراحة قصيرة تُجدد الطاقة وتُعزز الإنتاجية.</p>
          <ul class="service-features">
            <li>3 فئات: برونزية، فضية، ذهبية</li>
            <li>ساندويتش، معجنات، فواكه طازجة</li>
            <li>قهوة، مشروبات ساخنة وباردة</li>
            <li>الحد الأدنى 30 شخص للباقة</li>
          </ul>
          <a href="#tiers" class="service-cta">اعرض الباقات <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M11 17l-5-5m0 0l5-5m-5 5h12"/></svg></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============== Why Sakher ============== -->
<section class="why">
  <div class="container">
    <div style="text-align:center" class="reveal">
      <span class="section-eyebrow">لماذا صخر</span>
      <h2 class="section-title">أربعة أسباب تجعلنا الخيار الأمثل</h2>
      <p class="section-sub" style="margin:14px auto 0">نقل مسؤولية الضيافة والتموين لمختصين بأفضل الأسعار وأعلى جودة.</p>
    </div>
    <div class="why-grid">
      <?php
      $why_cards = [
        [ 'h' => 'توفير الوقت', 'p' => 'نساعد موظفيكم على توفير المال والوقت الضائع في الحصول على الاحتياجات والاغذية.', 'icon' => '<circle cx="12" cy="12" r="10"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l4 2"/>' ],
        [ 'h' => 'جودة واحترافية', 'p' => 'التزام عالٍ بالجودة والعمل كشركاء معكم — لا كمجرد موردين.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>' ],
        [ 'h' => 'تخفيف الأعباء', 'p' => 'نقل مسؤولية الضيافة والتموين لمختصين، بأفضل الأسعار وتقليل أخطاء الخدمة.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>' ],
        [ 'h' => 'رفاهية الفريق', 'p' => 'نخلق بيئة عمل مريحة تدعم رضا الموظفين وتحفزهم على الأداء الأفضل.', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>' ],
      ];
      foreach ( $why_cards as $c ): ?>
        <div class="why-card reveal">
          <div class="why-icon"><svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><?php echo $c['icon']; ?></svg></div>
          <h4><?php echo esc_html( $c['h'] ); ?></h4>
          <p><?php echo esc_html( $c['p'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============== Coffee Break Tiers ============== -->
<section class="tiers" id="tiers">
  <div class="container">
    <div class="tiers-head reveal">
      <span class="section-eyebrow">قهوة الاستراحة</span>
      <h2 class="section-title">ثلاث فئات تناسب احتياجاتك</h2>
      <p class="section-sub">اختر الباقة التي تليق بفريقك أو ضيوفك. الحد الأدنى 30 شخصاً لكل باقة.</p>
    </div>
    <div class="tiers-grid">
      <?php
      $tiers = [
        [ 'class' => 'tier-bronze', 'name' => 'FÆ بـرونـزيـة', 'title' => 'الفئة البرونزية', 'price' => 85, 'badge' => '', 'cta' => 'اطلب البرونزية',
          'features' => [
            'ميني ساندويتش (لبنة، تونة، تيركي)',
            'ميني كلوب ساندويتش',
            'دجاج مسخن رول + لحم مفروم بخبز البيتا',
            'كروسان جبن، سينامون، بنانا كيك، ميني أوبرا',
            'فواكه طازجة في كاسات صغار',
            'قهوة أمريكانو، شاي متنوع، مياه',
          ],
        ],
        [ 'class' => 'tier-silver', 'name' => 'FÆ فــضـيــة', 'title' => 'الفئة الفضية', 'price' => 125, 'badge' => '', 'cta' => 'اطلب الفضية',
          'features' => [
            'كل عناصر الفئة البرونزية',
            'ميني شاورما تركية + سبرينق رول خضار',
            'ساندوتش الجبن المشوي بالزعتر',
            'مافن (شوكلت، فانيلا)',
            'عصير برتقال طازج + جهاز قهوة (كابتشينو ولاتيه)',
            'مشروب سعودي شامبين + مياه زجاجية',
          ],
        ],
        [ 'class' => 'tier-gold tier-popular', 'name' => 'FÆ ذهـبـيــة', 'title' => 'الفئة الذهبية', 'price' => 155, 'badge' => 'الأكثر طلباً', 'cta' => 'اطلب الذهبية',
          'features' => [
            'كروك مدام الفرنسي + ميلانو مكسيكي',
            'لفائف حلومي بيستو وطماطم مجففة',
            'ميني بيتزا زيتون نباتية + ميني شاورما',
            'كاسترد دانيش، ريد فلفت سويس رول، ماربل كيك',
            'ميني دونات + كوكيز الفانيليا + شوفان التفاح',
            'أعواد فواكه + عصير بطيخ + عصير تفاح وجزر',
          ],
        ],
      ];
      foreach ( $tiers as $t ): ?>
        <div class="tier <?php echo esc_attr( $t['class'] ); ?> reveal">
          <?php if ( $t['badge'] ): ?><div class="tier-badge"><?php echo esc_html( $t['badge'] ); ?></div><?php endif; ?>
          <div class="tier-name"><?php echo esc_html( $t['name'] ); ?></div>
          <h3 class="tier-title"><?php echo esc_html( $t['title'] ); ?></h3>
          <div class="tier-price"><span class="num"><?php echo (int) $t['price']; ?></span><span class="unit">ريال / شخص</span></div>
          <div class="tier-meta">شامل الضريبة • الحد الأدنى 30 شخصاً</div>
          <ul class="tier-list">
            <?php foreach ( $t['features'] as $f ): ?>
              <li><svg fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg> <?php echo esc_html( $f ); ?></li>
            <?php endforeach; ?>
          </ul>
          <a href="<?php echo esc_url( $wa ); ?>" class="tier-cta"><?php echo esc_html( $t['cta'] ); ?></a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============== Pricing Comparison ============== -->
<section class="pricing" id="pricing">
  <div class="container">
    <div class="pricing-grid">
      <div class="reveal">
        <span class="section-eyebrow">شفافية الأسعار</span>
        <h2 class="section-title">أسعار أقل من السوق<br>بشكل ملحوظ</h2>
        <p class="section-sub" style="margin-bottom:24px">أسعارنا تشمل التوصيل وإدارة الطلبات بشكل دوري، مع حساب معدل استهلاك منشأتك لتجنب الهدر أو النقص.</p>
        <ul style="list-style:none;display:flex;flex-direction:column;gap:14px;margin-bottom:32px">
          <?php foreach ( [
            [ 'b' => 'توفير حقيقي:',     'r' => 'أقل من متوسط السوق بـ 25-30%' ],
            [ 'b' => 'السعر شامل:',      'r' => 'التوصيل + إدارة الطلبات' ],
            [ 'b' => 'ذكاء الاستهلاك:',  'r' => 'فريقنا يحسب احتياجك الفعلي' ],
          ] as $item ): ?>
            <li style="display:flex;gap:12px;align-items:start">
              <span style="background:var(--wood);color:var(--cream);width:28px;height:28px;border-radius:6px;display:grid;place-items:center;font-weight:700;flex:0 0 28px"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg></span>
              <span style="font-size:15px"><strong><?php echo esc_html( $item['b'] ); ?></strong> <?php echo esc_html( $item['r'] ); ?></span>
            </li>
          <?php endforeach; ?>
        </ul>
        <a href="<?php echo esc_url( $wa ); ?>" class="btn btn-primary">احصل على عرض مخصص</a>
      </div>

      <div class="pricing-table reveal">
        <div class="pricing-table-head">
          <div>المنتج</div>
          <div>سعرنا</div>
          <div>متوسط السوق</div>
        </div>
        <?php
        $prices = [
          [ 'n' => 'نسكافيه كلاسيك',  's' => '190 جرام، الحجم الكبير', 'our' => 24.24, 'mkt' => 35.95, 'save' => 11.71 ],
          [ 'n' => 'مبيض القهوة',     's' => '170 جرام، الحجم الكبير', 'our' => 6.32,  'mkt' => 11.95, 'save' => 5.63 ],
          [ 'n' => 'شاي ليبتون',      's' => 'كرتون 100 كيس',          'our' => 11.55, 'mkt' => 17.81, 'save' => 6.26 ],
          [ 'n' => 'كرتون ماء نوفا',  's' => '330مل، 40 قارورة',       'our' => 18.56, 'mkt' => 24.46, 'save' => 5.90 ],
          [ 'n' => 'قهوة كيف المسافر','s' => 'بطعم الهيل، 10 دلال',    'our' => 48.95, 'mkt' => 55.00, 'save' => 6.05 ],
          [ 'n' => 'سكر أظرف أندرينا','s' => 'كرتون 100 ظرف',          'our' => 6.16,  'mkt' => 10.96, 'save' => 4.80 ],
        ];
        foreach ( $prices as $p ): ?>
          <div class="pricing-row">
            <div class="pricing-name"><?php echo esc_html( $p['n'] ); ?><small><?php echo esc_html( $p['s'] ); ?></small></div>
            <div class="pricing-our"><?php echo esc_html( number_format( $p['our'], 2 ) ); ?> ﷼<div class="pricing-savings">وفّر <?php echo esc_html( number_format( $p['save'], 2 ) ); ?></div></div>
            <div class="pricing-market"><?php echo esc_html( number_format( $p['mkt'], 2 ) ); ?> ﷼</div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ============== How It Works ============== -->
<section class="how" id="how">
  <div class="container">
    <div style="text-align:center" class="reveal">
      <span class="section-eyebrow">كيف نعمل</span>
      <h2 class="section-title">من الطلب إلى التوصيل في 4 خطوات</h2>
      <p class="section-sub" style="margin:14px auto 0">نموذج عمل مدروس يضمن لك راحة البال واستمرارية الخدمة.</p>
    </div>
    <div class="how-steps">
      <?php foreach ( [
        [ 'h' => 'تواصل معنا',         'p' => 'أرسل احتياجك عبر الواتساب أو اتصل، ونحدد موعداً لمناقشة متطلبات منشأتك.' ],
        [ 'h' => 'تحليل الاستهلاك',     'p' => 'فريقنا يحسب معدل استهلاكك الفعلي ويقترح خطة توريد دورية مخصصة.' ],
        [ 'h' => 'التوقيع والتنفيذ',    'p' => 'اتفاقية شراكة واضحة، وبدء التوريد المنتظم وفق الجدول المتفق عليه.' ],
        [ 'h' => 'المتابعة المستمرة',   'p' => 'مراجعة دورية للأداء والاستهلاك، وتعديل الخطة عند الحاجة.' ],
      ] as $i => $s ): ?>
        <div class="step reveal">
          <div class="step-num"><?php echo $i + 1; ?></div>
          <h4><?php echo esc_html( $s['h'] ); ?></h4>
          <p><?php echo esc_html( $s['p'] ); ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- ============== Partners ============== -->
<section class="partners" id="partners">
  <div class="container">
    <div class="partners-head reveal">
      <span class="section-eyebrow">شركاؤنا</span>
      <h2 class="section-title">أبرز الشركاء في تقديم خدمات التموين</h2>
    </div>
  </div>
  <div class="partners-marquee">
    <div class="partner-track" id="partnerTrack">
      <?php
      $partners = [
        [ 'NESPRESSO',   '' ],
        [ 'SUBWAY',      'صب واي' ],
        [ 'JUICE TIME',  'وقت العصير' ],
        [ "DUNKIN'",     'دانكن' ],
        [ 'دوّار',        'السعادة' ],
        [ 'TAMR',        'تمر' ],
        [ 'حكيمة',       '' ],
        [ 'EDISON',      'Electric' ],
        [ 'REPOSITORY',  'Roasters Hub' ],
      ];
      $render_partners = function() use ( $partners ) {
        foreach ( $partners as $p ) {
          $br = $p[1] ? '<br>' . esc_html( $p[1] ) : '';
          printf( '<div class="partner">%s%s</div>', esc_html( $p[0] ), $br );
        }
        echo '<div class="partner" style="background:var(--wood);color:var(--cream);border-color:var(--wood)">+50<br>عميل</div>';
      };
      // Print twice for seamless marquee loop
      $render_partners();
      $render_partners();
      ?>
    </div>
  </div>
</section>

<!-- ============== CTA Banner ============== -->
<section class="cta-banner" id="contact">
  <div class="container cta-inner">
    <div class="cta-text">
      <h2>جاهز ترفع مستوى الضيافة في مكتبك؟</h2>
      <p>تواصل معنا الحين، وأحد ممثلينا بيرجع لك خلال ساعات العمل.</p>
    </div>
    <div class="cta-actions">
      <a href="<?php echo esc_url( $wa ); ?>" class="btn btn-wa" style="padding:16px 28px;font-size:15px">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.51 5.26l-.999 3.648 3.978-1.607zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
        تواصل عبر واتساب
      </a>
      <a href="tel:0535563801" class="btn btn-primary" style="padding:16px 28px;font-size:15px">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.21l-2.26 1.13a11.04 11.04 0 005.5 5.5l1.13-2.26a1 1 0 011.21-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z"/></svg>
        053 556 3801
      </a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
