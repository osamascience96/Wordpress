/*! elementor - v3.5.3 - 28-12-2021 */
(self["webpackChunkelementor"] = self["webpackChunkelementor"] || []).push([["frontend-modules"],{

/***/ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js":
/*!***********************************************************************!*\
  !*** ../node_modules/@babel/runtime/helpers/interopRequireDefault.js ***!
  \***********************************************************************/
/***/ ((module) => {

function _interopRequireDefault(obj) {
  return obj && obj.__esModule ? obj : {
    "default": obj
  };
}

module.exports = _interopRequireDefault;
module.exports["default"] = module.exports, module.exports.__esModule = true;

/***/ }),

/***/ "../assets/dev/js/editor/utils/is-instanceof.js":
/*!******************************************************!*\
  !*** ../assets/dev/js/editor/utils/is-instanceof.js ***!
  \******************************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

/**
 * Some FileAPI objects such as FileList, DataTransferItem and DataTransferItemList has inconsistency with the retrieved
 * object (from events, etc.) and the actual JavaScript object so a regular instanceof doesn't work. This function can
 * check whether it's instanceof by using the objects constructor and prototype names.
 *
 * @param object
 * @param constructors
 * @returns {boolean}
 */
var _default = (object, constructors) => {
  constructors = Array.isArray(constructors) ? constructors : [constructors];

  for (const constructor of constructors) {
    if (object.constructor.name === constructor.prototype[Symbol.toStringTag]) {
      return true;
    }
  }

  return false;
};

exports["default"] = _default;

/***/ }),

/***/ "../assets/dev/js/frontend/document.js":
/*!*********************************************!*\
  !*** ../assets/dev/js/frontend/document.js ***!
  \*********************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

class _default extends elementorModules.ViewModule {
  getDefaultSettings() {
    return {
      selectors: {
        elements: '.elementor-element',
        nestedDocumentElements: '.elementor .elementor-element'
      },
      classes: {
        editMode: 'elementor-edit-mode'
      }
    };
  }

  getDefaultElements() {
    const selectors = this.getSettings('selectors');
    return {
      $elements: this.$element.find(selectors.elements).not(this.$element.find(selectors.nestedDocumentElements))
    };
  }

  getDocumentSettings(setting) {
    let elementSettings;

    if (this.isEdit) {
      elementSettings = {};
      const settings = elementor.settings.page.model;
      jQuery.each(settings.getActiveControls(), controlKey => {
        elementSettings[controlKey] = settings.attributes[controlKey];
      });
    } else {
      elementSettings = this.$element.data('elementor-settings') || {};
    }

    return this.getItems(elementSettings, setting);
  }

  runElementsHandlers() {
    this.elements.$elements.each((index, element) => elementorFrontend.elementsHandler.runReadyTrigger(element));
  }

  onInit() {
    this.$element = this.getSettings('$element');
    super.onInit();
    this.isEdit = this.$element.hasClass(this.getSettings('classes.editMode'));

    if (this.isEdit) {
      elementor.on('document:loaded', () => {
        elementor.settings.page.model.on('change', this.onSettingsChange.bind(this));
      });
    } else {
      this.runElementsHandlers();
    }
  }

  onSettingsChange() {}

}

exports["default"] = _default;

/***/ }),

/***/ "../assets/dev/js/frontend/handlers/base-swiper.js":
/*!*********************************************************!*\
  !*** ../assets/dev/js/frontend/handlers/base-swiper.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _base = _interopRequireDefault(__webpack_require__(/*! ./base */ "../assets/dev/js/frontend/handlers/base.js"));

class SwiperHandlerBase extends _base.default {
  getInitialSlide() {
    const editSettings = this.getEditSettings();
    return editSettings.activeItemIndex ? editSettings.activeItemIndex - 1 : 0;
  }

  getSlidesCount() {
    return this.elements.$slides.length;
  } // This method live-handles the 'Pause On Hover' control's value being changed in the Editor Panel


