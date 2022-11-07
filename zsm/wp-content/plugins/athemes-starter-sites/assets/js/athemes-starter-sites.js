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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "a", function() { return $; });
/* unused harmony export $window */
/* unused harmony export $doc */
/* unused harmony export $body */
/**
 * Window size
 */
var $ = jQuery;
var $window = $(window);
var $doc = $(document);
var $body = $('body');


/***/ }),
/* 1 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(2);
__webpack_require__(3);
__webpack_require__(4);
__webpack_require__(5);
module.exports = __webpack_require__(6);


/***/ }),
/* 2 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utility__ = __webpack_require__(0);
/**
 * Demos.
 */

/*
 * Filter.
 */

function atssDemosFilter() {
  var atssCategory = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-categories-select').val();
  var atssBuilder = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-builders-select').val(); // Remove active.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(".atss-demos .atss-demo-item").removeClass('atss-demo-item-active'); // Add active.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(".atss-demos .atss-demo-item[data-categories*=\"[".concat(atssCategory, "]\"][data-builders*=\"[").concat(atssBuilder, "]\"]")).addClass('atss-demo-item-active');
}
/*
 * Category Select.
 */


Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('change', '.atss-categories-select', function (e) {
  atssDemosFilter();
  e.preventDefault();
});
/*
 * Builder Select.
 */

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('change', '.atss-builders-select', function (e) {
  atssDemosFilter();
  e.preventDefault();
});

/***/ }),
/* 3 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utility__ = __webpack_require__(0);
/**
 * Finish Animation.
 */

'use strict';

var _window$popmotion = window.popmotion;
var tween = _window$popmotion.tween;
var physics = _window$popmotion.physics;
var easing = _window$popmotion.easing;
var transform = _window$popmotion.transform;
var easeIn = easing.easeIn;
var interpolate = transform.interpolate;

function showTick() {
  if (Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-logo').data('init')) {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-logo').html(Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-logo').data('init'));
  } else {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-logo').data('init', Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-logo').html());
  }

  var circleStyler = styler(document.getElementById('tick-outline-path'));
  var tickStyler = styler(document.getElementById('tick-path'));
  var spinCircle = physics({
    velocity: -400,
    onUpdate: function onUpdate(v) {
      return circleStyler.set('rotate', v);
    }
  });
  var mapCircleOpacityToLength = interpolate([0, 1], [0, 65]);
  var openOutline = tween({
    ease: easeIn,
    onUpdate: function onUpdate(v) {
      return circleStyler.set({
        opacity: v,
        pathLength: mapCircleOpacityToLength(v)
      });
    },
    onComplete: function onComplete() {
      return spinCircle.start();
    }
  }).start();
  setTimeout(function () {
    // Complete the circle
    tween({
      from: circleStyler.get('pathLength'),
      to: 100,
      onUpdate: function onUpdate(v) {
        return circleStyler.set('pathLength', v);
      }
    }).start(); // Slow the spinning

    spinCircle.setProps({
      friction: 0.6
    }); // Draw tick

    tween({
      onUpdate: function onUpdate(v) {
        return tickStyler.set({
          opacity: v,
          pathLength: v * 100
        });
      }
    }).start();
  }, 1000);
}

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('DOMImportFinish', showTick);

/***/ }),
/* 4 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utility__ = __webpack_require__(0);
/**
 * Import.
 */

/*
 * Open import demo.
 */

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('click', '.atss-demo-import-open', function (e) {
  var $this = this; // Get demo id.

  var $demo_id = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).data('id'); // Body import.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('body').addClass('atss-import-theme-active'); // Variables.

  var data = {
    'action': 'atss_html_import_data',
    'nonce': atss_localize.nonce,
    'demo_id': $demo_id
  }; // Reset current step.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-step').removeClass('atss-import-step-active');
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-step').first().addClass('atss-import-step-active'); // Remove warning.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-theme .atss-msg-warning').remove(); // Reset variables.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').html('');
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').addClass('atss-import-load');
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-process .atss-import-progress-label').html('');
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-process .atss-import-progress-indicator').attr('style', '--atss-indicator: 0%;');
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-process .atss-import-progress-sublabel').html('0%'); // Send Request.

  __WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */].post(atss_localize.ajax_url, data, function (response) {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').removeClass('atss-import-load');

    if (response.success) {
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').html(response.data);
    } else if (response.data) {
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').html("<div class=\"atss-msg-warning\">".concat(response.data, "</div>"));
    } else {
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').html("<div class=\"atss-msg-warning\">".concat(atss_localize.failed_message, "</div>"));
    }
  }).fail(function (xhr, textStatus, e) {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').removeClass('atss-import-load');
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start .atss-import-output').html("<div class=\"atss-msg-warning\">".concat(atss_localize.failed_message, "</div>"));
  });
  e.preventDefault();
});
/*
 * Close import.
 */

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('click', '.atss-demo-import-close, .atss-import-overlay', function (e) {
  // Remove import from body.
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('body').removeClass('atss-import-theme-active');
  e.preventDefault();
});
/*
 * Import Indicator.
 */

function atssImportIndicator($this, $e, $data) {
  // Set indicator.
  var indicator = Math.round(100 / $data.steps * $data.index); // Change indicator.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-process .atss-import-progress-indicator').attr('style', "--atss-indicator: ".concat(indicator, "%;"));
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-process .atss-import-progress-sublabel').html("".concat(indicator, "%"));
}
/*
 * Import Step.
 */


