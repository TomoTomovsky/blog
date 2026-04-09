<x-layout>
    <form id="create-post-form" method="POST" action="{{ route('posts.store') }}" class="flex flex-col max-w-3xl mx-auto my-4">
        @csrf

        @if ($errors->any())
            <ul class="bg-red-200 text-red-700 p-6 mb-4">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <label>Tytul</label>
        <input type="text" name="title" value="{{ old('title') }}" />
        @error('title')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label>Przyjazny adres</label>
        <input type="text" name="slug" value="{{ old('slug') }}" />
        @error('slug')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label>Autor</label>
        <input type="text" name="author" value="{{ old('author') }}" />
        @error('author')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label>Zajawka</label>
        <textarea name="lead">{{ old('lead') }}</textarea>
        @error('lead')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <label>Treść</label>
        <textarea name="content">{{ old('content') }}</textarea>
        @error('content')
            <div class="text-red-500">{{ $message }}</div>
        @enderror

        <button id="robot-check-button" type="button" class="bg-blue-700 text-white p-4 mt-4">Dodaj</button>
    </form>

    <div id="captcha-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 p-4">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl">
            <div class="mb-4 flex items-center justify-between gap-4">
                <h3 class="text-lg font-semibold text-gray-900">Robot Check 3000</h3>
                <span id="captcha-step" class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">1/4</span>
            </div>

            <p id="captcha-question" class="text-gray-700">Czy na pewno nie jestes robotem?</p>

            <div class="mt-5 h-2 w-full overflow-hidden rounded-full bg-gray-200">
                <div id="captcha-progress" class="h-full w-1/4 rounded-full bg-indigo-600 transition-all"></div>
            </div>

            <div class="mt-6 flex items-center justify-end gap-3">
                <button id="captcha-no-button" type="button"
                    class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100">
                    Nie
                </button>
                <button id="captcha-yes-button" type="button"
                    class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-700">
                    Tak
                </button>
            </div>
        </div>
    </div>

    <div id="captcha-decline-message"
        class="fixed bottom-4 right-4 z-50 hidden rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white shadow-lg">
        Ty no szkoda
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('create-post-form');
            const button = document.getElementById('robot-check-button');
            const modal = document.getElementById('captcha-modal');
            const yesButton = document.getElementById('captcha-yes-button');
            const noButton = document.getElementById('captcha-no-button');
            const question = document.getElementById('captcha-question');
            const step = document.getElementById('captcha-step');
            const progress = document.getElementById('captcha-progress');
            const declineMessage = document.getElementById('captcha-decline-message');

            if (!form || !button || !modal || !yesButton || !noButton || !question || !step || !progress || !declineMessage) {
                return;
            }

            const questions = [
                'Czy na pewno nie jestes robotem?',
                'Na pewno na pewno?',
                'To ostatnia szansa, serio?',
                'Finalne pytanie: wciaz nie robot?'
            ];
            let currentStep = 0;

            const clearFormCompletely = () => {
                form.reset();

                form.querySelectorAll('input, textarea, select').forEach((field) => {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        field.checked = false;
                        return;
                    }

                    if (field.tagName === 'SELECT') {
                        field.selectedIndex = 0;
                        return;
                    }

                    field.value = '';
                });
            };

            const openModal = () => {
                currentStep = 0;
                renderStep();
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            };

            const closeModal = () => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            };

            const renderStep = () => {
                const visibleStep = currentStep + 1;
                question.textContent = questions[currentStep];
                step.textContent = `${visibleStep}/${questions.length}`;
                progress.style.width = `${(visibleStep / questions.length) * 100}%`;
            };

            const showDeclineMessage = () => {
                declineMessage.classList.remove('hidden');
                setTimeout(() => {
                    declineMessage.classList.add('hidden');
                }, 1400);
            };

            button.addEventListener('click', function (event) {
                event.preventDefault();
                openModal();
            });

            yesButton.addEventListener('click', function () {
                if (currentStep === questions.length - 1) {
                    closeModal();
                    form.submit();
                    return;
                }

                currentStep++;
                renderStep();
            });

            noButton.addEventListener('click', function () {
                closeModal();
                showDeclineMessage();
                clearFormCompletely();
            });
        });
    </script>
</x-layout>
