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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./platform/admin/resources/assets/js/event-create-update.js":
/*!*******************************************************************!*\
  !*** ./platform/admin/resources/assets/js/event-create-update.js ***!
  \*******************************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _helpers__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./helpers */ "./platform/admin/resources/assets/js/helpers.js");
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }



var EventCreateUpdate =
/*#__PURE__*/
function () {
  function EventCreateUpdate() {
    _classCallCheck(this, EventCreateUpdate);

    this.$slug = $('input[name=slug]');
    this.$name = $('input[name=name]');
    this.init();
  }

  _createClass(EventCreateUpdate, [{
    key: "initCKEditor",
    value: function initCKEditor() {
      CKEDITOR.replace('description', {
        height: 200
      });
    }
  }, {
    key: "init",
    value: function init() {
      var _this = this;

      this.initDropify();
      this.initCKEditor();
      this.$slug.focus(function (event) {
        if (_this.$name.val() !== '' && _this.$slug.val() === '') {
          _this.$slug.val(_helpers__WEBPACK_IMPORTED_MODULE_0__["default"].toSlug(_this.$name.val()));
        }
      });
    }
  }, {
    key: "initDropify",
    value: function initDropify() {
      $('.dropify').dropify();
    }
  }]);

  return EventCreateUpdate;
}();

$(function () {
  new EventCreateUpdate();
});

/***/ }),

/***/ "./platform/admin/resources/assets/js/helpers.js":
/*!*******************************************************!*\
  !*** ./platform/admin/resources/assets/js/helpers.js ***!
  \*******************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "default", function() { return Helpers; });
function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }

function _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); return Constructor; }

var Helpers =
/*#__PURE__*/
function () {
  function Helpers() {
    _classCallCheck(this, Helpers);
  }

  _createClass(Helpers, null, [{
    key: "showInputErrors",
    value: function showInputErrors(errors) {
      var prefix = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '';
      Object.keys(errors).map(function (key) {
        var message = errors[key][0];
        var select = prefix !== '' ? "#".concat(prefix, "_").concat(key) : "#".concat(key);
        var formControl = $(select);
        Helpers.hideInputErrors(formControl);
        formControl.addClass('is-invalid').parent().append("<div class=\"invalid-feedback\">".concat(message, "</div>"));
        formControl.unbind('focus');
        formControl.focus(function () {
          formControl.removeClass('is-invalid').parent().find('.invalid-feedback').remove();
        });
      });
    }
  }, {
    key: "hideInputErrors",
    value: function hideInputErrors(formControl) {
      var reset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
      formControl.unbind('focus');
      formControl.removeClass('is-invalid').parent().find('.invalid-feedback').remove();
      if (reset) formControl.val(null);
    }
  }, {
    key: "showToast",
    value: function showToast(message) {
      var type = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'success';
      $.toast({
        heading: 'Notification',
        text: message,
        showHideTransition: 'slide',
        icon: type,
        loaderBg: '#f2a654',
        position: 'top-right'
      });
    }
  }, {
    key: "toSlug",
    value: function toSlug(str) {
      var slug = str.toLowerCase();
      slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
      slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
      slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
      slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
      slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
      slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
      slug = slug.replace(/đ/gi, 'd');
      slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
      slug = slug.replace(/ /gi, "-");
      slug = slug.replace(/\-\-\-\-\-/gi, '-');
      slug = slug.replace(/\-\-\-\-/gi, '-');
      slug = slug.replace(/\-\-\-/gi, '-');
      slug = slug.replace(/\-\-/gi, '-');
      slug = '@' + slug + '@';
      slug = slug.replace(/\@\-|\-\@|\@/gi, '');
      return slug;
    }
  }]);

  return Helpers;
}();



/***/ }),

/***/ 6:
/*!*************************************************************************!*\
  !*** multi ./platform/admin/resources/assets/js/event-create-update.js ***!
  \*************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! /Users/duongle/www/dissertation/platform/admin/resources/assets/js/event-create-update.js */"./platform/admin/resources/assets/js/event-create-update.js");


/***/ })

/******/ });