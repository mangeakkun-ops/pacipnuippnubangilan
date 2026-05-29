(function () {
	'use strict';

	const $ = (selector, scope = document) => scope.querySelector(selector);
	const $$ = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

	function showToast(message, type = 'success') {
		const stack = $('[data-toast-stack]');
		if (!stack || !message) {
			return;
		}
		const toast = document.createElement('div');
		toast.className = `toast toast--${type}`;
		toast.textContent = message;
		stack.appendChild(toast);
		window.setTimeout(() => {
			toast.style.opacity = '0';
			toast.style.transform = 'translateY(8px)';
			window.setTimeout(() => toast.remove(), 260);
		}, 4200);
	}

	function initLoader() {
		const loader = $('[data-loader]');
		if (!loader) {
			return;
		}
		window.addEventListener('load', () => {
			loader.classList.add('is-hidden');
		});
		window.setTimeout(() => loader.classList.add('is-hidden'), 1400);
	}

	function initMobileMenu() {
		const toggle = $('[data-menu-toggle]');
		const panel = $('[data-nav-panel]');
		if (!toggle || !panel) {
			return;
		}
		toggle.addEventListener('click', () => {
			const open = panel.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
		$$('.primary-menu a', panel).forEach((link) => {
			link.addEventListener('click', () => {
				panel.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
			});
		});
	}

	function initSearchModal() {
		const modal = $('[data-search-modal]');
		const openers = $$('[data-search-open]');
		const closers = $$('[data-search-close]');
		if (!modal || !openers.length) {
			return;
		}
		const input = $('#global-search-field', modal);
		const open = () => {
			modal.hidden = false;
			document.body.style.overflow = 'hidden';
			window.setTimeout(() => input && input.focus(), 60);
		};
		const close = () => {
			modal.hidden = true;
			document.body.style.overflow = '';
		};
		openers.forEach((button) => button.addEventListener('click', open));
		closers.forEach((button) => button.addEventListener('click', close));
		document.addEventListener('keydown', (event) => {
			if (event.key === 'Escape' && !modal.hidden) {
				close();
			}
		});
	}

	function getSavedThemeMode() {
		try {
			return window.localStorage.getItem('pac-theme-mode');
		} catch (error) {
			return null;
		}
	}

	function saveThemeMode(mode) {
		try {
			window.localStorage.setItem('pac-theme-mode', mode);
		} catch (error) {
			// Storage can be unavailable in private browsing or restricted embeds.
		}
	}

	function initDarkMode() {
		const buttons = $$('[data-theme-toggle]');
		const saved = getSavedThemeMode();
		if (saved === 'dark') {
			document.body.classList.add('dark-mode');
		}
		buttons.forEach((button) => {
			button.addEventListener('click', () => {
				document.body.classList.toggle('dark-mode');
				saveThemeMode(document.body.classList.contains('dark-mode') ? 'dark' : 'light');
			});
		});
	}

	function initHeroSlider() {
		const slider = $('[data-hero-slider]');
		if (!slider) {
			return;
		}
		const slides = $$('.hero-slide', slider);
		const dotsWrap = $('[data-hero-dots]', slider);
		const prev = $('[data-hero-prev]', slider);
		const next = $('[data-hero-next]', slider);
		let active = 0;
		let timer = null;

		if (slides.length <= 1) {
			return;
		}

		const dots = dotsWrap ? slides.map((_, index) => {
			const dot = document.createElement('button');
			dot.type = 'button';
			dot.setAttribute('aria-label', `Slide ${index + 1}`);
			dot.addEventListener('click', () => goTo(index));
			dotsWrap.appendChild(dot);
			return dot;
		}) : [];

		function render() {
			slides.forEach((slide, index) => slide.classList.toggle('is-active', index === active));
			dots.forEach((dot, index) => dot.classList.toggle('is-active', index === active));
		}

		function goTo(index) {
			active = (index + slides.length) % slides.length;
			render();
			restart();
		}

		function restart() {
			window.clearInterval(timer);
			timer = window.setInterval(() => goTo(active + 1), 6500);
		}

		prev && prev.addEventListener('click', () => goTo(active - 1));
		next && next.addEventListener('click', () => goTo(active + 1));
		render();
		restart();
	}

	function initTestimonialSlider() {
		const slider = $('[data-testimonial-slider]');
		if (!slider) {
			return;
		}
		const slides = $$('.testimonial-slide', slider);
		if (slides.length <= 1) {
			return;
		}
		let active = 0;
		window.setInterval(() => {
			active = (active + 1) % slides.length;
			slides.forEach((slide, index) => slide.classList.toggle('is-active', index === active));
		}, 5200);
	}

	function initReveal() {
		const items = $$('.reveal');
		if (!items.length) {
			return;
		}
		if (!('IntersectionObserver' in window)) {
			items.forEach((item) => item.classList.add('is-visible'));
			return;
		}
		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				}
			});
		}, { threshold: 0.14 });
		items.forEach((item) => observer.observe(item));
	}

	function initCounters() {
		const counters = $$('[data-counter]');
		if (!counters.length) {
			return;
		}
		const run = (item) => {
			const target = Number(item.dataset.counter || 0);
			const duration = 1100;
			const start = performance.now();
			const tick = (now) => {
				const progress = Math.min((now - start) / duration, 1);
				item.textContent = Math.floor(progress * target).toLocaleString('id-ID');
				if (progress < 1) {
					requestAnimationFrame(tick);
				}
			};
			requestAnimationFrame(tick);
		};
		if (!('IntersectionObserver' in window)) {
			counters.forEach(run);
			return;
		}
		const observer = new IntersectionObserver((entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					run(entry.target);
					observer.unobserve(entry.target);
				}
			});
		});
		counters.forEach((counter) => observer.observe(counter));
	}

	function initTabs() {
		$$('[data-tabs]').forEach((tabs) => {
			const buttons = $$('[data-tab]', tabs);
			const panels = $$('[data-tab-panel]', tabs);
			buttons.forEach((button) => {
				button.addEventListener('click', () => {
					const key = button.dataset.tab;
					buttons.forEach((item) => item.classList.toggle('is-active', item === button));
					panels.forEach((panel) => panel.classList.toggle('is-active', panel.dataset.tabPanel === key));
				});
			});
		});
	}

	function initAjaxForms() {
		$$('.ajax-form').forEach((form) => {
			form.addEventListener('submit', async (event) => {
				event.preventDefault();
				const action = form.dataset.action;
				const submit = $('button[type="submit"]', form);
				if (!action || !window.pacTheme) {
					return;
				}
				const data = new FormData(form);
				data.append('action', action);
				data.append('nonce', window.pacTheme.nonce);
				if (submit) {
					submit.disabled = true;
					submit.dataset.originalText = submit.textContent;
					submit.textContent = window.pacTheme.i18n.loading;
				}
				try {
					const response = await fetch(window.pacTheme.ajaxUrl, {
						method: 'POST',
						credentials: 'same-origin',
						body: data
					});
					const json = await response.json();
					if (!json.success) {
						throw new Error(json.data && json.data.message ? json.data.message : window.pacTheme.i18n.error);
					}
					showToast(json.data.message || window.pacTheme.i18n.success, 'success');
					if (action === 'pacipnuippnu_request_surat' || action === 'pacipnuippnu_contact') {
						form.reset();
					}
				} catch (error) {
					showToast(error.message || window.pacTheme.i18n.error, 'error');
				} finally {
					if (submit) {
						submit.disabled = false;
						submit.textContent = submit.dataset.originalText;
					}
				}
			});
		});
	}

	function initGallery() {
		$$('[data-lightbox]').forEach((link) => {
			link.addEventListener('click', (event) => {
				event.preventDefault();
				const overlay = document.createElement('div');
				const closeButton = document.createElement('button');
				const image = document.createElement('img');
				overlay.className = 'lightbox';
				closeButton.type = 'button';
				closeButton.setAttribute('aria-label', 'Tutup');
				closeButton.textContent = '×';
				image.src = link.href;
				image.alt = '';
				overlay.append(closeButton, image);
				document.body.appendChild(overlay);
				document.body.style.overflow = 'hidden';
				const close = () => {
					overlay.remove();
					document.body.style.overflow = '';
				};
				overlay.addEventListener('click', (clickEvent) => {
					if (clickEvent.target === overlay || clickEvent.target.tagName === 'BUTTON') {
						close();
					}
				});
				document.addEventListener('keydown', function esc(eventKey) {
					if (eventKey.key === 'Escape') {
						close();
						document.removeEventListener('keydown', esc);
					}
				});
			});
		});

		const filters = $('[data-gallery-filter]');
		if (!filters) {
			return;
		}
		$$('button', filters).forEach((button) => {
			button.addEventListener('click', () => {
				const filter = button.dataset.filter;
				$$('button', filters).forEach((item) => item.classList.toggle('is-active', item === button));
				$$('[data-category]').forEach((tile) => {
					const categories = tile.dataset.category || '';
					tile.hidden = filter !== 'all' && !categories.includes(filter);
				});
			});
		});
	}

	function initCountdowns() {
		$$('[data-countdown]').forEach((card) => {
			const target = new Date(card.dataset.countdown.replace(' ', 'T')).getTime();
			const output = $('.countdown-values', card);
			if (!target || !output) {
				return;
			}
			const render = () => {
				const diff = target - Date.now();
				if (diff <= 0) {
					output.innerHTML = '<span>Dimulai</span>';
					return;
				}
				const days = Math.floor(diff / 86400000);
				const hours = Math.floor((diff % 86400000) / 3600000);
				const minutes = Math.floor((diff % 3600000) / 60000);
				output.innerHTML = `<span>${days}<small>Hari</small></span><span>${hours}<small>Jam</small></span><span>${minutes}<small>Menit</small></span>`;
			};
			render();
			window.setInterval(render, 60000);
		});
	}

	function initScrollTop() {
		const button = $('[data-scroll-top]');
		if (!button) {
			return;
		}
		window.addEventListener('scroll', () => {
			button.classList.toggle('is-visible', window.scrollY > 600);
		}, { passive: true });
		button.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
	}

	function initPartnerTrack() {
		const track = $('[data-partner-track]');
		if (!track || window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
			return;
		}
		let scrollAmount = 0;
		window.setInterval(() => {
			scrollAmount += 1;
			if (scrollAmount >= track.scrollWidth - track.clientWidth) {
				scrollAmount = 0;
			}
			track.scrollTo({ left: scrollAmount, behavior: 'smooth' });
		}, 80);
	}

	document.addEventListener('DOMContentLoaded', () => {
		initLoader();
		initMobileMenu();
		initSearchModal();
		initDarkMode();
		initHeroSlider();
		initTestimonialSlider();
		initReveal();
		initCounters();
		initTabs();
		initAjaxForms();
		initGallery();
		initCountdowns();
		initScrollTop();
		initPartnerTrack();
	});

	window.pacShowToast = showToast;
})();

