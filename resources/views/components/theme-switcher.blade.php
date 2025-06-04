<div class="mr-4">
    <x-filament::dropdown placement="bottom-end">
        <x-slot name="trigger">
            <button
                type="button"
                @class([
                    'flex items-center justify-center w-9 h-9 rounded-full hover:bg-gray-500/5 focus:outline-none',
                    'dark:text-white' => config('filament.dark_mode'),
                ])
            >
                <span id="current-theme-icon" class="text-lg">☀️</span>
            </button>
        </x-slot>

        <x-filament::dropdown.list>
            <x-filament::dropdown.list.item
                wire:click="null"
                tag="button"
                class="theme-option"
                data-theme="light"
            >
                <div class="flex items-center gap-2">
                    <span>☀️</span>
                    <span>{{ __('Light') }}</span>
                </div>
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                wire:click="null"
                tag="button"
                class="theme-option"
                data-theme="dark"
            >
                <div class="flex items-center gap-2">
                    <span>🌙</span>
                    <span>{{ __('Dark') }}</span>
                </div>
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                wire:click="null"
                tag="button"
                class="theme-option"
                data-theme="nature"
            >
                <div class="flex items-center gap-2">
                    <span>🌿</span>
                    <span>{{ __('Nature') }}</span>
                </div>
            </x-filament::dropdown.list.item>
        </x-filament::dropdown.list>
    </x-filament::dropdown>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const themeOptions = document.querySelectorAll('.theme-option');
        const currentThemeIcon = document.getElementById('current-theme-icon');
        const icons = {
            light: '☀️',
            dark: '🌙',
            nature: '🌿'
        };

        // Set initial theme
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', currentTheme);
        currentThemeIcon.textContent = icons[currentTheme];

        themeOptions.forEach(option => {
            option.addEventListener('click', () => {
                const theme = option.dataset.theme;
                document.documentElement.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);
                currentThemeIcon.textContent = icons[theme];
            });
        });
    });
</script>
@endpush 