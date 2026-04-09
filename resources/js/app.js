import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
	const root = document.documentElement;
	const themeToggle = document.getElementById('theme-toggle');
	const themeToggleIcon = document.getElementById('theme-toggle-icon');
	const themeToggleLabel = document.getElementById('theme-toggle-label');

	const applyTheme = (theme) => {
		if (theme === 'dark') {
			root.classList.add('dark');
			if (themeToggleIcon) {
				themeToggleIcon.textContent = '☀️';
			}
			if (themeToggleLabel) {
				themeToggleLabel.textContent = 'Jasny';
			}
			return;
		}

		root.classList.remove('dark');
		if (themeToggleIcon) {
			themeToggleIcon.textContent = '🌙';
		}
		if (themeToggleLabel) {
			themeToggleLabel.textContent = 'Ciemny';
		}
	};

	const savedTheme = localStorage.getItem('theme');
	if (savedTheme === 'dark' || savedTheme === 'light') {
		applyTheme(savedTheme);
	} else {
		applyTheme(root.classList.contains('dark') ? 'dark' : 'light');
	}

	if (themeToggle) {
		themeToggle.addEventListener('click', () => {
			const nextTheme = root.classList.contains('dark') ? 'light' : 'dark';
			localStorage.setItem('theme', nextTheme);
			applyTheme(nextTheme);
		});
	}

	const duckButton = document.getElementById('duck-button');
	const bubble = document.getElementById('duck-joke-bubble');
	const text = document.getElementById('duck-joke-text');

	if (!duckButton || !bubble || !text) {
		return;
	}

	const jokes = [
		'helloWorld("print"); // nailed it',
		'Works on my machine is a deployment strategy.',
		'I fixed one bug and discovered a feature.',
		'There is no place like 127.0.0.1',
		'if (codeWorks) { dontTouch(); }',
		'printf("U mnie dziala\\n")',
		'const luck = Math.random() * 0;',
	];

	let lastIndex = -1;

	duckButton.addEventListener('click', () => {
		let nextIndex = Math.floor(Math.random() * jokes.length);

		while (nextIndex === lastIndex && jokes.length > 1) {
			nextIndex = Math.floor(Math.random() * jokes.length);
		}

		lastIndex = nextIndex;
		text.textContent = jokes[nextIndex];
		bubble.classList.remove('hidden');
	});
});