  togglePauseOnHover(toggleOn) {
    if (toggleOn) {
      this.elements.$swiperContainer.on({
        mouseenter: () => {
          this.swiper.autoplay.stop();
        },
        mouseleave: () => {
          this.swiper.autoplay.start();
        }
      });
    } else {
      this.elements.$swiperContainer.off('mouseenter mouseleave');
    }
  }

  handleKenBurns() {
    const settings = this.getSettings();

    if (this.$activeImageBg) {
      this.$activeImageBg.removeClass(settings.classes.kenBurnsActive);
    }

    this.activeItemIndex = this.swiper ? this.swiper.activeIndex : this.getInitialSlide();

    if (this.swiper) {
      this.$activeImageBg = jQuery(this.swiper.slides[this.activeItemIndex]).children('.' + settings.classes.slideBackground);
    } else {
      this.$activeImageBg = jQuery(this.elements.$slides[0]).children('.' + settings.classes.slideBackground);
    }

    this.$activeImageBg.addClass(settings.classes.kenBurnsActive);
  }

}

exports["default"] = SwiperHandlerBase;

/***/ }),

/***/ "../assets/dev/js/frontend/handlers/base.js":
/*!**************************************************!*\
  !*** ../assets/dev/js/frontend/handlers/base.js ***!
  \**************************************************/
/***/ ((module) => {

"use strict";


module.exports = elementorModules.ViewModule.extend({
  $element: null,
  editorListeners: null,
  onElementChange: null,
  onEditSettingsChange: null,
  onPageSettingsChange: null,
  isEdit: null,
  __construct: function (settings) {
    if (!this.isActive(settings)) {
      return;
    }

    this.$element = settings.$element;
    this.isEdit = this.$element.hasClass('elementor-element-edit-mode');

    if (this.isEdit) {
      this.addEditorListeners();
    }
  },
  isActive: function () {
    return true;
  },
  findElement: function (selector) {
    var $mainElement = this.$element;
    return $mainElement.find(selector).filter(function () {
      return jQuery(this).closest('.elementor-element').is($mainElement);
    });
  },
  getUniqueHandlerID: function (cid, $element) {
    if (!cid) {
      cid = this.getModelCID();
    }

    if (!$element) {
      $element = this.$element;
    }

    return cid + $element.attr('data-element_type') + this.getConstructorID();
  },
  initEditorListeners: function () {
    var self = this;
    self.editorListeners = [{
      event: 'element:destroy',
      to: elementor.channels.data,
      callback: function (removedModel) {
        if (removedModel.cid !== self.getModelCID()) {
          return;
        }

        self.onDestroy();
      }
    }];

    if (self.onElementChange) {
      const elementType = self.getWidgetType() || self.getElementType();
      let eventName = 'change';

      if ('global' !== elementType) {
        eventName += ':' + elementType;
      }

      self.editorListeners.push({
        event: eventName,
        to: elementor.channels.editor,
        callback: function (controlView, elementView) {
          var elementViewHandlerID = self.getUniqueHandlerID(elementView.model.cid, elementView.$el);

          if (elementViewHandlerID !== self.getUniqueHandlerID()) {
            return;
          }

          self.onElementChange(controlView.model.get('name'), controlView, elementView);
        }
      });
    }

    if (self.onEditSettingsChange) {
      self.editorListeners.push({
        event: 'change:editSettings',
        to: elementor.channels.editor,
        callback: function (changedModel, view) {
          if (view.model.cid !== self.getModelCID()) {
            return;
          }

          self.onEditSettingsChange(Object.keys(changedModel.changed)[0]);
        }
      });
    }

    ['page'].forEach(function (settingsType) {
      var listenerMethodName = 'on' + settingsType[0].toUpperCase() + settingsType.slice(1) + 'SettingsChange';

      if (self[listenerMethodName]) {
        self.editorListeners.push({
          event: 'change',
          to: elementor.settings[settingsType].model,
          callback: function (model) {
            self[listenerMethodName](model.changed);
          }
        });
      }
    });
  },
  getEditorListeners: function () {
    if (!this.editorListeners) {
      this.initEditorListeners();
    }

    return this.editorListeners;
  },
  addEditorListeners: function () {
    var uniqueHandlerID = this.getUniqueHandlerID();
    this.getEditorListeners().forEach(function (listener) {
      elementorFrontend.addListenerOnce(uniqueHandlerID, listener.event, listener.callback, listener.to);
    });
  },
  removeEditorListeners: function () {
    var uniqueHandlerID = this.getUniqueHandlerID();
    this.getEditorListeners().forEach(function (listener) {
      elementorFrontend.removeListeners(uniqueHandlerID, listener.event, null, listener.to);
    });
  },
  getElementType: function () {
    return this.$element.data('element_type');
  },
  getWidgetType: function () {
    const widgetType = this.$element.data('widget_type');

    if (!widgetType) {
      return;
    }

    return widgetType.split('.')[0];
  },
  getID: function () {
    return this.$element.data('id');
  },
  getModelCID: function () {
    return this.$element.data('model-cid');
  },
  getElementSettings: function (setting) {
    let elementSettings = {};
    const modelCID = this.getModelCID();

    if (this.isEdit && modelCID) {
      const settings = elementorFrontend.config.elements.data[modelCID],
            attributes = settings.attributes;
      let type = attributes.widgetType || attributes.elType;

      if (attributes.isInner) {
        type = 'inner-' + type;
      }

      let settingsKeys = elementorFrontend.config.elements.keys[type];

      if (!settingsKeys) {
        settingsKeys = elementorFrontend.config.elements.keys[type] = [];
        jQuery.each(settings.controls, (name, control) => {
          if (control.frontend_available) {
            settingsKeys.push(name);
          }
        });
      }

      jQuery.each(settings.getActiveControls(), function (controlKey) {
        if (-1 !== settingsKeys.indexOf(controlKey)) {
          let value = attributes[controlKey];

          if (value.toJSON) {
            value = value.toJSON();
          }

          elementSettings[controlKey] = value;
        }
      });
    } else {
      elementSettings = this.$element.data('settings') || {};
    }

    return this.getItems(elementSettings, setting);
  },
  getEditSettings: function (setting) {
    var attributes = {};

    if (this.isEdit) {
      attributes = elementorFrontend.config.elements.editSettings[this.getModelCID()].attributes;
    }

    return this.getItems(attributes, setting);
  },
  getCurrentDeviceSetting: function (settingKey) {
    return elementorFrontend.getCurrentDeviceSetting(this.getElementSettings(), settingKey);
  },
  onInit: function () {
    if (this.isActive(this.getSettings())) {
      elementorModules.ViewModule.prototype.onInit.apply(this, arguments);
    }
  },
  onDestroy: function () {
    if (this.isEdit) {
      this.removeEditorListeners();
    }

    if (this.unbindEvents) {
      this.unbindEvents();
    }
  }
});

/***/ }),

