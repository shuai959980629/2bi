//jQuery.extend(jQuery.validator.messages, {
//	required : "必填项",
//	remote : "请修正该字段",
//	email : "请输入正确格式的电子邮件",
//    isPhone:"请输入有效的联系电话",
//	url : "请输入合法的网址",
//	date : "请输入合法的日期",
//	dateISO : "请输入合法的日期 (ISO).",
//	number : "请输入合法的数字",
//	digits : "只能输入整数",
//	creditcard : "请输入合法的信用卡号",
//	equalTo : "请再次输入相同的密码",
//	accept : "请输入拥有合法后缀名的字符串",
//	maxlength : jQuery.validator.format("请最多输入{0}个字符。"),
//	minlength : jQuery.validator.format("请最少输入{0}个字符。"),
//	rangelength : jQuery.validator.format("请输入长度在{0}到{1}个字符。"),
//	range : jQuery.validator.format("请输入{0}到{1}之间的字符"),
//	max : jQuery.validator.format("最大值不能超过{0}"),
//	min : jQuery.validator.format("最小值不能小于{0}")
//});

jQuery.extend(jQuery.validator.messages, {
    required : "X",
    remote : "X",
    email : "X",
    isPhone:"X",
    url : "X",
    date : "X",
    dateISO : "X",
    number : "X",
    digits : "X",
    creditcard : "X",
    equalTo : "X",
    accept : "X",
    maxlength : jQuery.validator.format("X"),
    minlength : jQuery.validator.format("X"),
    rangelength : jQuery.validator.format("X"),
    range : jQuery.validator.format("X"),
    max : jQuery.validator.format("X"),
    min : jQuery.validator.format("X")
});

function jump_url(url) {
	if (url) {
		window.location.href = url;
	}
}

function post_ajax(from) {
	$.post($("#" + from).attr('action'), $("#" + from).serialize(), function(data, textStatus) {
		if (data.status == 1) {
            html_notice('邻售后台管理',data.msg,1);
		} else {
            html_notice('邻售后台管理',data.msg,0);  
		}
	}, "json");
}


function html_notice(title,msg,is_refresh){
	var nhtml = '<div id="prompt">';
	nhtml += '<div class="title">'+title+'</div>';
	nhtml += '<div class="content">'+msg+'</div>';
	nhtml += '<div class="prompt_button"><a class="determine prompt_confirm" is_refresh="'+is_refresh+'" href="javascript:void(0)">确定</a></div>';
	nhtml += '</div><div id="pop_up"></div>';
	$("body").append(nhtml);
}

$(".prompt_confirm").live('click',function(){
    cancel();
	$("#prompt").remove();
	$("#pop_up").remove();
    var is_refresh = $(this).attr('is_refresh');
    if(is_refresh==1){
        /*
        var url = window.location.href;
        var arr = url.split('?');
        window.location.href = arr[0];
        */
        window.location.reload();
    }
});

//function CheckMail(email)
//{
//    var MailReg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
//    if ( ! MailReg.test(email) )
//        return false;
//
//    return true;
//}
//
//function CheckPhone(phone)
//{
//    var PhoneReg = /^(13+\d{9})|(15+\d{9})|(18+\d{9})$/;
//    if ( ! PhoneReg.test(phone) )
//        return false;
//
//    return true;
//}

// 联系电话(手机/电话皆可)验证
jQuery.validator.addMethod("isPhone", function(value,element) {
    var length = value.length;
    var mobile = /^(((13[0-9]{1})|(15[0-9]{1}))+\d{8})$/;
    var tel = /^\d{3,4}-?\d{7,9}$/;
    return this.optional(element) || (tel.test(value) || mobile.test(value));
}, "X");//请正确填写您的联系电话

// 文字验证匹配
jQuery.validator.addMethod("isBlank", function(value,element) {
    var values = value.replace(/(\r)*\n/g,"").replace(/\s/g,"").replace(/&nbsp;/g,"").replace(/<br\/>/g,"");
    return this.optional(element) || (values != '');
}, "X");//请正确填写描述内容！

// 判断是否上传图片
jQuery.validator.addMethod("isUpload", function(value,element) {
    return this.optional(element) || ((value > 0) && $('#image_src').val() != '');
}, "X");//你忘了上传附件了哦！

// 判断企业log是否上传图片
jQuery.validator.addMethod("isUploadLogo", function(value,element) {
    return this.optional(element) || ((value > 0) && $('#logo_src').val() != '');
}, "X");//你忘了上传logo了哦！

// 判断是否上传音频
jQuery.validator.addMethod("isUploadApp", function(value,element) {
    return this.optional(element) || ((value > 0) && $('#app_src').val() != '');
}, "X");//你忘了上传音频附件了哦！

