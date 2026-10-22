import axios from 'axios';

/**
 * Axios automatically sends the CSRF token as a header based on the value
 * of the "XSRF" token cookie set by Laravel.
 */
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