/***/ "../assets/dev/js/frontend/modules.js":
/*!********************************************!*\
  !*** ../assets/dev/js/frontend/modules.js ***!
  \********************************************/
/***/ ((__unused_webpack_module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");

var _modules = _interopRequireDefault(__webpack_require__(/*! ../modules/modules */ "../assets/dev/js/modules/modules.js"));

var _document = _interopRequireDefault(__webpack_require__(/*! ./document */ "../assets/dev/js/frontend/document.js"));

var _stretchElement = _interopRequireDefault(__webpack_require__(/*! ./tools/stretch-element */ "../assets/dev/js/frontend/tools/stretch-element.js"));

var _base = _interopRequireDefault(__webpack_require__(/*! ./handlers/base */ "../assets/dev/js/frontend/handlers/base.js"));

var _baseSwiper = _interopRequireDefault(__webpack_require__(/*! ./handlers/base-swiper */ "../assets/dev/js/frontend/handlers/base-swiper.js"));

_modules.default.frontend = {
  Document: _document.default,
  tools: {
    StretchElement: _stretchElement.default
  },
  handlers: {
    Base: _base.default,
    SwiperBase: _baseSwiper.default
  }
};

/***/ }),

/***/ "../assets/dev/js/frontend/tools/stretch-element.js":
/*!**********************************************************!*\
  !*** ../assets/dev/js/frontend/tools/stretch-element.js ***!
  \**********************************************************/
