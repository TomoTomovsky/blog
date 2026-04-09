import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
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
