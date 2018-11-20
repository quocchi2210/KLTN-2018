/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 244);
/******/ })
/************************************************************************/
/******/ ({

/***/ 244:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(245);


/***/ }),

/***/ 245:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
throw new Error("Cannot find module \"babel-polyfill\"");
throw new Error("Cannot find module \"vue\"");
throw new Error("Cannot find module \"vue-i18n\"");
throw new Error("Cannot find module \"vue-router\"");
throw new Error("Cannot find module \"element-ui\"");
throw new Error("Cannot find module \"vue-data-tables\"");
throw new Error("Cannot find module \"vue-events\"");
throw new Error("Cannot find module \"element-ui/lib/locale/lang/en\"");
throw new Error("Cannot find module \"vue-simplemde\"");
throw new Error("Cannot find module \"../../../../Core/User/Assets/js/UserRoutes\"");
throw new Error("Cannot find module \"../../../../Core/Bussiness/Assets/js/BussinessRoutes\"");
function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

function _toConsumableArray(arr) { if (Array.isArray(arr)) { for (var i = 0, arr2 = Array(arr.length); i < arr.length; i++) { arr2[i] = arr[i]; } return arr2; } else { return Array.from(arr); } }

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

__webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"./bootstrap\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));
__webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"./bussiness\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));













__WEBPACK_IMPORTED_MODULE_1_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_4_element_ui___default.a, { locale: __WEBPACK_IMPORTED_MODULE_7_element_ui_lib_locale_lang_en___default.a });
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_5_vue_data_tables___default.a, { locale: __WEBPACK_IMPORTED_MODULE_7_element_ui_lib_locale_lang_en___default.a });
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_2_vue_i18n___default.a);
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_3_vue_router___default.a);
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.use(__webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"vue-shortkey\""); e.code = 'MODULE_NOT_FOUND'; throw e; }())), { prevent: ['input', 'textarea'] });

__WEBPACK_IMPORTED_MODULE_1_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_6_vue_events___default.a);
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.use(__WEBPACK_IMPORTED_MODULE_8_vue_simplemde___default.a);
__webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"./mixins\""); e.code = 'MODULE_NOT_FOUND'; throw e; }()));

__WEBPACK_IMPORTED_MODULE_1_vue___default.a.component('DeleteButton', __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"../../../../Core/Core/Assets/js/components/DeleteComponent\""); e.code = 'MODULE_NOT_FOUND'; throw e; }())));
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.component('EditButton', __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"../../../../Core/Core/Assets/js/components/EditButtonComponent\""); e.code = 'MODULE_NOT_FOUND'; throw e; }())));
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.component('ActiveButton', __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"../../../../Core/Core/Assets/js/components/ActiveComponent\""); e.code = 'MODULE_NOT_FOUND'; throw e; }())));
__WEBPACK_IMPORTED_MODULE_1_vue___default.a.component('DeactiveButton', __webpack_require__(!(function webpackMissingModule() { var e = new Error("Cannot find module \"../../../../Core/Core/Assets/js/components/DeactiveComponent\""); e.code = 'MODULE_NOT_FOUND'; throw e; }())));

var currentLocale = document.documentElement.lang;

var router = new __WEBPACK_IMPORTED_MODULE_3_vue_router___default.a({
    mode: 'history',
    base: '',
    routes: [].concat(_toConsumableArray(__WEBPACK_IMPORTED_MODULE_9__Core_User_Assets_js_UserRoutes___default.a), _toConsumableArray(__WEBPACK_IMPORTED_MODULE_10__Core_Bussiness_Assets_js_BussinessRoutes___default.a))
});

var messages = _defineProperty({}, currentLocale, window.HijackCMS.translations);

var i18n = new __WEBPACK_IMPORTED_MODULE_2_vue_i18n___default.a({
    locale: currentLocale,
    messages: messages
});

var app = new __WEBPACK_IMPORTED_MODULE_1_vue___default.a({
    el: '#app',
    router: router,
    i18n: i18n
});

window.axios.interceptors.response.use(null, function (error) {
    if (error.response === undefined) {
        console.log(error);
        return;
    }
    if (error.response.status === 403) {
        app.$notify.error({
            title: app.$t('core.unauthorized'),
            message: app.$t('core.unauthorized-access')
        });
        window.location = route('dashboard.index');
    }
    if (error.response.status === 401) {
        app.$notify.error({
            title: app.$t('core.unauthenticated'),
            message: app.$t('core.unauthenticated-message')
        });
        window.location = route('login');
    }
    return Promise.reject(error);
});

/***/ })

/******/ });