class ThemeSwitcher {
  constructor() {
    this.themes = ['light', 'dark', 'nature'];
    this.currentTheme = localStorage.getItem('theme') || 'light';
    this.init();
  }

  init() {
    this.createSwitcher();
    this.setTheme(this.currentTheme);
    this.addEventListeners();
  }

  createSwitcher() {
    const switcher = document.createElement('div');
    switcher.className = 'theme-switch';

    const buttonGroup = document.createElement('div');
    buttonGroup.className = 'uk-button-group';

    this.themes.forEach(theme => {
      const button = document.createElement('button');
      button.className = `uk-button ${theme === this.currentTheme ? 'active' : ''}`;
      button.dataset.theme = theme;
      button.innerHTML = this.getThemeIcon(theme);
      buttonGroup.appendChild(button);
    });

    switcher.appendChild(buttonGroup);
    document.body.appendChild(switcher);
  }

  getThemeIcon(theme) {
    const icons = {
      light: '☀️',
      dark: '🌙',
      nature: '🌿'
    };
    return icons[theme] || '🎨';
  }

  setTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    this.currentTheme = theme;

    // Update active button
    document.querySelectorAll('.theme-switch button').forEach(button => {
      button.classList.toggle('active', button.dataset.theme === theme);
    });
  }

  addEventListeners() {
    document.querySelectorAll('.theme-switch button').forEach(button => {
      button.addEventListener('click', () => {
        const theme = button.dataset.theme;
        this.setTheme(theme);
      });
    });
  }
}

// Initialize theme switcher
document.addEventListener('DOMContentLoaded', () => {
  window.themeSwitcher = new ThemeSwitcher();
}); 