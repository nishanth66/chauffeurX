/*
 * Copyright (c) 2018 Bob Hageman (https://gitlab.com/b.hageman)
 * Licensed under the MIT (http://www.opensource.org/licenses/mit-license)
 *
 * Version 1.0.3
 */
!function (o, t, e, i) {
    "use strict";
    var n = "pinlogin", s = {
        fields: 5, placeholder: "•", autofocus: !0, hideinput: !0, reset: !0, complete: function (t) {
        }, invalid: function (t, e) {
        }, keydown: function (t, e, i) {
        }, input: function (t, e, i) {
        }
    };

    function a(t, e) {
        this.element = t, this.settings = o.extend({}, s, e), this._defaults = s, this._name = n, this.init()
    }

    o.extend(a.prototype, {
        init: function () {
            this._values = new Array(this.settings.fields), this._container = o("<div />").prop({
                id: this._name,
                class: this._name
            });
            for (var t = 0; t < this.settings.fields; t++) {
                var e = this._createInput(this._getFieldId(t), t);
                this._attachEvents(e, t), this._container.append(e)
            }
            o(this.element).append(this._container), this.reset()
        }, _createInput: function (t, e) {
            return o("<input>").prop({
                type: "tel",
                id: t,
                name: t,
                maxlength: 1,
                inputmode: "numeric",
                "x-inputmode": "numeric",
                pattern: "^[0-9]*$",
                autocomplete: "off",
                class: "pinlogin-field"
            })
        }, _attachEvents: function (t, n) {
            var s = this;
            t.on("focus", o.proxy(function (t) {
                o(this).val("")
            })), t.on("blur", o.proxy(function (t) {
                !o(this).is("[readonly]") && null != s._values[n] && s.settings.hideinput && o(this).val(s.settings.placeholder)
            })), t.on("input", o.proxy(function (t) {
                var e = new RegExp(o(this).prop("pattern"));
                if (!o(this).val().match(e)) return o(this).val("").addClass("invalid"), s.settings.invalid(o(this), n), t.preventDefault(), void t.stopPropagation();
                if (o(this).removeClass("invalid"), s.settings.input(t, o(this), n), s._values[n] = o(this).val(), s.settings.hideinput && o(this).val(s.settings.placeholder), n < s.settings.fields - 1) s._getField(n + 1).removeProp("readonly"), s.focus(n + 1); else {
                    var i = s._values.join("");
                    s.settings.reset && s.reset(), s.settings.complete(i)
                }
            })), t.on("keydown", o.proxy(function (t) {
                s.settings.keydown(t, o(this), n), (37 == t.keyCode || 8 == t.keyCode) && 0 < n && (s.resetField(n), s.focus(n - 1), t.preventDefault(), t.stopPropagation())
            }))
        }, _getFieldId: function (t) {
            return this.element.id + "_" + this._name + "_" + t
        }, _getField: function (t) {
            return o("#" + this._getFieldId(t))
        }, focus: function (t) {
            this.enableField(t), this._getField(t).focus()
        }, reset: function () {
            this._values = new Array(this.settings.fields), this._container.children("input").each(function (t) {
                o(this).val(""), 0 < t && o(this).prop("readonly", !0).removeClass("invalid")
            }), this.settings.autofocus && this.focus(0)
        }, resetField: function (t) {
            this._values[t] = "", this._getField(t).val("").prop("readonly", !0).removeClass("invalid")
        }, disable: function () {
            this._container.children("input").each(function (t) {
                o(this).prop("readonly", !0)
            })
        }, disableField: function (t) {
            this._getField(t).prop("readonly", !0)
        }, enable: function () {
            this._container.children("input").each(function (t) {
                o(this).prop("readonly", !1)
            })
        }, enableField: function (t) {
            this._getField(t).prop("readonly", !1)
        }
    }), o.fn[n] = function (t) {
        var e;
        return this.each(function () {
            (e = o.data(this, "plugin_" + n)) || (e = new a(this, t), o.data(this, "plugin_" + n, e))
        }), e
    }
}(jQuery, window, document);