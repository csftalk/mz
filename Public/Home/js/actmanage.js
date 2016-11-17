var modifyNicknameUrl = '/uc/webjsp/member/modifyNickname';
var modifyPasswordUrl = '/uc/webjsp/member/updatePasswordCheck';
var nickNameIsUsedUrl = '/uc/system/webjsp/member/isVaildNickname';
var isValidFlymeUrl = '/uc/webjsp/member/isValidFlyme';
var isValidUserAnswerUrl = '/uc/system/question/isValidUserAnswer';
var updateUserAnswerUrl = '/uc/webjsp/member/updateUserAnswer';
var updateFlymeUrl = '/uc/webjsp/member/updateFlyme';
var redirectUrl = '/uc/webjsp/member/detail';
var checkValidPasswordUrl = '/uc/webjsp/member/checkValidPassword';
var isValidEMail = '/uc/system/webjsp/member/isValidEmail';
var isValidPhoneUrl = '/uc/system/webjsp/member/isValidPhone';
var isMyPhoneUrl = '/uc/webjsp/member/isMyPhoneCheck';
var checkOldPhoneUrl = '/uc/webjsp/member/checkBindPhone';
var logoutCode = '403004'; //账号密码输入错误超过10次就需要强制用户退出
var showPasswordErrorCode = '403005';
var showErrorVCode = '200000';
$(function() {
    global.isNotMiddleForm = true;
    var manage = new Manage();
    manage.init();

    if('CountryCode' in window) {
        window['CountryCode'].init()
        bindCycodeEvent()
    }
});