function atssImportStep($this, $e, $data) {
  if (!Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('body').hasClass('atss-import-theme-active')) {
    return;
  } // Done.


  if ($data.index >= $data.steps) {
    // Change step.
    setTimeout(function () {
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-step').removeClass('atss-import-step-active');
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-finish').addClass('atss-import-step-active');
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).trigger('DOMImportFinish');
    }, 200);
    return;
  } // Set progress label.


  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-progress-label').html(Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($data.forms).eq($data.index).find('input[name="step_name"]').val()); // Send Request.

  __WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */].post({
    url: atss_localize.ajax_url,
    type: 'POST',
    data: Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($data.forms).eq($data.index).serialize(),
    timeout: 0
  }).done(function (response) {
    if (response.success) {
      if ('undefined' !== typeof response.status && 'newAJAX' === response.status) {
        atssImportStep($this, $e, $data);
      } else {
        $data.index = $data.index + 1;
        atssImportIndicator($this, $e, $data);
        atssImportStep($this, $e, $data);
      }
    } else if (response.data) {
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-progress').after("<div class=\"atss-msg-warning\">".concat(response.data, "</div>"));
    } else {
      Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-progress').after("<div class=\"atss-msg-warning\">".concat(atss_localize.failed_message, "</div>"));
    }
  }).fail(function () {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-progress').after("<div class=\"atss-msg-warning\">".concat(atss_localize.failed_message, "</div>"));
  });
}
/*
 * Import Content.
 */


function atssImportContent($this, $e) {
  var forms = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-start form').filter(function (index, element) {
    if (Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(element).find('.atss-checkbox').prop('checked')) {
      return true;
    } else {
      return false;
    }
  });
  var steps = forms.length;

  if (steps <= 0) {
    return;
  }

  atssImportStep($this, $e, {
    'forms': forms,
    'steps': steps,
    'index': 0
  });
}
/*
 * Start import.
 */


Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('click', '.atss-demo-import-start', function (e) {
  var $this = this;
  var $e = e; // Change process.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-step').removeClass('atss-import-step-active');
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-import-process').addClass('atss-import-step-active'); // Run Import.

  setTimeout(function () {
    atssImportContent($this, $e);
  }, 10);
  e.preventDefault();
});

/***/ }),
/* 5 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utility__ = __webpack_require__(0);
/**
 * Preview.
 */

/*
 * Open preview.
 */

function atssOpenPreview($this, e) {
  var demo_id = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).data('id');
  var preview = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).data('preview');
  var name = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).data('name');
  var type = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).data('type');

  if ('false' === preview) {
    return;
  } // Remove current class from siblings items.


  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).siblings().removeClass('atss-demo-item-open'); // Current item.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).addClass('atss-demo-item-open'); // Set demo id.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-demo-import-open').attr('data-id', demo_id); // Prev Next Buttons.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview').find('.atss-prev-demo, .atss-next-demo').removeClass('atss-inactive');
  var prev = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).prev('.atss-demo-item-active');

  if (prev.length <= 0) {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-prev-demo').addClass('atss-inactive');
  }

  var next = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).next('.atss-demo-item-active');

  if (next.length <= 0) {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-next-demo').addClass('atss-inactive');
  } // Reset header info.


  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-header-info').html(''); // Add name to info.

  if (name) {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-header-info').append("<div class=\"atss-demo-name\">".concat(name, "</div>"));
  } // Add badge to info.


  if (type) {
    Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-header-info').append("<div class=\"atss-demo-badge atss-badge atss-badge-success\">".concat(type, "</div>"));
  }

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-preview-actions').html(Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])($this).find('.atss-demo-actions').html()); // Set url in iframe.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-preview-iframe').attr('src', preview); // Body preview.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('body').addClass('atss-preview-active');
}
/*
 * Open preview demo.
 */


Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('click', '.atss-demo-item', function (e) {
  if (!Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(e.target).is('.atss-demo-import-open, .atss-demo-import-url')) {
    atssOpenPreview(this, e);
    e.preventDefault();
  }
});
/*
 * Open preview prev demo.
 */

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('click', '.atss-prev-demo', function (e) {
  var prev = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-demo-item-open').prev('.atss-demo-item-active');

  if (prev.length > 0) {
    atssOpenPreview(prev, e);
  }

  e.preventDefault();
});
/*
 * Open preview next demo.
 */

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('click', '.atss-next-demo', function (e) {
  var next = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-demo-item-open').next('.atss-demo-item-active');

  if (next.length > 0) {
    atssOpenPreview(next, e);
  }

  e.preventDefault();
});
/*
 * Close preview.
 */

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).on('click', '.atss-preview-cancel a', function (e) {
  // Remove current class from items.
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-demo-item').removeClass('atss-demo-item-open'); // Remove preview from body.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('body').removeClass('atss-preview-active'); // Remove url from iframe.

  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-preview .atss-preview-iframe').removeAttr('src');
  e.preventDefault();
});

/***/ }),
/* 6 */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__utility__ = __webpack_require__(0);
/**
 * Select.
 */

Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(document).ready(function () {
  function selectImage(opt) {
    if (!opt.id) {
      return opt.text;
    }

    var optimage = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(opt.element).data('image');

    if (!optimage) {
      return opt.text;
    } else {
      var $opt = Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('<span class="select-line"><img width="24px" src="' + optimage + '" class="select-image" /> ' + Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])(opt.element).text() + '</span>');
      return $opt;
    }
  }

  ;
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-categories-select').select2({
    dropdownAutoWidth: true,
    width: 'auto',
    minimumResultsForSearch: -1,
    dropdownCssClass: 'atss-select-dropdown'
  });
  Object(__WEBPACK_IMPORTED_MODULE_0__utility__["a" /* $ */])('.atss-builders-select').select2({
    dropdownAutoWidth: true,
    width: 'auto',
    minimumResultsForSearch: -1,
    templateResult: selectImage,
    templateSelection: selectImage,
    dropdownCssClass: 'atss-select-dropdown'
  });
});

/***/ })
/******/ ]);