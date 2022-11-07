/*! elementor - v3.8.0 - 30-10-2022 */
"use strict";
(self["webpackChunkelementor"] = self["webpackChunkelementor"] || []).push([["alert"],{

/***/ "../assets/dev/js/frontend/handlers/alert.js":
/*!***************************************************!*\
  !*** ../assets/dev/js/frontend/handlers/alert.js ***!
  \***************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

class Alert extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        dismissButton: '.elementor-alert-dismiss'
      }
    };
  }

  getDefaultElements() {
    const selectors = this.getSettings('selectors');
    return {
      $dismissButton: this.$element.find(selectors.dismissButton)
    };
  }

  bindEvents() {
    this.elements.$dismissButton.on('click', this.onDismissButtonClick.bind(this));
  }

  onDismissButtonClick() {
    this.$element.fadeOut();
  }

}

exports["default"] = Alert;

/***/ })

}]);
//# sourceMappingURL=alert.e48284fab1c1d836b7a9.bundle.js.map