var Manage = function() {
    this.$form = $("#mainForm");
    this.$btn = $('#login');
};
$.extend(Manage.prototype, {
    defaulsts: {
        validPhoneUrl: '/uc/system/webjsp/member/isValidPhone'
    },
    init: function() {
        this.resetResize(848);
        this.initEvent();
        this.checkSaveLevel();

        $("#safeLevelTip").click(function(){
            nAlert("设置密码+20，验证邮箱+20，绑定手机号+30，设置密保问题+30，账号安全等着你拿100满分哦", '提示');
            $(".alertDialogMain").css("border","")
        });

        $.floatTip({
            'data': [{
                'id': 'newnickName',
                'text': '支持中英文、数字和下划线，3个月内只能改一次',
                'width': 200,
                'loc': 0,
                'diffy': 2,
                'diff': 10
            }, {
                'id': 'ce-u-new_pwd1',
                'text': '长度为8-16个字符，区分大小写，至少包含两种类型',
                'width': 200,
                'loc': 1,
                'diffy': 2,
                'diff': 10
            }, {
                'id': 'ce-u-new_pwd2',
                'text': '长度为8-16个字符，区分大小写，至少包含两种类型',
                'width': 200,
                'loc': 1,
                'diffy': 2,
                'diff': 10
            }, {
                'id': 'flyme',
                'text': '长度为4-32个字符支持数字、字母、下划线，字母开头，字母或数字结尾',
                'width': 200,
                'loc': 1,
                'diffy': 2,
                'diff': 10
            }]
        });

        util.getToken('doSyncPost');
    },
    resetResize: function(h) {
        var height = $(window).height();
        if (height > h) {
            var h1 = false;
        } else {
            var h1 = h;
        }
        global.resizer.setProperty('minH', h, h1, true);
        $(document.body).css('min-height', h);
    },
    initInput: function($input, info) {
        util.initPlaceholder($input, info, 'emptyInput');
    },
    initEvent: function() {
        this.mscEvents();
        this.revealEvent();
        this.mailAuto();
        this.renotice();
        this.getKapkey();
        this.getQuestionList("question_one", "question_two");
        this.getQuestionList("question_two", "question_one");
        this.gotoModifyIcon();

        //因源代码不知道在哪设置footer，故只能在这里加入
        var $foot = $('#flymeFooter')
        $('#editMobile').on('click', function() {
          $foot.css('top', 950)
        })
        $('#setTelCheckPassCancel').on('click', function(){
          $foot.css('top', 848)
        })
        $('#modifyPassword').on('click', function() {
          $foot.css('top', 950)
        })
        $('#ce-u-pwd-phone-cancel').on('click', function(){
          $foot.css('top', 848)
        })


        $(".funnyNameClose").click(function() {
            util.doAsyncPost('/uc/webjsp/member/updateNewUserFlag', function(result) {
                result = util.getData(result);
                if (result == null) return;
                $("#getFunnyName").hide();
            });
        });
        $(".top-leftWrap").hover(function() {
            $("#modifyIconTip,.modifyIconTip-bg").show();
        }, function() {
            $("#modifyIconTip.modifyIconTip-bg").hide();
        });
        $("#questionCode1").dropdown().on("dropdown.set", function(e, t, v) {
            $(".dropdown_menu[data-target='#questionCode2']").find("li").show().filter("[data-value='" + v + "']").hide();
        });
        $("#questionCode2").dropdown().on("dropdown.set", function(e, t, v) {
            $(".dropdown_menu[data-target='#questionCode1']").find("li").show().filter("[data-value='" + v + "']").hide();
        });
        $("#questionCode3").dropdown({
            formName: 'questionCode1'
        }).on("dropdown.set", function(e, t, v) {
            $(".dropdown_menu[data-target='#questionCode4']").find("li").show().filter("[data-value='" + v + "']").hide();
        });
        $("#questionCode4").dropdown({
            formName: 'questionCode2'
        }).on("dropdown.set", function(e, t, v) {
            $(".dropdown_menu[data-target='#questionCode3']").find("li").show().filter("[data-value='" + v + "']").hide();
        });
    },
    gotoModifyIcon: function() {
        var self = this;
        $("#modifyIconTip").click(function() {
            var This = $(this);
            var src = "/uc/webjsp/membericon/modify";
            var source = {
                self: This,
                src: src
            };
            self.EditEventCheckInput(source, function() {
                window.location.href = 'https://' + window.location.host + src;
            });

        });
    },
    getAllOptions: function() {
        var self = this;
        var data = [
            {
                modify: "#nickNameEdite,.getFunnyNameTitle",
                title: "#nickNameTitle",
                content: "#nickNameCon",
                save: "#editSave",
                cancel: "#editCancel",
                url: modifyNicknameUrl,
                eventcallback: function() {
                    var name = $("#nickName").text();
                    name = $.trim(name);
                    $("#newnickName").val(name);
                },
                successcallback: function(i, result) {
                    var text = result;
                    $('#nickName,#mzCustName').text(text);
                    $(data[i].content).find("input").val("");
                    $("#getFunnyName").hide();
                    nAlert("昵称已修改成功<p class='grayTip paddingT20'>部分位置显示可能会延迟</p>");
                    var nickName = $("#nickName").text();
                    $('#head-name').text(nickName).attr("title",nickName);
                    $(".alertDialogMain").css("border", "")
                },
                rules: util.createRule({
                    nickname: {
                        required: true,
                        nicknameLen: [2, 32],
                        noEmpty: true,
                        nickname: true,
                        remote: nickNameIsUsedUrl
                    }
                }),
                messages: util.createMes({
                    nickname: {
                        required: "请填写昵称",
                        nicknameLen: "只能输入2-32位中英文、数字、点号和下划线",
                        noEmpty: '只能输入2-32位中英文、数字、点号和下划线',
                        nickname: '只能输入2-32位中英文、数字、点号和下划线',
                        remote: function(value, result){
                            var msg = result.message;
                            if(msg == ""){
                                msg = '此昵称已存在';
                            }
                            return msg;
                        }
                    }
                }),
                height: 900,
                type: "修改昵称"
            }, {
                modify: "#setuserName",
                title: "#setUserNameWrap",
                content: "#setaccount",
                save: "#newSave",
                cancel: "#newCancel",
                url: updateFlymeUrl,
                eventcallback: function() {},
                successcallback: function(i, result) {
                    var text = result;
                    $('#userName').text(text + "@flyme.cn");
                    $(data[i].content).find("input").val("");
                    $("#getUserNameWrap").show();
                    $("#setUserNameWrap").hide();
                },
                rules: util.createRule({
                    account: {
                        remote: isValidFlymeUrl
                    }
                }),
                messages: util.message,
                height: 900,
                type: "修改账号"
            },
            {
                modify: "#modifyPassword",
                title: "#pwdWrap",
                content: "#changePasswordWrapFirst",
                nextContent: "#changePasswordWrap",
                save: "#ce-u-pwd-phone-check",
                cancel: "#ce-u-pwd-phone-cancel",
                url: checkOldPhoneUrl+'?type=password&vCodeTypeValue=23',
                eventcallback: function() {},
                successcallback: function(i, result) {
                    $(data[i].content).find("input").val("");
                    self.resetResize(1100);
                },
                errorcallback: function(message, errorCode) {
                    if (errorCode == logoutCode) {
                        var u = 'https://login.flyme.cn/sso/logout?useruri=https%3a%2f%2fi.flyme.cn%2fuc%2fwebjsp%2fmember%2fdetail';
                        if(/in\.meizu\.com/.test(location.hostname)) {
                            u = u.replace(/\.flyme\.cn/, '.in.meizu.com')
                        }
                        location.href = u;
                    }
                    if (errorCode == showErrorVCode) {
                        util.addTips("kapkeyTel-check-phone", message);
                    }
                },
                rules: util.createRule({
                    bindPhone: {
                      zdiyRemote: isMyPhoneUrl
                    },
                    kapkey:null
                }),
                messages: util.createMes({
                    bindPhone: {
                      zdiyRemote: '输入的不是绑定手机'
                    },
                    kapkey:null
                }),
                height: 1000,
                type: "修改密码（验证原手机）"
            },
            {
                modify: "",
                title: "#pwdWrap",
                content: "#changePasswordWrap",
                save: "#ce-u-pwdsave",
                cancel: "#ce-u-pwdcancel",
                url: modifyPasswordUrl,
                eventcallback: function() {},
                successcallback: function() {
                    nAlert("修改密码成功，请用新密码重新登录", "提示", function(e) {
                      var s = 'https://login.flyme.cn/sso/logout?useruri='
                      var callback = location.href;
                      if(/in\.meizu\.com/.test(location.hostname)){
                          s = s.replace(/\.flyme\.cn/, '.in.meizu.com');
                          callback = callback.replace(/\.flyme\.cn/, '.in.meizu.com');
                      }
                      location.href = s + encodeURIComponent(callback);
                    });
                    $(".alertDialogMain").css("border","");
                    $(".alertDialogClose").click(function(){
                    	var s = 'https://login.flyme.cn/sso/logout?useruri='
                      var callback = location.href;
                      if(/in\.meizu\.com/.test(location.hostname)){
                          s = s.replace(/\.flyme\.cn/, '.in.meizu.com');
                          callback = callback.replace(/\.flyme\.cn/, '.in.meizu.com');
                      }
                      location.href = s + encodeURIComponent(callback);
                    });
                },
                errorcallback: function(message, errorCode, fn) {
                    //$("#ce-u-current_pwd,#ce-u-new_pwd1, #ce-u-new_pwd2").val("");
                    if (errorCode == logoutCode) {
//                    	var s = 'https://login.flyme.cn/sso/logout?useruri=https%3a%2f%2fi.flyme.cn%2fuc%2fwebjsp%2fmember%2fdetail';
                    	var s = 'https://login.flyme.cn/sso/logout?useruri=' + location.href;
                        if(/in\.meizu\.com/.test(location.hostname)) s = s.replace(/\.flyme\.cn/, '.in.meizu.com')
                        location.href = s;
                    }
                    if (errorCode == showPasswordErrorCode) {
                        util.addTips("ce-u-current_pwd", message);
                    }
                    //fn&&fn();
                },
                rules: util.createRule({
                    resetPassword: {
                        unequalTo: '#memberFlyme'
                    },
                    password: {
                        required: true,
                        rangelength: false,
                        accountChar: false,
                        accountTowType: false,
                        accountNoEq: false
                    }
                }),
                messages: util.createMes({
                    resetPassword: {
                        unequalTo: '密码不能和用户名相同'
                    },
                    password: {
                        required: "密码不能为空",
                        rangelength: "",
                        accountChar: '',
                        accountTowType: '',
                        accountNoEq: ''
                    }
                }),
                height: 1100,
                type: "修改密码"
            }, {
                modify: "#emailEdite",
                title: "#emailWrap",
                nextContent: "#changeEmailWrap-active-two",
                content: "#changeEmailWrap-activeone",
                save: "#ce-u-activenext",
                cancel: "#ce-u-activecancel",
                url: "", //ReceiveEmail可变，save点击的时候才去取url   saveEvent方法里做判断
                eventcallback: function() {
                    var text = $("#email-item-middle1 .email").text();
                    $("#ce-u-current_email").text(text);
                    self.addPwdCss();
                },
                successcallback: function(i) {
                    $(data[i].content).find("input").val("");
                    $("#ce-u-active_email").val("")
                },
                rules: util.rule,
                messages: util.message,
                height: 1000,
                type: "修改邮箱（已验证第一步）"
            },

            {
                modify: "",
                title: "#emailWrap",
                content: "#changeEmailWrap-active-two",
                prevContent: "#changeEmailWrap-activeone",
                save: "#ce-u-activesave",
                cancel: "#ce-u-activecanceltwo",
                url: "/uc/webjsp/member/bindEmail?vCodeTypeValue=12",
                eventcallback: function(i) {
                    $(data[i].prevContent).find("input").val("");
                },
                successcallback: function(i, result) {
                    var text = result.email || result;
                    $("#emailWrap .email").text(self.hideEmail(text));
                    $(data[i].content).find("input").val("");
                    ReceiveEmail = text;
                    self.removePwdCss();
                    self.resetResize(848);
                },
                rules: util.createRule({
                    email: {
                        remote: isValidEMail
                    },
                    kapkey:null
                }),
                messages: util.message,/*{
                	email:{
                		remote:function(v,res){
                			if(!res.value || res.code==500){
                				$("#getKey-activeEmail").addClass("invalidBtn");
                				return res.message==""?"此邮箱已存在":res.message;
                			}
                		}
                	},
                	kapkey:null
                },*/
                height: 1100,
                type: "修改邮箱（已验证第二步）"
            },

            {
                modify: "#emailBind",
                title: "#emailWrap",
                content: "#bindEmail-step1",
                nextContent: "#bindEmailWrap",
                save: "#bindEmail-step1-savenext",
                cancel: "#bindEmail-step1-savenextcancel",
                url: checkValidPasswordUrl+'?type=email',
                eventcallback: function(i) {
                    self.addPwdCss();
                },
                successcallback: function(i) {
                },
                errorcallback: function(message, errorCode) {
                    if (errorCode == logoutCode) {
                    	var s = 'https://login.flyme.cn/sso/logout?useruri=https%3a%2f%2fmember.meizu.com%2fuc%2fwebjsp%2fmember%2fdetail';

                    	if(/in\.meizu\.com/.test(location.hostname)) s = s.replace(/\.flyme\.cn/, '.in.meizu.com')

                    	location.href = s;
                    }
                    if (errorCode == showPasswordErrorCode) {
                        util.addTips("ce-u-password-bind", message);
                    }
                },
                rules: util.createRule({
                    password: {
                        required: true,
                        rangelength: false,
                        accountChar: false,
                        accountTowType: false,
                        accountNoEq: false
                    }
                }),
                messages: util.createMes({
                    password: {
                        required: "密码不能为空",
                        rangelength: '',
                        accountChar: '',
                        accountTowType: '',
                        accountNoEq: ''
                    }
                }),
                height: 1100,
                type: "绑定邮箱（输入密码）"
            },
            {
                modify: "",
                title: "#emailWrap",
                content: "#bindEmailWrap",
                save: "#ce-u-bindsave",
                cancel: "#ce-u-bindcancel",
                url: "/uc/webjsp/member/bindEmail?vCodeTypeValue=5",
                //            url:"",
                eventcallback: function() {
                    self.addPwdCss();
                },
                successcallback: function(i, result) {
                    var item = $("#email-item-middle1");
                    item.siblings(".item-middle").hide();
                    item.show();
                    var text = result.email || result;
                    item.find(".email").text(self.hideEmail(text));
                    $("#emailEdite").parent(".item-right").show().siblings(".item-right").hide();
                    $(data[i].content).find("input").val("");
                    ReceiveEmail = text;
                    self.getSaveLevel();
                    self.removePwdCss();
                    self.resetResize(848);
                },
                rules: util.createRule({
                    email: {
                        remote: isValidEMail
                    },
                    kapkey:null
                }),
                messages: util.message,/*{
                	email:{
                		remote:function(v,res){
                			if(!res.value || res.code==500){
                				$("#getKey-bindEmail").addClass("invalidBtn");
                				return res.message==""?"此邮箱已存在":res.message;
                			}
                		}
                	},
                	kapkey:null
                },*/
                height: 1100,
                type: "绑定邮箱"
            },
            {
                modify: "#emailbindEdite",
                title: "#emailWrap",
                content: "#changeEmailWrap-unactiveone",
                nextContent: "#changeEmailWrap-unactive",
                save: "#ce-u-savenext",
                cancel: "#ce-u-savenextcancel",
                url: checkValidPasswordUrl+'?type=email',
                eventcallback: function(i) {
                    self.addPwdCss();
                },
                successcallback: function(i) {
                },
                errorcallback: function(message, errorCode) {
                    if (errorCode == logoutCode) {
                    	var u = 'https://login.flyme.cn/sso/logout?useruri=https%3a%2f%2fi.flyme.cn%2fuc%2fwebjsp%2fmember%2fdetail';

                    	if(/in\.meizu\.com/.test(location.hostname)) u = u.replace(/\.flyme\.cn/, '.in.meizu.com')

                    	location.href = u;
                    }
                    if (errorCode == showPasswordErrorCode) {
                        util.addTips("ce-u-password", message);
                    }
                },
                rules: util.createRule({
                    password: {
                        required: true,
                        rangelength: false,
                        accountChar: false,
                        accountTowType: false,
                        accountNoEq: false
                    }
                }),
                messages: util.createMes({
                    password: {
                        required: "密码不能为空",
                        rangelength: '',
                        accountChar: '',
                        accountTowType: '',
                        accountNoEq: ''
                    }
                }),
                height: 1100,
                type: "修改邮件（未验证-先验证密码）"
            },
            {
                modify: "",
                title: "#emailWrap",
                content: "#changeEmailWrap-unactive",
                save: "#ce-u-save",
                cancel: "#ce-u-cancel",
                url: "/uc/webjsp/member/updateNotVerifiedEmail?vCodeTypeValue=15",
                eventcallback: function(i) {
                },
                successcallback: function(i, result) {
                    var item = $("#email-item-middle1");
                    item.siblings(".item-middle").hide();
                    item.show();
                    var text = result.email || result;
                    item.find(".email").text(self.hideEmail(text));
                    $("#emailbindEdite").parent(".item-right").show().siblings(".item-right").hide();
                    $(data[i].content).find("input").val("");
                    self.removePwdCss();
                    self.resetResize(1200);

                    var s = 'https://i.flyme.cn/uc/webjsp/member/detail';

                    if(/in\.meizu\.com/.test(location.hostname)) s = s.replace(/\.flyme\.cn/, '.in.meizu.com')

                    location.href = s;
                },
                rules: util.rule,
                messages: util.message,/*{
                	email:{
                		remote:function(v,res){
                			if(!res.value || res.code==500){
                				$("#getKeynewEmail").addClass("invalidBtn");
                				return res.message==""?"此邮箱已存在":res.message;
                			}
                		}
                	},
                	kapkey:null
                },*/
                height: 1200,
                type: "修改邮件（未验证）"
            },
            {
                modify: "#bindMobile",
                title: "#telWrap",
                content: "#bindTel-step1",
                nextContent: "#bindTelWrap",
                save: "#bindTel-step1-setTelCheckPassSave",
                cancel: "#bindTel-step1-setTelCheckPassCancel",
                url: checkValidPasswordUrl+'?type=phone',
                eventcallback: function(){},
                successcallback: function(i, result) {
                    $(data[i].content).find("input").val("");
                    self.resetResize(1100);
                },
                errorcallback: function(message, errorCode) {
                    if (errorCode == logoutCode) {
                        var u = 'https://login.flyme.cn/sso/logout?useruri=https%3a%2f%2fmember.meizu.com%2fuc%2fwebjsp%2fmember%2fdetail';
                        if(/in\.meizu\.com/.test(location.hostname)) {
                            u = u.replace(/\.flyme\.cn/, '.in.meizu.com')
                        }
                        location.href = u;
                    }
                    if (errorCode == showPasswordErrorCode) {
                        util.addTips("ce-u-passwordNew-bindTel", message);
                    }
                },
                rules: util.createRule({
                    password: {
                        required: true,
                        rangelength: false,
                        accountChar: false,
                        accountTowType: false,
                        accountNoEq: false
                    }
                }),
                messages: util.createMes({
                    password: {
                        required: "密码不能为空",
                        rangelength: '',
                        accountChar: '',
                        accountTowType: '',
                        accountNoEq: ''
                    }
                }),
                height: 1000,
                type: "修改手机号码（验证密码）"
            },
            {
                modify: "",
                title: "#telWrap",
                content: "#bindTelWrap",
                save: "#ce-u-bindTelsave",
                cancel: "#ce-u-bindTelcancel",
                url: "/uc/webjsp/member/bindPhone?vCodeTypeValue=6",
                eventcallback: function() {},
                successcallback: function(i, result) {
                    var item = $("#telModify");
                    item.siblings(".item-middle").hide();
                    item.show();
                    $("#editMobile").parent(".item-right").show().siblings(".item-right").hide();
                    $('#current_phone').text(self.hidePhone(result));
                    self.getSaveLevel();
                    self.resetResize(848);
                    location.reload();
                },
//                 errorcallback: function(message, errorCode) {
//                     if (errorCode == 110000) {
//                         util.addTips("ce-u-bind_tel", message);
//                     }
//                     if (errorCode == 200000) {
//                         util.addTips("ce-u-bind_tel", message);
//                     }
//                 },
                rules: util.createRule({
                    phone: {
                    	zdiyRemote: isValidPhoneUrl
                    },
                    kapkey:null
                }),
                messages: util.createMes({
                	phone: {
                    	zdiyRemote: "此号码已被绑定"
                    },
                    kapkey:null
                }),
                height: 1100,
                type: "绑定手机号码"
            },
            {
                modify: "#editMobile",
                title: "#telWrap",
                content: "#setTelCheckPass",
                nextContent: "#changeTelWrap-activeNew",
                save: "#setTelCheckPassSave",
                cancel: "#setTelCheckPassCancel",
                url: checkOldPhoneUrl+'?type=phone_update&vCodeTypeValue=23',
                eventcallback: function() {},
                successcallback: function(i, result) {
                    $(data[i].content).find("input").val("");
                    self.resetResize(1100);
                },
                errorcallback: function(message, errorCode) {
                    if (errorCode == logoutCode) {
                        var u = 'https://login.flyme.cn/sso/logout?useruri=https%3a%2f%2fi.flyme.cn%2fuc%2fwebjsp%2fmember%2fdetail';
                        if(/in\.meizu\.com/.test(location.hostname)) {
                            u = u.replace(/\.flyme\.cn/, '.in.meizu.com')
                        }
                        location.href = u;
                    }
                    if (errorCode == showErrorVCode) {
                        util.addTips("kapkeyTelOld", message);
                    }
                },
                rules: util.createRule({
                    bindPhone: {
                      zdiyRemote: isMyPhoneUrl
                    },
                    kapkey:null
                }),
                messages: util.createMes({
                    bindPhone: {
                      zdiyRemote: '输入的不是绑定手机'
                    },
                    kapkey:null
                }),
                height: 1000,
                type: "修改手机号码（验证原手机）"
            }, {
                modify: "",
                title: "#telWrap",
                content: "#changeTelWrap-activeNew",
                save: "#ce-u-telsaveNew",
                cancel: "#ce-u-telcancelNew",
                url: "/uc/webjsp/member/modifyBindPhoneCheck?vCodeTypeValue=14",
                eventcallback: function() {},
                successcallback: function(i, result) {
                    $(data[i].content).find("input").val("");
                    $('#current_phone').text(self.hidePhone(result));
                    self.resetResize(848);
                },
                rules: util.createRule({
                    phone: {
                    	zdiyRemote: isValidPhoneUrl
                    },
                    kapkey:null
                }),
                messages: util.createMes({
                	phone: {
                    	zdiyRemote: "此号码已被绑定"
                    },
                    kapkey:null
                }),
                height: 1100,
                type: "修改手机号码（选择类型）"
            },
            {
                modify: "#setSafe",
                title: "#questionWrap",
                content: "#setQuestion-stepOne",
                nextContent: "#setQuestion-stepTwo",
                save: "#setQuestionSave",
                cancel: "#setQuestionCancel",
                url: checkValidPasswordUrl+'?type=question',
                eventcallback: function() {},
                successcallback: function(i) {
                    $(data[i].content).find("input[type != hidden]").val("");
                    self.resetResize(1100);
                },
                errorcallback: function(message, errorCode) {
                    if (errorCode == logoutCode) {
                    	var u = 'https://login.flyme.cn/sso/logout?useruri=https%3a%2f%2fi.flyme.cn%2fuc%2fwebjsp%2fmember%2fdetail';
                        if(/in\.meizu\.com/.test(location.hostname)) {
                            u = u.replace(/\.flyme\.cn/, '.in.meizu.com')
                        }
                        location.href = u;
                    }
                    if (errorCode == showPasswordErrorCode) {
                        util.addTips("setQuestion_pwd", message);
                    }
                },
                rules: util.createRule({
                    password: {
                        required: true,
                        rangelength: false,
                        accountChar: false,
                        accountTowType: false,
                        accountNoEq: false
                    }
                }),
                messages: util.createMes({
                    password: {
                        required: "密码不能为空",
                        rangelength: '',
                        accountChar: '',
                        accountTowType: '',
                        accountNoEq: ''
                    }
                }),
                height: 1000,
                type: "设置密保（第一次）先验证"
            }, {
                modify: "",
                title: "#questionWrap",
                content: "#setQuestion-stepTwo",
                save: "#ce-u-setQuetionsave",
                cancel: "#ce-u-setQuetioncancel",
                redirect: true,
                redirectUrl: redirectUrl,
                url: updateUserAnswerUrl,
                eventcallback: function() {},
                successcallback: function(i) {
                    $(data[i].content).find("input[type != hidden]").val("");
                    $(data[i].content).find("select").removeClass("checked").find("option:first").attr("selected", "selected");
                    self.resetResize(848);
                },
                rules: util.rule,
                messages: util.message,
                type: "设置密保（第一次）"
            },
            {
                modify: "#modifySafe",
                title: "#questionWrap",
                content: "#changeQuestionWrap",
                save: "#ce-u-cquestionsave",
                cancel: "#ce-u-cquestioncansel",
                url: isValidUserAnswerUrl,
                eventcallback: function() {},
                successcallback: function(i) {
                    $(data[i].title).hide();
                    $(data[i].content).find("input[type != hidden]").val("");
                    $("#resetQuestion").show();
                },
                rules: util.rule,
                messages: util.message,
                height: 1100,
                type: "修改密保（先验证）"
            },
            {
                modify: "",
                title: "#questionWrap",
                content: "#resetQuestion",
                save: "#ce-u-resetQuetionsave",
                cancel: "#ce-u-resetQuetioncancel",
                redirect: true,
                redirectUrl: redirectUrl,
                url: updateUserAnswerUrl,
                eventcallback: function() {},
                successcallback: function(i) {
                    $(data[i].content).find("input").val("");
                    $(data[i].content).find("select").removeClass("checked").find("option:first").attr("selected", "selected");
                    self.resetResize(848);
                },
                rules: util.rule,
                messages: util.message,
                height: 1100,
                type: "修改密保（修改）"
            }
        ];
        return data;
    },
    getSaveLevel: function() {
        var param = {};
        var self = this;
        util.doAsyncPost("/uc/webjsp/account/getSecurityScore", function(result) {
            $("#safeLevel").text(result.value.score);
            self.checkSaveLevel();
        }, param);
    },
    checkSaveLevel: function(){
    	var $safeLevel = $("#safeLevel");
        var safeLevel = $("#safeLevel").text();
        if(safeLevel <= 40){
            $safeLevel.addClass('red');
        }else
        if(safeLevel <= 70){
            $safeLevel.addClass('orange');
        }else
        if(safeLevel <= 100){
            $safeLevel.addClass('green');
        }
    },
    hideEmail: function(changeEmail) {
        var email = changeEmail.split("@")[0];
        var suffix = changeEmail.split("@")[1];
        var length = email.length;
        var hiddenEmail = "";
        hiddenEmail += email.charAt(0);
        if (length >= 4) {
            hiddenEmail += "****";
            for (var i = length - 3; i < length; i++) {
                hiddenEmail += email.charAt(i);
            }
        } else {
            for (var i = 0; i < 8 - length; i++) {
                hiddenEmail += "*";
            }
            for (var i = 1; i < length; i++) {
                hiddenEmail += email.charAt(i);
            }
        }
        return hiddenEmail + "@" + suffix;
    },
    hidePhone: function(changePhone) {
        var self = this;
        //判断是否带国家码
        if (changePhone.indexOf(":") != -1) {
            var phoneAndArea = changePhone.split(":");
            if (phoneAndArea.length == 2) {
                changePhone = phoneAndArea[1];
            }
        }
        //适配各种电话号码长度
        if (changePhone.length == 6) {
           return self.plusXing(changePhone, 1, 1);
        }else if (changePhone.length == 7) {
           return self.plusXing(changePhone, 1, 2);
        }else if (changePhone.length == 8) {
           return self.plusXing(changePhone, 2, 2);
        }else if (changePhone.length == 9) {
           return self.plusXing(changePhone, 3, 2);
        }else if (changePhone.length == 10) {
           return self.plusXing(changePhone, 2, 4);
        }else if (changePhone.length == 11) {
           return self.plusXing(changePhone, 3, 4);
        }else {
           if(changePhone.length < 6){
               return self.plusXing(changePhone, 0, 1);
           }else{
               return self.plusXing(changePhone, 4, 4);
           }
        }
        //return changePhone.substring(0, 3) + "****" + changePhone.substring(7, 11);
    },
    plusXing: function(str,frontLen,endLen) {
        var len = str.length-frontLen-endLen;
        var xing = '';
        for (var i=0;i<len;i++) {
            xing+='*';
        }
        return str.substr(0,frontLen)+xing+str.substr(str.length-endLen);
    },
    showKapkeyText: function(dom) {
        $(dom).find(".get_kapkey").show();
        $(dom).find(".kapkey_requested").hide();
    },
    getKapkey: function() {
        var self = this;
        var _beginCount = function(count, $o) {
            $o.addClass('invalidBtn');
            $o.text('已发送 ' + count);
            interval = setInterval(function() {
                count--;
                $o.text('已发送 ' + count);
                if (count <= 0) {
                    clearInterval(interval);
                    $o.text('获取验证码');
                    $.data($o[0], 'going', false);
                    if ($.data($o[0], 'isPhoneOk')) {
                        $o.removeClass('invalidBtn');
                    }
                }
            }, 1000);
        };
        $("form").delegate(".get_kapkey", "click", function(e) {
            var targetId = e.target.id;
            var vCodeType = 12;
            var param = {};
            var sendEmailVcode = "/uc/webjsp/vcode/sendEmailVcodeNoEmail?targetId=" + targetId;
            var sendSmsVCode = "/uc/webjsp/vcode/sendSmsVCode";
            var This = $(this);
            var type = This.attr("data-type");
            var form = This.parents("form");
            var code = This.attr("data-value");
            var email = form.find("input[name=email]");
            var mobile = form.find("input[name=mobile]");
            var phone = form.find("input[name=phone]");
            if ($(this).attr("data-action") == "bindPhone") {
                sendSmsVCode = "/uc/webjsp/vcode/sendSmsVCodeForCheck";
                phone = form.find("input[name=bindPhone]");
            }
            if (type == "1") {
                return;
            }
            if (mobile.length > 0) {
                var val = mobile.val();
                param.phone = val;
            }
            if (email.length > 0) {
                var val = email.val();
                param.email = val;
            }
            if (phone.length > 0) {
                var val = phone.val();
                param.phone = val;
            }
            if (targetId == "getKeyone") { //邮箱有省略拿全局变量里完整的
                param.email = ReceiveEmail;
            }
            param.vCodeTypeValue = parseInt(code);
            if(!!param.phone){
                if($.data(This[0], 'going')){
                    return;
                }
                nAlert('<p>请输入图中文字</p><p class="normalInput"><input type="text" value="" name="kapmap" id="kapmap" class="kapkey" maxlength="6" autocomplete="off"><img id="imgKey" class="pointer" title="点击可刷新验证码" src="/kaptcha.jpg?t=1411024557506"></p>',"提示",function(){
                    param.kapkey = $("#kapmap").val();
                    param.phone = '00' + ($('#cycode').html() - 0) + ':' + param.phone;
                    util.doAsyncPost(sendSmsVCode, function(result){
                        result = util.getData(result, false, function(mes, code, callback){
                            callback();
                        });
                        if(result == true){
                            $.data(This[0], 'going', true);
                            _beginCount(60, This);
                        }
                    }, param);
                });
                $("#kapmap").focus();
                function refreshImg(){
                    $("#imgKey")[0].src = "/kaptcha.jpg?t="+new Date().getTime();
                    return false;
                }
                $("#imgKey").click(refreshImg);
                refreshImg();
                $(".alertDialogMain").css("border","none")
            }else{
            	setTimeout(function(){
            		if($("#ce-u-active_email").is(":visible") && $("#ce-u-active_email").hasClass("error")){
            			$("#getKey-activeEmail").addClass("invalidBtn");
            			return;
            		}
            		if($("#ce-u-new_email").is(":visible") && $("#ce-u-new_email").hasClass("error")){
            			$("#getKeynewEmail").addClass("invalidBtn");
            			 return;
            		}
            		if($("#ce-u-bind_email").is(":visible") && $("#ce-u-bind_email").hasClass("error")){
            			$("#getKey-bindEmail").addClass("invalidBtn");
            			 return;
            		}
            		var hideMail = "", temp = param.email.split("@");
                	if(temp[0].length===1) hideMail = temp[0]+"*******@"+temp[1];
                	if(temp[0].length===2) hideMail = temp[0].substring(0,1)+"******"+temp[0].substring(1,2)+"@"+temp[1];
                	if(temp[0].length===3) hideMail = temp[0].substring(0,1)+"*****"+temp[0].substring(1,3)+"@"+temp[1];
                	if(temp[0].length>3) hideMail = temp[0].substring(0,1)+"****"+temp[0].substring(temp[0].length-3,temp[0].length)+"@"+temp[1];
                	// nAlert("验证码已发往邮箱"+hideMail+",<br/>请前往查看并将验证码填写在输入框<br/>（30分钟内有效）","提示");
                    util.doAsyncPost(sendEmailVcode, operate, param);
            	},200)
            }
            function operate(result){
                result = util.getData(result, null, function(message, errorCode) {
                    if (errorCode == 110000) {
                        var id = This.parents("form").find("input[name=mobile]").attr("id");
                        util.addTips(id, message);
                        This.attr("data-type", 1).addClass("invalidBtn");
                    } else {
                        var id = This.parents("form").find("input[name=email]").attr("id");
                        if(errorCode == 200001){
                            nAlert(message, '提示');
                        }
                        else if(errorCode == 200003){
                            nAlert(message, '提示');
                        }
                        else if(errorCode == 200011){
                            nAlert(message, '提示');
                        }
                        else if (id) {
                            util.addTips(id, message);
                            This.attr("data-type", 1).addClass("invalidBtn");
                        } else {
                            nAlert(message, '提示');
                            $(".alertDialogMain").css("border","")
                            This.attr("data-type", 1).addClass("invalidBtn");
                        }
                    }
                });
                if (result == null) return;
                var hideMail = "", temp = param.email.split("@");
                nAlert("验证码已发往邮箱"+hideMail+",<br/>请前往查看并将验证码填写在输入框<br/>（30分钟内有效）","提示");
                var dom = This.parent().find(".interval_num");
                var json = {
                    dom: dom,
                    This: This
                };
                self.setTimeout(json, function() {
                    This.show();
                    This.next().hide();
                });
                This.hide();
                This.next().show();
                This.next().addClass("invalidBtn");
            }
        });
    },
    renotice: function() {
        var self = this;
        $(".renotice").click(function() {
            var This = $(this);
            var status = This.attr("data-status");
            if (status == 1) {
                util.doAsyncPost("/uc/system/webjsp/account/resendActiveEmail", function(result) {
                    result = util.getData(result);
                    if (result == null) return;
                    var dom = This.parent().find(".timeup");
                    var json = {
                        dom: dom,
                        This: This
                    };
                    self.setTimeout(json, function() {

                    });
                    This.attr("data-status", 2).addClass("invalidBtn");
                });
            }
        });
    },
    setTimeout: function(json, callback) {
        var num = 60;
        var dom = json.dom;
        var This = json.This;
        dom.show().css({
            color: "#7f7f7f",
            cursor: "default"
        });
        var time = setInterval(function() {
            num--;
            dom.text(num);
            if (num == 0) {
                clearInterval(time);
                callback();
                This.attr("data-status", 1).removeClass("invalidBtn");
                dom.hide().text(60);
            }
        }, 1000);
    },
    getPrevTitle: function(prev) { //获取用于展示的title
        if (prev.hasClass("lineWrap")) {
            return prev;
        } else {
            var obj = prev.prev();
            return this.getPrevTitle(obj);
        }
    },
    showPrevTitle: function(form, callback, e, source) { //点修改的时候隐藏其他修改项的可编辑部分  显示title
        if (!e) return;
        if (source && source.src) {
            window.location.href = source.src;
            return;
        }
        var parent = form.parents(".modify_content");
        var prev = parent.prev();
        parent.hide();
        var obj = this.getPrevTitle(prev);
        form.find(".normalInput, input").removeClass("error").removeClass("checked");
        form.find("input[type!=hidden]").val("");
        form.find("span.error").hide();
        $(obj).show();
        callback(e);
    },
    EditEventCheckInput: function(source, callback) { //点修改的时候判断input是否有输入
        var self = this;
        var This = source.self;
        var form = $("form:visible");
        if (form.length > 0) {
            var input = form.find("input[type!=hidden]");
            var len = input.length;
            if (len == 0) {
                this.showPrevTitle(form, callback, true, source);
            } else {
                for (var o = 0; o < len; o++) {
                    if (input.eq(o).val() != "" && (This.hasClass("modify")||This.hasClass("getFunnyNameTitle"))) {
                        nConfirm("<p>当前信息尚未保存</p><p>修改其他项目将导致当前正在编辑的信息丢失</p><p>是否继续？</p>", "提示", function(e) {
                            self.showPrevTitle(form, callback, e, source);
                        });
                        return;
                    } else {
                        this.showPrevTitle(form, callback, true, source);
                    };
                }
            }
        } else {
            callback(true);
        }
    },
    getAllOptionsKey: function(data) {
        var json = {
            title: data.title,
            prevTitle: data.prevTitle,
            modify: data.modify,
            content: data.content,
            nextContent: data.nextContent,
            save: data.save,
            cancel: data.cancel,
            rules: data.rules,
            messages: data.messages,
            successcallback: data.successcallback,
            errorcallback: data.errorcallback,
            eventcallback: data.eventcallback,
            height: data.height,
            url: data.url,
            redirect: data.redirect,
            redirectUrl: data.redirectUrl
        };
        return json;
    },
    modifyEvent: function(json, index) {
        var self = this;
        if (!json.modify || json.modify == "") {
            return;
        }
        $(json.modify).click(function() {
            var This = $(this);
            var source = {
                self: This
            };
            self.EditEventCheckInput(source, function(status) {
                if (status) {
                    $(json.title).hide();
                    $(json.content).show();
                    if (json.eventcallback) {
                        json.eventcallback(index)
                    };
                    self.resetResize(json.height);
                } else {}
            });
        });
    },
    saveEvent: function(json, index) {
        var self = this;
        var form = $(json.content).find('form');
        var $cycodeBox = $("#cycode-box");
        form.validate($.extend(util.simpleValidate, {
            errorClass: "error",
            validClass: "checked",
            errorElement: "span",
            onfocusout: function(element) {
                var dom = $(element);
                var isPhone = element.name == 'phone';

                dom.valid();

                if (dom.attr("data-key") == "kapkey") {
                    if (dom.hasClass("checked")) {
                    	if(dom.parents("form").find(".get_kapkey").text().indexOf("已发送")!=-1) return;
                    	setTimeout(function(){
                    		if(dom.parents("form").find("input[data-key='kapkey']").hasClass("error")) return;
                            dom.parents("form").find(".get_kapkey").removeClass("invalidBtn").attr("data-type", 2);
                    	},50);
                    }
                    if (dom.hasClass("error")) {
                        dom.parents("form").find(".get_kapkey").addClass("invalidBtn").attr("data-type", 1);
                    }

                    // 国家码，这里的dom结构不同。。
                    if(isPhone) {
                    	if(dom.parents("form").find(".get_kapkey").text().indexOf("已发送")!=-1) return;

                    	setTimeout(function(){
                    		if(dom.parents("form").find("input[data-key='kapkey']").hasClass("error")) return;
                            dom.parents("form").find(".get_kapkey").removeClass("invalidBtn").attr("data-type", 2);
                    	},50);

                    	if($cycodeBox.hasClass('error')) {
                    		dom.parents("form").find(".get_kapkey").addClass("invalidBtn").attr("data-type", 1);
                    	}
                    }
                }
            },
            onfocusin: function(element) {
                var dom = $(element);
                if (dom.attr("id") == "newnickName") {
                    return;
                }
                dom.valid();
            },
            submitHandler: function() {
            	var data = CountryCode.getFormData(form)

                data['phone'] = '00' + ($('#cycode').html() - 0) + ':' + data['phone']
            	data['form_resubmit_token_key'] = $("#form_resubmit_token_key").val()

                $.ajax({
                    type: "post",
                    url: json.url,
                    data: data,
                    dataType: "json",
                    success: function(result) {
                        util.getToken('doSyncPost');
                        result = util.getData(result, null, json.errorcallback);
                        if (result == null) {
                            return;
                        }
                        if (json.redirect) {
                            location.href = json.redirectUrl;
                            return;
                        }
                        $('form').find('.normalInput, input').removeClass("error").removeClass("checked");
                        $('form').find('input[type!=hidden]').val('');
                        var showContent = json.nextContent ? json.nextContent : json.title;
                        // hardcode...
                        if('#changeTelWrap-activeNew' === showContent && !$(showContent).find('#cycode').length) {
                        	var $box = $('#cycode-box')
                        	$('#ce-u-cTelNew').replaceWith($box)
                        	$(showContent).find('#ce-u-bind_tel').attr('id', '#ce-u-cTelNew')
                        }

                        $('form').find("span.error").remove();
                        $(showContent).show();
                        $(json.content).hide();
                        if (json.successcallback) {
                            json.successcallback(index, result)
                        }
                        if (json.content == "#changeTelWrap-activeNew" ) {
                            self.showKapkeyText(json.content);
                        }
                    },
                    error: function(result) {
                        util.getToken('doSyncPost');
                        nAlert("网络错误！", "提示");
                        $(".alertDialogMain").css("border","")
                    }
                });
            },
            showErrors: function(errorMap, errorList) {
            	var defShowErr = this.defaultShowErrors
            	var phoneMsg = errorMap['phone']

                if(phoneMsg) {
                	$cycodeBox.addClass('error')
                    if(!$('#err-tips-phone').length)
                    	$('<span id="err-tips-phone" for="phone" class="error">'+phoneMsg+'</span>').insertAfter($cycodeBox)
                    delete errorMap['phone']
                }

                defShowErr.call(this, errorMap, errorList)
            },
            rules: json.rules,
            messages: json.messages
        }));
        $(json.save).click(function() {
            if ($(this).attr("id") == "ce-u-activenext") { //修改邮箱第一步   ReceiveEmail会动态改变，写到点击事件内部,避免被缓存
                var validEmailCodeUrl = "/uc/webjsp/vcode/isValidEmailCheck?email=" + ReceiveEmail + "&vCodeTypeValue=12";
                json.url = validEmailCodeUrl;
            }
            var form = $(json.content).find('form');
            form.submit();
        });
    },
    cancelEvent: function(json) {
        var self = this;
        $(json.cancel).click(function() {
            $("#questionCode1").setValue({
                "text": "请选择密保问题",
                "value": ""
            });
            $("#questionCode2").setValue({
                "text": "请选择密保问题",
                "value": ""
            });
            $("#questionCode3").setValue({
                "text": "请选择密保问题",
                "value": ""
            });
            $("#questionCode4").setValue({
                "text": "请选择密保问题",
                "value": ""
            });
            $(".dropdown_menu li").show();
            $('form').find('.normalInput, input[type!=hidden]').removeClass("error").removeClass("checked");
            $('form').find('input[type!=hidden]').val('');
            $('form').find("select").removeClass("checked").removeClass("error").find("option:first").attr("selected", "selected");
            $('form').find("span.error").remove();
            $(json.title).show();
            $(json.content).hide();
            self.removePwdCss();
            if (json.prevTitle) {
                $(json.prevTitle).hide();
            }
            if (json.content == "#changeTelWrap-activeNew" || json.content == "#bindTelWrap") {

                self.showKapkeyText(json.content);
            }
            self.resetResize(848);
        });
    },
    addPwdCss: function() {
        $("#pwdWrap").addClass("pwd_position");
    },
    removePwdCss: function() {
        $("#pwdWrap").removeClass("pwd_position");
    },
    mscEvents: function() { //修改modify 保存save 取消cancel  事件
        var self = this;
        var data = this.getAllOptions();
        var len = data.length;
        for (var i = 0; i < len; i++) {
            (function() {
                var json = self.getAllOptionsKey(data[i]);
                var index = i;
                self.modifyEvent(json, index);
                self.saveEvent(json, index);
                self.cancelEvent(json);
            })();
        }
    },
    revealEvent: function(){//明文，密文切换事件
        var $pwd1 = $('#ce-u-new_pwd1');
        var $pwd2 = $('#ce-u-new_pwd2');
        function _createPwd(type){
            if(type == 'text'){
                $pwd1.val($pwd2.val());
                $pwd1.attr('name', 'resetPassword').show();
                $pwd2.removeAttr('name').hide();
                if(!$pwd1.val()){
                    $pwd1.next('.inputTip').show();
                }
                $pwd2.next('.inputTip').hide();
            }else{
                $pwd2.val($pwd1.val());
                $pwd2.attr('name', 'resetPassword').show();
                $pwd1.removeAttr('name').hide();
                if(!$pwd2.val()){
                    $pwd2.next('.inputTip').show();
                }
                $pwd1.next('.inputTip').hide();
            }
            $(this).removeClass(type == 'text' ? 'pwdBtn' : 'pwdBtnShow');
            $(this).addClass(type == 'text' ? 'pwdBtnShow' : 'pwdBtn');
        };
        $('#pwdBtn').click(function(){
            if($(this).hasClass('pwdBtn')){
                _createPwd.call(this, 'text');
            }else{
                _createPwd.call(this, 'password');
            }
        });
    },
    getQuestionList: function(one, two) {
        var self = this;
        $("." + one).click(function() {
            var This = $(this);
            var inputHidden = This.next();
            var value = This.attr("value");
            inputHidden.val(value);
            if (value != 0) {
                $("." + two + ":visible span").show();
                $("." + two + ":visible option").eq(value).wrap('<span style="display:none;"></span>');
            }
        });
    },
    mailAuto: function() {
        mzMailAuto('ce-u-new_email');
        mzMailAuto('ce-u-bind_email');
        mzMailAuto('ce-u-active_email');
        mzMailAuto('validateEmail');
    },
    resize: function() {
        var $con = $('#content'),
            _this = this;
        return function() {
            $con.height($(window).height() - _this.fHeight);
        };
    }
});

function bindCycodeEvent() {
    var $cycodeBox = $('#cycode-box');
    var $account = $('#ce-u-bind_tel');

    $account.on('focus', function(e) {
    	if($cycodeBox.hasClass('error')) {
    		$cycodeBox.removeClass('error')
    		$('#err-tips-phone').remove()
    	}
    })
}