/***/ ((module) => {

"use strict";


module.exports = elementorModules.ViewModule.extend({
  getDefaultSettings: function () {
    return {
      element: null,
      direction: elementorFrontend.config.is_rtl ? 'right' : 'left',
      selectors: {
        container: window
      }
    };
  },
  getDefaultElements: function () {
    return {
      $element: jQuery(this.getSettings('element'))
    };
  },
  stretch: function () {
    var containerSelector = this.getSettings('selectors.container'),
        $container;

    try {
      $container = jQuery(containerSelector);
    } catch (e) {}

    if (!$container || !$container.length) {
      $container = jQuery(this.getDefaultSettings().selectors.container);
    }

    this.reset();
    var $element = this.elements.$element,
        containerWidth = $container.innerWidth(),
        elementOffset = $element.offset().left,
        isFixed = 'fixed' === $element.css('position'),
        correctOffset = isFixed ? 0 : elementOffset;

    if (window !== $container[0]) {
      var containerOffset = $container.offset().left;

      if (isFixed) {
        correctOffset = containerOffset;
      }

      if (elementOffset > containerOffset) {
        correctOffset = elementOffset - containerOffset;
      }
    }

    if (!isFixed) {
      if (elementorFrontend.config.is_rtl) {
        correctOffset = containerWidth - ($element.outerWidth() + correctOffset);
      }

      correctOffset = -correctOffset;
    }

    var css = {};
    css.width = containerWidth + 'px';
    css[this.getSettings('direction')] = correctOffset + 'px';
    $element.css(css);
  },
  reset: function () {
    var css = {};
    css.width = '';
    css[this.getSettings('direction')] = '';
    this.elements.$element.css(css);
  }
});

/***/ }),

/***/ "../assets/dev/js/modules/imports/args-object.js":
/*!*******************************************************!*\
  !*** ../assets/dev/js/modules/imports/args-object.js ***!
  \*******************************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _instanceType = _interopRequireDefault(__webpack_require__(/*! ./instance-type */ "../assets/dev/js/modules/imports/instance-type.js"));

var _isInstanceof = _interopRequireDefault(__webpack_require__(/*! ../../editor/utils/is-instanceof */ "../assets/dev/js/editor/utils/is-instanceof.js"));

class ArgsObject extends _instanceType.default {
  static getInstanceType() {
    return 'ArgsObject';
  }
  /**
   * Function constructor().
   *
   * Create ArgsObject.
   *
   * @param {{}} args
   */


  constructor(args) {
    super();
    this.args = args;
  }
  /**
   * Function requireArgument().
   *
   * Validate property in args.
   *
   * @param {string} property
   * @param {{}} args
   *
   * @throws {Error}
   *
   */


  requireArgument(property, args = this.args) {
    if (!args.hasOwnProperty(property)) {
      throw Error(`${property} is required.`);
    }
  }
  /**
   * Function requireArgumentType().
   *
   * Validate property in args using `type === typeof(args.whatever)`.
   *
   * @param {string} property
   * @param {string} type
   * @param {{}} args
   *
   * @throws {Error}
   *
   */


  requireArgumentType(property, type, args = this.args) {
    this.requireArgument(property, args);

    if (typeof args[property] !== type) {
      throw Error(`${property} invalid type: ${type}.`);
    }
  }
  /**
   * Function requireArgumentInstance().
   *
   * Validate property in args using `args.whatever instanceof instance`.
   *
   * @param {string} property
   * @param {instanceof} instance
   * @param {{}} args
   *
   * @throws {Error}
   *
   */


  requireArgumentInstance(property, instance, args = this.args) {
    this.requireArgument(property, args);

    if (!(args[property] instanceof instance) && !(0, _isInstanceof.default)(args[property], instance)) {
      throw Error(`${property} invalid instance.`);
    }
  }
  /**
   * Function requireArgumentConstructor().
   *
   * Validate property in args using `type === args.whatever.constructor`.
   *
   * @param {string} property
   * @param {*} type
   * @param {{}} args
   *
   * @throws {Error}
   *
   */


