! function($) {
    function initAudioPlayer() {
        function t(audioPath, thumbPath, autoplay) {
            var i = thumbPath,
                e = autoplay,
                s = "",
                o = "",
                r = "",
                l = "";
            e.length > 0 && "true" == e && (w.autoplay = !0), s.length > 0 && "false" == s && $("div.share-button").remove(), o.length > 0 && "false" == o && $("div.sound").remove(), r.length > 0 && "false" == r && $("div.repeat").remove(), l.length > 0 && "false" == l && $("div.shuffle").remove(), i.length > 0 && $("div.dsap .blur").css({
                filter: "blur(" + i + ")",
                "-webkit-filter": "blur(" + i + ")",
                "-ms-filter": "blur(" + i + ")",
                "-o-filter": "blur(" + i + ")",
                "-moz-filter": "blur(" + i + ")"
            });


            k.push(audioPath);
            var t = thumbPath;
            $(".p2 ul").append("<li class='list' id='row" + k.length + "'>   <div class='lB'><div class='listNum'><span>" + n(k.length) + "</span></div><p class='title'>" + m("temp", 15) + "</p><p class='singer'>" + m("temp", 20) + "</p></div><div class='rB'><div class='artwork' style='background: url(" + t + ") no-repeat'></div><p class='duration'><span class='cur'>00:00</span><span class='slash'> / </span><span class='due'>00:00</span></p><div class='res'>" + h("temp", "apple") + h("temp", "amazon") + d("temp", audioPath) + "</div></div></li>"), $("li#row" + k.length + " .lB .title").attr("data-title", "temp"), $("li#row" + k.length + " .lB .singer").attr("data-artist", "temp")

            u(), a()
        }

        function i(t) {
            w.src = t, w.play(), $(O).css("background-image", "url(/assets/audio-player/img/pause.png)")
        }

        function e(t) {
            return x = Math.floor(Math.random() * t + 0), C == x ? e(t) : C = x, C
        }

        function s(t) {
            var i = Math.floor(t / 60),
                e = Math.floor(t - 60 * i);
            return 10 > e && (e = "0" + e), 10 > i && (i = "0" + i), i + ":" + e
        }

        function n(t) {
            return 10 > t && (t = "0" + t), t
        }

        function a() {
            w.src = S;
            var t = k.length;
            t > q && (w.src = k[q], $(w).on("loadedmetadata", function() {
                $("li#row" + (q + 1) + " .rB .duration .due").html(s(w.duration)), q++, $(this).off("loadedmetadata"), a()
            }))
        }

        function o() {
            k.length <= A + 1 ? (S = k[0], A = k.indexOf(S), T = A + 1) : (S = k[A + 1], A = k.indexOf(S), T = A + 1), i(S), l(A + 1)
        }

        function r() {
            $("#row" + T + " .rB .duration .cur").css({
                display: "none"
            }), $("#row" + T + " .rB .duration .slash").css({
                display: "none"
            })
        }

        function l(t) {
            t = "row" + t;
            var i = $("#" + t + " .rB .artwork").css("background-image");
            $(".blur").css("background-image", i);
            var e = $("#" + t + " .lB .title").attr("data-title");
            $(".tracTit").html(m(e, 27));
            var s = $("#" + t + " .lB .singer").attr("data-artist");
            $(".tracSin").html(m(s, 27))
        }

        function h(t, i) {
            var e = t.length > 0;
            return e && "apple" == i ? "<a href='" + t + "' class='apple' target='_blank' title='Listen it on Apple Music'></a>" : e && "amazon" == i ? "<a href='" + t + "' class='amazon' target='_blank' title='Listen it on Amazon'></a>" : " "
        }

        function d(t, i) {
            return "true" === t ? "<a href='" + i + "' class='download' target='_blank' title='Downlod it' download></a>" : " "
        }

        function u() {
            var t, i = window.location.hash;
            if (i.length > 0) var t = i.substr(4);
            t >= 0 && t < k.length ? (t = parseInt(t), S = k[t], A = k.indexOf(S), T = A + 1, w.src = S, l(A + 1), $(O).css("background-image", "url(/assets/audio-player/img/pause.png)"), w.autoplay = !0) : (S = k[0], A = k.indexOf(S), T = A + 1, w.src = S, l(A + 1))
        }

        function c() {
            var t = window.location.toString();
            return t = t.replace(/(#mp-[^#\s]+)/, ""), t = t + "#mp-" + A
        }

        function p(t) {
            var i = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(t);
            $("li.social-facebook").find("a").attr("href", i)
        }

        function f(t) {
            var i = "https://twitter.com/home?status=" + encodeURIComponent(t);
            $("li.social-twitter").find("a").attr("href", i)
        }

        function _(t) {
            var i = "https://plus.google.com/share?url=" + encodeURIComponent(t);
            $("li.social-gplus").find("a").attr("href", i)
        }

        function v(t) {
            var i = $("li#row" + T + " .lB .singer").attr("data-artist"),
                e = $("li#row" + T + " .lB .title").attr("data-title"),
                s = e + " by " + i,
                n = "Check out the track " + e + " by " + i + " on " + t,
                a = "mailto:?subject=" + s + "&body=" + n;
            $(".social-email > a").on("click", function(t) {
                t.preventDefault(), window.location = a
            })
        }

        function g() {
            $(".social-networks").hasClass("open-menu") && $(".social-networks").removeClass("open-menu")
        }

        function m(t, i) {
            var e = t.length;
            return e > i ? t.substring(0, i - 1) + "..." : t
        }

        function b() {
            var t = w.currentTime * (100 / w.duration);
            $("#slider").roundSlider("option", "value", t)
        }

        function y(t) {
            var i = t.value;
            $("#slider").roundSlider("option", "value", i), seekto = w.duration * (i / 100), w.currentTime = seekto
        }
        $(".dsap").append('<div class="blur"></div><div class="mS"> <div class="p1"> <div class="middle"><div class="play"><div id="slider"></div><div class="plpusbt"></div></div> </div> </div> <div class="p2" style="display:none"> <ul></ul> </div> <div class="p3" style="display:none"> </div> </div> </div>');
        var w, k, S, A, T, C, E, O, B, V;
        k = [], O = $(".plpusbt"), B = $(".frw"), V = $(".bkw"), E = !1;
        window.location.hash;
        w = new Audio, w.loop = !1;
        var audioPath = $(".dsap").attr("data-audio");
        var thumbPath = $(".dsap").attr("data-thumbnail");
        var autoplay = $(".dsap").attr("data-autoplay");

        t(audioPath, thumbPath, autoplay)

        O.on("click tap", function() {
            g(), w.paused ? (w.play(), $(this).css("background-image", "url(/assets/audio-player/img/pause.png)")) : (w.pause(), $(this).css("background-image", "url(/assets/audio-player/img/play.png)"))
        }), B.on("click", function() {
            g(), r(), $("#row" + T + " .lB .title .eq").remove(), o()
        }), V.on("click", function() {
            g(), r(), $("#row" + T + " .lB .title .eq").remove(), 0 >= A ? (S = k[k.length - 1], A = k.indexOf(S), T = A + 1) : (S = k[A - 1], A = k.indexOf(S), T = A + 1), i(S), l(A + 1)
        }), $(".sound").on("click", function() {
            g(), w.muted ? (w.muted = !1, $(this).css("background-image", "url(/assets/audio-player/img/volume-high.png)")) : (w.muted = !0, $(this).css("background-image", "url(/assets/audio-player/img/volume-low.png)"))
        }), $(".repeat").on("click", function() {
            g(), $(this).toggleClass("active"), $(this).hasClass("active") ? (w.loop = !0, $(this).css({
                "background-color": "rgba(255,255,255,0.3)",
                "-webkit-transform": "rotate(180deg)",
                "-o-transform": "rotate(180deg)",
                "-ms-transform": "rotate(180deg)",
                "-moz-transform": "rotate(180deg)",
                transform: "rotate(180deg)"
            })) : (w.loop = !1, $(this).css({
                "background-color": "transparent",
                "-webkit-transform": "rotate(0)",
                "-o-transform": "rotate(0)",
                "-ms-transform": "rotate(0)",
                "-moz-transform": "rotate(0)",
                transform: "rotate(0)"
            }), $(this).css("-webkit-transform", ""))
        }), $(".shuffle").on("click", function() {
            g(), $(this).toggleClass("active"), $(this).hasClass("active") ? (E = !0, $(this).css("background-color", "rgba(255,255,255,0.3)")) : (E = !1, $(this).css("background-color", "transparent"))
        }), $("div.p2").on("click", "ul li", function(t) {
            if (g(), "A" != t.target.nodeName) {
                r(), $("#row" + T + " .lB .title .eq").remove();
                var e = parseInt($(this).attr("id").substr(3), 10);
                A = e - 1, S = k[A], T = A + 1, i(S), l(A + 1)
            }
        }), $(".share-button").on("click", function() {
            var t = c();
            p(t), f(t), _(t), v(t)
        }), $(".play").hover(function() {
            g()
        }), $(w).on("ended", function() {
            /*if ($("#row" + T + " .lB .title .eq").remove(), this.loop) this.play();
            else if (E) {
                r();
                var t = e(k.length);
                A = t, S = k[t], T = A + 1, this.src = S, this.play(), l(A + 1)
            } else O.css("background-image", "url(img/play.png)"), r(), o()*/
            O.css("background-image", "url(/assets/audio-player/img/play.png)")
        }), $(w).on("timeupdate", function() {
            $(".middle .play .fTim").html(s(this.currentTime) + " / " + s(this.duration)), $("#row" + T + " .rB .duration .cur").html(s(this.currentTime)), $("#row" + T + " .rB .duration .cur").css({
                display: "inline"
            }), $("#row" + T + " .rB .duration .slash").css({
                display: "inline"
            }), b()
        }), $(w).on("playing", function() {
            $(O).css("background-image", "url(/assets/audio-player/img/pause.png)");
            var t = parseInt(A, 10) + 1,
                i = $("#row" + t + " .lB .title");
            i.find("div").hasClass("eq") || i.append("<div class='eq'><div class='bar1'></div><div class='bar2'></div><div class='bar3'></div></div>")
        }), $(w).on("pause", function() {
            $("#row" + T + " .lB .title .eq").remove()
        });
        var q = 0;
        $(w).off("loadedmetadata"), $(window).keypress(function(t) {
            //(0 === t.keyCode || 32 === t.keyCode) && (t.preventDefault(), w.paused ? (w.play(), $(O).css("background-image", "url(/assets/audio-player/img/pause.png)")) : (w.pause(), $(O).css("background-image", "url(/assets/audio-player/img/play.png)")))
        }), $("#slider").roundSlider({
            width: 8,
            radius: "70",
            handleSize: "15,15",
            value: 0,
            max: "100",
            startAngle: 90,
            step: "0.005",
            showTooltip: !1,
            editableTooltip: !1,
            sliderType: "min-range",
            drag: function(t) {
                y(t)
            },
            change: function(t) {
                y(t)
            }
        }), $(".social-toggle").on("click", function() {
            $(this).next().toggleClass("open-menu")
        }), $("div.grid-button").on("click", function() {
            g(), $(".grid").toggleClass("open close");
            var t = $(".mS > div:visible");
            if ("none" == $("div.p2").css("display")) var i = $("div.p2");
            else var i = $("div.p1");
            t.fadeOut(500, function() {
                i.fadeIn(500)
            })
        })
    }! function($, window, undefined) {
        "use strict";

        function $proxy(t, i) {
            return "function" == typeof $.proxy ? $.proxy(t, i) : function(e) {
                t.call(i, e)
            }
        }

        function $data(t, i, e) {
            return "function" == typeof $.data ? $.data(t, i, e) : e ? void 0 : $(t).hasClass("rs-control")
        }

        function $isPlainObject(t) {
            if ("function" == typeof $.isPlainObject) return $.isPlainObject(t);
            var i = JSON.stringify(t);
            return "object" == typeof t && t.length === undefined && i.length > 2 && "{" === i.substr(0, 1) && "}" === i.substr(i.length - 1)
        }

        function isNumber(t) {
            return t = parseFloat(t), "number" == typeof t && !isNaN(t)
        }

        function createElement(t) {
            var i = t.split(".");
            return $(document.createElement(i[0])).addClass(i[1] || "")
        }

        function getdistance(t, i) {
            return Math.sqrt((t.x - i.x) * (t.x - i.x) + (t.y - i.y) * (t.y - i.y))
        }

        function setTransform(t, i) {
            return t.css("-webkit-transform", "rotate(" + i + "deg)"), t.css("-moz-transform", "rotate(" + i + "deg)"), t.css("-ms-transform", "rotate(" + i + "deg)"), t.css("-o-transform", "rotate(" + i + "deg)"), t.css("transform", "rotate(" + i + "deg)"), t
        }

        function RoundSlider(t, i) {
            t.id && (window[t.id] = this), this.control = $(t), this.options = $.extend({}, this.defaults, i), this._raise("beforeCreate") !== !1 ? (this._init(), this._raise("create")) : this._removeData()
        }

        function CreateRoundSlider(t, i) {
            for (var e, s, n = 0; n < this.length; n++)
                if (e = this[n], s = $data(e, pluginName)) {
                    if ($isPlainObject(t)) "function" == typeof s.option ? s.option(t) : e.id && window[e.id] && "function" == typeof window[e.id].option && window[e.id].option(t);
                    else if ("string" == typeof t && "function" == typeof s[t]) {
                        if (("option" == t || t.startsWith("get")) && i[2] === undefined) return s[t](i[1]);
                        s[t](i[1], i[2])
                    }
                } else $data(e, pluginName, new RoundSlider(e, t));
            return this
        }
        var pluginName = "roundSlider";
        $.fn[pluginName] = function(t) {
            return CreateRoundSlider.call(this, t, arguments)
        }, RoundSlider.prototype = {
            pluginName: pluginName,
            version: "1.0",
            options: {},
            defaults: {
                min: 0,
                max: 100,
                step: 1,
                value: null,
                radius: 85,
                width: 18,
                handleSize: "+0",
                startAngle: 0,
                endAngle: "+360",
                animation: !0,
                showTooltip: !0,
                editableTooltip: !0,
                readOnly: !1,
                disabled: !1,
                keyboardAction: !0,
                mouseScrollAction: !1,
                sliderType: "default",
                circleShape: "full",
                handleShape: "round",
                beforeCreate: null,
                create: null,
                start: null,
                drag: null,
                change: null,
                stop: null,
                tooltipFormat: null
            },
            _props: function() {
                return {
                    numberType: ["min", "max", "step", "radius", "width", "startAngle"],
                    booleanType: ["animation", "showTooltip", "editableTooltip", "readOnly", "disabled", "keyboardAction", "mouseScrollAction"],
                    stringType: ["sliderType", "circleShape", "handleShape"]
                }
            },
            control: null,
            _init: function() {
                this._initialize(), this._update(), this._render()
            },
            _initialize: function() {
                this._isBrowserSupport = this._isBrowserSupported(), this._isBrowserSupport && (this._originalObj = this.control.clone(), this._isReadOnly = !1, this._checkDataType(), this._refreshCircleShape())
            },
            _render: function() {
                if (this.container = createElement("div.rs-container"), this.innerContainer = createElement("div.rs-inner-container"), this.block = createElement("div.rs-block rs-outer rs-border"), this.container.append(this.innerContainer.append(this.block)), this.control.addClass("rs-control").empty().append(this.container), this._setRadius(), this._isBrowserSupport) this._createLayers(), this._setProperties(), this._setValue(), this._bindControlEvents("_bind"), this._checkIE();
                else {
                    var t = createElement("div.rs-msg");
                    t.html("function" == typeof this._throwError ? this._throwError() : this._throwError), this.control.empty().addClass("rs-error").append(t)
                }
            },
            _update: function() {
                this._validateSliderType(), this._updateStartEnd(), this._validateStartEnd(), this._handle1 = this._handle2 = this._handleDefaults(), this._analyzeModelValue(), this._validateModelValue()
            },
            _createLayers: function() {
                var t, i = this.options.width,
                    e = this._start;
                t = createElement("div.rs-path rs-transition"), this._rangeSlider || this._showRange ? (this.block1 = t.clone().addClass("rs-range-color").rsRotate(e), this.block2 = t.clone().addClass("rs-range-color").css("opacity", "0").rsRotate(e), this.block3 = t.clone().addClass("rs-path-color").rsRotate(e), this.block4 = t.addClass("rs-path-color").css({
                    opacity: "1",
                    "z-index": "1"
                }).rsRotate(e - 180), this.block.append(this.block1, this.block2, this.block3, this.block4).addClass("rs-split")) : this.block.append(t.addClass("rs-path-color")), this.lastBlock = createElement("span.rs-block").css({
                    padding: i
                }), this.innerBlock = createElement("div.rs-inner rs-bg-color rs-border"), this.lastBlock.append(this.innerBlock), this.block.append(this.lastBlock), this._appendHandle(), this._appendOverlay(), this._appendHiddenField()
            },
            _setProperties: function() {
                this._prechange = this._predrag = this.options.value, this._setHandleShape(), this._addAnimation(), this._appendTooltip(), this.options.showTooltip || this._removeTooltip(), this.options.disabled ? this.disable() : this.options.readOnly && this._readOnly(!0), this.options.mouseScrollAction && this._bindScrollEvents("_bind")
            },
            _setValue: function() {
                if (this._rangeSlider) this._setHandleValue(1), this._setHandleValue(2);
                else {
                    this._showRange && this._setHandleValue(1);
                    var t = "default" == this.options.sliderType ? this._active || 1 : parseFloat(this.bar.children().attr("index"));
                    this._setHandleValue(t)
                }
            },
            _appendTooltip: function() {
                0 === this.container.children(".rs-tooltip").length && (this.tooltip = createElement("span.rs-tooltip rs-tooltip-text"), this.container.append(this.tooltip), this._tooltipEditable(), this._updateTooltip())
            },
            _removeTooltip: function() {
                0 != this.container.children(".rs-tooltip").length && this.tooltip && this.tooltip.remove()
            },
            _tooltipEditable: function() {
                if (this.tooltip && this.options.showTooltip) {
                    var t;
                    this.options.editableTooltip ? (this.tooltip.addClass("edit"), t = "_bind") : (this.tooltip.removeClass("edit"), t = "_unbind"), this[t](this.tooltip, "click", this._editTooltip)
                }
            },
            _editTooltip: function() {
                this.tooltip.hasClass("edit") && !this._isReadOnly && (this.input = createElement("input.rs-input rs-tooltip-text").css({
                    height: this.tooltip.outerHeight(),
                    width: this.tooltip.outerWidth()
                }), this.tooltip.html(this.input).removeClass("edit").addClass("hover"), this.input.val(this._getTooltipValue(!0)).focus(), this._bind(this.input, "blur", this._focusOut), this._bind(this.input, "change", this._focusOut))
            },
            _focusOut: function(t) {
                "change" == t.type ? (this.options.value = this.input.val().replace("-", ","), this._analyzeModelValue(), this._validateModelValue(), this._setValue(), this.input.val(this._getTooltipValue(!0))) : this.tooltip.addClass("edit").removeClass("hover"), this._raiseEvent("change")
            },
            _setHandleShape: function() {
                var t = this.options.handleShape;
                this._handles().removeClass("rs-handle-dot rs-handle-square"), "dot" == t ? this._handles().addClass("rs-handle-dot") : "square" == t ? this._handles().addClass("rs-handle-square") : this.options.handleShape = this.defaults.handleShape
            },
            _setHandleValue: function(t) {
                this._active = t;
                var i = this["_handle" + t];
                "min-range" != this.options.sliderType && (this.bar = this._activeHandleBar()), this._changeSliderValue(i.value, i.angle)
            },
            _setAnimation: function() {
                this.options.animation ? this._addAnimation() : this._removeAnimation()
            },
            _addAnimation: function() {
                this.options.animation && this.control.addClass("rs-animation")
            },
            _removeAnimation: function() {
                this.control.removeClass("rs-animation")
            },
            _setRadius: function() {
                var t, i, e = this.options.radius,
                    s = 2 * e,
                    n = this.options.circleShape,
                    a = s,
                    o = s;
                if (this.container.removeClass().addClass("rs-container"), 0 === n.indexOf("half")) {
                    switch (n) {
                        case "half-top":
                        case "half-bottom":
                            a = e, o = s;
                            break;
                        case "half-left":
                        case "half-right":
                            a = s, o = e
                    }
                    this.container.addClass(n.replace("half-", "") + " half")
                } else 0 === n.indexOf("quarter") ? (a = o = e, t = n.split("-"), this.container.addClass(t[0] + " " + t[1] + " " + t[2])) : this.container.addClass("full " + n);
                i = {
                    height: a,
                    width: o
                }, this.control.css(i), this.container.css(i)
            },
            _border: function() {
                return 2 * parseFloat(this.block.css("border-top-width"))
            },
            _appendHandle: function() {
                (this._rangeSlider || !this._showRange) && this._createHandle(1), (this._rangeSlider || this._showRange) && this._createHandle(2), this._startLine = this._addSeperator(this._start, "rs-start"), this._endLine = this._addSeperator(this._start + this._end, "rs-end")
            },
            _addSeperator: function(t, i) {
                var e = createElement("span.rs-seperator").css({
                        width: this.options.width,
                        "margin-left": this._border() / 2
                    }),
                    s = createElement("span.rs-bar rs-transition " + i).append(e).rsRotate(t);
                return this.container.append(s), s
            },
            _updateSeperator: function() {
                this._startLine.rsRotate(this._start), this._endLine.rsRotate(this._start + this._end)
            },
            _createHandle: function(t) {
                var i, e = createElement("div.rs-handle rs-move");
                e.attr({
                    index: t,
                    tabIndex: "0"
                });
                var s = this.control[0].id,
                    s = s ? s + "_" : "",
                    n = s + "handle" + ("range" == this.options.sliderType ? "_" + (1 == t ? "start" : "end") : "");
                return e.attr({
                    role: "slider",
                    "aria-label": n
                }), i = createElement("div.rs-bar rs-transition").css("z-index", "4").append(e).rsRotate(this._start), i.addClass("range" == this.options.sliderType && 2 == t ? "rs-second" : "rs-first"), this.container.append(i), this._refreshHandle(), this.bar = i, this._active = t, 1 != t && 2 != t && (this["_handle" + t] = this._handleDefaults()), this._bind(e, "focus", this._handleFocus), this._bind(e, "blur", this._handleBlur), e
            },
            _refreshHandle: function() {
                var hSize = this.options.handleSize,
                    h, w, isSquare = !0,
                    s, diff;
                if ("string" == typeof hSize && isNumber(hSize))
                    if ("+" === hSize.charAt(0) || "-" === hSize.charAt(0)) try {
                        hSize = eval(this.options.width + hSize.charAt(0) + Math.abs(parseFloat(hSize)))
                    } catch (e) {
                        console.warn(e)
                    } else hSize.indexOf(",") && (s = hSize.split(","), isNumber(s[0]) && isNumber(s[1]) && (w = parseFloat(s[0]), h = parseFloat(s[1]), isSquare = !1));
                isSquare && (h = w = isNumber(hSize) ? parseFloat(hSize) : this.options.width), diff = (this.options.width + this._border() - w) / 2, this._handles().css({
                    height: h,
                    width: w,
                    margin: -h / 2 + "px 0 0 " + diff + "px"
                })
            },
            _handleDefaults: function() {
                return {
                    angle: this._valueToAngle(this.options.min),
                    value: this.options.min
                }
            },
            _handles: function() {
                return this.container.children("div.rs-bar").find(".rs-handle")
            },
            _activeHandleBar: function() {
                return $(this.container.children("div.rs-bar")[this._active - 1])
            },
            _handleArgs: function() {
                var t = this["_handle" + this._active];
                return {
                    element: this._activeHandleBar().children(),
                    index: this._active,
                    value: t ? t.value : null,
                    angle: t ? t.angle : null
                }
            },
            _raiseEvent: function(t) {
                return this._updateTooltip(), "change" == t && this._updateHidden(), this["_pre" + t] !== this.options.value ? (this["_pre" + t] = this.options.value, this._raise(t, {
                    value: this.options.value,
                    handle: this._handleArgs()
                })) : void 0
            },
            _elementDown: function(t) {
                var i, e, s, n, a;
                if (!this._isReadOnly)
                    if (i = $(t.target), i.hasClass("rs-handle")) this._handleDown(t);
                    else {
                        var o = this._getXY(t),
                            r = this._getCenterPoint(),
                            l = getdistance(o, r),
                            h = this.block.outerWidth() / 2,
                            d = h - (this.options.width + this._border());
                        l >= d && h >= l && (t.preventDefault(), e = this.control.find(".rs-handle.rs-focus"), this.control.attr("tabindex", "0").focus().removeAttr("tabindex"), s = this._getAngleValue(o, r), n = s.angle, a = s.value, this._rangeSlider && (e = this.control.find(".rs-handle.rs-focus"), this._active = 1 == e.length ? parseFloat(e.attr("index")) : this._handle2.value - a < a - this._handle1.value ? 2 : 1, this.bar = this._activeHandleBar()), this._changeSliderValue(a, n), this._raiseEvent("change"))
                    }
            },
            _handleDown: function(t) {
                t.preventDefault();
                var i = $(t.target);
                i.focus(), this._removeAnimation(), this._bindMouseEvents("_bind"), this.bar = i.parent(), this._active = parseFloat(i.attr("index")), this._handles().removeClass("rs-move"), this._raise("start", {
                    handle: this._handleArgs()
                })
            },
            _handleMove: function(t) {
                t.preventDefault();
                var i, e, s = this._getXY(t),
                    n = this._getCenterPoint(),
                    a = this._getAngleValue(s, n);
                i = a.angle, e = a.value, this._changeSliderValue(e, i), this._raiseEvent("drag")
            },
            _handleUp: function() {
                this._handles().addClass("rs-move"), this._bindMouseEvents("_unbind"), this._addAnimation(), this._raiseEvent("change"), this._raise("stop", {
                    handle: this._handleArgs()
                })
            },
            _handleFocus: function(t) {
                if (!this._isReadOnly) {
                    var i = $(t.target);
                    this._handles().removeClass("rs-focus"), i.addClass("rs-focus"), this.bar = i.parent(), this._active = parseFloat(i.attr("index")), this.options.keyboardAction && (this._bindKeyboardEvents("_unbind"), this._bindKeyboardEvents("_bind")), this.control.find("div.rs-bar").css("z-index", "4"), this.bar.css("z-index", "5")
                }
            },
            _handleBlur: function() {
                this._handles().removeClass("rs-focus"), this.options.keyboardAction && this._bindKeyboardEvents("_unbind")
            },
            _handleKeyDown: function(t) {
                var i, e, s, n;
                this._isReadOnly || (i = t.keyCode, 27 == i && this._handles().blur(), i >= 35 && 40 >= i && (i >= 37 && 40 >= i && this._removeAnimation(), e = this["_handle" + this._active], t.preventDefault(), 38 == i || 37 == i ? s = this._round(this._limitValue(e.value + this.options.step)) : 39 == i || 40 == i ? s = this._round(this._limitValue(e.value - this._getMinusStep(e.value))) : 36 == i ? s = this._getKeyValue("Home") : 35 == i && (s = this._getKeyValue("End")), n = this._valueToAngle(s), this._changeSliderValue(s, n), this._raiseEvent("change")))
            },
            _handleKeyUp: function() {
                this._addAnimation()
            },
            _getMinusStep: function(t) {
                if (t == this.options.max) {
                    var i = (this.options.max - this.options.min) % this.options.step;
                    return 0 == i ? this.options.step : i
                }
                return this.options.step
            },
            _getKeyValue: function(t) {
                return this._rangeSlider ? "Home" == t ? 1 == this._active ? this.options.min : this._handle1.value : 1 == this._active ? this._handle2.value : this.options.max : "Home" == t ? this.options.min : this.options.max
            },
            _elementScroll: function(t) {
                if (!this._isReadOnly) {
                    t.preventDefault();
                    var i, e, s, n, a = t.originalEvent || t;
                    n = a.wheelDelta ? a.wheelDelta / 60 : a.detail ? -a.detail / 2 : 0, 0 != n && (this._updateActiveHandle(t), i = this["_handle" + this._active], e = i.value + (n > 0 ? this.options.step : -this._getMinusStep(i.value)), e = this._limitValue(e), s = this._valueToAngle(e), this._removeAnimation(), this._changeSliderValue(e, s), this._raiseEvent("change"), this._addAnimation())
                }
            },
            _updateActiveHandle: function(t) {
                var i = $(t.target);
                i.hasClass("rs-handle") && i.parent().parent()[0] == this.control[0] && (this.bar = i.parent(), this._active = parseFloat(i.attr("index"))), this.bar.find(".rs-handle").hasClass("rs-focus") || this.bar.find(".rs-handle").focus()
            },
            _bindControlEvents: function(t) {
                this[t](this.control, "mousedown", this._elementDown), this[t](this.control, "touchstart", this._elementDown)
            },
            _bindScrollEvents: function(t) {
                this[t](this.control, "mousewheel", this._elementScroll), this[t](this.control, "DOMMouseScroll", this._elementScroll)
            },
            _bindMouseEvents: function(t) {
                this[t]($(document), "mousemove", this._handleMove), this[t]($(document), "mouseup", this._handleUp), this[t]($(document), "mouseleave", this._handleUp), this[t]($(document), "touchmove", this._handleMove), this[t]($(document), "touchend", this._handleUp), this[t]($(document), "touchcancel", this._handleUp)
            },
            _bindKeyboardEvents: function(t) {
                this[t]($(document), "keydown", this._handleKeyDown), this[t]($(document), "keyup", this._handleKeyUp)
            },
            _changeSliderValue: function(t, i) {
                var e = this._oriAngle(i),
                    s = this._limitAngle(i);
                if (this._rangeSlider || this._showRange) {
                    if (1 == this._active && e <= this._oriAngle(this._handle2.angle) || 2 == this._active && e >= this._oriAngle(this._handle1.angle)) {
                        this["_handle" + this._active] = {
                            angle: i,
                            value: t
                        }, this.options.value = this._rangeSlider ? this._handle1.value + "," + this._handle2.value : t, this.bar.rsRotate(s), this._updateARIA(t);
                        var n = this._oriAngle(this._handle2.angle) - this._oriAngle(this._handle1.angle),
                            a = "1",
                            o = "0";
                        180 >= n && (a = "0", o = "1"), this.block2.css("opacity", a), this.block3.css("opacity", o), (1 == this._active ? this.block4 : this.block2).rsRotate(s - 180), (1 == this._active ? this.block1 : this.block3).rsRotate(s)
                    }
                } else this["_handle" + this._active] = {
                    angle: i,
                    value: t
                }, this.options.value = t, this.bar.rsRotate(s), this._updateARIA(t)
            },
            _updateARIA: function(t) {
                var i, e = this.options.min,
                    s = this.options.max;
                this.bar.children().attr({
                    "aria-valuenow": t
                }), "range" == this.options.sliderType ? (i = this._handles(), i.eq(0).attr({
                    "aria-valuemin": e
                }), i.eq(1).attr({
                    "aria-valuemax": s
                }), 1 == this._active ? i.eq(1).attr({
                    "aria-valuemin": t
                }) : i.eq(0).attr({
                    "aria-valuemax": t
                })) : this.bar.children().attr({
                    "aria-valuemin": e,
                    "aria-valuemax": s
                })
            },
            _getXY: function(t) {
                return -1 == t.type.indexOf("mouse") && (t = (t.originalEvent || t).changedTouches[0]), {
                    x: t.pageX,
                    y: t.pageY
                }
            },
            _getCenterPoint: function() {
                var t = this.block.offset();
                return {
                    x: t.left + this.block.outerWidth() / 2,
                    y: t.top + this.block.outerHeight() / 2
                }
            },
            _getAngleValue: function(t, i) {
                var e = Math.atan2(t.y - i.y, i.x - t.x),
                    s = -e / (Math.PI / 180);
                return s < this._start && (s += 360), s = this._checkAngle(s), this._processStepByAngle(s)
            },
            _checkAngle: function(t) {
                var i, e = this._oriAngle(t);
                return e > this._end && (i = this._oriAngle(this["_handle" + this._active].angle), t = this._start + (i <= this._end - i ? 0 : this._end)), t
            },
            _processStepByAngle: function(t) {
                var i = this._angleToValue(t);
                return this._processStepByValue(i)
            },
            _processStepByValue: function(t) {
                var i, e, s, n, a, o, r = this.options.step;
                return i = (t - this.options.min) % r, e = t - i, s = this._limitValue(e + r), n = this._limitValue(e - r), a = t >= e ? s - t > t - e ? e : s : e - t > t - n ? e : n, a = this._round(a), o = this._valueToAngle(a), {
                    value: a,
                    angle: o
                }
            },
            _round: function(t) {
                var i = this.options.step.toString().split(".");
                return i[1] ? parseFloat(t.toFixed(i[1].length)) : Math.round(t)
            },
            _oriAngle: function(t) {
                var i = t - this._start;
                return 0 > i && (i += 360), i
            },
            _limitAngle: function(t) {
                return t > 360 + this._start && (t -= 360), t < this._start && (t += 360), t
            },
            _limitValue: function(t) {
                return t < this.options.min && (t = this.options.min), t > this.options.max && (t = this.options.max), t
            },
            _angleToValue: function(t) {
                var i = this.options;
                return this._oriAngle(t) / this._end * (i.max - i.min) + i.min
            },
            _valueToAngle: function(t) {
                var i = this.options;
                return (t - i.min) / (i.max - i.min) * this._end + this._start
            },
            _appendHiddenField: function() {
                this._hiddenField = createElement("input").attr({
                    type: "hidden",
                    name: this.control[0].id || "",
                    value: this.options.value
                }), this.control.append(this._hiddenField)
            },
            _updateHidden: function() {
                this._hiddenField.val(this.options.value)
            },
            _updateTooltip: function() {
                this.tooltip && !this.tooltip.hasClass("hover") && this.tooltip.html(this._getTooltipValue()), this._updateTooltipPos()
            },
            _updateTooltipPos: function() {
                this.tooltip && this.tooltip.css(this._getTooltipPos())
            },
            _getTooltipPos: function() {
                var t, i = this.options.circleShape;
                if ("full" == i || "pie" == i || 0 === i.indexOf("custom")) return {
                    "margin-top": -this.tooltip.outerHeight() / 2,
                    "margin-left": -this.tooltip.outerWidth() / 2
                };
                if (-1 != i.indexOf("half")) {
                    switch (i) {
                        case "half-top":
                        case "half-bottom":
                            t = {
                                "margin-left": -this.tooltip.outerWidth() / 2
                            };
                            break;
                        case "half-left":
                        case "half-right":
                            t = {
                                "margin-top": -this.tooltip.outerHeight() / 2
                            }
                    }
                    return t
                }
                return {}
            },
            _getTooltipValue: function(t) {
                if (this._rangeSlider) {
                    var i = this.options.value.split(",");
                    return t ? i[0] + " - " + i[1] : this._tooltipValue(i[0]) + " - " + this._tooltipValue(i[1])
                }
                return t ? this.options.value : this._tooltipValue(this.options.value)
            },
            _tooltipValue: function(t) {
                var i = this._raise("tooltipFormat", {
                    value: t,
                    handle: this._handleArgs()
                });
                return null != i && "boolean" != typeof i ? i : t
            },
            _validateStartAngle: function() {
                var t = this.options.startAngle;
                return t = (isNumber(t) ? parseFloat(t) : 0) % 360, 0 > t && (t += 360), this.options.startAngle = t, t
            },
            _validateEndAngle: function() {
                var end = this.options.endAngle;
                if ("string" == typeof end && isNumber(end) && ("+" === end.charAt(0) || "-" === end.charAt(0))) try {
                    end = eval(this.options.startAngle + end.charAt(0) + Math.abs(parseFloat(end)))
                } catch (e) {
                    console.warn(e)
                }
                return end = (isNumber(end) ? parseFloat(end) : 360) % 360, end <= this.options.startAngle && (end += 360), end
            },
            _refreshCircleShape: function() {
                var t, i = this.options.circleShape,
                    e = ["half-top", "half-bottom", "half-left", "half-right", "quarter-top-left", "quarter-top-right", "quarter-bottom-right", "quarter-bottom-left", "pie", "custom-half", "custom-quarter"]; - 1 == e.indexOf(i) && (t = ["h1", "h2", "h3", "h4", "q1", "q2", "q3", "q4", "3/4", "ch", "cq"].indexOf(i), i = -1 != t ? e[t] : "half" == i ? "half-top" : "quarter" == i ? "quarter-top-left" : "full"), this.options.circleShape = i
            },
            _appendOverlay: function() {
                var t = this.options.circleShape;
                "pie" == t ? this._checkOverlay(".rs-overlay", 270) : ("custom-half" == t || "custom-quarter" == t) && (this._checkOverlay(".rs-overlay1", 180), "custom-quarter" == t && this._checkOverlay(".rs-overlay2", this._end))
            },
            _checkOverlay: function(t, i) {
                var e = this.container.children(t);
                0 == e.length && (e = createElement("div" + t + " rs-transition rs-bg-color"), this.container.append(e)), e.rsRotate(this._start + i)
            },
            _checkDataType: function() {
                var t, i, e, s = this.options,
                    n = this._props();
                for (t in n.numberType) i = n.numberType[t], e = s[i], s[i] = isNumber(e) ? parseFloat(e) : this.defaults[i];
                for (t in n.booleanType) i = n.booleanType[t], e = s[i], s[i] = "false" == e ? !1 : !!e;
                for (t in n.stringType) i = n.stringType[t], e = s[i], s[i] = ("" + e).toLowerCase()
            },
            _validateSliderType: function() {
                var t = this.options.sliderType.toLowerCase();
                this._rangeSlider = this._showRange = !1, "range" == t ? this._rangeSlider = this._showRange = !0 : -1 != t.indexOf("min") ? (this._showRange = !0, t = "min-range") : t = "default", this.options.sliderType = t
            },
            _updateStartEnd: function() {
                var t = this.options.circleShape;
                "full" != t && (-1 != t.indexOf("quarter") ? this.options.endAngle = "+90" : -1 != t.indexOf("half") ? this.options.endAngle = "+180" : "pie" == t && (this.options.endAngle = "+270"), "quarter-top-left" == t || "half-top" == t ? this.options.startAngle = 0 : "quarter-top-right" == t || "half-right" == t ? this.options.startAngle = 90 : "quarter-bottom-right" == t || "half-bottom" == t ? this.options.startAngle = 180 : ("quarter-bottom-left" == t || "half-left" == t) && (this.options.startAngle = 270))
            },
            _validateStartEnd: function() {
                this._start = this._validateStartAngle(), this._end = this._validateEndAngle();
                var t = this._start < this._end ? 0 : 360;
                this._end += t - this._start
            },
            _analyzeModelValue: function() {
                var t, i, e = this.options.value,
                    s = this.options.min,
                    n = this.options.max,
                    a = "string" == typeof e ? e.split(",") : [e];
                this._rangeSlider ? i = "string" == typeof e ? a.length >= 2 ? (isNumber(a[0]) ? a[0] : s) + "," + (isNumber(a[1]) ? a[1] : n) : isNumber(a[0]) ? s + "," + a[0] : s + "," + s : isNumber(e) ? s + "," + e : s + "," + s : "string" == typeof e ? (t = a.pop(), i = isNumber(t) ? parseFloat(t) : s) : i = isNumber(e) ? parseFloat(e) : s, this.options.value = i
            },
            _validateModelValue: function() {
                var t, i = this.options.value;
                if (this._rangeSlider) {
                    var e = i.split(","),
                        s = parseFloat(e[0]),
                        n = parseFloat(e[1]);
                    s = this._limitValue(s), n = this._limitValue(n), s > n && (n = s), this._handle1 = this._processStepByValue(s), this._handle2 = this._processStepByValue(n), this.options.value = this._handle1.value + "," + this._handle2.value
                } else t = this._showRange ? 2 : this._active || 1, this["_handle" + t] = this._processStepByValue(this._limitValue(i)), this._showRange && (this._handle1 = this._handleDefaults()), this.options.value = this["_handle" + t].value
            },
            _isBrowserSupported: function() {
                for (var t = ["borderRadius", "WebkitBorderRadius", "MozBorderRadius", "OBorderRadius", "msBorderRadius", "KhtmlBorderRadius"], i = 0; i < t.length; i++)
                    if (document.body.style[t[i]] !== undefined) return !0
            },
            _throwError: function() {
                return "This browser doesn't support the border-radious property."
            },
            _checkIE: function() {
                var t = window.navigator.userAgent;
                (t.indexOf("MSIE ") >= 0 || t.indexOf("Trident/") >= 0) && this.control.css({
                    "-ms-touch-action": "none",
                    "touch-action": "none"
                })
            },
            _raise: function(t, i) {
                var e = this.options[t],
                    s = !0;
                return i = i || {}, e && (i.type = t, "string" == typeof e && (e = window[e]), $.isFunction(e) && (s = e.call(this, i), s = s === !1 ? !1 : s)), this.control.trigger($.Event ? $.Event(t, i) : t), s
            },
            _bind: function(t, i, e) {
                $(t).bind(i, $proxy(e, this))
            },
            _unbind: function(t, i, e) {
                $.proxy ? $(t).unbind(i, $.proxy(e, this)) : $(t).unbind(i)
            },
            _getInstance: function() {
                return $data(this.control[0], pluginName)
            },
            _removeData: function() {
                var t = this.control[0];
                $.removeData && $.removeData(t, pluginName), t.id && delete window[t.id]
            },
            _destroyControl: function() {
                this.control.empty().removeClass("rs-control").height("").width(""), this._removeAnimation(), this._bindControlEvents("_unbind")
            },
            _updateWidth: function() {
                this.lastBlock.css("padding", this.options.width), this._refreshHandle()
            },
            _readOnly: function(t) {
                this._isReadOnly = t, this.container.removeClass("rs-readonly"), t && this.container.addClass("rs-readonly")
            },
            _get: function(t) {
                return this.options[t]
            },
            _set: function(t, i) {
                var e = this._props();
                if (-1 != $.inArray(t, e.numberType)) {
                    if (!isNumber(i)) return;
                    i = parseFloat(i)
                } else -1 != $.inArray(t, e.booleanType) ? i = "false" == i ? !1 : !!i : -1 != $.inArray(t, e.stringType) && (i = i.toLowerCase());
                if (this.options[t] != i) {
                    switch (this.options[t] = i, t) {
                        case "startAngle":
                        case "endAngle":
                            this._validateStartEnd(), this._updateSeperator(), this._appendOverlay();
                        case "min":
                        case "max":
                        case "step":
                        case "value":
                            this._analyzeModelValue(), this._validateModelValue(), this._setValue(), this._updateHidden(), this._updateTooltip();
                            break;
                        case "radius":
                            this._setRadius(), this._updateTooltipPos();
                            break;
                        case "width":
                            this._removeAnimation(), this._updateWidth(), this._updateTooltipPos(), this._addAnimation(), this.container.children().find(".rs-seperator").css({
                                width: this.options.width,
                                "margin-left": this._border() / 2
                            });
                            break;
                        case "handleSize":
                            this._refreshHandle();
                            break;
                        case "handleShape":
                            this._setHandleShape();
                            break;
                        case "animation":
                            this._setAnimation();
                            break;
                        case "showTooltip":
                            this.options.showTooltip ? this._appendTooltip() : this._removeTooltip();
                            break;
                        case "editableTooltip":
                            this._tooltipEditable(), this._updateTooltipPos();
                            break;
                        case "disabled":
                            this.options.disabled ? this.disable() : this.enable();
                            break;
                        case "readOnly":
                            this.options.readOnly ? this._readOnly(!0) : !this.options.disabled && this._readOnly(!1);
                            break;
                        case "mouseScrollAction":
                            this._bindScrollEvents(this.options.mouseScrollAction ? "_bind" : "_unbind");
                            break;
                        case "circleShape":
                            this._refreshCircleShape(), "full" == this.options.circleShape && (this.options.startAngle = 0, this.options.endAngle = "+360");
                        case "sliderType":
                            this._destroyControl(), this._init()
                    }
                    return this
                }
            },
            option: function(t, i) {
                if (this._getInstance() && this._isBrowserSupport) {
                    if ($isPlainObject(t)) {
                        (t.min !== undefined || t.max !== undefined) && (t.min !== undefined && (this.options.min = t.min, delete t.min), t.max !== undefined && (this.options.max = t.max, delete t.max), t.value == undefined && this._set("value", this.options.value));
                        for (var e in t) this._set(e, t[e])
                    } else if (t && "string" == typeof t) {
                        if (i === undefined) return this._get(t);
                        this._set(t, i)
                    }
                    return this
                }
            },
            getValue: function(t) {
                if ("range" == this.options.sliderType && t && isNumber(t)) {
                    var i = parseFloat(t);
                    if (1 == i || 2 == i) return this["_handle" + i].value
                }
                return this._get("value")
            },
            setValue: function(t, i) {
                if (t && isNumber(t)) {
                    if (i && isNumber(i))
                        if ("range" == this.options.sliderType) {
                            var e = parseFloat(i),
                                s = parseFloat(t);
                            1 == e ? t = s + "," + this._handle2.value : 2 == e && (t = this._handle1.value + "," + s)
                        } else "default" == this.options.sliderType && (this._active = i);
                    this._set("value", t)
                }
            },
            disable: function() {
                this.options.disabled = !0, this.container.addClass("rs-disabled"), this._readOnly(!0)
            },
            enable: function() {
                this.options.disabled = !1, this.container.removeClass("rs-disabled"), this.options.readOnly || this._readOnly(!1)
            },
            destroy: function() {
                this._getInstance() && (this._destroyControl(), this._removeData(), this._originalObj.insertAfter(this.control), this.control.remove())
            }
        }, $.fn.rsRotate = function(t) {
            return setTransform(this, t)
        }, "undefined" == typeof $.fn.outerHeight && ($.fn.outerHeight = function() {
            return this[0].offsetHeight
        }, $.fn.outerWidth = function() {
            return this[0].offsetWidth
        }), "undefined" == typeof $.fn.hasClass && ($.fn.hasClass = function(t) {
            return -1 !== this[0].className.split(" ").indexOf(t)
        }), "undefined" == typeof $.fn.offset && ($.fn.offset = function() {
            return {
                left: this[0].offsetLeft,
                top: this[0].offsetTop
            }
        }), $.fn[pluginName].prototype = RoundSlider.prototype
    }(jQuery, window), $(document).ready(function() {
        initAudioPlayer()
    }), $(".social-toggle").on("click", function() {
        $(this).next().toggleClass("open-menu")
    })
}(jQuery);