import{j as a,E as e,h as s,i as r,k as l}from"./element-plus-7c00a5ec.js";import{u as o,a as t,g as i,l as p,r as d,_ as m}from"./index-9c9bb131.js";import{F as u,e as n,K as c,L as g,i as j,c as f,a as v,P as h,S as w,au as b,av as y,o as _,u as V,B as k,Y as q,W as x}from"./@vue-83238ad5.js";import"./lodash-es-6861d6dc.js";import"./async-validator-cf877c1f.js";import"./@vueuse-974038d5.js";import"./dayjs-6442e2b1.js";import"./clipboard-690b0fc8.js";import"./@element-plus-9fff3ffd.js";import"./@ctrl-91de2ec7.js";import"./@popperjs-b78c3215.js";import"./escape-html-3c2115ff.js";import"./normalize-wheel-es-3222b0a2.js";import"./vue-router-62c38a24.js";import"./axios-a8ee11a1.js";import"./pinia-34541c90.js";import"./pinia-plugin-persistedstate-d2bd58cf.js";import"./zipson-d6101bf1.js";import"./mitt-f0e54764.js";const z=""+new URL("../png/login-996560b2.png",import.meta.url).href,U=a=>(b("data-v-a1ce6b28"),a=a(),y(),a),C={class:"login-page"},F={class:"page-container"},L=U((()=>v("div",{class:"container-img"},[v("img",{src:z,loading:"lazy"})],-1))),R={class:"container-form"},B=U((()=>v("div",{class:"form-title"},"登录",-1))),D=["src"],E=m(u({__name:"index",setup(m){const u=n(),b=c({username:[{required:!0,message:"请输入用户名",trigger:"blur"}],password:[{required:!0,message:"请输入密码",trigger:"blur"}],captcha:[{required:!0,message:"请输入验证码",trigger:"blur"}]}),y=o(),z=t();let U=n("");const E=c({username:"",password:"",captcha:""});let{username:I,password:K,captcha:M}=g(E);j((()=>{P()}));const P=()=>{i().then((a=>{U.value=a}))},S=async()=>{await z.fetchMenuData()};return(o,t)=>{const i=s,m=r,n=l,c=a;return _(),f("div",C,[v("div",F,[L,v("div",R,[B,h(c,{ref_key:"ruleFormRef",ref:u,model:E,rules:b,"label-position":"top"},{default:w((()=>[h(m,{label:"用户名",prop:"username",required:""},{default:w((()=>[h(i,{modelValue:V(I),"onUpdate:modelValue":t[0]||(t[0]=a=>k(I)?I.value=a:I=a),placeholder:"请输入"},null,8,["modelValue"])])),_:1}),h(m,{label:"密码",prop:"password",required:""},{default:w((()=>[h(i,{modelValue:V(K),"onUpdate:modelValue":t[1]||(t[1]=a=>k(K)?K.value=a:K=a),placeholder:"请输入",type:"password","show-password":""},null,8,["modelValue"])])),_:1}),h(m,{label:"谷歌验证码（6位）",prop:"captcha",required:""},{default:w((()=>[h(i,{modelValue:V(M),"onUpdate:modelValue":t[2]||(t[2]=a=>k(M)?M.value=a:M=a),placeholder:"请输入"},null,8,["modelValue"])])),_:1}),V(U)?(_(),f("img",{key:0,class:"verification-img",src:V(U),onClick:t[3]||(t[3]=a=>P()),loading:"lazy"},null,8,D)):q("",!0),h(n,{class:"submit-btn",type:"primary",onClick:t[4]||(t[4]=a=>(async a=>{a&&await a.validate((async(a,s)=>{if(a){const a=await p(E),{code:s,data:r,msg:l}=a;1===s?(S(),await y.login({...r.userinfo,password:E.password}),d.push("/data-statistics")):(e({title:"通知",message:l,type:"error"}),P())}}))})(u.value))},{default:w((()=>[x("登录")])),_:1})])),_:1},8,["model","rules"])])])])}}}),[["__scopeId","data-v-a1ce6b28"]]);export{E as default};