  requireArgumentConstructor(property, type, args = this.args) {
    this.requireArgument(property, args);

    if (args[property].constructor !== type) {
      throw Error(`${property} invalid constructor type.`);
    }
  }

}

exports["default"] = ArgsObject;

/***/ }),

/***/ "../assets/dev/js/modules/imports/force-method-implementation.js":
/*!***********************************************************************!*\
  !*** ../assets/dev/js/modules/imports/force-method-implementation.js ***!
  \***********************************************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = exports.ForceMethodImplementation = void 0;

// TODO: Wrong location used as `elementorModules.ForceMethodImplementation(); should be` `elementorUtils.forceMethodImplementation()`;
class ForceMethodImplementation extends Error {
  constructor(info = {}) {
    super(`${info.isStatic ? 'static ' : ''}${info.fullName}() should be implemented, please provide '${info.functionName || info.fullName}' functionality.`);
    Error.captureStackTrace(this, ForceMethodImplementation);
  }

}

exports.ForceMethodImplementation = ForceMethodImplementation;

var _default = () => {
  const stack = Error().stack,
        caller = stack.split('\n')[2].trim(),
        callerName = caller.startsWith('at new') ? 'constructor' : caller.split(' ')[1],
        info = {};
  info.functionName = callerName;
  info.fullName = callerName;

  if (info.functionName.includes('.')) {
    const parts = info.functionName.split('.');
    info.className = parts[0];
    info.functionName = parts[1];
  } else {
    info.isStatic = true;
  }

  throw new ForceMethodImplementation(info);
};

exports["default"] = _default;

/***/ }),

/***/ "../assets/dev/js/modules/imports/instance-type.js":
/*!*********************************************************!*\
  !*** ../assets/dev/js/modules/imports/instance-type.js ***!
  \*********************************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

class InstanceType {
  static [Symbol.hasInstance](target) {
    /**
     * This is function extending being called each time JS uses instanceOf, since babel use it each time it create new class
     * its give's opportunity to mange capabilities of instanceOf operator.
     * saving current class each time will give option later to handle instanceOf manually.
     */
    let result = super[Symbol.hasInstance](target); // Act normal when validate a class, which does not have instance type.

    if (target && !target.constructor.getInstanceType) {
      return result;
    }

    if (target) {
      if (!target.instanceTypes) {
        target.instanceTypes = [];
      }

      if (!result) {
        if (this.getInstanceType() === target.constructor.getInstanceType()) {
          result = true;
        }
      }

      if (result) {
        const name = this.getInstanceType === InstanceType.getInstanceType ? 'BaseInstanceType' : this.getInstanceType();

        if (-1 === target.instanceTypes.indexOf(name)) {
          target.instanceTypes.push(name);
        }
      }
    }

    if (!result && target) {
      // Check if the given 'target', is instance of known types.
      result = target.instanceTypes && Array.isArray(target.instanceTypes) && -1 !== target.instanceTypes.indexOf(this.getInstanceType());
    }

    return result;
  }

  constructor() {
    // Since anonymous classes sometimes do not get validated by babel, do it manually.
    let target = new.target;
    const prototypes = [];

    while (target.__proto__ && target.__proto__.name) {
      prototypes.push(target.__proto__);
      target = target.__proto__;
    }

    prototypes.reverse().forEach(proto => this instanceof proto);
  }

  static getInstanceType() {
    elementorModules.ForceMethodImplementation();
  }

}

exports["default"] = InstanceType;

/***/ }),

/***/ "../assets/dev/js/modules/imports/module.js":
/*!**************************************************!*\
  !*** ../assets/dev/js/modules/imports/module.js ***!
  \**************************************************/
