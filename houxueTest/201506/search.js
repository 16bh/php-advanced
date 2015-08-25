/**
 * Created by Administrator on 2015/6/25.
 */
M.define("search", function (a) {
    var b = function (c) {
        this.init(c)
    };
    M.object.merge(b.prototype, {
        init: function (c) {
            c.searchitempanel.checkFuncObj = {};
            c.searchitempanel.checkFuncObj.func = this.reload;
            c.searchitempanel.checkFuncObj.source = this;
            if (c.searchlist && c.searchlist.data && c.searchlist.data.shopInfo) {
                this.shopInit(c.searchlist.data.shopInfo)
            } else {
                $("#shopMain").attr("search_land_searchTransformation_show", "true")
            }
            c.searchlist.listUrl = "/ware/searchList.action";
            c.searchlist.buriedPointVal = "search";
            this.searchList = new (M.exports("searchlist").clazz)(c.searchlist);
            this.searchItemPanel = new (M.exports("searchitempanel").clazz)(c.searchitempanel);
            this.searchLand = new (M.exports("searchland").clazz)({
                showFuncObj: {
                    source: this, func: function () {
                        var d = this;
                        d.searchList.closeLoad();
                        $("#layout_jdBar").hide();
                        $("#layout_urlblack").hide();
                        $("#layout_clear_keyword").show();
                        $("#layout_search_submit").show()
                    }
                },
                hideFuncObj: {
                    source: this, func: function () {
                        var d = this;
                        d.searchList.opendLoad();
                        $("#layout_urlblack").show();
                        $("#layout_clear_keyword").hide();
                        $("#layout_search_submit").hide()
                    }
                },
                claerKeywordBtnId: "layout_clear_keyword",
                keyword: c.searchland.keyword ? c.searchland.keyword : "",
                hotKeyword: c.searchland.hotKeyword ? c.searchland.hotKeyword : null,
                submitId: "layout_search_submit",
                formId: "layout_searchForm",
                catelogyListId: "layout_category",
                keywordId: "layout_newkeyword",
                isHome: false,
                closeSearchLandBtnId: "layout_search_bar_cancel",
                searchPanelId: "layout_search_head"
            });
            this.sort = "";
            this.integrativeOpen = false
        }, closeMask: function () {
            var c = this;
            $("#integrative-menu").removeClass("show");
            $("#integrative-menu").hide();
            $("#integrative-mask").css({height: "0px;", "margin-top": "0px;"});
            c.integrativeOpen = false;
            c.searchList.opendLoad()
        }, openMask: function () {
            var c = this;
            $("#integrative-menu").addClass("show");
            $("#integrative-menu").show();
            $("#integrative-mask").css({height: $("#list").height() + "px", "margin-top": "108px"});
            c.integrativeOpen = true;
            c.searchList.closeLoad()
        }, integrativeMenu: function (d, f, e) {
            var c = this;
            $("#integrative-menu").children().removeClass("active");
            d && $(d).addClass("active") & $("#sales-volume-order").removeClass("active") & $("#prcie-order").removeClass("active") & $("#prcie-order").children().removeClass("arrow-down") & $("#prcie-order").children().removeClass("arrow-up") & $("#integrative").addClass("active");
            f && $("#integrative").find("a").text(f);
            c.closeMask();
            if (c.sort != e) {
                c.sort = e;
                c.reload(true)
            }
        }, bind: function () {
            var c = this;
            $("#screening").on("click", function () {
                c.searchItemPanel.keepBefore();
                c.searchItemPanel.show();
                $("#integrative-menu").removeClass("show");
                $("#integrative-menu").hide();
                $("#integrative-mask").css({height: "0px;", "margin-top": "0px;"});
                c.integrativeOpen = false;
                c.searchList.opendLoad()
            });
            $("#integrative-mask").on("click", function () {
                if (c.searchList.isReloadHasData()) {
                    $("#integrative-menu").removeClass("show");
                    $("#integrative-menu").hide();
                    $("#integrative-mask").css({height: "0px;", "margin-top": "0px;"});
                    c.integrativeOpen = false;
                    c.searchList.opendLoad()
                }
            });
            $("#sales-volume-order").on("click", function () {
                if (c.searchList.isReloadHasData()) {
                    if (!$(this).hasClass("active")) {
                        $(this).addClass("active");
                        $("#integrative").removeClass("active");
                        $("#prcie-order").removeClass("active");
                        $("#prcie-order").children().removeClass("arrow-down");
                        $("#prcie-order").children().removeClass("arrow-up");
                        c.integrativeMenu(null, null, "1")
                    }
                }
            });
            $("#prcie-order").on("click", function () {
                if (c.searchList.isReloadHasData()) {
                    if (!$(this).children().hasClass("arrow-down")) {
                        $(this).addClass("active");
                        $(this).children().addClass("arrow-down");
                        $(this).children().removeClass("arrow-up");
                        c.integrativeMenu(null, null, "3")
                    } else {
                        $(this).addClass("active");
                        $(this).children().addClass("arrow-up");
                        $(this).children().removeClass("arrow-down");
                        c.integrativeMenu(null, null, "2")
                    }
                    $("#integrative").removeClass("active");
                    $("#sales-volume-order").removeClass("active")
                }
            });
            $("#integrative").on("click", function () {
                if (c.searchList.isReloadHasData()) {
                    if (c.integrativeOpen) {
                        c.closeMask()
                    } else {
                        c.openMask()
                    }
                }
            });
            $("#comprehensive-order").on("click", function () {
                if (c.searchList.isReloadHasData()) {
                    c.integrativeMenu(this, "综合", "")
                }
            });
            $("#new-product-order").on("click", function () {
                if (c.searchList.isReloadHasData()) {
                    c.integrativeMenu(this, "新品", "5")
                }
            });
            $("#comment-order").on("click", function () {
                if (c.searchList.isReloadHasData()) {
                    c.integrativeMenu(this, "评论数", "6")
                }
            })
        }, clearOrder: function () {
            var c = this;
            $("#integrative-menu").children().removeClass("active");
            $("#sales-volume-order").removeClass("active");
            $("#prcie-order").removeClass("active");
            $("#prcie-order").children().removeClass("arrow-down");
            $("#prcie-order").children().removeClass("arrow-up");
            $("#integrative").addClass("active");
            $("#integrative").find("a").text("综合");
            c.sort = ""
        }, reload: function (e) {
            var d = this;
            var c = d.searchItemPanel.getValue();
            c = c ? c : {};
            if (!e) {
                d.clearOrder()
            }
            c.sort = d.sort;
            d.searchList.reload(c)
        }, shopInit: function (c) {
            $("#shopUrl").attr("href", "http://ok.jd.com/m/index-" + c.shopId + ".htm");
            $("#shopUrl").attr("report-eventparam", c.shopId);
            $("#shopName").text(c.shopName);
            $("#shopLogo").attr("src", c.logoUrl);
            $("#shopScore").css("width", (c.score * 10) + "%");
            $("#shopMain").show()
        }, render: function () {
            var c = this;
            c.searchItemPanel.render();
            c.searchList.render();
            c.searchLand.render();
            c.bind()
        }, run: function () {
            var c = this;
            c.render()
        }
    });
    a.clazz = b
});
M.define("searchitem", function (b) {
    var a = function (c) {
        this.init(c)
    };
    M.object.merge(a.prototype, {
        init: function (k) {
            this.btnGroup = [];
            var c = k.itemArray ? k.itemArray : [];
            this.selection = k.selection ? true : false;
            this.key = k.key ? k.key : null;
            this.outTextId = k.outTextId ? k.outTextId : null;
            this.classfly = k.classfly ? k.classfly : "";
            this.searchitemGroupIdBase = "m_searchitem_";
            var f = k.checkItem ? k.checkItem : null;
            this.value = [];
            this.beforeValue = [];
            if (c.length > 0) {
                for (var g = 0; g < c.length; g++) {
                    var n = this.getGroupByName(c[g].itemName);
                    if (n == null) {
                        n = {
                            groupName: "",
                            btnLsit: [],
                            groupId: M.genId(this.searchitemGroupIdBase),
                            btnId: M.genId(this.searchitemGroupIdBase)
                        };
                        this.btnGroup.push(n);
                        n.groupName = c[g].itemName
                    }
                    var l = c[g].termList;
                    if (l.length > 0) {
                        var d = this.getBtnSet(n.btnLsit, l[0].sign);
                        if (d == null) {
                            d = {sign: l[0].sign, list: []};
                            n.btnLsit.push(d)
                        }
                        for (var e = 0; e < l.length; e++) {
                            var p = {text: l[e].text, value: l[e].value, otherAttr: l[e].otherAttr};
                            if (f && f.length > 0) {
                                for (var m = 0; m < f.length; m++) {
                                    if (f[m] == l[e].value) {
                                        p.secondChange = true;
                                        break
                                    }
                                }
                            }
                            var h = new (M.exports("searchitembutton").clazz)(p);
                            d.list.push(h)
                        }
                        if (this.key == "price") {
                            var h = new (M.exports("searchiteminput").clazz)({
                                firstText: "起始价格",
                                secondText: "终止价格",
                                firstName: "min",
                                secondName: "max",
                                isNum: true,
                                checkBtnFunc: function () {
                                    var j = this;
                                    var q = $.trim($("#" + j.firstId).val());
                                    var i = $.trim($("#" + j.secondId).val());
                                    if (q && i && M.string.isUnsignedNumeric(q) && M.string.isUnsignedNumeric(i) && q != i && q >= 0 && i >= 0) {
                                        return true
                                    }
                                    alert("您输入的内容不符合规格");
                                    return false
                                },
                                textCallFunc: function () {
                                    var i = this;
                                    var j = null;
                                    if ($.trim($("#" + i.firstId).val()) && $.trim($("#" + i.secondId).val())) {
                                        j = $.trim($("#" + i.firstId).val()) + "-" + $.trim($("#" + i.secondId).val())
                                    }
                                    return j
                                }
                            });
                            d.list.push(h)
                        }
                    }
                }
            }
            var o = [];
            M.object.each(k.otherAttr, function (j, i) {
                o.push(j)
            });
            this.othersText = o.join(",")
        }, keepBefore: function () {
            var k = this;
            k.beforeValue = k.value;
            for (var d = 0, l = k.btnGroup.length; d < l; d++) {
                for (var c = 0, f = k.btnGroup[d].btnLsit.length; c < f; c++) {
                    var h = k.btnGroup[d].btnLsit[c].list;
                    for (var e = 0; e < h.length; e++) {
                        h[e].keepBefore()
                    }
                }
            }
        }, reBefore: function () {
            var c = this;
            c.value = c.beforeValue;
            for (var h = 0, e = c.btnGroup.length; h < e; h++) {
                for (var f = 0, d = c.btnGroup[h].btnLsit.length; f < d; f++) {
                    var l = c.btnGroup[h].btnLsit[f].list;
                    for (var k = 0; k < l.length; k++) {
                        l[k].reBefore()
                    }
                }
            }
            var m = c.getText();
            var n = m.join(",");
            if (n == "") {
                n = "全部"
            }
            $("#" + c.outTextId).text(n)
        }, html: function () {
            var c = this;
            var n = [];
            var d = [];
            var k = [];
            var e = [];
            for (var m = 0; m < c.btnGroup.length; m++) {
                if (c.btnGroup[m].groupName != "" && c.btnGroup[m].btnLsit.length > 0) {
                    d.push(c.btnGroup[m].groupName)
                }
            }
            if (d.length > 0) {
                k.push('<ul><li class="brand-tab">');
                for (var m = 0; m < d.length; m++) {
                    k.push('<label id="' + c.getGroupByName(d[m]).groupId + '" class="' + (m == 0 ? "current" : "") + '">' + d[m] + "</label>")
                }
                k.push('</li"></ul>')
            }
            for (var m = 0; m < c.btnGroup.length; m++) {
                var p = c.btnGroup[m].btnLsit;
                if (p.length > 0) {
                    e.push('<ul id="' + c.btnGroup[m].btnId + '" class="tab-con brand" style="' + (m == 0 ? "" : "display: none;") + '">');
                    for (var l = 0; l < p.length; l++) {
                        var h = p[l];
                        if (h.list.length > 0) {
                            if (h.sign != "") {
                                e.push('<li class="letter"><span>' + h.sign + "</span></li>")
                            }
                            for (var o = 0; o < h.list.length; o++) {
                                var f = h.list[o];
                                e.push(f.html())
                            }
                        }
                    }
                    e.push("</ul>")
                }
            }
            n = n.concat(['<div style="height:0px;overflow-y:auto;">'], k, e, ["</div>"]);
            return n.join("")
        }, bind: function (e, o, n) {
            var c = this;
            for (var k = 0; k < c.btnGroup.length; k++) {
                if (c.btnGroup[k].groupName != "") {
                    var f = c.btnGroup[k].groupId;
                    $("#" + f).on("click", function () {
                        c.groupBind($(this).attr("id"))
                    })
                }
                var p = c.btnGroup[k].btnLsit;
                for (var h = 0; h < p.length; h++) {
                    var d = p[h];
                    var m = d.list;
                    for (var l = 0; l < m.length; l++) {
                        m[l].bind(e, o, n)
                    }
                }
            }
        }, groupBind: function (f) {
            var g = this;
            for (var e = 0; e < g.btnGroup.length; e++) {
                if (f == g.btnGroup[e].groupId) {
                    $("#" + f).addClass("current");
                    $("#" + g.btnGroup[e].btnId).show();
                    var d = 5;
                    var h = $("#" + g.btnGroup[e].btnId).find(".letter").length;
                    var c = $("#" + g.btnGroup[e].btnId).find("li").length - h;
                    d = d + h * 25 + c * 45 + 45;
                    if (d > 365) {
                        d = 365
                    }
                    $("#" + g.btnGroup[e].btnId).parent().css("height", d)
                } else {
                    $("#" + g.btnGroup[e].groupId).removeClass("current");
                    $("#" + g.btnGroup[e].btnId).hide()
                }
            }
        }, cancelBtn: function (o, e) {
            var d = e.getId();
            for (var f = 0, c = o.btnLsit.length; f < c; f++) {
                var p = o.btnLsit;
                for (var l = 0, k = p.length; l < k; l++) {
                    var n = p[l].list;
                    for (var i = 0, m = n.length; i < m; i++) {
                        if (e.getId() != n[i].getId()) {
                            n[i].cancel(false)
                        }
                    }
                }
            }
        }, getGroupByName: function (f) {
            var e = this;
            var c = null;
            for (var d = 0; d < e.btnGroup.length; d++) {
                if (e.btnGroup[d].groupName == f) {
                    c = e.btnGroup[d];
                    break
                }
            }
            return c
        }, getGroupByBtnId: function (f) {
            var c = this;
            var e = null;
            for (var k = 0; k < c.btnGroup.length; k++) {
                var n = c.btnGroup[k].btnLsit;
                for (var h = 0; h < n.length; h++) {
                    var d = n[h];
                    var m = d.list;
                    for (var l = 0; l < m.length; l++) {
                        if (f == m[l].getId()) {
                            e = c.btnGroup[k];
                            break
                        }
                    }
                    if (e != null) {
                        break
                    }
                }
                if (e != null) {
                    break
                }
            }
            return e
        }, getBtnSet: function (f, c) {
            var d = null;
            for (var e = 0; e < f.length; e++) {
                if (f[e].btnSign == c) {
                    d = f[e];
                    break
                }
            }
            return d
        }, reValue: function () {
            var e = [];
            var c = this;
            for (var h = 0; h < c.btnGroup.length; h++) {
                var n = c.btnGroup[h].btnLsit;
                for (var f = 0; f < n.length; f++) {
                    var d = n[f];
                    var l = d.list;
                    for (var k = 0; k < l.length; k++) {
                        var m = l[k].getValue();
                        if (m != null) {
                            e.push(m)
                        }
                    }
                }
            }
            return e
        }, getValue: function () {
            var c = this;
            return c.value
        }, getText: function () {
            var e = [];
            var c = this;
            for (var h = 0; h < c.btnGroup.length; h++) {
                var n = c.btnGroup[h].btnLsit;
                for (var f = 0; f < n.length; f++) {
                    var d = n[f];
                    var l = d.list;
                    for (var k = 0; k < l.length; k++) {
                        var m = l[k].getText();
                        if (m != null) {
                            e.push(m)
                        }
                    }
                }
            }
            return e
        }, getKey: function () {
            var c = this;
            return c.key
        }, getClassfly: function () {
            var c = this;
            return c.classfly
        }, getOthersText: function () {
            var c = this;
            return c.othersText
        }, reAll: function () {
            var k = this;
            for (var d = 0, l = k.btnGroup.length; d < l; d++) {
                for (var c = 0, f = k.btnGroup[d].btnLsit.length; c < f; c++) {
                    var h = k.btnGroup[d].btnLsit[c].list;
                    for (var e = 0; e < h.length; e++) {
                        h[e].cancel(false)
                    }
                }
                $("#" + k.btnGroup[d].btnId).children().removeClass("checked")
            }
            k.value = [];
            $("#" + k.outTextId).text("全部")
        }
    });
    b.clazz = a
});
M.define("searchitembutton", function (b) {
    var a = function (c) {
        this.init(c)
    };
    M.object.merge(a.prototype, {
        init: function (d) {
            this.value = null;
            this.baseId = "";
            this.secondChange = d.secondChange ? d.secondChange : false;
            this.beforeSecondChange = false;
            if (d.value) {
                this.value = d.value
            }
            this.text = d.text ? d.text : "";
            this.baseId = d.id ? d.id : null;
            this.id = d.id ? M.genId("m_searchItembutton_" + d.id) : M.genId("m_searchItembutton_");
            var c = [];
            M.object.each(d.otherAttr, function (f, e) {
                c.push(f)
            });
            this.othersText = c.join(",")
        }, getType: function () {
            return "searchitembutton"
        }, keepBefore: function () {
            var c = this;
            c.beforeSecondChange = c.secondChange
        }, reBefore: function () {
            var c = this;
            if (c.secondChange != c.beforeSecondChange) {
                c.secondChange = c.beforeSecondChange;
                if (c.secondChange) {
                    $("#" + c.id).addClass("checked")
                } else {
                    $("#" + c.id).removeClass("checked")
                }
            }
        }, getText: function () {
            var c = this;
            if (c.secondChange) {
                return c.text
            } else {
                return null
            }
        }, getValue: function () {
            var c = this;
            if (c.secondChange) {
                return c.value
            } else {
                return null
            }
        }, getBaseId: function () {
            var c = this;
            return c.baseId
        }, getId: function () {
            var c = this;
            return c.id
        }, isCheck: function () {
            var c = this;
            return c.secondChange
        }, cancel: function (c) {
            var d = this;
            d.secondChange = false;
            if (c) {
                $("#" + d.id).removeClass("checked")
            }
        }, bind: function (g, f, d) {
            var h = this;
            $("#" + h.id).on("click", function () {
                if (!h.secondChange) {
                    h.secondChange = true;
                    $(this).addClass("checked")
                } else {
                    $(this).removeClass("checked");
                    h.secondChange = false
                }
                if (g && M.object.isFunction(g)) {
                    var i = [h];
                    if (d) {
                        i = [h].concat(d)
                    }
                    var j = f ? f : null;
                    g.apply(j, i)
                }
            });
            if (h.isCheck()) {
                if (g && M.object.isFunction(g)) {
                    var c = [h];
                    if (d) {
                        c = [h].concat(d)
                    }
                    var e = f ? f : null;
                    g.apply(e, c)
                }
            }
        }, html: function () {
            var d = this;
            var c = '<li id="' + d.id + '" class="' + (d.secondChange ? "checked" : "") + '"><i class="tick"></i><span>' + d.text + "</span>" + (d.othersText && d.othersText != "" ? ("<small>" + d.othersText + "</small>") : "") + "</li>";
            return c
        }
    });
    b.clazz = a
});
M.define("searchiteminput", function (a) {
    var b = function (c) {
        this.init(c)
    };
    M.object.merge(b.prototype, {
        init: function (c) {
            this.value = null;
            this.baseId = "";
            this.secondChange = false;
            this.beforeSecondChange = false;
            this.baseId = c.id ? c.id : null;
            this.id = c.id ? M.genId("m_searchiteminput_" + c.id) : M.genId("m_searchiteminput_");
            this.firstText = c.firstText ? c.firstText : "";
            this.secondText = c.secondText ? c.secondText : "";
            this.firstName = c.firstName ? c.firstName : M.genId("m_searchiteminput_");
            this.secondName = c.secondName ? c.secondName : M.genId("m_searchiteminput_");
            this.firstId = c.firstId ? c.firstId : M.genId("m_searchiteminput_");
            this.secondId = c.secondId ? c.secondId : M.genId("m_searchiteminput_");
            this.isNum = c.isNum ? c.isNum : true;
            this.checkId = M.genId("m_searchiteminput_");
            this.checkBtnFunc = c.checkBtnFunc ? c.checkBtnFunc : null;
            this.textCallFunc = c.textCallFunc ? c.textCallFunc : "";
            this.check = false;
            this.beforeCheck = false;
            this.beforefirstVal = "";
            this.beforeSecondVal = ""
        }, getType: function () {
            return "searchiteminput"
        }, keepBefore: function () {
            var c = this;
            c.beforefirstVal = $.trim($("#" + c.firstId).val());
            c.beforeSecondVal = $.trim($("#" + c.secondId).val())
        }, reBefore: function () {
            var c = this;
            $("#" + c.firstId).val(c.beforefirstVal);
            $("#" + c.secondId).val(c.beforeSecondVal)
        }, getText: function () {
            var c = this;
            return c.textCallFunc.call(c)
        }, getValue: function () {
            var c = this;
            return c.value
        }, getBaseId: function () {
            var c = this;
            return c.baseId
        }, getId: function () {
            var c = this;
            return c.id
        }, cancel: function () {
            var c = this;
            $("#" + c.firstId).val("");
            $("#" + c.secondId).val("");
            c.value = null
        }, bind: function (e, d, c) {
            var f = this;
            $("#" + f.checkId).on("click", function () {
                if (f.checkBtnFunc && M.object.isFunction(f.checkBtnFunc)) {
                    if (f.checkBtnFunc.call(f)) {
                        f.value = '{"' + f.firstName + '" : "' + $.trim($("#" + f.firstId).val()) + '", "' + f.secondName + '" : "' + $.trim($("#" + f.secondId).val()) + '"}'
                    } else {
                        f.value = null
                    }
                } else {
                    if ($.trim($("#" + f.firstId).val()) && $.trim($("#" + f.secondId).val())) {
                        f.value = '{"' + f.firstName + '" : "' + $.trim($("#" + f.firstId).val()) + '", "' + f.secondName + '" : "' + $.trim($("#" + f.secondId).val()) + '"}'
                    } else {
                        f.value = null
                    }
                }
                if (e && M.object.isFunction(e)) {
                    var g = [f];
                    if (c) {
                        g = [f].concat(c)
                    }
                    var h = d ? d : null;
                    e.apply(h, g)
                }
            })
        }, html: function () {
            var d = this;
            var c = [];
            c.push('<li id="' + d.id + '" class="">');
            c.push('<table class="price-range">');
            c.push("<tr>");
            c.push('<td><input class="adv-srch-num-inpt" id="' + d.firstId + '" maxlength="10" ' + (d.firstText ? 'placeholder="' + d.firstText + '"' : "") + " " + (d.isNum ? 'type="number" pattern="[0-9]*"' : "") + "></td>");
            c.push('<td><em class="dash"></em></td>');
            c.push('<td><input class="adv-srch-num-inpt" id="' + d.secondId + '" maxlength="10" ' + (d.secondText ? 'placeholder="' + d.secondText + '"' : "") + " " + (d.isNum ? 'type="number" pattern="[0-9]*"' : "") + "></td>");
            c.push('<td><button id="' + d.checkId + '" class="confirm">确定</button></td>');
            c.push("</tr>");
            c.push("</table>");
            c.push("</li>");
            return c.join("")
        }
    });
    a.clazz = b
});
M.define("searchitempanel", function (a) {
    var b = function (c) {
        this.init(c)
    };
    M.object.merge(b.prototype, {
        init: function (c) {
            this.baseId = c.id ? M.genId("m_searchutempanel_" + c.id) : M.genId("m_searchutempanel_");
            this.id = c.id ? M.genId("m_searchutempanel_" + c.id) : M.genId("m_searchutempanel_");
            this.baseLiId = this.id + "_li";
            this.categoriesId = M.genId(this.baseId + "_categories");
            this.reCheckId = M.genId(this.baseId + "_reCheckId");
            this.checkId = M.genId(this.baseId + "_checkId");
            this.shadowId = M.genId(this.baseId + "_shadowid");
            this.menuId = M.genId(this.baseId + "_menuid");
            this.categoriesTextId = M.genId(this.baseId + "_categoriesTextId");
            this.checkfuncObj = c.checkFuncObj;
            this.beforeCategoriesText = "";
            this.categories = [];
            this.others = [];
            this.isQq = navigator.userAgent.indexOf("MQQBrowser") >= 0;
            this.renderId = c.renderId;
            this.categoriesIdArray = [];
            this.othersIdArray = [];
            this.othersTextIdArray = [];
            this.searchRadioArray = [];
            this.searchSelectArray = [];
            c.searchItem && this.createSearchItemBtnGroupList(c.searchItem, c.checkItem);
            c.searchRadio && this.createSearchRadioArrayGroupList(c.searchRadio);
            c.searchSelect && this.createSearchSelectArrayGroupList(c.searchSelect)
        }, keepBefore: function () {
            var d = this;
            d.beforeCategoriesText = $("#" + d.categoriesTextId).text();
            for (var c = 0; d.searchRadioArray.length > c; c++) {
                d.searchRadioArray[c].keepBefore()
            }
            for (var c = 0; d.searchSelectArray.length > c; c++) {
                d.searchSelectArray[c].keepBefore()
            }
            for (var c = 0; d.categories.length > c; c++) {
                d.categories[c].keepBefore()
            }
            for (var c = 0; d.others.length > c; c++) {
                d.others[c].keepBefore()
            }
        }, reBefore: function () {
            var d = this;
            $("#" + d.categoriesTextId).text(d.beforeCategoriesText);
            for (var c = 0; d.searchRadioArray.length > c; c++) {
                d.searchRadioArray[c].reBefore()
            }
            for (var c = 0; d.searchSelectArray.length > c; c++) {
                d.searchSelectArray[c].reBefore()
            }
            for (var c = 0; d.categories.length > c; c++) {
                d.categories[c].reBefore()
            }
            for (var c = 0; d.others.length > c; c++) {
                d.others[c].reBefore()
            }
        }, createSearchItemBtnGroupList: function (g, e) {
            var h = this;
            var d = [];
            if (g && M.object.isArray(g) && g.length > 0) {
                for (var f = 0; f < g.length; f++) {
                    if (g[f].itemArray && g[f].itemArray.length > 0 && g[f].itemArray[0].termList && g[f].itemArray[0].termList.length > 0) {
                        if (g[f].key == "catelogyList") {
                            if (e && e.catelogyList && e.catelogyList.length > 0) {
                                g[f].checkItem = e.catelogyList
                            }
                            h.categories.push(new (M.exports("searchitem").clazz)(g[f]))
                        } else {
                            if (g[f].key == "expressionKey") {
                                g[f].selection = true
                            }
                            var c = M.genId(h.baseLiId);
                            h.othersTextIdArray.push(c);
                            g[f].outTextId = c;
                            h.others.push(new (M.exports("searchitem").clazz)(g[f]))
                        }
                    }
                }
            }
        }, createSearchRadioArrayGroupList: function (c) {
            var e = this;
            if (c && M.object.isArray(c) && c.length > 0) {
                for (var d = 0; d < c.length; d++) {
                    var f = new (M.exports("searchradio").clazz)(c[d]);
                    e.searchRadioArray.push(f)
                }
            }
        }, createSearchSelectArrayGroupList: function (c) {
            var e = this;
            if (c && M.object.isArray(c) && c.length > 0) {
                for (var d = 0; d < c.length; d++) {
                    var f = new (M.exports("searchselect").clazz)(c[d]);
                    e.searchSelectArray.push(f)
                }
            }
        }, html: function () {
            var e = this;
            var d = [];
            d.push('<div id="' + e.id + '" class="menu_sidebar" id="search-conditions">');
            d.push('<div id="' + e.shadowId + '" class="list_content_mask" style="display: none;"></div>');
            d.push('<div id="' + e.menuId + '" class="sidebar-content" style="-webkit-transform-origin: 0px 0px; opacity: 1; -webkit-transform: scale(1, 1);display: none;">');
            d.push('<div class="sidebar-header">');
            d.push('<div class="sidebar-header-right">');
            d.push('<span id="' + e.reCheckId + '" class="sidebar-btn-reset J_ping" report-eventid="MFilter_Reset" report-eventparam="">重置</span>');
            d.push('<span id="' + e.checkId + '" class="sidebar-btn-confirm J_ping" report-eventid="MFilter_Confirm" report-eventparam="">确定</span>');
            d.push("</div>");
            d.push('<div class="sidebar-header-left">');
            d.push('<div style="min-width:296px;">');
            for (var c = 0; c < e.searchSelectArray.length; c++) {
                d.push(e.searchSelectArray[c].html())
            }
            d.push("</div>");
            d.push("</div>");
            d.push("</div>");
            d.push('<div class="sidebar-items-container">');
            d.push('<div class="spacer44"></div>');
            d.push('<div class="diver20"></div>');
            if (e.searchRadioArray.length > 0) {
                d.push('<ul class="sidebar-list sidebar-conditions">');
                for (var c = 0; c < e.searchRadioArray.length; c++) {
                    d.push(e.searchRadioArray[c].html())
                }
                d.push("</ul>")
            }
            if (e.categories.length > 0) {
                d.push('<ul style="height:46px;overflow-y:auto;" class="sidebar-list sidebar-categories">');
                d.push('<li id="' + e.categoriesId + '" class="all-categories-item"><a href="javascript:void(0);"><i class="arrow"></i><span>全部分类</span><small class="" id="' + e.categoriesTextId + '">全部</small></a></li>');
                for (var c = 0; c < e.categories.length; c++) {
                    var f = M.genId(e.baseLiId);
                    e.categoriesIdArray.push(f);
                    d.push('<li class="sidebar-cat-items">');
                    d.push('<a id="' + f + '" href="javascript:void(0);"><i class="arrow"></i><span>' + e.categories[c].getClassfly() + "</span><small>" + e.categories[c].getOthersText() + "</small></a>");
                    d.push(e.categories[c].html());
                    d.push("</li>")
                }
                d.push("</ul>");
                d.push('<div class="diver20"></div>')
            }
            if (e.others.length > 0) {
                d.push('<ul class="sidebar-list sidebar-categories">');
                for (var c = 0; c < e.others.length; c++) {
                    var f = M.genId(e.baseLiId);
                    e.othersIdArray.push(f);
                    d.push("<li>");
                    d.push('<a id="' + f + '" href="javascript:void(0);">');
                    d.push('<i class="arrow"></i>');
                    d.push('<span class="sort-of-brand">' + e.others[c].getClassfly() + "</span>");
                    d.push('<small id="' + e.othersTextIdArray[c] + '" class="sort-of-brand">全部</small>');
                    d.push("</a>");
                    d.push(e.others[c].html());
                    d.push("</li>")
                }
                d.push("</ul>")
            }
            d.push("</div>");
            d.push("</div>");
            d.push("</div>");
            d.push("</div>");
            return d.join("")
        }, show: function () {
            var c = this;
            $("html").removeClass("sidebar-back");
            $("html").addClass("sidebar-move");
            $("#" + c.shadowId).show();
            $("#" + c.menuId).show()
        }, hide: function () {
            var c = this;
            $("html").addClass("sidebar-back");
            setTimeout(function () {
                $("html").removeClass("sidebar-back");
                $("html").removeClass("sidebar-move")
            }, 300);
            $("#" + c.shadowId).hide();
            $("#" + c.menuId).hide()
        }, itemOthersBind: function () {
            var e = this;
            for (var c = 0; c < e.othersIdArray.length; c++) {
                $("#" + e.othersIdArray[c]).on("click", function () {
                    var f = $(this).attr("id");
                    if ($(this).parent("li").hasClass("opened")) {
                        if (e.isQq) {
                            $(this).next().css({height: "0px"});
                            $("#" + f).parent().removeClass("opened")
                        } else {
                            $(this).next().animate({height: "0px"}, {
                                duration: 200,
                                easing: "linear",
                                complete: function () {
                                    $("#" + f).parent().removeClass("opened")
                                }
                            })
                        }
                    } else {
                        var m = false;
                        var n = $("#" + f).parent("li").siblings();
                        for (var k = 0; k < n.length; k++) {
                            if ($(n[k]).hasClass("opened")) {
                                m = true;
                                if (e.isQq) {
                                    $(n[k]).children("div").css({height: "0px"});
                                    $(n[k]).removeClass("opened")
                                } else {
                                    $(n[k]).children("div").animate({height: "0px"}, {duration: 200, easing: "linear"});
                                    $(n[k]).removeClass("opened")
                                }
                            }
                        }
                        for (var k = 0; k < e.categoriesIdArray.length; k++) {
                            if ($("#" + e.categoriesIdArray[k]).parent("li").hasClass("opened")) {
                                m = true;
                                var l = k;
                                if (e.isQq) {
                                    $("#" + e.categoriesIdArray[l]).next().css({height: "0px"});
                                    $("#" + e.categoriesIdArray[l]).parent().removeClass("opened")
                                } else {
                                    $("#" + e.categoriesIdArray[l]).next().animate({height: "0px"}, {
                                        duration: 200,
                                        easing: "linear",
                                        complete: function () {
                                            $("#" + e.categoriesIdArray[l]).parent().removeClass("opened")
                                        }
                                    })
                                }
                            }
                        }
                        if ($("#" + e.categoriesId).parent().hasClass("open-all-cate")) {
                            m = true;
                            if (e.isQq) {
                                $("#" + e.categoriesId).parent().css({height: "46px"});
                                $("#" + e.categoriesId).parent().removeClass("open-all-cate");
                                $("#" + e.categoriesId).removeClass("opened")
                            } else {
                                $("#" + e.categoriesId).parent().animate({height: "46px"}, {
                                    duration: 200,
                                    easing: "linear",
                                    complete: function () {
                                        $("#" + e.categoriesId).parent().removeClass("open-all-cate");
                                        $("#" + e.categoriesId).removeClass("opened")
                                    }
                                })
                            }
                        }
                        $("#" + f).parent("li").addClass("opened");
                        var h = $(this).next().find("ul");
                        var o = 5;
                        if (h.length == 3) {
                            for (var k = 0; k < h.length; k++) {
                                if (k == 0) {
                                    o = o + $(h[k]).find("li").length * 45
                                } else {
                                    if ($(h[k]).css("display") == "" || $(h[k]).css("display") == "block") {
                                        if (k == 1) {
                                            o = o + $(h[k]).find("li").length * 45
                                        } else {
                                            var g = $(h[k]).find(".letter").length;
                                            var i = $(h[k]).find("li").length - g;
                                            o = o + g * 25 + i * 45
                                        }
                                    }
                                }
                            }
                        } else {
                            for (var k = 0; k < h.length; k++) {
                                o = o + $(h[k]).find("li").length * 45
                            }
                        }
                        if (o > 365) {
                            o = 365
                        }
                        if (e.isQq) {
                            $(this).next().css({height: "auto"})
                        } else {
                            $(this).next().animate({height: o}, {
                                duration: 200, easing: "linear", complete: function () {
                                    var j = $("#" + f).parent().parent().children().find("a").last().attr("id");
                                    if (j == f && !m) {
                                        var p = $("#" + e.menuId).children().last();
                                        p[0].scrollTop = $("#" + e.menuId).children().last().scrollTop() + 45
                                    }
                                }
                            })
                        }
                    }
                })
            }
            for (var c = 0; c < e.others.length; c++) {
                var d = e.others[c];
                e.others[c].bind(e.othersBtnBind, d)
            }
        }, itemCategoriesBind: function () {
            var d = this;
            for (var c = 0; c < d.categoriesIdArray.length; c++) {
                $("#" + d.categoriesIdArray[c]).on("click", function () {
                    var k = $(this).attr("id");
                    if ($(this).parent("li").hasClass("opened")) {
                        if (d.isQq) {
                            $(this).next().css({height: "0px"});
                            $("#" + k).parent().removeClass("opened")
                        } else {
                            $(this).next().animate({height: "0px"}, {
                                duration: 200,
                                easing: "linear",
                                complete: function () {
                                    $("#" + k).parent().removeClass("opened")
                                }
                            })
                        }
                    } else {
                        var e = false;
                        var i = $("#" + k).parent("li").siblings();
                        for (var f = 1; f < i.length; f++) {
                            if ($(i[f]).hasClass("opened")) {
                                e = true;
                                if (d.isQq) {
                                    $(i[f]).children("div").css({height: "0px"});
                                    $(i[f]).removeClass("opened")
                                } else {
                                    $(i[f]).children("div").animate({height: "0px"}, {duration: 200, easing: "linear"});
                                    $(i[f]).removeClass("opened")
                                }
                            }
                        }
                        $("#" + k).parent("li").addClass("opened");
                        var h = $(this).next().children().find("li");
                        var g = "";
                        if (h.length > 8) {
                            g = (45 * 8 + 3) + "px"
                        } else {
                            g = (45 * h.length + 3) + "px"
                        }
                        $("#" + k).parent("li").addClass("opened");
                        if (d.isQq) {
                            $(this).next().css({height: "auto"})
                        } else {
                            $(this).next().animate({height: g}, {
                                duration: 200, easing: "linear", complete: function () {
                                    var j = $("#" + k).parent().parent().children().find("a").last().attr("id");
                                    if (j == k && !e) {
                                        var l = $("#" + k).parent().parent();
                                        l[0].scrollTop = $("#" + k).parent().parent().scrollTop() + 45
                                    }
                                }
                            })
                        }
                    }
                })
            }
            for (var c = 0; c < d.categories.length; c++) {
                d.categories[c].bind(d.categoriesBtnBind, d)
            }
        }, categoriesBind: function () {
            var c = this;
            $("#" + c.categoriesId).on("click", function () {
                var h = $(this).attr("id");
                if ($(this).parent().hasClass("open-all-cate")) {
                    for (var e = 0; e < c.categoriesIdArray.length; e++) {
                        if ($("#" + c.categoriesIdArray[e]).parent("li").hasClass("opened")) {
                            var d = e;
                            if (c.isQq) {
                                $("#" + c.categoriesIdArray[d]).next().css({height: "0px"});
                                $("#" + c.categoriesIdArray[d]).parent().removeClass("opened")
                            } else {
                                $("#" + c.categoriesIdArray[d]).next().animate({height: "0px"}, {
                                    duration: 200,
                                    easing: "linear",
                                    complete: function () {
                                        $("#" + c.categoriesIdArray[d]).parent().removeClass("opened")
                                    }
                                })
                            }
                        }
                    }
                    if (c.isQq) {
                        $(this).parent().css({height: "46px"});
                        $("#" + h).parent().removeClass("open-all-cate");
                        $("#" + h).removeClass("opened")
                    } else {
                        $(this).parent().animate({height: "46px"}, {
                            duration: 200, easing: "linear", complete: function () {
                                $("#" + h).parent().removeClass("open-all-cate");
                                $("#" + h).removeClass("opened")
                            }
                        })
                    }
                } else {
                    for (var e = 0; e < c.othersIdArray.length; e++) {
                        if ($("#" + c.othersIdArray[e]).parent().hasClass("opened")) {
                            if (c.isQq) {
                                $("#" + c.othersIdArray[e]).parent().removeClass("opened");
                                $("#" + c.othersIdArray[e]).next().css({height: "0px"})
                            } else {
                                $("#" + c.othersIdArray[e]).parent().removeClass("opened");
                                $("#" + c.othersIdArray[e]).next().animate({height: "0px"}, {
                                    duration: 200,
                                    easing: "linear"
                                })
                            }
                        }
                    }
                    var g = $(this).parent().children("li");
                    var f = "";
                    if ((g.length - 1) > 14) {
                        f = (45 * 14 + 5) + "px"
                    } else {
                        f = (45 * g.length + 5) + "px"
                    }
                    $(this).parent().addClass("open-all-cate");
                    $(this).addClass("opened");
                    if (c.isQq) {
                        $(this).parent().css({height: "auto"})
                    } else {
                        $(this).parent().animate({height: f}, {duration: 200, easing: "linear"})
                    }
                }
            })
        }, bind: function () {
            var d = this;
            d.itemCategoriesBind();
            d.itemOthersBind();
            d.categoriesBind();
            for (var c = 0; c < d.searchSelectArray.length; c++) {
                d.searchSelectArray[c].bind()
            }
            for (var c = 0; c < d.searchRadioArray.length; c++) {
                d.searchRadioArray[c].bind()
            }
            $("#" + d.checkId).on("click", function () {
                d.hide();
                if (d.checkfuncObj && d.checkfuncObj.func && M.object.isFunction(d.checkfuncObj.func)) {
                    var e = d.checkfuncObj.source ? d.checkfuncObj.source : null;
                    d.checkfuncObj.func.call(e)
                }
            });
            $("#" + d.reCheckId).on("click", function () {
                d.reAll()
            });
            $("#" + d.shadowId).on("click", function () {
                d.hide();
                d.reBefore()
            })
        }, othersBtnBind: function (f) {
            var g = this;
            if (f.getType() == "searchitembutton" && f.isCheck()) {
                var h = g.getGroupByBtnId(f.getId());
                var e = h.groupId;
                for (var d = 0, k = g.btnGroup.length; d < k; d++) {
                    if (g.selection) {
                        if (e != g.btnGroup[d].groupId) {
                            g.cancelBtn(g.btnGroup[d], f);
                            $("#" + g.btnGroup[d].btnId).children().removeClass("checked")
                        }
                    } else {
                        if (e == g.btnGroup[d].groupId) {
                            g.cancelBtn(g.btnGroup[d], f);
                            $("#" + f.getId()).siblings().removeClass("checked")
                        } else {
                            g.cancelBtn(g.btnGroup[d], f);
                            $("#" + g.btnGroup[d].btnId).children().removeClass("checked")
                        }
                    }
                }
            } else {
                if (f.getType() == "searchiteminput") {
                    for (var d = 0, k = g.btnGroup.length; d < k; d++) {
                        var h = g.getGroupByBtnId(f.getId());
                        var e = h.groupId;
                        if (e == g.btnGroup[d].groupId) {
                            g.cancelBtn(g.btnGroup[d], f);
                            $("#" + f.getId()).siblings().removeClass("checked")
                        }
                    }
                }
            }
            g.value = g.reValue();
            var c = g.getText();
            var j = "全部";
            if (c.length >= 2) {
                j = c.join(",")
            } else {
                if (c.length == 1) {
                    j = c[0]
                }
            }
            $("#" + g.outTextId).text(j)
        }, categoriesBtnBind: function (f) {
            var h = this;
            for (var e = 0; e < h.categories.length; e++) {
                var g = h.categories[e].getGroupByBtnId(f.getId());
                if (g) {
                    var k = h.categories[e].getGroupByBtnId(f.getId());
                    var d = k.groupId;
                    for (var c = 0, l = h.categories[e].btnGroup.length; c < l; c++) {
                        if (h.categories[e].selection) {
                            if (d != h.categories[e].btnGroup[c].groupId) {
                                h.categories[e].cancelBtn(h.categories[e].btnGroup[c], f);
                                $("#" + h.categories[e].btnGroup[c].btnId).children().removeClass("checked")
                            }
                        } else {
                            if (d == h.categories[e].btnGroup[c].groupId) {
                                h.categories[e].cancelBtn(h.categories[e].btnGroup[c], f);
                                $("#" + f.getId()).siblings().removeClass("checked")
                            } else {
                                h.categories[e].cancelBtn(h.categories[e].btnGroup[c], f);
                                $("#" + h.categories[e].btnGroup[c].btnId).children().removeClass("checked")
                            }
                        }
                    }
                    h.categories[e].value = h.categories[e].reValue()
                } else {
                    h.categories[e].reAll()
                }
            }
            if (f.isCheck()) {
                $("#" + h.categoriesTextId).text(f.getText())
            } else {
                $("#" + h.categoriesTextId).text("全部")
            }
        }, reAll: function () {
            var d = this;
            for (var c = 0; d.searchRadioArray.length > c; c++) {
                d.searchRadioArray[c].cancel(true)
            }
            for (var c = 0; d.searchSelectArray.length > c; c++) {
                d.searchSelectArray[c].cancel()
            }
            for (var c = 0; d.categories.length > c; c++) {
                d.categories[c].reAll()
            }
            for (var c = 0; d.others.length > c; c++) {
                d.others[c].reAll()
            }
            $("#" + d.categoriesTextId).text("全部")
        }, getValue: function () {
            var g = {};
            var f = this;
            for (var e = 0; f.searchRadioArray.length > e; e++) {
                g[f.searchRadioArray[e].getKey()] = f.searchRadioArray[e].getValue()
            }
            for (var e = 0; f.searchSelectArray.length > e; e++) {
                g[f.searchSelectArray[e].getKey()] = f.searchSelectArray[e].getValue()
            }
            for (var e = 0; f.categories.length > e; e++) {
                var c = f.categories[e].getValue();
                if (g[f.categories[e].getKey()]) {
                    for (var d = 0; c.length > d; d++) {
                        g[f.categories[e].getKey()].push(c[d])
                    }
                } else {
                    g[f.categories[e].getKey()] = [];
                    for (var d = 0; c.length > d; d++) {
                        g[f.categories[e].getKey()].push(c[d])
                    }
                }
            }
            for (var e = 0; f.others.length > e; e++) {
                var c = f.others[e].getValue();
                if (g[f.others[e].getKey()]) {
                    for (var d = 0; c.length > d; d++) {
                        g[f.others[e].getKey()].push(c[d])
                    }
                } else {
                    g[f.others[e].getKey()] = [];
                    for (var d = 0; c.length > d; d++) {
                        g[f.others[e].getKey()].push(c[d])
                    }
                }
            }
            return g
        }, render: function (d) {
            var c = this;
            $("#" + c.renderId).html(c.html());
            c.bind()
        }, run: function () {
            var c = this;
            $("#test").html(c.html());
            c.bind()
        }
    });
    a.clazz = b
});
M.define("searchlist", function (b) {
    var a = function (c) {
        this.init(c)
    };
    M.object.merge(a.prototype, {
        init: function (d) {
            this.baseId = "searchlist";
            this.renderId = d.renderId;
            this.listUlId = M.genId(this.baseId);
            this.loadDataId = M.genId(this.baseId);
            this.notFoundId = M.genId(this.baseId);
            this.pagenumId = M.genId(this.baseId);
            this.runtopId = M.genId(this.baseId);
            this.geToIndex = M.genId(this.baseId);
            this.goToTop = M.genId(this.baseId);
            this.page = 1;
            this.allapge = 0;
            this.hasData = true;
            this.baseParams = d.baseParams;
            this.canload = true;
            this.scrollEffective = true;
            if (d.scrollEffective == false) {
                this.scrollEffective = false
            } else {
                this.scrollEffective = true
            }
            this.buriedPointVal = d.buriedPointVal;
            this.listUrl = d.listUrl ? d.listUrl : "";
            this.searchParams = "";
            this.searchParamsObj = {};
            this.imgLazyLad = new (M.exports("Imglazyload").clazz)();
            var c = 0;
            c = $("header").height();
            c = c + $("footer").height();
            $("#" + this.renderId).css("min-height", ($(window).height() - c));
            if (!d.data || !d.data.wareList || d.data.wareList.length == 0) {
                $("#" + this.renderId).html(this.notFoundHtml());
                $("#" + this.notFoundId).show();
                this.hasData = false
            } else {
                $("body").addClass("loading");
                this.allapge = parseInt(d.data.wareCount / 20, 10);
                this.allapge = (d.data.wareCount % 20) > 0 ? (this.allapge + 1) : this.allapge;
                $("#" + this.renderId).append(this.showDataUlHtml());
                $("#" + this.listUlId).html(this.showDataHtml(d.data.wareList));
                $("#" + this.renderId).append(this.notFoundHtml());
                $("#" + this.renderId).append(this.loadPageDataHtml());
                $("#" + this.renderId).append(this.runTopHtml());
                $("#" + this.pagenumId).text(this.page + "/" + this.allapge);
                this.page++;
                $("body").removeClass("loading");
                this.imgLazyLad.lazyLad()
            }
        }, runTopHtml: function () {
            var d = this;
            var c = [];
            c.push('<div style="display : none;" id="' + d.runtopId + '" class="right-opera J_ping" report-eventparam="" report-eventid="MList_BackToTop">');
            c.push("<ul>");
            c.push('<li id="' + d.goToTop + '"></li>');
            c.push('<li id="' + d.geToIndex + '"></li>');
            c.push("</ul>");
            c.push("</div>");
            return c.join("")
        }, notFoundHtml: function () {
            var d = this;
            var c = [];
            c.push('<div style="display : none;" id="' + d.notFoundId + '" class="not-found">');
            c.push('<div class="notice">抱歉，没有找到符合条件的商品</div>');
            c.push("</div>");
            return c.join("")
        }, loadPageDataHtml: function () {
            var d = this;
            var c = [];
            c.push('<div style="display : none;" id="' + d.loadDataId + '" class="swipe-up">');
            c.push('<div class="swipe-up-wrapper">');
            c.push('<div class="loading-con">');
            c.push('<span id="' + d.pagenumId + '" class="pagenum"></span>');
            c.push('<span class="loading"><i>加载中...</i></span>');
            c.push('<div class="clear"></div>');
            c.push("</div>");
            c.push("</div>");
            c.push("</div>");
            return c.join("")
        }, showDataHtml: function (m) {
            var d = this;
            var k = [];
            var n = d.searchParamsObj.region ? d.searchParamsObj.region : "";
            n = n ? ("?provinceId=" + n + "&cityId=0") : "";
            if (m.length > 0) {
                for (var h = 0, f = m.length; h < f; h++) {
                    var e = "";
                    if (m[h].eche && m[h].toMURL) {
                        e = m[h].toMURL
                    } else {
                        if (m[h].international) {
                            e = "http://m.jd.hk/product/" + m[h].wareId + ".html" + n
                        } else {
                            e = "http://item.m.jd.com/product/" + m[h].wareId + ".html" + n
                        }
                    }
                    var c = d.buriedPointHtml(m[h], h);
                    k.push("<li>");
                    k.push('<a style=" text-decoration:none;" href="' + e + '" ' + c + " >");
                    k.push('<div class="list-thumb">');
                    k.push('<img width="85" imgsrc="' + m[h].imageurl.replace("/n4/", "/n7/") + '" height="85" src="/images/search/thumb-avatar-170x170.png">');
                    k.push("</div>");
                    k.push('<div class="list-descriptions">');
                    k.push('<div class="list-descriptions-wrapper">');
                    k.push('<div class="product-name">' + m[h].wname + "</div>");
                    k.push('<div class="price-spot">');
                    k.push('<span class="product-price">￥<span>' + m[h].jdPrice + "</span></span>");
                    if (m[h].international) {
                        k.push('<span class="product-price">');
                        k.push('<img width="55" height="16" src="http://st.360buyimg.com/m/images/search/54f185c0Nc46e761a.png">');
                        k.push("</span>")
                    }
                    k.push("</div>");
                    k.push('<div class="reputation">');
                    if (m[h].good) {
                        k.push('<span class="ratings">' + m[h].good + "好评" + (m[h].totalCount ? ("(" + m[h].totalCount + "人)") : "") + "</span>")
                    }
                    if (m[h].promotionFlag && m[h].promotionFlag.length > 0) {
                        for (var l = 0, o = m[h].promotionFlag.length; l < o; l++) {
                            k.push('<span class="sign-items sign-item-' + m[h].promotionFlag[l] + '"></span>')
                        }
                    }
                    k.push("</div>");
                    k.push("</div>");
                    k.push("</div>");
                    k.push("</a>");
                    k.push("</li>")
                }
            }
            return k.join("")
        }, buriedPointHtml: function (f, c) {
            var e = this;
            var d = "";
            if (e.buriedPointVal == "search") {
                if (f.international) {
                    d = ' class="J_ping" report-eventid="MList_Product"  report-eventparam="international" '
                } else {
                    d = ' class="J_ping" report-eventid="MList_Product"  report-eventparam="' + f.wareId + '" '
                }
            } else {
                if (e.buriedPointVal == "lookSimilar") {
                    d = ' class="J_ping" report-eventid="MHomeSimilarities_Products"  report-eventparam="' + c + "_" + f.wareId + '_1" '
                }
            }
            return d
        }, showDataUlHtml: function () {
            var d = this;
            var c = [];
            c.push('<ul id="' + d.listUlId + '" class="list_body"></ul>');
            return c.join("")
        }, load: function () {
            var c = this;
            $("#" + c.loadDataId).show();
            $("#" + c.notFoundId).hide();
            if (c.listUrl) {
                M.http.ajax({
                    url: c.listUrl,
                    data: "_format_=json&" + c.searchParams + "&page=" + c.page + "&" + c.baseParams,
                    success: function (d) {
                        var e = null;
                        if (d && d.value) {
                            e = $.parseJSON(d.value);
                            c.allapge = parseInt(e.wareCount / 20, 10);
                            c.allapge = (e.wareCount % 20) > 0 ? c.allapge + 1 : c.allapge;
                            if (e.wareList && e.wareList.length > 0) {
                                $("#" + c.listUlId).append(c.showDataHtml(e.wareList));
                                $("#" + c.listUlId).css({display: "block;"});
                                $("#" + c.notFoundId).hide();
                                $("#" + c.pagenumId).text(c.page + "/" + c.allapge);
                                c.imgLazyLad.lazyLad()
                            }
                            c.page++
                        }
                        $("#" + c.loadDataId).hide();
                        c.canload = true
                    },
                    error: function () {
                        $("#" + c.loadDataId).hide();
                        c.canload = true
                    }
                })
            }
        }, reload: function (e) {
            var d = this;
            d.searchParamsObj = e;
            var f = d.createSearchParams(e);
            if (d.searchParams != f) {
                d.searchParams = f;
                $("body").addClass("loading");
                var c = d.baseParams.split("=");
                if (c.length < 2 || c[1] == "") {
                    $("body").removeClass("loading")
                } else {
                    if (d.listUrl) {
                        M.http.ajax({
                            url: d.listUrl,
                            data: "_format_=json&" + d.searchParams + "&page=1&" + d.baseParams,
                            success: function (g) {
                                var h = null;
                                $("#" + d.runtopId).hide();
                                if (g && g.value) {
                                    h = $.parseJSON(g.value);
                                    d.allapge = parseInt(h.wareCount / 20, 10);
                                    d.allapge = (h.wareCount % 20) > 0 ? d.allapge + 1 : d.allapge;
                                    d.page = 1;
                                    if (h.wareList && h.wareList.length > 0) {
                                        $("#" + d.listUlId).html(d.showDataHtml(h.wareList));
                                        $("#" + d.listUlId).css({display: "block;"});
                                        $("#" + d.notFoundId).hide();
                                        $("#" + d.pagenumId).text(d.page + "/" + h.wareCount);
                                        d.page++;
                                        d.imgLazyLad.lazyLad();
                                        d.hasData = true
                                    } else {
                                        $("#" + d.listUlId).css({display: "none"});
                                        $("#" + d.notFoundId).show();
                                        d.hasData = false
                                    }
                                }
                                $("body").removeClass("loading")
                            },
                            error: function () {
                                $("body").removeClass("loading");
                                $("#" + d.runtopId).hide();
                                $("#" + d.notFoundId).show();
                                d.hasData = false;
                                d.canload = true
                            }
                        })
                    }
                }
            }
        }, createSearchParams: function (d) {
            var c = [];
            M.object.each(d, function (l, h) {
                c.push(h);
                if (M.object.isArray(l)) {
                    c.push("=[");
                    for (var f = 0, e = l.length, k = e - 1; f < e; f++) {
                        c.push(l[f]);
                        if (f < k) {
                            c.push(",")
                        }
                    }
                    c.push("]&")
                } else {
                    c.push("=");
                    c.push(l);
                    c.push("&")
                }
            });
            return c.join("")
        }, isReloadHasData: function () {
            var c = this;
            return c.hasData
        }, closeLoad: function () {
            var c = this;
            c.scrollEffective = false
        }, opendLoad: function () {
            var c = this;
            c.scrollEffective = true
        }, listScrollBind: function () {
            var c = this;
            $(window).scroll(function () {
                c.imgLazyLad.lazyLad();
                if ((c.page - 1) < c.allapge && $(window).scrollTop() > ($("#" + c.renderId).height() - 85 * 6) && c.canload && c.scrollEffective) {
                    $("#" + c.loadDataId).show();
                    c.canload = false;
                    c.load()
                }
                if ($(window).scrollTop() >= $(window).height()) {
                    if (c.canload) {
                        $("#" + c.runtopId).show()
                    }
                } else {
                    $("#" + c.runtopId).hide()
                }
            });
            $(window).resize(function () {
                c.imgLazyLad.lazyLad()
            })
        }, bind: function () {
            var c = this;
            c.listScrollBind();
            $("#" + c.geToIndex).on("click", function () {
                window.location.href = "/index.html"
            });
            $("#" + c.goToTop).on("click", function () {
                window.scrollTo(0, 1)
            })
        }, render: function (d) {
            var c = this;
            c.bind()
        }, run: function () {
            var c = this;
            c.bind()
        }
    });
    b.clazz = a
});
M.define("searchradio", function (a) {
    var b = function (c) {
        this.init(c)
    };
    M.object.merge(b.prototype, {
        init: function (c) {
            this.text = c.text ? c.text : "";
            this.key = c.key ? c.key : "";
            this.id = c.id ? M.genId("m_searchradio_" + c.id) : M.genId("m_searchradio_");
            this.baseId = c.id ? c.id : null;
            this.reportEventid = c.reportEventid ? c.reportEventid : "";
            this.isCheck = false
        }, keepBefore: function () {
            var c = this;
            c.beforeIsCheck = c.isCheck
        }, reBefore: function () {
            var c = this;
            if (c.isCheck != c.beforeIsCheck) {
                c.isCheck = c.beforeIsCheck;
                if (c.isCheck) {
                    $("#" + c.id).children().find("i").addClass("checked")
                } else {
                    $("#" + c.id).children().find("i").removeClass("checked")
                }
            }
        }, getValue: function () {
            var c = this;
            if (c.isCheck) {
                return 1
            } else {
                return 0
            }
        }, getKey: function () {
            var c = this;
            return c.key
        }, getBaseId: function () {
            var c = this;
            return c.baseId
        }, getId: function () {
            var c = this;
            return c.id
        }, cancel: function (c) {
            var d = this;
            d.secondChange = false;
            if (c) {
                $("#" + d.id).find("span").find("i").removeClass("checked")
            }
        }, bind: function (c) {
            var d = this;
            $("#" + d.id).on("click", function () {
                if (!d.isCheck) {
                    d.isCheck = true;
                    $(this).children().find("i").addClass("checked")
                } else {
                    $(this).children().find("i").removeClass("checked");
                    d.isCheck = false
                }
                if (c) {
                    c(d)
                }
            })
        }, html: function () {
            var d = this;
            var c = '<li id ="' + d.id + '" class="J_ping" report-eventid="' + d.reportEventid + '" ><span class="chk-40-wrapper"><i class="chkbox-40"></i></span><span>' + d.text + "</span></li>";
            return c
        }
    });
    a.clazz = b
});
M.define("searchselect", function (b) {
    var a = function (c) {
        this.init(c)
    };
    M.object.merge(a.prototype, {
        init: function (c) {
            this.valueArray = c.valueArray && M.object.isArray(c.valueArray) ? c.valueArray : [];
            this.key = c.key ? c.key : "";
            this.defaultlabel = c.defaultlabel ? c.defaultlabel : "";
            this.id = c.id ? M.genId("m_searchselect_" + c.id) : M.genId("m_searchselect_");
            this.selectId = c.id ? M.genId("m_searchselect_select_" + c.id) : M.genId("m_searchselect_select");
            this.textId = c.id ? M.genId("m_searchselect_text_" + c.id) : M.genId("m_searchselect_text");
            this.baseId = c.id ? c.id : null;
            this.value = this.defaultlabel;
            this.beforeValue = this.defaultlabel
        }, keepBefore: function () {
            var c = this;
            c.beforeValue = c.value
        }, reBefore: function () {
            var e = this;
            if (e.value != e.beforeValue) {
                e.value = e.beforeValue;
                var d = document.getElementById(e.selectId);
                for (var c = 0; c < d.options.length; c++) {
                    if (d.options[c].value == e.value) {
                        d.options[c].selected = true;
                        break
                    }
                }
                $("#" + e.textId).text($("#" + e.selectId).find("option:selected").text())
            }
        }, getValue: function () {
            var c = this;
            return c.value
        }, getKey: function () {
            var c = this;
            return c.key
        }, getBaseId: function () {
            var c = this;
            return c.baseId
        }, getId: function () {
            var c = this;
            return c.id
        }, cancel: function () {
            var e = this;
            var d = document.getElementById(e.selectId);
            for (var c = 0; c < d.options.length; c++) {
                if (d.options[c].value == e.defaultlabel) {
                    d.options[c].selected = true;
                    break
                }
            }
            e.value = e.defaultlabel;
            $("#" + e.textId).text($("#" + e.selectId).find("option:selected").text())
        }, html: function () {
            var f = this;
            var d = [];
            if (f.valueArray.length > 0) {
                d.push('<span class="sidebar-btn-location"><strong>地点</strong></span>');
                d.push('<span class="sidebar-btn-delivery J_ping" report-eventid="MFilter_Sendto" report-eventparam="">送至</span>');
                d.push('<span class="sidebar-btn-region">');
                d.push('<select id="' + f.selectId + '" class="fm-select">');
                for (var c = 0; c < f.valueArray.length; c++) {
                    var e = f.defaultlabel == f.valueArray[c].label;
                    d.push("<option " + (e ? 'selected="selected"' : "") + ' value="' + f.valueArray[c].label + '">' + f.valueArray[c].value + "</option>")
                }
                d.push("</select>");
                d.push('<div id="' + f.textId + '">');
                d.push("全部");
                d.push("</div>");
                d.push("</span>")
            }
            return d.join("")
        }, bind: function (c) {
            var d = this;
            $("#" + d.selectId).on("change", function () {
                $("#" + d.textId).text($("#" + d.selectId).find("option:selected").text());
                d.value = $("#" + d.selectId).find("option:selected").val();
                if (c) {
                    c(d)
                }
            })
        }
    });
    b.clazz = a
});
M.define("Imglazyload", function (a) {
    var b = function (c) {
    };
    M.object.merge(b.prototype, {
        lazyLad: function () {
            var h = $(window).height();
            var g = $("img[imgsrc]");
            var f = $(window).scrollTop();
            for (var d = 0, c = g.size(); d < c; d++) {
                currentObj = $(g[d]);
                var e = currentObj.offset().top - h - 200;
                if (parseInt(f) >= parseInt(e)) {
                    currentObj.attr("src", currentObj.attr("imgsrc"));
                    currentObj.removeAttr("imgsrc")
                }
            }
        }
    });
    a.clazz = b
});
M.define("searchland", function (a) {
    var b = function (c) {
        this.init(c)
    };
    M.object.merge(b.prototype, {
        init: function (d) {
            this.searchHistoryLocalStorageName = "searchhistory";
            this.formId = d.formId ? d.formId : "";
            this.submitId = d.submitId ? d.submitId : "";
            this.catelogyListId = d.catelogyListId ? d.catelogyListId : "";
            this.isHome = d.isHome ? d.isHome : false;
            this.closeSearchLandBtnId = d.closeSearchLandBtnId ? d.closeSearchLandBtnId : "";
            this.claerKeywordBtnId = d.claerKeywordBtnId ? d.claerKeywordBtnId : "";
            this.keywordId = d.keywordId ? d.keywordId : "";
            this.searchPanelId = d.searchPanelId ? d.searchPanelId : "";
            this.keyword = d.keyword ? d.keyword : "";
            this.keyword = M.string.decodeHtml(this.keyword);
            this.oldkeyword = null;
            var c = "searchhistory_";
            this.controlId = M.genId(c);
            this.hotKeyWordId = M.genId(c);
            this.changeHotKeyWordId = M.genId(c);
            this.hotKeyWordheadId = M.genId(c);
            this.hotKeyWordBtnIds = [];
            this.clearHistoryId = M.genId(c);
            this.hotKeyword = d.hotKeyword ? d.hotKeyword : null;
            this.landSearchWordHide = d.landSearchWordHide ? true : false;
            this.hotKeywordIndex = 0;
            this.openSearchLoad = false;
            this.searchliIdList = [];
            this.searchLoop = false;
            this.showFuncObj = d.showFuncObj ? d.showFuncObj : null;
            this.hideFuncObj = d.hideFuncObj ? d.hideFuncObj : null;
            if (this.keyword != "") {
                $("#" + this.keywordId).val(this.keyword);
                $("#" + this.keywordId).addClass("hilight1")
            }
        }, searchLoadControl: function () {
            var d = this;
            var c = $("#" + d.keywordId).val().trim();
            if (c == "" && d.searchLoop) {
                d.searchLoadFromHistory();
                $("#" + d.claerKeywordBtnId).css({display: "none"})
            } else {
                if (c != "" && d.oldkeyword != c && d.searchLoop) {
                    d.searchLoadFromKeyword(c);
                    $("#" + d.claerKeywordBtnId).css({display: "block"})
                }
            }
            setTimeout(function () {
                d.searchLoadControl()
            }, 500)
        }, searchLoadFromHistory: function () {
            var e = this;
            e.searchLoop = false;
            if (!e.searchLocalStorage) {
                var c = M.localstorage.get(e.searchHistoryLocalStorageName);
                if (c && c.length > 0 && e.openSearchLoad) {
                    c = decodeURIComponent(c);
                    var d = c.split("|");
                    e.searchLandUnbind();
                    $("#" + e.controlId).html(e.searchLandLiHtml(d));
                    $("#" + e.clearHistoryId).parent().css({display: "block;"});
                    e.searchLandBind(true);
                    e.tipArray = d;
                    $("#" + e.controlId).removeClass("jd-auto-complete");
                    $("#" + e.controlId).children("li").css({display: "block"});
                    e.searchLoop = true
                } else {
                    $("#" + e.controlId).html("");
                    e.searchLoop = true
                }
                $("#" + e.hotKeyWordId).show();
                $("#" + e.hotKeyWordheadId).show()
            } else {
                if (e.openSearchLoad) {
                    e.searchLoop = true
                }
            }
            e.searchLocalStorage = true
        }, searchLoadFromKeyword: function (c) {
            var d = this;
            d.searchLoop = false;
            d.oldkeyword = c;
            d.searchLocalStorage = false;
            M.http.ajax({
                url: "/ware/searchSuggestion.action", data: {keyword: c, _format_: "json"}, success: function (f) {
                    if (f && f.searchTipList && d.openSearchLoad) {
                        var e = $.parseJSON(f.searchTipList);
                        if (e.length > 0) {
                            d.searchLandUnbind();
                            $("#" + d.hotKeyWordId).hide();
                            $("#" + d.hotKeyWordheadId).hide();
                            $("#" + d.controlId).html(d.searchLandLiHtml(e));
                            $("#" + d.controlId).addClass("jd-auto-complete");
                            d.searchLandBind(false);
                            d.tipArray = e;
                            $("#" + d.clearHistoryId).parent().css({display: "none;"});
                            $("#" + d.controlId).children("li").css({display: "block"})
                        }
                        d.searchLoop = true
                    } else {
                        if (d.openSearchLoad) {
                            d.searchLoop = true
                        }
                    }
                }, error: function (e) {
                    if (d.openSearchLoad) {
                        d.searchLoop = true
                    }
                }
            })
        }, searchLandLiHtml: function (e) {
            var f = this;
            f.searchliIdList = [];
            var h = [];
            for (var d = 0; d < e.length; d++) {
                var j = "searchland_li_" + d;
                f.searchliIdList.push(j);
                var g = "";
                var c = "&nbsp;";
                if (M.object.isObject(e[d])) {
                    g = e[d].text;
                    if (e[d].otherAttr.tipNumber) {
                        c = e[d].otherAttr.tipNumber
                    }
                } else {
                    g = e[d]
                }
                h.push('<li style="display:none;" id="' + j + '" searchland_index="' + d + '"><a href="javascript:void(0);"><span>' + g + "</span></a></li>")
            }
            return h.join("")
        }, searchLandLiFade: function () {
            var d = this;
            var c = 0;
            d.searchLandLiRecursiveFade(c, d.searchliIdList.length)
        }, searchLandLiRecursiveFade: function (c, d) {
            var e = this;
            if (c < d) {
                $("#" + e.searchliIdList[c]).fadeIn(10, function () {
                    var f = c + 1;
                    e.searchLandLiRecursiveFade(f, d)
                })
            } else {
                e.searchLoop = true
            }
        }, searchLandUnbind: function () {
            var e = this;
            if (e.searchliIdList && e.searchliIdList.length > 0) {
                for (var d = 0, c = e.searchliIdList.length; d < c; d++) {
                    $("#" + e.searchliIdList[d]).off("click")
                }
            }
        }, searchLandBind: function (c) {
            var f = this;
            if (f.searchliIdList.length > 0) {
                var e = c;
                for (var d = 0; d < f.searchliIdList.length; d++) {
                    $("#" + f.searchliIdList[d]).on("click", function () {
                        var g = $(this).attr("searchland_index");
                        var h = f.tipArray[g];
                        f.sendMping((e ? "MSearch_HistoryRecords" : "MSearch_SearchDropDownAssociationalWords"));
                        f.searchLandSubmit(h)
                    })
                }
            }
        }, searchLandSubmit: function (e) {
            var d = this;
            var c = null;
            if (M.object.isObject(e)) {
                c = $.parseJSON(e.value)
            } else {
                c = {};
                c.keyword = e
            }
            $("#" + d.keywordId).val(c.keyword);
            c.catelogyList && $("#" + d.catelogyListId).val(JSON.stringify(c.catelogyList));
            d.searchLandAddHistory(c.keyword);
            $("#" + d.formId).submit();
            d.searchLoop = false
        }, searchLandAddHistory: function (l) {
            var k = this;
            if ($.trim(l).length > 0 && $.trim(l) != "") {
                l = $.trim(l);
                var j = "";
                var f = M.localstorage.get(k.searchHistoryLocalStorageName);
                var e = 0;
                if (f != null) {
                    l = k.makeSearchName(l);
                    var c = [l];
                    f = decodeURIComponent(f);
                    var h = f.split("|");
                    for (var d = 0; d < h.length; d++) {
                        if (e == 14) {
                            break
                        }
                        if (h[d] != l) {
                            c.push(h[d])
                        }
                        e++
                    }
                    j = c.join("|")
                } else {
                    var c = l;
                    j = c
                }
                M.localstorage.set(k.searchHistoryLocalStorageName, encodeURIComponent(j))
            }
        }, makeSearchName: function (c) {
            if (c.length >= 30) {
                c = c.substring(0, 30)
            }
            return c
        }, clearHistory: function () {
            var c = this;
            M.localstorage.remove(c.searchHistoryLocalStorageName)
        }, searchTransformation: function () {
            var f = this;
            if (!f.openSearchLoad) {
                $("body").removeClass("hide-landing");
                $("body").addClass("show-landing");
                $("body").addClass("history-color");
                var c = $("body").children("div");
                for (var d = 0; d < c.length; d++) {
                    if ($(c[d]).attr("id") != "search_land_searchland" && !$(c[d]).attr("search_land_searchTransformation_show")) {
                        $(c[d]).css("display", "none")
                    }
                }
                $("body").children("footer").css("display", "none");
                if (f.showFuncObj && f.showFuncObj.func) {
                    var e = f.showFuncObj.source ? f.showFuncObj.source : null;
                    f.showFuncObj.func.call(e)
                }
                $("#" + f.searchPanelId).removeClass("on-blur");
                $("#" + f.searchPanelId).addClass("on-focus");
                window.scrollTo(0, 1);
                f.openSearchLoad = true;
                f.searchLoop = true
            } else {
                $("body").removeClass("show-landing");
                $("body").removeClass("history-color");
                $("body").addClass("hide-landing");
                var c = $("body").children("div");
                for (var d = 0; d < c.length; d++) {
                    if ($(c[d]).attr("id") != "search_land_searchland" && !$(c[d]).attr("search_land_searchTransformation_show")) {
                        $(c[d]).css("display", "block")
                    }
                }
                $("body").children("footer").css("display", "block");
                if (f.hideFuncObj && f.hideFuncObj.func) {
                    var e = f.hideFuncObj.source ? f.hideFuncObj.source : null;
                    f.hideFuncObj.func.call(e)
                }
                f.openSearchLoad = false;
                f.searchLoop = false;
                f.searchLocalStorage = false;
                f.oldkeyword = "";
                $("#" + f.controlId).html("");
                $("#" + f.searchPanelId).removeClass("on-focus");
                $("#" + f.searchPanelId).addClass("on-blur");
                $("#" + f.hotKeyWordId).show();
                $("#" + f.hotKeyWordheadId).show()
            }
        }, searchLandHotKeywordRecursiveFade: function (c, g, d, f) {
            var h = this;
            if (d < f) {
                for (var e = d; e < f; e++) {
                    if (e <= 2) {
                        $(c[e]).parent().addClass("tab-item-1")
                    } else {
                        $(c[e]).parent().addClass("tab-item-2")
                    }
                }
                setTimeout(function () {
                    for (var j = d; j < f; j++) {
                        if (j <= 2) {
                            $(c[j]).text(g[j])
                        }
                    }
                }, 310);
                setTimeout(function () {
                    for (var j = d; j < f; j++) {
                        if (j <= 2) {
                            $(c[j]).parent().removeClass("tab-item-1")
                        }
                    }
                }, 500);
                setTimeout(function () {
                    for (var j = d; j < f; j++) {
                        if (j > 2) {
                            $(c[j]).text(g[j])
                        }
                    }
                }, 410);
                setTimeout(function () {
                    for (var j = d; j < f; j++) {
                        if (j > 2) {
                            $(c[j]).text(g[j]);
                            $(c[j]).parent().removeClass("tab-item-2")
                        }
                    }
                }, 750)
            }
        }, mainHtml: function () {
            var e = this;
            var d = [];
            d.push('<div id="search_land_searchland" class="search-lading-area">');
            if (e.hotKeyword && e.hotKeyword.length > 0) {
                d.push('<div id="' + e.hotKeyWordheadId + '" class="hot-search-bar"><strong>热搜</strong><span id="' + e.changeHotKeyWordId + '"><i></i>换一批</span></div>');
                d.push('<div id="' + e.hotKeyWordId + '" class="landing-tags">');
                for (var c = 0; c < 6 && c < e.hotKeyword.length; c++) {
                    e.hotKeywordIndex = c;
                    var f = "hotKeyWordBtn_" + c;
                    e.hotKeyWordBtnIds.push(f);
                    d.push('<a id="' + f + '" href="javascript:void(0);"><span>' + e.hotKeyword[c] + "</span></a>")
                }
            }
            d.push("</div>");
            d.push('<ul id="' + e.controlId + '" class="landing-keywords">');
            d.push("</ul>");
            d.push('<div class="landing-clear" style="display:none;"><span id="' + e.clearHistoryId + '">清空历史搜索</span></div>');
            d.push("</div>");
            return d.join("")
        }, sendMping: function (d) {
            try {
                var f = new MPing.inputs.Click(d);
                f.event_param = "";
                var c = new MPing();
                c.send(f)
            } catch (g) {
            }
        }, render: function () {
            var d = this;
            var e = $("#footer").length > 0 ? $("#footer") : $("footer");
            $(e).before(d.mainHtml());
            $("body").addClass((d.isHome ? "mhome" : "mlist"));
            $("body").addClass("hide-landing");
            $("#" + d.keywordId).on("click", function (g) {
                var f = null;
                if (d.isHome) {
                    if (d.openSearchLoad) {
                        f = "MSearch_Search"
                    } else {
                        f = "MHome_Search"
                    }
                } else {
                    f = "MProductList_Search"
                }
                d.sendMping(f);
                if (!d.openSearchLoad) {
                    if (d.landSearchWordHide) {
                        $("#" + d.keywordId).val("")
                    } else {
                        $("#" + d.keywordId).val(d.keyword)
                    }
                    d.searchTransformation()
                }
            });
            $("#" + d.keywordId).on("keydown", function (g) {
                if (g.keyCode == "13") {
                    var f = $.trim($("#" + d.keywordId).val());
                    if (f != "") {
                        d.sendMping("MSearch_Searchthi");
                        d.searchLandSubmit(f)
                    }
                }
                return
            });
            $("#" + d.closeSearchLandBtnId).on("click", function () {
                if (d.openSearchLoad) {
                    d.searchTransformation();
                    $("#" + d.keywordId).val(d.keyword);
                    $("#" + this.keywordId).addClass("hilight1")
                }
            });
            $("#" + d.clearHistoryId).on("click", function () {
                d.sendMping("MSearch_ClearHistory");
                d.clearHistory();
                $("#" + d.controlId).html("");
                $("#" + d.clearHistoryId).parent().css({display: "none;"})
            });
            $("#" + d.submitId).on("click", function () {
                var g = $.trim($("#" + d.keywordId).val());
                if (g != "") {
                    var f = null;
                    if (d.isHome) {
                        if (d.openSearchLoad) {
                            f = "MSearch_SearchButton"
                        } else {
                            f = "MHome_SearchButton"
                        }
                    } else {
                        f = "MSearch_SearchButton"
                    }
                    d.sendMping(f);
                    d.searchLandSubmit(g)
                }
            });
            $("#" + d.claerKeywordBtnId).on("click", function () {
                $("#" + d.keywordId).val("");
                $(this).css({display: "none;"})
            });
            $("#" + d.keywordId).on("keyup", function () {
                if ($(this).val() != d.keyword) {
                    $(this).removeClass("hilight1");
                    $(this).addClass("hilight2")
                } else {
                    $(this).removeClass("hilight2");
                    $(this).addClass("hilight1")
                }
            });
            if (d.hotKeyWordBtnIds.length > 0) {
                for (var c = 0; c < d.hotKeyWordBtnIds.length; c++) {
                    $("#" + d.hotKeyWordBtnIds[c]).on("click", function () {
                        var f = $.trim($(this).find("span").text());
                        if (f != "") {
                            d.sendMping("MSearch_HotWords");
                            d.searchLandSubmit(f)
                        }
                    })
                }
            }
            if (d.hotKeyword && d.hotKeyword.length > 0) {
                $("#" + d.changeHotKeyWordId).on("click", function () {
                    var g = 0;
                    var k = [];
                    for (var h = d.hotKeywordIndex + 1, f = h + 6; h < f && h < d.hotKeyword.length; h++) {
                        g++;
                        d.hotKeywordIndex = h;
                        k.push(d.hotKeyword[h])
                    }
                    if (g < 6) {
                        for (var h = 0, f = 6 - g; h < f && h < d.hotKeyword.length; h++) {
                            g++;
                            d.hotKeywordIndex = h;
                            k.push(d.hotKeyword[h])
                        }
                    }
                    var l = $("#" + d.hotKeyWordId).children().find("span");
                    $("#" + d.hotKeyWordheadId).addClass("rotate");
                    setTimeout(function () {
                        $("#" + d.hotKeyWordheadId).removeClass("rotate")
                    }, 500);
                    d.sendMping("MSearch_ChangeKeyWords");
                    d.searchLandHotKeywordRecursiveFade(l, k, 0, g)
                })
            }
            d.searchLoadControl()
        }
    });
    a.clazz = b
});