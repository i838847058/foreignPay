import{B as a,k as e,j as s,x as t,i as l,y as r,F as o,G as p,A as i}from"./element-plus-7c00a5ec.js";import{d,_ as m,k as n}from"./index-9c9bb131.js";import{O as u}from"./index-d4b26e89.js";import{F as c,o as f,c as j,P as b,S as _,au as v,av as y,a as h,K as z,W as A,Q as g,a9 as x,T as w,u as C}from"./@vue-83238ad5.js";import"./lodash-es-6861d6dc.js";import"./async-validator-cf877c1f.js";import"./@vueuse-974038d5.js";import"./dayjs-6442e2b1.js";import"./clipboard-690b0fc8.js";import"./@element-plus-9fff3ffd.js";import"./@ctrl-91de2ec7.js";import"./@popperjs-b78c3215.js";import"./escape-html-3c2115ff.js";import"./normalize-wheel-es-3222b0a2.js";import"./vue-router-62c38a24.js";import"./axios-a8ee11a1.js";import"./pinia-34541c90.js";import"./pinia-plugin-persistedstate-d2bd58cf.js";import"./zipson-d6101bf1.js";import"./mitt-f0e54764.js";const I={class:"search-data"},V=(a=>(v("data-v-238fdf1f"),a=a(),y(),a))((()=>h("div",{class:"search-result"}," 查询结果： 累计收入：20000.00 累计支出：20000.00 ",-1))),D=m(c({__name:"SearchTable",props:["tableData"],setup:e=>(s,t)=>{const l=a,r=d;return f(),j("div",I,[V,b(r,{table:e.tableData},{default:_((()=>[b(l,{prop:"no",label:"平台订单号",width:"200"}),b(l,{prop:"name",label:"可用余额",width:"200"}),b(l,{prop:"state",label:"收入",width:"200"}),b(l,{prop:"state",label:"支出",width:"200"}),b(l,{prop:"zis",label:"币种"}),b(l,{prop:"zis",label:"流水时间"})])),_:1},8,["table"])])}}),[["__scopeId","data-v-238fdf1f"]]),T={class:"search-container"},k={class:"get-currency-btn"},Y={class:"search-form"},N=m(c({__name:"index",setup(a){const d={total:3,data:[{no:"1",name:"2312312312312312312",state:"2312312312312312312",city:"游戏AA",address:"印度币INR",zip:"CA 90036",zis:"CA 90036"},{no:"2",name:"2312312312312312312",state:"2312312312312312312",city:"游戏AA",address:"印度币INR",zip:"CA 90036",zis:"CA 90036"},{no:"3",name:"2312312312312312312",state:"2312312312312312312",city:"游戏AA",address:"印度币INR",zip:"CA 90036",zis:"CA 90036"}]},m=z({paymentTime:"",state:"ALL"});return(a,c)=>{const v=n,y=e,z=t,I=l,V=r,N=o,R=p,F=i,L=s;return f(),j("div",T,[h("div",k,[b(y,{type:"primary",size:"large"},{default:_((()=>[b(v,{name:"export",size:20}),A(" 导出Excel")])),_:1})]),h("div",Y,[b(L,{model:m,"label-position":"top"},{default:_((()=>[b(F,{gutter:36},{default:_((()=>[b(V,{span:8},{default:_((()=>[b(I,{label:"创建时间："},{default:_((()=>[b(z,{modelValue:m.paymentTime,"onUpdate:modelValue":c[0]||(c[0]=a=>m.paymentTime=a),size:"large","range-separator":"⇀",type:"daterange","start-placeholder":"开始日期","end-placeholder":"结束日期","value-format":"YYYY-MM-DD"},null,8,["modelValue"])])),_:1})])),_:1}),b(V,{span:8},{default:_((()=>[b(I,{label:"系统订单号："},{default:_((()=>[b(R,{modelValue:m.state,"onUpdate:modelValue":c[1]||(c[1]=a=>m.state=a),size:"large",placeholder:"请选择",style:{width:"100%"}},{default:_((()=>[(f(!0),j(g,null,x(C(u),(a=>(f(),w(N,{key:a.value,label:a.label,value:a.value},null,8,["label","value"])))),128))])),_:1},8,["modelValue"])])),_:1})])),_:1}),b(V,{span:8,class:"submit-btn"},{default:_((()=>[b(I,null,{default:_((()=>[b(y,{type:"primary",size:"large"},{default:_((()=>[A("查询")])),_:1})])),_:1})])),_:1})])),_:1})])),_:1},8,["model"])]),b(D,{tableData:d})])}}}),[["__scopeId","data-v-4d0d8a87"]]);export{N as default};
