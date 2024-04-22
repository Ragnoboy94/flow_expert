import axios from 'axios';
import Cookies from 'js-cookie';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let bearer = Cookies.get('access_token');

if (bearer) {
    window.axios.defaults.headers.common['Authorization'] = bearer;
}