/***/ ((module) => {

"use strict";


const Module = function () {
  const $ = jQuery,
        instanceParams = arguments,
        self = this,
        events = {};
  let settings;

  const ensureClosureMethods = function () {
    $.each(self, function (methodName) {
      const oldMethod = self[methodName];

      if ('function' !== typeof oldMethod) {
        return;
      }

      self[methodName] = function () {
        return oldMethod.apply(self, arguments);
      };
    });
  };

  const initSettings = function () {
    settings = self.getDefaultSettings();
    const instanceSettings = instanceParams[0];

    if (instanceSettings) {
      $.extend(true, settings, instanceSettings);
    }
  };

  const init = function () {
    self.__construct.apply(self, instanceParams);

    ensureClosureMethods();
    initSettings();
    self.trigger('init');
  };

  this.getItems = function (items, itemKey) {
    if (itemKey) {
      const keyStack = itemKey.split('.'),
            currentKey = keyStack.splice(0, 1);

      if (!keyStack.length) {
        return items[currentKey];
      }

      if (!items[currentKey]) {
        return;
      }

      return this.getItems(items[currentKey], keyStack.join('.'));
    }

    return items;
  };

  this.getSettings = function (setting) {
    return this.getItems(settings, setting);
  };

  this.setSettings = function (settingKey, value, settingsContainer) {
    if (!settingsContainer) {
      settingsContainer = settings;
    }

    if ('object' === typeof settingKey) {
      $.extend(settingsContainer, settingKey);
      return self;
    }

    const keyStack = settingKey.split('.'),
          currentKey = keyStack.splice(0, 1);

    if (!keyStack.length) {
      settingsContainer[currentKey] = value;
      return self;
    }

    if (!settingsContainer[currentKey]) {
      settingsContainer[currentKey] = {};
    }

    return self.setSettings(keyStack.join('.'), value, settingsContainer[currentKey]);
  };

  this.getErrorMessage = function (type, functionName) {
    let message;

    switch (type) {
      case 'forceMethodImplementation':
        message = `The method '${functionName}' must to be implemented in the inheritor child.`;
        break;

      default:
        message = 'An error occurs';
    }

    return message;
  }; // TODO: This function should be deleted ?.


  this.forceMethodImplementation = function (functionName) {
    throw new Error(this.getErrorMessage('forceMethodImplementation', functionName));
  };

  this.on = function (eventName, callback) {
    if ('object' === typeof eventName) {
      $.each(eventName, function (singleEventName) {
        self.on(singleEventName, this);
      });
      return self;
    }

    const eventNames = eventName.split(' ');
    eventNames.forEach(function (singleEventName) {
      if (!events[singleEventName]) {
        events[singleEventName] = [];
      }

      events[singleEventName].push(callback);
    });
    return self;
  };

  this.off = function (eventName, callback) {
    if (!events[eventName]) {
      return self;
    }

    if (!callback) {
      delete events[eventName];
      return self;
    }

    const callbackIndex = events[eventName].indexOf(callback);

    if (-1 !== callbackIndex) {
      delete events[eventName][callbackIndex]; // Reset array index (for next off on same event).

      events[eventName] = events[eventName].filter(val => val);
    }

    return self;
  };

  this.trigger = function (eventName) {
    const methodName = 'on' + eventName[0].toUpperCase() + eventName.slice(1),
          params = Array.prototype.slice.call(arguments, 1);

    if (self[methodName]) {
      self[methodName].apply(self, params);
    }

    const callbacks = events[eventName];

    if (!callbacks) {
      return self;
    }

    $.each(callbacks, function (index, callback) {
      callback.apply(self, params);
    });
    return self;
  };

  init();
};

Module.prototype.__construct = function () {};

Module.prototype.getDefaultSettings = function () {
  return {};
};

Module.prototype.getConstructorID = function () {
  return this.constructor.name;
};

Module.extend = function (properties) {
  const $ = jQuery,
        parent = this;

  const child = function () {
    return parent.apply(this, arguments);
  };

  $.extend(child, parent);
  child.prototype = Object.create($.extend({}, parent.prototype, properties));
  child.prototype.constructor = child;
  child.__super__ = parent.prototype;
  return child;
};

module.exports = Module;

/***/ }),

/***/ "../assets/dev/js/modules/imports/utils/masonry.js":
/*!*********************************************************!*\
  !*** ../assets/dev/js/modules/imports/utils/masonry.js ***!
  \*********************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");

var _viewModule = _interopRequireDefault(__webpack_require__(/*! ../view-module */ "../assets/dev/js/modules/imports/view-module.js"));

