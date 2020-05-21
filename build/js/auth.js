!function(o){var s={};function i(e){if(s[e])return s[e].exports;var t=s[e]={i:e,l:!1,exports:{}};return o[e].call(t.exports,t,t.exports,i),t.l=!0,t.exports}i.m=o,i.c=s,i.d=function(e,t,o){i.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},i.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},i.t=function(t,e){if(1&e&&(t=i(t)),8&e)return t;if(4&e&&"object"==typeof t&&t&&t.__esModule)return t;var o=Object.create(null);if(i.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:t}),2&e&&"string"!=typeof t)for(var s in t)i.d(o,s,function(e){return t[e]}.bind(null,s));return o},i.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return i.d(t,"a",t),t},i.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},i.p="/build/js/",i(i.s=16)}({0:function(e,t,o){"use strict";function s(e,t,o,s,i,n,r,a){var d,l="function"==typeof e?e.options:e;if(t&&(l.render=t,l.staticRenderFns=o,l._compiled=!0),s&&(l.functional=!0),n&&(l._scopeId="data-v-"+n),r?(d=function(e){(e=e||this.$vnode&&this.$vnode.ssrContext||this.parent&&this.parent.$vnode&&this.parent.$vnode.ssrContext)||"undefined"==typeof __VUE_SSR_CONTEXT__||(e=__VUE_SSR_CONTEXT__),i&&i.call(this,e),e&&e._registeredComponents&&e._registeredComponents.add(r)},l._ssrRegister=d):i&&(d=a?function(){i.call(this,this.$root.$options.shadowRoot)}:i),d)if(l.functional){l._injectStyles=d;var u=l.render;l.render=function(e,t){return d.call(t),u(e,t)}}else{var p=l.beforeCreate;l.beforeCreate=p?[].concat(p,d):[d]}return{exports:e,options:l}}o.d(t,"a",function(){return s})},16:function(e,t,o){"use strict";o.r(t);function s(){var t=this,e=t.$createElement,o=t._self._c||e;return o("form",{staticClass:"pckg-auth-full"},["login"!=t.myStep||t.email&&0<t.email.length?o("div",{domProps:{innerHTML:t._s(t.__("auth."+t.myStep+".intro",{email:t.emailModel}))}}):t._e(),0<=["login","forgottenPassword","passwordSent","resetPassword","signup"].indexOf(t.myStep)?o("div",{staticClass:"form-group"},[o("label",[t._v(t._s(t.__("auth.label.email")))]),-1==["passwordSent","resetPassword"].indexOf(t.myStep)?o("div",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.emailModel,expression:"emailModel"}],attrs:{type:"email",name:"email",autocomplete:"username"},domProps:{value:t.emailModel},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.executeAction(e)},input:function(e){e.target.composing||(t.emailModel=e.target.value)}}}),o("htmlbuilder-validator-error",{attrs:{bag:t.errors,name:"email"}})],1):o("div",[t._v(" "+t._s(t.emailModel)+" ")])]):t._e(),0<=["passwordSent"].indexOf(t.myStep)?o("div",{staticClass:"form-group"},[o("label",[t._v(t._s(t.__("auth.label.securityCode")))]),o("div",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.code,expression:"code"}],attrs:{type:"text",name:"code",autocomplete:"off"},domProps:{value:t.code},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.executeAction(e)},input:function(e){e.target.composing||(t.code=e.target.value)}}}),o("htmlbuilder-validator-error",{attrs:{bag:t.errors,name:"code"}})],1)]):t._e(),0<=["login"].indexOf(t.myStep)?o("div",{staticClass:"form-group"},[o("label",[t._v(t._s(t.__("auth.label.password")))]),"login"==t.myStep?o("a",{staticClass:"as-link font-size-xs pull-right",attrs:{href:"#",tabindex:"-1"},on:{click:function(e){return e.preventDefault(),t.setStep("forgottenPassword")}}},[t._v(t._s(t.__("auth.forgottenPassword.question")))]):t._e(),o("div",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],attrs:{type:"password",name:"password",autocomplete:"current-password"},domProps:{value:t.password},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.executeAction(e)},input:function(e){e.target.composing||(t.password=e.target.value)}}}),o("htmlbuilder-validator-error",{attrs:{bag:t.errors,name:"password"}})],1)]):t._e(),0<=["resetPassword","signup"].indexOf(t.myStep)?o("div",{staticClass:"form-group"},[o("label",[t._v(t._s(t.__("auth.label.newPassword")))]),o("div",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.password,expression:"password"}],attrs:{type:"password",autocomplete:"new-password"},domProps:{value:t.password},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.executeAction(e)},input:function(e){e.target.composing||(t.password=e.target.value)}}}),o("div",{staticClass:"help"},[t._v(t._s(t.__("auth.help.newPassword")))]),o("htmlbuilder-validator-error",{attrs:{bag:t.errors,name:"password"}})],1)]):t._e(),0<=["resetPassword","signup"].indexOf(t.myStep)?o("div",{staticClass:"form-group"},[o("label",[t._v(t._s(t.__("auth.label.repeatPassword")))]),o("div",[o("input",{directives:[{name:"model",rawName:"v-model",value:t.passwordRepeat,expression:"passwordRepeat"}],attrs:{type:"password",autocomplete:"new-password"},domProps:{value:t.passwordRepeat},on:{keyup:function(e){return!e.type.indexOf("key")&&t._k(e.keyCode,"enter",13,e.key,"Enter")?null:t.executeAction(e)},input:function(e){e.target.composing||(t.passwordRepeat=e.target.value)}}}),o("htmlbuilder-validator-error",{attrs:{bag:t.errors,name:"passwordRepeat"}})],1)]):t._e(),0<t.error.length?o("div",{staticClass:"alert alert-danger clear-both"},[t._v(t._s(t.error))]):t._e(),o("button",{key:"btnAction",staticClass:"button btn-block",attrs:{disabled:t.loading},on:{click:function(e){return e.preventDefault(),t.executeAction(e)}}},[t.loading?[o("i",{staticClass:"fal fa-spinner fa-spin"})]:[t._v(t._s(t.__("auth."+t.myStep+".btn")))]],2),o("div",{staticClass:"centered margin-top-md margin-bottom-sm"},["login"==t.myStep?o("a",{staticClass:"as-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.setStep("signup")}}},[t._v(t._s(t.__("auth.signup.question")))]):t._e(),0<=["forgottenPassword","signup"].indexOf(t.myStep)?o("a",{staticClass:"as-link",attrs:{href:"#"},on:{click:function(e){return e.preventDefault(),t.setStep("login")}}},[t._v(t._s(t.__("auth.login.question")))]):t._e()])])}function i(e){return(i="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(e){return typeof e}:function(e){return e&&"function"==typeof Symbol&&e.constructor===Symbol&&e!==Symbol.prototype?"symbol":typeof e})(e)}s._withStripped=!0;var n={name:"pckg-auth-full",mixins:[{methods:{validateAndSubmit:function(o,s){this.$validator.validateAll().then(function(e){if(e)o();else{var t=$(this.$el).find(".htmlbuilder-validator-error").first();t&&("undefined"==typeof globalScrollTo?"undefined":i(globalScrollTo))==Function&&globalScrollTo(t),s&&s()}}.bind(this))},clearErrorResponse:function(){this.errors.clear()},hydrateErrorResponse:function(e){this.clearErrorResponse(),e.responseJSON&&($.each(e.responseJSON.descriptions||[],function(e,t){this.errors.remove(e),this.errors.add({field:e,msg:t})}.bind(this)),this.$nextTick(function(){var e=$(this.$el).find(".htmlbuilder-validator-error").first();e&&("undefined"==typeof globalScrollTo?"undefined":i(globalScrollTo))==Function&&globalScrollTo(e)}.bind(this)))}}}],props:{email:{},step:{type:String,default:"login"},options:{default:function(){return{disable:{}}}}},data:function(){return{emailModel:this.email||"",password:"",passwordRepeat:"",code:"",myStep:this.step,error:"",loading:!1,existingUser:!1,disable:this.options.disable||{}}},created:function(){if("loginModal"==document.URL.substring(document.URL.lastIndexOf("#")+1))return this.isLoggedIn?void http.redirect("/profile"):void this.$emit("opened")},mounted:function(){var e=document.URL.substring(document.URL.lastIndexOf("#")+1);if(0===e.indexOf("passwordSent")){var t=e.split("-");this.$emit("opened"),this.setStep("passwordSent"),this.emailModel=t[1],this.code=t[2],this.executeAction()}$dispatcher.$on("auth:login",this.openLoginModal),$dispatcher.$on("auth:forgotenPassword",this.openForgottenPasswordModal)},beforeDestroy:function(){$dispatcher.$off("auth:login",this.openLoginModal),$dispatcher.$off("auth:forgotenPassword",this.openForgottenPasswordModal)},watch:{emailModel:function(){this.existingUser=!1},step:function(e){this.myStep=e,this.error=""}},methods:{executeAction:function(){this.error="","login"==this.myStep&&(this.loading=!0,http.post("/login",{email:this.emailModel,password:this.password},function(e){if(this.loading=!1,e.success)return $dispatcher.$emit("auth:user:loggedIn"),e.redirect&&-1===window.location.pathname.indexOf("/basket")?void http.redirect(e.redirect):(this.$emit("close"),void(this.visible=!1));this.errors.clear(),"activateAccount"!==e.type?this.error=e.text||"Unknown error":this.setStep("activateAccount")}.bind(this),function(e){this.loading=!1,http.postError(e),this.errors.clear(),$.each(e.responseJSON.descriptions||[],function(e,t){this.errors.remove(e),this.errors.add({field:e,msg:t})}.bind(this))}.bind(this))),"signup"==this.myStep&&(this.loading=!0,http.post("/api/auth/signup",{email:this.emailModel,password:this.password,passwordRepeat:this.passwordRepeat},function(e){this.loading=!1,e.success&&this.setStep("accountCreated")}.bind(this),function(e){this.loading=!1,this.hydrateErrorResponse(e)}.bind(this))),"accountCreated"===this.myStep&&this.setStep("login"),0<=["forgottenPassword","activateAccount"].indexOf(this.myStep)&&(this.loading=!0,http.post("/forgot-password",{email:this.emailModel},function(e){this.loading=!1,e.success&&this.setStep("passwordSent")}.bind(this),function(e){this.loading=!1,this.hydrateErrorResponse(e)}.bind(this))),"passwordSent"==this.myStep&&(this.loading=!0,http.post("/password-code",{email:this.emailModel,code:this.code},function(e){this.loading=!1,e.success&&this.setStep("resetPassword")}.bind(this),function(e){this.loading=!1,this.hydrateErrorResponse(e)}.bind(this))),"resetPassword"==this.myStep&&(this.loading=!0,http.post("/reset-password",{code:this.code,email:this.emailModel,password:this.password,passwordRepeat:this.passwordRepeat},function(e){this.loading=!1,e.success&&($dispatcher.$emit("auth:user:loggedIn"),this.$emit("close"),this.visible=!1,window.location.pathname.indexOf("/basket")<0&&http.redirect())}.bind(this),function(e){this.loading=!1,this.hydrateErrorResponse(e)}.bind(this)))},openLoginModal:function(e){e&&e.email&&(this.emailModel=e.email),this.setStep("login"),this.$emit("opened")},openForgottenPasswordModal:function(){this.setStep("forgottenPassword"),this.$emit("opened")},setStep:function(e){this.myStep=e,this.$emit("steps",e)}},computed:{isLoggedIn:function(){return this.$store.getters.isLoggedIn},stepBtnText:function(){return{login:"Login",forgottenPassword:"Send security code",passwordSent:"Confirm security code",resetPassword:"Set new password",activateAccount:"Send security code"}[this.myStep]||utils.ucfirst(this.myStep)}}};n.mixins.push(pckgTranslations),n.computed.stepButtonText=function(){return __("auth."+this.myStep+".btn")};var r=n,a=o(0),d=Object(a.a)(r,s,[],!1,null,null,null);d.options.__file="vendor/pckg/auth/src/Pckg/Auth/View/full.vue";var l=d.exports;Vue.component("pckg-auth-full",l)}});