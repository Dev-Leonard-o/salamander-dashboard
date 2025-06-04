<div>
    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('theme-changed', ({ theme }) => {
                document.documentElement.classList.remove('light', 'dark', 'ocean', 'sunset', 'forest');
                document.documentElement.classList.add(theme);
            });
        });
    </script>
</div> 