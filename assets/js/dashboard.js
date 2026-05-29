(function () {
	'use strict';

	const $ = (selector, scope = document) => scope.querySelector(selector);
	const $$ = (selector, scope = document) => Array.from(scope.querySelectorAll(selector));

	function drawDashboardCharts() {
		$$('.dashboard-chart').forEach((canvas) => {
			const ctx = canvas.getContext('2d');
			if (!ctx) {
				return;
			}
			let data = {};
			try {
				data = JSON.parse(canvas.dataset.chart || '{}');
			} catch (error) {
				data = {};
			}
			const entries = Object.entries(data);
			if (!entries.length) {
				return;
			}
			const width = canvas.width;
			const height = canvas.height;
			const padding = 34;
			const max = Math.max(...entries.map((entry) => Number(entry[1]) || 0), 1);
			const barWidth = (width - padding * 2) / entries.length - 14;

			ctx.clearRect(0, 0, width, height);
			ctx.fillStyle = getComputedStyle(document.body).getPropertyValue('--color-surface-soft') || '#f6faf7';
			ctx.fillRect(0, 0, width, height);
			ctx.font = '16px system-ui, sans-serif';
			ctx.textAlign = 'center';

			entries.forEach(([label, value], index) => {
				const numeric = Number(value) || 0;
				const x = padding + index * (barWidth + 14) + 10;
				const barHeight = Math.max(10, (numeric / max) * (height - 100));
				const y = height - padding - barHeight;
				ctx.fillStyle = index % 2 ? '#c89b3c' : '#0f7a45';
				ctx.fillRect(x, y, barWidth, barHeight);
				ctx.fillStyle = '#10231a';
				ctx.fillText(String(numeric), x + barWidth / 2, y - 10);
				ctx.fillText(label, x + barWidth / 2, height - 12);
			});
		});
	}

	function initSuratStatusForms() {
		$$('.surat-status-form').forEach((form) => {
			form.addEventListener('submit', async (event) => {
				event.preventDefault();
				if (!window.pacTheme) {
					return;
				}
				const submit = $('button[type="submit"]', form);
				const data = new FormData(form);
				data.append('action', 'pacipnuippnu_update_surat_status');
				data.append('nonce', window.pacTheme.nonce);
				data.append('post_id', form.dataset.postId);
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
					if (window.pacShowToast) {
						window.pacShowToast(json.data.message, 'success');
					}
				} catch (error) {
					if (window.pacShowToast) {
						window.pacShowToast(error.message || window.pacTheme.i18n.error, 'error');
					}
				} finally {
					if (submit) {
						submit.disabled = false;
						submit.textContent = submit.dataset.originalText;
					}
				}
			});
		});
	}

	document.addEventListener('DOMContentLoaded', () => {
		drawDashboardCharts();
		initSuratStatusForms();
	});
})();

