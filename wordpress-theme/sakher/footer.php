<?php
/**
 * Theme footer
 */
$wa = sakher_whatsapp_url();
$tel = '0535563801';
$email = 'sakher@tamr.com.co';
?>
<footer class="footer">
  <div class="container">
    <div class="footer-grid">
      <div class="footer-about">
        <div class="logo" style="margin-bottom:18px">
          <div class="logo-mark"></div>
          <div class="logo-text" style="color:var(--cream)">
            صخر
            <small style="color:var(--tan-light)">للضيافة والتموين</small>
          </div>
        </div>
        <p>نُعيد تعريف مفهوم الضيافة في بيئة العمل من خلال كوادر مؤهلة وخدمات تضمن رفاهية فريقك وتعكس انطباعاً راقياً لضيوفك.</p>
        <div class="social">
          <a href="#" aria-label="X / Twitter"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
          <a href="#" aria-label="Instagram"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg></a>
          <a href="#" aria-label="LinkedIn"><svg fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
        </div>
      </div>
      <div>
        <h5>روابط سريعة</h5>
        <ul>
          <li><a href="#services">خدماتنا</a></li>
          <li><a href="#tiers">قهوة الاستراحة</a></li>
          <li><a href="#pricing">الأسعار</a></li>
          <li><a href="#how">كيف نعمل</a></li>
          <li><a href="#partners">عملاؤنا</a></li>
        </ul>
      </div>
      <div>
        <h5>الخدمات</h5>
        <ul>
          <li><a href="#">تموين المكاتب</a></li>
          <li><a href="#">قهوة الاستراحة</a></li>
          <li><a href="#">المستلزمات المكتبية</a></li>
          <li><a href="#">أدوات النظافة</a></li>
          <li><a href="#">المشروبات والأغذية</a></li>
        </ul>
      </div>
      <div>
        <h5>تواصل معنا</h5>
        <ul class="footer-contact">
          <li>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.95.68l1.5 4.5a1 1 0 01-.5 1.21l-2.26 1.13a11.04 11.04 0 005.5 5.5l1.13-2.26a1 1 0 011.21-.5l4.5 1.5a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.72 21 3 14.28 3 6V5z"/></svg>
            <a href="tel:<?php echo esc_attr( $tel ); ?>"><?php echo esc_html( $tel ); ?></a>
          </li>
          <li>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            <a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a>
          </li>
          <li>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a2 2 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0zM15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>الرياض، المملكة العربية السعودية</span>
          </li>
          <li>
            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>الأحد - الخميس: 7 صباحاً - 4 مساءً</span>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <div>© <?php echo esc_html( date_i18n( 'Y' ) ); ?> صخر للضيافة والتموين. جميع الحقوق محفوظة.</div>
      <div style="display:flex;gap:20px">
        <a href="#">سياسة الخصوصية</a>
        <a href="#">الشروط والأحكام</a>
      </div>
    </div>
  </div>
</footer>

<!-- ============== Lead Modal ============== -->
<div class="modal-overlay" id="leadModal" role="dialog" aria-labelledby="leadTitle" aria-modal="true">
  <div class="modal">
    <button class="modal-close" id="leadClose" aria-label="إغلاق">
      <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <h3 id="leadTitle">اطلب عرض ضيافة مخصص</h3>
    <p class="modal-sub">عبّي البيانات وبيتواصل معك أحد ممثلينا خلال ساعات العمل.</p>

    <div class="form-success" id="leadSuccess">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" style="vertical-align:-3px;margin-left:6px"><polyline points="20 6 9 17 4 12"/></svg>
      شكراً لتواصلك! استلمنا طلبك وبنتواصل معك قريباً.
    </div>

    <form id="leadForm" novalidate>
      <div class="form-row">
        <div class="form-group">
          <label for="leadName">الاسم *</label>
          <input type="text" id="leadName" name="name" required minlength="2" autocomplete="name">
        </div>
        <div class="form-group">
          <label for="leadPhone">رقم الجوال *</label>
          <input type="tel" id="leadPhone" name="phone" required pattern="^[0-9+\s]{8,15}$" autocomplete="tel" inputmode="tel" placeholder="05XXXXXXXX">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="leadCompany">اسم الشركة</label>
          <input type="text" id="leadCompany" name="company" autocomplete="organization">
        </div>
        <div class="form-group">
          <label for="leadEmail">البريد الإلكتروني</label>
          <input type="email" id="leadEmail" name="email" autocomplete="email">
        </div>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label for="leadService">نوع الخدمة *</label>
          <select id="leadService" name="service" required>
            <option value="">— اختر —</option>
            <option value="catering">تموين منتظم</option>
            <option value="coffee_break">قهوة استراحة</option>
            <option value="both">الاثنان معاً</option>
          </select>
        </div>
        <div class="form-group">
          <label for="leadTier">الباقة (اختياري)</label>
          <select id="leadTier" name="tier">
            <option value="">— غير محدد —</option>
            <option value="bronze">برونزية (85﷼)</option>
            <option value="silver">فضية (125﷼)</option>
            <option value="gold">ذهبية (155﷼)</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label for="leadPeople">عدد الأشخاص (للقهوة)</label>
        <input type="number" id="leadPeople" name="people" min="30" placeholder="الحد الأدنى 30">
      </div>
      <div class="form-group">
        <label for="leadNotes">ملاحظات إضافية</label>
        <textarea id="leadNotes" name="notes" maxlength="500"></textarea>
      </div>
      <div class="form-error" id="leadError" role="alert" aria-live="polite"></div>
      <button type="submit" class="btn btn-primary btn-submit" id="leadSubmit">
        <span>إرسال الطلب</span>
      </button>
    </form>
  </div>
</div>

<!-- Floating WhatsApp -->
<a href="<?php echo esc_url( $wa ); ?>" class="fab-wa" aria-label="تواصل عبر واتساب">
  <svg fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163a11.867 11.867 0 01-1.587-5.946C.16 5.335 5.495 0 12.05 0a11.817 11.817 0 018.413 3.488 11.824 11.824 0 013.48 8.414c-.003 6.557-5.338 11.892-11.893 11.892a11.9 11.9 0 01-5.688-1.448L.057 24zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884a9.86 9.86 0 001.51 5.26l-.999 3.648 3.978-1.607zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
</a>

<?php wp_footer(); ?>
</body>
</html>