module.exports = _viewModule.default.extend({
  getDefaultSettings: function () {
    return {
      container: null,
      items: null,
      columnsCount: 3,
      verticalSpaceBetween: 30
    };
  },
  getDefaultElements: function () {
    return {
      $container: jQuery(this.getSettings('container')),
      $items: jQuery(this.getSettings('items'))
    };
  },
  run: function () {
    var heights = [],
        distanceFromTop = this.elements.$container.position().top,
        settings = this.getSettings(),
        columnsCount = settings.columnsCount;
    distanceFromTop += parseInt(this.elements.$container.css('margin-top'), 10);
    this.elements.$items.each(function (index) {
      var row = Math.floor(index / columnsCount),
          $item = jQuery(this),
          itemHeight = $item[0].getBoundingClientRect().height + settings.verticalSpaceBetween;

      if (row) {
        var itemPosition = $item.position(),
            indexAtRow = index % columnsCount,
            pullHeight = itemPosition.top - distanceFromTop - heights[indexAtRow];
        pullHeight -= parseInt($item.css('margin-top'), 10);
        pullHeight *= -1;
        $item.css('margin-top', pullHeight + 'px');
        heights[indexAtRow] += itemHeight;
      } else {
        heights.push(itemHeight);
      }
    });
  }
});

/***/ }),

/***/ "../assets/dev/js/modules/imports/utils/scroll.js":
/*!********************************************************!*\
  !*** ../assets/dev/js/modules/imports/utils/scroll.js ***!
  \********************************************************/
/***/ ((__unused_webpack_module, exports) => {

"use strict";


Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

// Moved from elementor pro: 'assets/dev/js/frontend/utils'
class Scroll {
  /**
   * @param {object} obj
   * @param {number} obj.sensitivity - Value between 0-100 - Will determine the intersection trigger points on the element
   * @param {function} obj.callback - Will be triggered on each intersection point between the element and the viewport top/bottom
   * @param {string} obj.offset - Offset between the element intersection points and the viewport, written like in CSS: '-50% 0 -25%'
   * @param {HTMLElement} obj.root - The element that the events will be relative to, if 'null' will be relative to the viewport
   */
  static scrollObserver(obj) {
    let lastScrollY = 0; // Generating threshholds points along the animation height
    // More threshholds points = more trigger points of the callback

    const buildThreshholds = (sensitivityPercentage = 0) => {
      const threshholds = [];

      if (sensitivityPercentage > 0 && sensitivityPercentage <= 100) {
        const increment = 100 / sensitivityPercentage;

        for (let i = 0; i <= 100; i += increment) {
          threshholds.push(i / 100);
        }
      } else {
        threshholds.push(0);
      }

      return threshholds;
    };

    const options = {
      root: obj.root || null,
      rootMargin: obj.offset || '0px',
      threshold: buildThreshholds(obj.sensitivity)
    };

    function handleIntersect(entries, observer) {
      const currentScrollY = entries[0].boundingClientRect.y,
            isInViewport = entries[0].isIntersecting,
            intersectionScrollDirection = currentScrollY < lastScrollY ? 'down' : 'up',
            scrollPercentage = Math.abs(parseFloat((entries[0].intersectionRatio * 100).toFixed(2)));
      obj.callback({
        sensitivity: obj.sensitivity,
        isInViewport,
        scrollPercentage,
        intersectionScrollDirection
      });
      lastScrollY = currentScrollY;
    }

    return new IntersectionObserver(handleIntersect, options);
  }
  /**
   * @param {jQuery Element} $element
   * @param {object} offsetObj
   * @param {number} offsetObj.start - Offset start value in percentages
   * @param {number} offsetObj.end - Offset end value in percentages
   */


  static getElementViewportPercentage($element, offsetObj = {}) {
    const elementOffset = $element[0].getBoundingClientRect(),
          offsetStart = offsetObj.start || 0,
          offsetEnd = offsetObj.end || 0,
          windowStartOffset = window.innerHeight * offsetStart / 100,
          windowEndOffset = window.innerHeight * offsetEnd / 100,
          y1 = elementOffset.top - window.innerHeight,
          y2 = elementOffset.top + windowStartOffset + $element.height(),
          startPosition = 0 - y1 + windowStartOffset,
          endPosition = y2 - y1 + windowEndOffset,
          percent = Math.max(0, Math.min(startPosition / endPosition, 1));
    return parseFloat((percent * 100).toFixed(2));
  }
  /**
   * @param {object} offsetObj
   * @param {number} offsetObj.start - Offset start value in percentages
   * @param {number} offsetObj.end - Offset end value in percentages
   * @param {number} limitPageHeight - Will limit the page height calculation
   */


  static getPageScrollPercentage(offsetObj = {}, limitPageHeight) {
    const offsetStart = offsetObj.start || 0,
          offsetEnd = offsetObj.end || 0,
          initialPageHeight = limitPageHeight || document.documentElement.scrollHeight - document.documentElement.clientHeight,
          heightOffset = initialPageHeight * offsetStart / 100,
          pageRange = initialPageHeight + heightOffset + initialPageHeight * offsetEnd / 100,
          scrollPos = document.documentElement.scrollTop + document.body.scrollTop + heightOffset;
    return scrollPos / pageRange * 100;
  }

}

exports["default"] = Scroll;

/***/ }),

