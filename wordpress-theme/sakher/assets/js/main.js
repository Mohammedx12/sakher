/**
 * Sakher theme — front-end interactions
 * Reveal-on-scroll, stat counters, lead modal, hero logo composition,
 * mobile nav, scroll-spy.
 */
(function () {
	'use strict';

	// ── REST endpoint provided via wp_localize_script ──
	var API = (typeof sakherTheme !== 'undefined' && sakherTheme.apiUrl)
		? sakherTheme.apiUrl
		: '/wp-json/sakher/v1';
	var WA  = (typeof sakherTheme !== 'undefined' && sakherTheme.whatsapp)
		? sakherTheme.whatsapp
		: '966535563801';

	// ── Reveal on scroll ──
	var io = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) {
			if (e.isIntersecting) {
				e.target.classList.add('in');
				io.unobserve(e.target);
			}
		});
	}, { threshold: 0.12, rootMargin: '0px 0px -60px 0px' });
	document.querySelectorAll('.reveal').forEach(function (el) { io.observe(el); });

	// ── Animate stat numbers ──
	var animateStats = function (el) {
		var text = el.textContent;
		var num  = parseInt(text.replace(/\D/g, ''), 10);
		if (!num) return;
		var prefix = (text.match(/^[+\-]?/) || [''])[0];
		var suffix = (text.match(/[%hKMB]+$/) || [''])[0];
		var current = 0;
		var step = Math.max(1, Math.floor(num / 40));
		var tick = function () {
			current += step;
			if (current >= num) { el.textContent = prefix + num + suffix; return; }
			el.textContent = prefix + current + suffix;
			requestAnimationFrame(tick);
		};
		tick();
	};
	var statObs = new IntersectionObserver(function (entries) {
		entries.forEach(function (e) {
			if (e.isIntersecting) { animateStats(e.target); statObs.unobserve(e.target); }
		});
	}, { threshold: 0.5 });
	document.querySelectorAll('.stat-num').forEach(function (s) { statObs.observe(s); });

	// ── Lead Modal ──
	var modal      = document.getElementById('leadModal');
	var modalClose = document.getElementById('leadClose');
	var leadForm   = document.getElementById('leadForm');
	var leadError  = document.getElementById('leadError');
	var leadSucc   = document.getElementById('leadSuccess');
	var leadSubmit = document.getElementById('leadSubmit');

	if (modal && leadForm) {
		var openModal = function (preset) {
			preset = preset || {};
			if (preset.tier)    document.getElementById('leadTier').value    = preset.tier;
			if (preset.service) document.getElementById('leadService').value = preset.service;
			modal.classList.add('open');
			document.body.style.overflow = 'hidden';
			setTimeout(function () { document.getElementById('leadName').focus(); }, 100);
		};
		var closeModal = function () {
			modal.classList.remove('open');
			document.body.style.overflow = '';
			leadError.textContent = '';
		};

		modalClose.addEventListener('click', closeModal);
		modal.addEventListener('click', function (e) { if (e.target === modal) closeModal(); });
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && modal.classList.contains('open')) closeModal();
		});

		// Wire CTAs that should open the modal
		document.querySelectorAll('[data-lead]').forEach(function (el) {
			el.addEventListener('click', function (e) {
				e.preventDefault();
				openModal({ tier: el.dataset.tier || '', service: el.dataset.service || '' });
			});
		});

		document.querySelectorAll('.tier-cta').forEach(function (el) {
			el.addEventListener('click', function (e) {
				e.preventDefault();
				var tierEl = el.closest('.tier');
				var tier = '';
				if (tierEl && tierEl.classList.contains('tier-bronze')) tier = 'bronze';
				else if (tierEl && tierEl.classList.contains('tier-silver')) tier = 'silver';
				else if (tierEl && tierEl.classList.contains('tier-gold')) tier = 'gold';
				openModal({ tier: tier, service: 'coffee_break' });
			});
		});

		document.querySelectorAll('a.btn.btn-primary').forEach(function (el) {
			var txt = (el.textContent || '').trim();
			if (txt.indexOf('اطلب') === 0 || txt.indexOf('احصل على عرض') === 0) {
				el.addEventListener('click', function (e) {
					e.preventDefault();
					var service = txt.indexOf('التموين') !== -1 ? 'catering' : '';
					openModal({ service: service });
				});
			}
		});

		// Form submit → POST /wp-json/sakher/v1/leads
		leadForm.addEventListener('submit', function (e) {
			e.preventDefault();
			leadError.textContent = '';

			var data = {};
			new FormData(leadForm).forEach(function (v, k) { data[k] = v; });

			if (!data.name || data.name.length < 2) { leadError.textContent = 'الرجاء إدخال الاسم'; return; }
			if (!/^[0-9+\s]{8,15}$/.test(data.phone || '')) { leadError.textContent = 'رقم الجوال غير صحيح'; return; }
			if (!data.service) { leadError.textContent = 'الرجاء اختيار نوع الخدمة'; return; }

			leadSubmit.disabled = true;
			leadSubmit.querySelector('span').textContent = 'جاري الإرسال...';

			var headers = { 'Content-Type': 'application/json' };
			if (typeof sakherTheme !== 'undefined' && sakherTheme.nonce) {
				headers['X-WP-Nonce'] = sakherTheme.nonce;
			}

			fetch(API + '/leads', {
				method: 'POST',
				headers: headers,
				body: JSON.stringify(data)
			}).then(function (res) {
				if (!res.ok) throw new Error('server');
				return res.json();
			}).then(function () {
				leadSucc.classList.add('show');
				leadForm.reset();
				setTimeout(function () { closeModal(); leadSucc.classList.remove('show'); }, 2500);
			}).catch(function () {
				leadError.innerHTML = 'تعذر الإرسال. <a href="https://wa.me/' + WA + '" style="color:var(--wood);text-decoration:underline">تواصل واتساب مباشرة</a>';
			}).finally(function () {
				leadSubmit.disabled = false;
				leadSubmit.querySelector('span').textContent = 'إرسال الطلب';
			});
		});

		// Focus return to opener after closing
		var lastTrigger = null;
		document.addEventListener('click', function (e) {
			if (e.target.closest('[data-lead], .tier-cta, a.btn.btn-primary')) lastTrigger = e.target;
		});
		var origClose = closeModal;
		window.closeLeadModal = function () { origClose(); if (lastTrigger && lastTrigger.focus) lastTrigger.focus(); };
	}

	// ── Mobile menu toggle ──
	var menuBtn = document.querySelector('.menu-toggle');
	var navEl   = document.querySelector('.nav');
	if (menuBtn && navEl) {
		menuBtn.addEventListener('click', function () {
			var open = navEl.classList.toggle('is-open');
			menuBtn.setAttribute('aria-expanded', String(open));
		});
	}

	// ── Scroll-spy ──
	var navLinks = document.querySelectorAll('.nav a[href^="#"]');
	var sections = [];
	navLinks.forEach(function (a) {
		var s = document.querySelector(a.getAttribute('href'));
		if (s) sections.push(s);
	});
	if (sections.length) {
		var spy = new IntersectionObserver(function (entries) {
			entries.forEach(function (e) {
				if (e.isIntersecting) {
					var id = e.target.id;
					navLinks.forEach(function (a) {
						a.classList.toggle('is-active', a.getAttribute('href') === '#' + id);
					});
				}
			});
		}, { rootMargin: '-40% 0px -55% 0px' });
		sections.forEach(function (s) { spy.observe(s); });
	}

	// ── Logo art (hover/tap reveals product photos) ──
	var logoArt = document.getElementById('logoArt');
	if (logoArt) {
		var toggle = function () { logoArt.classList.toggle('is-revealed'); };
		logoArt.addEventListener('click', toggle);
		logoArt.addEventListener('keydown', function (e) {
			if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); toggle(); }
		});
		if (matchMedia('(hover: none)').matches) {
			var on = false;
			setInterval(function () { on = !on; logoArt.classList.toggle('is-revealed', on); }, 3500);
		}
	}
})();
