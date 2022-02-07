/*! elementor - v3.5.3 - 28-12-2021 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "../assets/dev/js/admin/new-template/layout.js":
/*!*****************************************************!*\
  !*** ../assets/dev/js/admin/new-template/layout.js ***!
  \*****************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

/* provided dependency */ var __ = __webpack_require__(/*! @wordpress/i18n */ "@wordpress/i18n")["__"];


var NewTemplateView = __webpack_require__(/*! elementor-admin/new-template/view */ "../assets/dev/js/admin/new-template/view.js");

module.exports = elementorModules.common.views.modal.Layout.extend({
  getModalOptions: function getModalOptions() {
    return {
      id: 'elementor-new-template-modal'
    };
  },
  getLogoOptions: function getLogoOptions() {
    return {
      title: __('New Template', 'elementor')
    };
  },
  initialize: function initialize() {
    elementorModules.common.views.modal.Layout.prototype.initialize.apply(this, arguments);
    this.showLogo();
    this.showContentView();
  },
  showContentView: function showContentView() {
    this.modalContent.show(new NewTemplateView());
  }
});

/***/ }),

/***/ "../assets/dev/js/admin/new-template/view.js":
/*!***************************************************!*\
  !*** ../assets/dev/js/admin/new-template/view.js ***!
  \***************************************************/
/***/ ((module) => {



module.exports = Marionette.ItemView.extend({
  id: 'elementor-new-template-dialog-content',
  template: '#tmpl-elementor-new-template',
  ui: {},
  events: {},
  onRender: function onRender() {}
});

/***/ }),

/***/ "@wordpress/i18n":
/*!**************************!*\
  !*** external "wp.i18n" ***!
  \**************************/
/***/ ((module) => {

module.exports = wp.i18n;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!***********************************************************!*\
  !*** ../assets/dev/js/admin/new-template/new-template.js ***!
  \***********************************************************/


var NewTemplateLayout = __webpack_require__(/*! elementor-admin/new-template/layout */ "../assets/dev/js/admin/new-template/layout.js");

var NewTemplateModule = elementorModules.ViewModule.extend({
  getDefaultSettings: function getDefaultSettings() {
    return {
      selectors: {
        addButton: '.page-title-action:first, #elementor-template-library-add-new'
      }
    };
  },
  getDefaultElements: function getDefaultElements() {
    var selectors = this.getSettings('selectors');
    return {
      $addButton: jQuery(selectors.addButton)
    };
  },
  bindEvents: function bindEvents() {
    this.elements.$addButton.on('click', this.onAddButtonClick);
    elementorCommon.elements.$window.on('hashchange', this.showModalByHash.bind(this));
  },
  showModalByHash: function showModalByHash() {
    if ('#add_new' === location.hash) {
      this.layout.showModal();
      location.hash = '';
    }
  },
  onInit: function onInit() {
    elementorModules.ViewModule.prototype.onInit.apply(this, arguments);
    this.layout = new NewTemplateLayout();
    this.showModalByHash();
  },
  onAddButtonClick: function onAddButtonClick(event) {
    event.preventDefault();
    this.layout.showModal();
  }
});
jQuery(function () {
  window.elementorNewTemplate = new NewTemplateModule();
});
})();

/******/ })()
;
//# sourceMappingURL=new-template.js.map