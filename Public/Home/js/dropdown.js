;(function () {
    var defaults = {
        "wrap": "this",//下拉列表用什么包裹，"this"为按钮自身，主流的插件放在"body"中
        "data": null,
        "formName": "",
        "zIndex": 999
    };

    function Dropdown(opt) {
        var $this = $(this),
            id = $this.attr("id"),
            height = $this.outerHeight(),
            name = !!opt.formName ? opt.formName : id,
            liArray = [],
            aTop = height / 2 - 3;
        $this.css("position", "relative").append("<i class='dropdown_arrow' style='top:" + aTop + "px; right:10px'></i>");
        if ($this.find("span").length < 1) {
            $this.append("<span></span>");
        }
        $this.append("<input type='hidden' name='" + name + "'>");
        if ($(".dropdown_menu[data-target='#" + id + "']").length < 1 && !!opt.data) {
            var wrap;
            if (opt.wrap == "this") {
                wrap = $this
            } else {
                wrap = $(opt.wrap)
            }
            wrap.append("<ul class='dropdown_menu' data-target='#" + id + "'></ul>")
        }
        var $menu = $(".dropdown_menu[data-target='#" + id + "']").hide().css({"position": "absolute", "zIndex": opt.zIndex});
        if (!!opt.data) {
            for (var i = 0; i < opt.data.length; i++) {
                liArray.push("<li data-text='" + opt.data[i].text + "' data-value='" + opt.data[i].value + "' >" + opt.data[i].text + "</li>");
            }
            $menu.html(liArray.join(""));
        }
        BindEvents($this, $menu, true);
    }

    function Reload(data) {
        var $this = $(this),
            id = $this.attr("id"),
            $menu = $(".dropdown_menu[data-target='#" + id + "']"),
            liArray = [];
        if (typeof data != "object") {
            return
        }
        for (var i = 0; i < data.length; i++) {
            liArray.push("<li data-text='" + data[i].text + "' data-value='" + data[i].value + "' >" + data[i].text + "</li>");
        }
        $menu.html(liArray.join(""));
        BindEvents($this, $menu, false);
    }

    function setValue(text, value) {
        var $this = $(this);
        $this.data("value", value).find("span:eq(0)").html(text).end().find("input:hidden").val(value);
    }

    function setDisable (val){

    }

    function BindEvents($this, $menu, init) {
        if(init){
            $("body").on("click",function(){
                $menu.hide();
            });
        }
        $this.off("click").on("click", function () {
            var width = $this.outerWidth(),
                height = $this.outerHeight(),
                offset = $this.offset();
            var border = parseInt($menu.css("borderLeftWidth")) + parseInt($menu.css("borderRightWidth"));
            var padding = parseInt($menu.css("paddingLeft")) + parseInt($menu.css("paddingRight"));
            $menu.css({"width": (width - border - padding), "top": offset.top + height, "left": offset.left}).show();
            $this.trigger("dropdown.show");
            return false;
        });
        $menu.delegate("li", "click", function () {
            var text = $(this).data("text");
            var value = $(this).data("value");
            setValue.call($this[0], text, value);
            $this.trigger("dropdown.set", [text, value]);
            $menu.hide();
        }).delegate("li", "mouseenter", function () {
            $(this).addClass("cursor").siblings("li").removeClass("cursor");
        }).mouseleave(function () {
            $menu.hide();
        });
    }

    //初始化下拉组件的方法
    $.fn.dropdown = function (opt) {
        var opts = defaults;
        $.extend(true, opts, opt);
        return this.each(function () {
            Dropdown.call(this, opts);
        });
    };
    //重载下拉框数据的方法
    $.fn.menuReload = function (data) {
        return this.each(function () {
            Reload.call(this, data);
        });
    };
    //设置下拉框的值
    $.fn.setValue = function (data) {
        return this.each(function () {
            setValue.call(this, data.text, data.value);
        });
    };
    $.fn.setDisable = function (val) {
        return this.each(function () {
            setDisable.call(this, val);
        });
    };
})();