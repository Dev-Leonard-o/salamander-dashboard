import './bootstrap';
import '../css/app.scss';
import '../css/themes.scss';
import './theme-switcher';

// Import UIkit
import UIkit from 'uikit';
import Icons from 'uikit/dist/js/uikit-icons';

// Load UIkit Icons
UIkit.use(Icons);

// Make UIkit available globally
window.UIkit = UIkit;
