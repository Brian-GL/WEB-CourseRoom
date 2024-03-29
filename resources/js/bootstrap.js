import $ from 'jquery'
window.$ = $;
window.jQuery = $;

import Swal from 'sweetalert2'
window.Swal = Swal;

import * as Memes from 'random-memes'
window.Memes = Memes;

import * as DataTables from 'datatables.net-bs5'
window.dt = DataTables;

import toastr from 'toastr';
window.toastr = toastr;

import * as Base64 from 'js-base64'
window.Base64 = Base64;

import _ from 'lodash';
window._ = _;

import * as Popper from '@popperjs/core'
window.Popper = Popper;

import dayjs from 'dayjs'
import 'dayjs/locale/es-mx' // import locale
import plugin from 'dayjs/plugin/localizedFormat'
dayjs.extend(plugin);
dayjs.locale('es-mx');
window.dayjs = dayjs;

import platform from 'platform'
window.platform = platform;

import Chart from 'chart.js/auto'
window.Chart = Chart;

import Calendar from '@event-calendar/core';
window.Calendar = Calendar;

import TimeGrid from '@event-calendar/time-grid';
window.TimeGrid = TimeGrid;

import DayGrid from '@event-calendar/day-grid';
window.DayGrid = DayGrid;

import Interaction from '@event-calendar/interaction';
window.Interaction = Interaction;

import 'bootstrap';

import * as bootstrap from 'bootstrap' 
window.bootstrap =  bootstrap;

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// import Pusher from 'pusher-js';
// window.Pusher = Pusher;

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: import.meta.env.VITE_PUSHER_APP_KEY,
//     wsHost: import.meta.env.VITE_PUSHER_HOST ?? `ws-${import.meta.env.VITE_PUSHER_APP_CLUSTER}.pusher.com`,
//     wsPort: import.meta.env.VITE_PUSHER_PORT ?? 80,
//     wssPort: import.meta.env.VITE_PUSHER_PORT ?? 443,
//     forceTLS: (import.meta.env.VITE_PUSHER_SCHEME ?? 'https') === 'https',
//     enabledTransports: ['ws', 'wss'],
// });
