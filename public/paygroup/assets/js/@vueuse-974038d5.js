import{s as e,w as t,r as n,u as r,g as o,d as a,e as i,f as s,h as u,i as l,n as c}from"./@vue-83238ad5.js";var f,d=Object.defineProperty,p=Object.defineProperties,v=Object.getOwnPropertyDescriptors,m=Object.getOwnPropertySymbols,O=Object.prototype.hasOwnProperty,y=Object.prototype.propertyIsEnumerable,b=(e,t,n)=>t in e?d(e,t,{enumerable:!0,configurable:!0,writable:!0,value:n}):e[t]=n;function w(r,o){var a;const i=e();var s,u;return t((()=>{i.value=r()}),(s=((e,t)=>{for(var n in t||(t={}))O.call(t,n)&&b(e,n,t[n]);if(m)for(var n of m(t))y.call(t,n)&&b(e,n,t[n]);return e})({},o),u={flush:null!=(a=null==o?void 0:o.flush)?a:"sync"},p(s,v(u)))),n(i)}const h="undefined"!=typeof window,g=e=>"string"==typeof e,I=()=>{},P=h&&(null==(f=null==window?void 0:window.navigator)?void 0:f.userAgent)&&/iP(ad|hone|od)/.test(window.navigator.userAgent);function E(e){return"function"==typeof e?e():r(e)}function j(e){return!!o()&&(a(e),!0)}function A(e,t=200,n={}){return function(e,t){return function(...n){return new Promise(((r,o)=>{Promise.resolve(e((()=>t.apply(this,n)),{fn:t,thisArg:this,args:n})).then(r).catch(o)}))}}(function(e,t={}){let n,r,o=I;const a=e=>{clearTimeout(e),o(),o=I};return i=>{const s=E(e),u=E(t.maxWait);return n&&a(n),s<=0||void 0!==u&&u<=0?(r&&(a(r),r=null),Promise.resolve(i())):new Promise(((e,l)=>{o=t.rejectOnCancel?l:e,u&&!r&&(r=setTimeout((()=>{n&&a(n),r=null,e(i())}),u)),n=setTimeout((()=>{r&&a(r),r=null,e(i())}),s)}))}}(t,n),e)}function T(e,t=200,n={}){const r=i(e.value),o=A((()=>{r.value=e.value}),t,n);return s(e,(()=>o())),r}function S(e,t,r={}){const{immediate:o=!0}=r,a=i(!1);let s=null;function u(){s&&(clearTimeout(s),s=null)}function l(){a.value=!1,u()}function c(...n){u(),a.value=!0,s=setTimeout((()=>{a.value=!1,s=null,e(...n)}),E(t))}return o&&(a.value=!0,h&&c()),j(l),{isPending:n(a),start:c,stop:l}}function Q(e){var t;const n=E(e);return null!=(t=null==n?void 0:n.$el)?t:n}const x=h?window:void 0,C=h?window.document:void 0;function N(...e){let t,n,r,o;if(g(e[0])||Array.isArray(e[0])?([n,r,o]=e,t=x):[t,n,r,o]=e,!t)return I;Array.isArray(n)||(n=[n]),Array.isArray(r)||(r=[r]);const a=[],i=()=>{a.forEach((e=>e())),a.length=0},u=s((()=>[Q(t),E(o)]),(([e,t])=>{i(),e&&a.push(...n.flatMap((n=>r.map((r=>((e,t,n,r)=>(e.addEventListener(t,n,r),()=>e.removeEventListener(t,n,r)))(e,n,r,t))))))}),{immediate:!0,flush:"post"}),l=()=>{u(),i()};return j(l),l}let _=!1;function k(e,t,n={}){const{window:r=x,ignore:o=[],capture:a=!0,detectIframe:i=!1}=n;if(!r)return;P&&!_&&(_=!0,Array.from(r.document.body.children).forEach((e=>e.addEventListener("click",I))));let s=!0;const u=e=>o.some((t=>{if("string"==typeof t)return Array.from(r.document.querySelectorAll(t)).some((t=>t===e.target||e.composedPath().includes(t)));{const n=Q(t);return n&&(e.target===n||e.composedPath().includes(n))}})),l=[N(r,"click",(n=>{const r=Q(e);r&&r!==n.target&&!n.composedPath().includes(r)&&(0===n.detail&&(s=!u(n)),s?t(n):s=!0)}),{passive:!0,capture:a}),N(r,"pointerdown",(t=>{const n=Q(e);n&&(s=!t.composedPath().includes(n)&&!u(t))}),{passive:!0}),i&&N(r,"blur",(n=>{var o;const a=Q(e);"IFRAME"!==(null==(o=r.document.activeElement)?void 0:o.tagName)||(null==a?void 0:a.contains(r.document.activeElement))||t(n)}))].filter(Boolean);return()=>l.forEach((e=>e()))}function B(e,t=!1){const n=i(),r=()=>n.value=Boolean(e());return r(),function(e,t=!0){u()?l(e):t?e():c(e)}(r,t),n}const L="undefined"!=typeof globalThis?globalThis:"undefined"!=typeof window?window:"undefined"!=typeof global?global:"undefined"!=typeof self?self:{},R="__vueuse_ssr_handlers__";function F({document:e=C}={}){if(!e)return i("visible");const t=i(e.visibilityState);return N(e,"visibilitychange",(()=>{t.value=e.visibilityState})),t}L[R]=L[R]||{};var D,W,z=Object.getOwnPropertySymbols,G=Object.prototype.hasOwnProperty,H=Object.prototype.propertyIsEnumerable;function M(e,t,n={}){const r=n,{window:o=x}=r,a=((e,t)=>{var n={};for(var r in e)G.call(e,r)&&t.indexOf(r)<0&&(n[r]=e[r]);if(null!=e&&z)for(var r of z(e))t.indexOf(r)<0&&H.call(e,r)&&(n[r]=e[r]);return n})(r,["window"]);let i;const u=B((()=>o&&"ResizeObserver"in o)),l=()=>{i&&(i.disconnect(),i=void 0)},c=s((()=>Q(e)),(e=>{l(),u.value&&o&&e&&(i=new ResizeObserver(t),i.observe(e,a))}),{immediate:!0,flush:"post"}),f=()=>{l(),c()};return j(f),{isSupported:u,stop:f}}(W=D||(D={})).UP="UP",W.RIGHT="RIGHT",W.DOWN="DOWN",W.LEFT="LEFT",W.NONE="NONE";var U=Object.defineProperty,q=Object.getOwnPropertySymbols,$=Object.prototype.hasOwnProperty,J=Object.prototype.propertyIsEnumerable,K=(e,t,n)=>t in e?U(e,t,{enumerable:!0,configurable:!0,writable:!0,value:n}):e[t]=n;function V({window:e=x}={}){if(!e)return i(!1);const t=i(e.document.hasFocus());return N(e,"blur",(()=>{t.value=!1})),N(e,"focus",(()=>{t.value=!0})),t}((e,t)=>{for(var n in t||(t={}))$.call(t,n)&&K(e,n,t[n]);if(q)for(var n of q(t))J.call(t,n)&&K(e,n,t[n])})({linear:function(e){return e}},{easeInSine:[.12,0,.39,0],easeOutSine:[.61,1,.88,1],easeInOutSine:[.37,0,.63,1],easeInQuad:[.11,0,.5,0],easeOutQuad:[.5,1,.89,1],easeInOutQuad:[.45,0,.55,1],easeInCubic:[.32,0,.67,0],easeOutCubic:[.33,1,.68,1],easeInOutCubic:[.65,0,.35,1],easeInQuart:[.5,0,.75,0],easeOutQuart:[.25,1,.5,1],easeInOutQuart:[.76,0,.24,1],easeInQuint:[.64,0,.78,0],easeOutQuint:[.22,1,.36,1],easeInOutQuint:[.83,0,.17,1],easeInExpo:[.7,0,.84,0],easeOutExpo:[.16,1,.3,1],easeInOutExpo:[.87,0,.13,1],easeInCirc:[.55,0,1,.45],easeOutCirc:[0,.55,.45,1],easeInOutCirc:[.85,0,.15,1],easeInBack:[.36,0,.66,-.56],easeOutBack:[.34,1.56,.64,1],easeInOutBack:[.68,-.6,.32,1.6]});export{N as a,Q as b,S as c,P as d,F as e,V as f,w as g,h as i,k as o,T as r,j as t,M as u};
