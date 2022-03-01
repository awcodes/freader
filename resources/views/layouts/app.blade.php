<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Freader | An RSS Feed Reader</title>
    <meta name="robots" content="noindex, nofollow">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @livewireStyles

    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <script>
        const theme = localStorage.getItem('theme')

        if ((theme === 'dark') || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        }
    </script>
</head>

<body class="flex flex-col h-full text-gray-900 bg-gray-100 dark:text-gray-100 dark:bg-gray-900">

    <header class="flex items-center justify-between p-4 border-b border-black">
        <h1 class="text-3xl font-bold">Freader</h1>
        <div class="flex items-center" x-data="{
                mode: null,

                theme: null,

                init: function () {
                    this.theme = localStorage.getItem('theme') || (this.isSystemDark() ? 'dark' : 'light')
                    this.mode = localStorage.getItem('theme') ? 'manual' : 'auto'

                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
                        if (this.mode === 'manual') return

                        if (event.matches && (! document.documentElement.classList.contains('dark'))) {
                            this.theme = 'dark'

                            document.documentElement.classList.add('dark')
                        } else if ((! event.matches) && document.documentElement.classList.contains('dark')) {
                            this.theme = 'light'

                            document.documentElement.classList.remove('dark')
                        }
                    })

                    $watch('theme', () => {
                        if (this.mode === 'auto') return

                        localStorage.setItem('theme', this.theme)

                        if (this.theme === 'dark' && (! document.documentElement.classList.contains('dark'))) {
                            document.documentElement.classList.add('dark')
                        } else if (this.theme === 'light' && document.documentElement.classList.contains('dark')) {
                            document.documentElement.classList.remove('dark')
                        }

                        $dispatch('dark-mode-toggled', this.theme)
                    })
                },

                isSystemDark: function () {
                    return window.matchMedia('(prefers-color-scheme: dark)').matches
                },
            }">
            <button type="button" x-show="theme === 'dark'" x-on:click="mode = 'manual'; theme = 'light'">
                <x-heroicon-s-sun class="h-6" />
                <span class="sr-only">{{ __('filament::layout.buttons.light_mode.label') }}</span>
            </button>
            <button type="button" x-show="theme === 'light'" x-on:click="mode = 'manual'; theme = 'dark'">
                <x-heroicon-s-moon class="h-6" />
                <span class="sr-only">{{ __('filament::layout.buttons.dark_mode.label') }}</span>
            </button>
        </div>
    </header>

    <main class="flex-1 h-full overflow-hidden">
        {{ $slot }}
    </main>

    @livewireScripts
    <script src="{{ mix('js/app.js') }}"></script>
    @stack('scripts')
</body>

</html>
