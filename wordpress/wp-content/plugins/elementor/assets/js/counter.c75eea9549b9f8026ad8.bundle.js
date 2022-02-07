/*! elementor - v3.5.3 - 28-12-2021 */
"use strict";
(self["webpackChunkelementor"] = self["webpackChunkelementor"] || []).push([["counter"],{

/***/ "../assets/dev/js/frontend/handlers/counter.js":
/*!*****************************************************!*\
  !*** ../assets/dev/js/frontend/handlers/counter.js ***!
  \*****************************************************/
/***/ ((__unused_webpack_module, exports) => {



Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

class Counter extends elementorModules.frontend.handlers.Base {
  getDefaultSettings() {
    return {
      selectors: {
        counterNumber: '.elementor-counter-number'
      }
    };
  }

  getDefaultElements() {
    const selectors = this.getSettings('selectors');
    return {
      $counterNumber: this.$element.find(selectors.counterNumber)
    };
  }

  onInit() {
    super.onInit();
    this.intersectionObserver = elementorModules.utils.Scroll.scrollObserver({
      callback: event => {
        if (event.isInViewport) {
          this.intersectionObserver.unobserve(this.elements.$counterNumber[0]);
          const data = this.elements.$counterNumber.data(),
                decimalDigits = data.toValue.toString().match(/\.(.*)/);

          if (decimalDigits) {
            data.rounding = decimalDigits[1].length;
          }

          this.elements.$counterNumber.numerator(data);
        }
      }
    });
    this.intersectionObserver.observe(this.elements.$counterNumber[0]);
  }

}

exports["default"] = Counter;

/***/ })

}]);
//# sourceMappingURL=counter.c75eea9549b9f8026ad8.bundle.js.map