// 判断是否存在门店联系方式
jQuery.validator.addMethod("isHavePhone", function(value,element) {
    return this.optional(element) || ((value > 0));
}, "X");//请至少填写一个门店联系方式！

// 判断是否存在关键字回复内容
jQuery.validator.addMethod("isHavekey", function(value,element) {
    return this.optional(element) || ($('#wx_content').val() != '' && $('input[name="cnt_selected[]"]').length > 0);
}, "X");//"请填写完整关键字自动回复信息！"

// 判断输入数据是否符合要求
jQuery.validator.addMethod("isCompliance", function(value,element) {
    return this.optional(element) || (value >= 6 && value <= 12);
}, "X");//"请填写6~12之间的数字！"

// 去掉前后空格后比较文字长度
jQuery.validator.addMethod("text_trim", function(value,element) {
    return this.optional(element) || ($.trim(value).length >= 2 && $.trim(value).length <= 25);
}, "X");//请确保文字前后无空格后文字长度在2~25以内！

//判断下拉框是否选择
jQuery.validator.addMethod("selected", function(value,element) {
    return this.optional(element) || ($(element).val()!=0);
}, "X");

jQuery.validator.addMethod("otherselected", function(value,element) {
    return this.optional(element) || ($(element).val()!='');
}, "X");