/***/ "../assets/dev/js/modules/imports/view-module.js":
/*!*******************************************************!*\
  !*** ../assets/dev/js/modules/imports/view-module.js ***!
  \*******************************************************/
/***/ ((module, __unused_webpack_exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");

var _module = _interopRequireDefault(__webpack_require__(/*! ./module */ "../assets/dev/js/modules/imports/module.js"));

module.exports = _module.default.extend({
  elements: null,
  getDefaultElements: function () {
    return {};
  },
  bindEvents: function () {},
  onInit: function () {
    this.initElements();
    this.bindEvents();
  },
  initElements: function () {
    this.elements = this.getDefaultElements();
  }
});

/***/ }),

/***/ "../assets/dev/js/modules/modules.js":
/*!*******************************************!*\
  !*** ../assets/dev/js/modules/modules.js ***!
  \*******************************************/
/***/ ((__unused_webpack_module, exports, __webpack_require__) => {

"use strict";


var _interopRequireDefault = __webpack_require__(/*! @babel/runtime/helpers/interopRequireDefault */ "../node_modules/@babel/runtime/helpers/interopRequireDefault.js");

Object.defineProperty(exports, "__esModule", ({
  value: true
}));
exports["default"] = void 0;

var _module = _interopRequireDefault(__webpack_require__(/*! ./imports/module */ "../assets/dev/js/modules/imports/module.js"));

var _viewModule = _interopRequireDefault(__webpack_require__(/*! ./imports/view-module */ "../assets/dev/js/modules/imports/view-module.js"));

var _argsObject = _interopRequireDefault(__webpack_require__(/*! ./imports/args-object */ "../assets/dev/js/modules/imports/args-object.js"));

var _masonry = _interopRequireDefault(__webpack_require__(/*! ./imports/utils/masonry */ "../assets/dev/js/modules/imports/utils/masonry.js"));

var _scroll = _interopRequireDefault(__webpack_require__(/*! ./imports/utils/scroll */ "../assets/dev/js/modules/imports/utils/scroll.js"));

var _forceMethodImplementation = _interopRequireDefault(__webpack_require__(/*! ./imports/force-method-implementation */ "../assets/dev/js/modules/imports/force-method-implementation.js"));

var _default = window.elementorModules = {
  Module: _module.default,
  ViewModule: _viewModule.default,
  ArgsObject: _argsObject.default,
  ForceMethodImplementation: _forceMethodImplementation.default,
  utils: {
    Masonry: _masonry.default,
    Scroll: _scroll.default
  }
};

exports["default"] = _default;

/***/ })

},
/******/ __webpack_require__ => { // webpackRuntimeModules
/******/ var __webpack_exec__ = (moduleId) => (__webpack_require__(__webpack_require__.s = moduleId))
/******/ var __webpack_exports__ = (__webpack_exec__("../assets/dev/js/frontend/modules.js"));
/******/ }
]);
//# sourceMappingURL=frontend-modules.js.map