import{unref as e,getCurrentScope as n,onScopeDispose as t,ref as r,readonly as o,getCurrentInstance as a,onMounted as u,nextTick as i,watch as s}from"vue";var l;Vue;const c="undefined"!=typeof window,f=()=>{};function d(n){return"function"==typeof n?n():e(n)}function p(e){return!!n()&&(t(e),!0)}function O(e,n,t={}){const{immediate:a=!0}=t,u=r(!1);let i=null;function s(){i&&(clearTimeout(i),i=null)}function l(){u.value=!1,s()}function f(...t){s(),u.value=!0,i=setTimeout((()=>{u.value=!1,i=null,e(...t)}),d(n))}return a&&(u.value=!0,c&&f()),p(l),{isPending:o(u),start:f,stop:l}}function v(e){var n;const t=d(e);return null!=(n=null==t?void 0:t.$el)?n:t}c&&(null==(l=null==window?void 0:window.navigator)?void 0:l.userAgent)&&/iP(ad|hone|od)/.test(window.navigator.userAgent),Vue;const y=c?window:void 0;function b(...e){let n,t,r,o;if("string"==typeof e[0]||Array.isArray(e[0])?([t,r,o]=e,n=y):[n,t,r,o]=e,!n)return f;Array.isArray(t)||(t=[t]),Array.isArray(r)||(r=[r]);const a=[],u=()=>{a.forEach((e=>e())),a.length=0},i=s((()=>[v(n),d(o)]),(([e,n])=>{u(),e&&a.push(...t.flatMap((t=>r.map((r=>((e,n,t,r)=>(e.addEventListener(n,t,r),()=>e.removeEventListener(n,t,r)))(e,t,r,n))))))}),{immediate:!0,flush:"post"}),l=()=>{i(),u()};return p(l),l}function w(e,n=!1){const t=r(),o=()=>t.value=Boolean(e());return o(),function(e,n=!0){a()?u(e):n?e():i(e)}(o,n),t}const I="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:{},m="__vueuse_ssr_handlers__";I[m]=I[m]||{};var g,E,h=Object.getOwnPropertySymbols,P=Object.prototype.hasOwnProperty,Q=Object.prototype.propertyIsEnumerable;function A(e,n,t={}){const r=t,{window:o=y}=r,a=((e,n)=>{var t={};for(var r in e)P.call(e,r)&&n.indexOf(r)<0&&(t[r]=e[r]);if(null!=e&&h)for(var r of h(e))n.indexOf(r)<0&&Q.call(e,r)&&(t[r]=e[r]);return t})(r,["window"]);let u;const i=w((()=>o&&"ResizeObserver"in o)),l=()=>{u&&(u.disconnect(),u=void 0)},c=s((()=>v(e)),(e=>{l(),i.value&&o&&e&&(u=new ResizeObserver(n),u.observe(e,a))}),{immediate:!0,flush:"post"}),f=()=>{l(),c()};return p(f),{isSupported:i,stop:f}}(E=g||(g={})).UP="UP",E.RIGHT="RIGHT",E.DOWN="DOWN",E.LEFT="LEFT",E.NONE="NONE";var T=Object.defineProperty,j=Object.getOwnPropertySymbols,x=Object.prototype.hasOwnProperty,C=Object.prototype.propertyIsEnumerable,N=(e,n,t)=>n in e?T(e,n,{enumerable:!0,configurable:!0,writable:!0,value:t}):e[n]=t;((e,n)=>{for(var t in n||(n={}))x.call(n,t)&&N(e,t,n[t]);if(j)for(var t of j(n))C.call(n,t)&&N(e,t,n[t])})({linear:function(e){return e}},{easeInSine:[.12,0,.39,0],easeOutSine:[.61,1,.88,1],easeInOutSine:[.37,0,.63,1],easeInQuad:[.11,0,.5,0],easeOutQuad:[.5,1,.89,1],easeInOutQuad:[.45,0,.55,1],easeInCubic:[.32,0,.67,0],easeOutCubic:[.33,1,.68,1],easeInOutCubic:[.65,0,.35,1],easeInQuart:[.5,0,.75,0],easeOutQuart:[.25,1,.5,1],easeInOutQuart:[.76,0,.24,1],easeInQuint:[.64,0,.78,0],easeOutQuint:[.22,1,.36,1],easeInOutQuint:[.83,0,.17,1],easeInExpo:[.7,0,.84,0],easeOutExpo:[.16,1,.3,1],easeInOutExpo:[.87,0,.13,1],easeInCirc:[.55,0,1,.45],easeOutCirc:[0,.55,.45,1],easeInOutCirc:[.85,0,.15,1],easeInBack:[.36,0,.66,-.56],easeOutBack:[.34,1.56,.64,1],easeInOutBack:[.68,-.6,.32,1.6]});export{A as a,O as b,c as i,b as u};