var FormValidation = function() {
	return {
		init : function() {
			// for more info visit the official plugin documentation: 
			// http://docs.jquery.com/Plugins/Validation
			var form1 = $('#form_add_accounts');
			var error1 = $('.alert-error', form1);
			var success1 = $('.alert-success', form1);
			form1.validate({
				errorElement : 'span', //default input error message container
				errorClass : 'help-inline', // default input error message class
				focusInvalid : false, // do not focus the last invalid input
				ignore : "",
				rules : {
					username : {
                        minlength:2,
                        text_trim:true,
                        maxlength:20,
						required : true
					},
                    realname : {
                        minlength:2,
                        text_trim:true,
                        maxlength:20,
						required : true
					},
                    department : {
                        minlength:2,
                        text_trim:true,
                        maxlength:20,
						required : true
					},
                    profile:{
                        selected : true
                    },
                    comment : {
                        minlength : 2,
                        maxlength : 250,
                        isBlank : true,
                        required : true
                    }
				},
				invalidHandler : function(event, validator) { //display error alert on form submit              
					success1.hide();
					error1.show();
					App.scrollTo(error1, -200);
				},
				highlight : function(element) { // hightlight error inputs
					$(element).closest('.help-inline').removeClass('ok'); // display OK icon
					$(element).closest('.control-group').removeClass('success')
							.addClass('error'); // set error class to the control group
				},
				unhighlight : function(element) { // revert the change dony by hightlight
					$(element).closest('.control-group').removeClass('error'); // set error class to the control group
				},
				success : function(label) {
					label.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
					.closest('.control-group').removeClass('error').addClass(
							'success'); // set success class to the control group
				},
				submitHandler : function(form) {
					success1.show();
					error1.hide();
					post_ajax('form_add_accounts');
					//form.submit();
				}
			});
		},
        
        //后台管理员权限
        rightInit:function(){
            var form1 = $('#form_add_right');
			var error1 = $('.alert-error', form1);
			var success1 = $('.alert-success', form1);
			form1.validate({
				errorElement : 'span', //default input error message container
				errorClass : 'help-inline', // default input error message class
				focusInvalid : false, // do not focus the last invalid input
				ignore : "",
				rules : {
					name : {
                        text_trim:true,
						required : true
					},
                    url : {
                        text_trim:true
					},
                    icon : {
                        text_trim:true
					},
                    orders : {
                        digits:true,
						required : true
					},
                    parent:{
                        otherselected : true
                    },
                    roue_char : {
                        text_trim:true,
						required : true
					}
				},
				invalidHandler : function(event, validator) { //display error alert on form submit              
					success1.hide();
					error1.show();
					App.scrollTo(error1, -200);
				},
				highlight : function(element) { // hightlight error inputs
					$(element).closest('.help-inline').removeClass('ok'); // display OK icon
					$(element).closest('.control-group').removeClass('success')
							.addClass('error'); // set error class to the control group
				},
				unhighlight : function(element) { // revert the change dony by hightlight
					$(element).closest('.control-group').removeClass('error'); // set error class to the control group
				},
				success : function(label) {
					label.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
					.closest('.control-group').removeClass('error').addClass(
							'success'); // set success class to the control group
				},
				submitHandler : function(form) {
					success1.show();
					error1.hide();
					post_ajax('form_add_right');
					//form.submit();
				}
			});
        },
 
        //增加APP
        appInit : function() {
            // for more info visit the official plugin documentation:
            // http://docs.jquery.com/Plugins/Validation
            var form1 = $('#form_app_add');
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement : 'span', //default input error message container
                errorClass : 'help-inline', // default input error message class
                focusInvalid : false, // do not focus the last invalid input
                onkeyup :true,// 是否在敲击键盘时验证,默认:true
                ignore : "",
                rules : {
                    appNum : {
                        isUploadApp:true,
                        required : true
                    },
                    picNum : {
                        isUpload : true,
                        required:true
                    },
                    size : {
                        required : true
                    },
                    version : {
                        required : true
                    },
                    inner_version : {
                        required : true
                    },
                    log:{
                        minlength:10,
                        maxlength:240,
                        isBlank : true,
                        required : true
                    }
                },
                invalidHandler : function(event, validator) { //display error alert on form submit
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },
                highlight : function(element) { // hightlight error inputs
                    $(element).closest('.help-inline').removeClass('ok'); // display OK icon
                    $(element).closest('.control-group').removeClass('success')
                        .addClass('error'); // set error class to the control group
                },
                unhighlight : function(element) { // revert the change dony by hightlight
                    $(element).closest('.control-group').removeClass('error'); // set error class to the control group
                },
                success : function(label) {
                    label.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
                        .closest('.control-group').removeClass('error').addClass(
                            'success'); // set success class to the control group
                },
                submitHandler : function(form) {
                    success1.show();
                    error1.hide();
                    post_ajax('form_app_add');
                    //form.submit();
                }
            });
        },      
        //修改密码
        modify_passwd : function() {
            var form1 = $('#modify_passwd');
            var error1 = $('.alert-error', form1);
            var success1 = $('.alert-success', form1);
            form1.validate({
                errorElement : 'span', //default input error message container
                errorClass : 'help-inline', // default input error message class
                focusInvalid : false, // do not focus the last invalid input
                ignore : "",
                rules : {
                	opasswd:{
                        minlength:6,
                        required:true
                    },
                    npasswd : {
                        minlength : 6,
                        required : true
                    },
                    rnpasswd : {
                    	required:true,
                        equalTo: "#npasswd"
                    }
                },
                invalidHandler : function(event, validator) { //display error alert on form submit
                    success1.hide();
                    error1.show();
                    App.scrollTo(error1, -200);
                },
                highlight : function(element) { // hightlight error inputs
                    $(element).closest('.help-inline').removeClass('ok'); // display OK icon
                    $(element).closest('.control-group').removeClass('success')
                        .addClass('error'); // set error class to the control group
                },
                unhighlight : function(element) { // revert the change dony by hightlight
                    $(element).closest('.control-group').removeClass('error'); // set error class to the control group
                },
                success : function(label) {
                    label.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
                        .closest('.control-group').removeClass('error').addClass(
                            'success'); // set success class to the control group
                },
                submitHandler : function(form) {
                    success1.show();
                    error1.hide();
                    post_ajax('modify_passwd');
                    //form.submit();
                }
            });
        },
        //专题活动
        themeinit : function() {
			var form1 = $('#form_add_theme');
			var error1 = $('.alert-error', form1);
			var success1 = $('.alert-success', form1);
			form1.validate({
				errorElement : 'span', //default input error message container
				errorClass : 'help-inline', // default input error message class
				focusInvalid : false, // do not focus the last invalid input
				ignore : "",
				rules : {
					name : {
                        minlength:2,
                        text_trim:true,
                        maxlength:20,
						required : true
					},
                    logo : {
						required : true
					},
                    valid_begin : {
                        text_trim:true,
						required : true
					},
                    valid_end : {
                        text_trim:true,
						required : true
					},
                    address : {
                        text_trim:true,
						required : true
					},
                    type:{
                        selected : true
                    },
                    content : {
						required : true
                    },
                    order: {
                        digits:true,
						required : true
					}
				},
				invalidHandler : function(event, validator) { //display error alert on form submit              
					success1.hide();
					error1.show();
					App.scrollTo(error1, -200);
				},
				highlight : function(element) { // hightlight error inputs
					$(element).closest('.help-inline').removeClass('ok'); // display OK icon
					$(element).closest('.control-group').removeClass('success')
							.addClass('error'); // set error class to the control group
				},
				unhighlight : function(element) { // revert the change dony by hightlight
					$(element).closest('.control-group').removeClass('error'); // set error class to the control group
				},
				success : function(label) {
					label.addClass('valid').addClass('help-inline ok') // mark the current input as valid and display OK icon
					.closest('.control-group').removeClass('error').addClass(
							'success'); // set success class to the control group
				},
				submitHandler : function(form) {
					success1.show();
					error1.hide();
                    waiting();
					post_ajax('form_add_theme');
				}
			});
		}

    };
}();