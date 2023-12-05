import{E as e,h as a,i as l,y as t,A as u,F as r,G as d,j as o,H as i,I as s,k as n,d as p,B as _,J as c,e as m}from"./element-plus-1f849017.js";import{b as g,e as b,f,h as v,_ as h,i as y,j as V,d as w}from"./index-a0d63162.js";import{_ as j}from"./index-40f8922d.js";import{d as k,e as q,J as z,f as U,o as x,c as C,O as D,R as F,a as E,S as I,V as R,P as T,a8 as $,u as A,X as G,A as J,i as O,z as P,W as S,at as B,au as H,ag as L}from"./@vue-af2a374f.js";import"./lodash-es-968ab13b.js";import"./async-validator-cf877c1f.js";import"./@vueuse-be664744.js";import"./dayjs-3df08a9b.js";import"./clipboard-690b0fc8.js";import"./@element-plus-ce49c33a.js";import"./@ctrl-91de2ec7.js";import"./@popperjs-b78c3215.js";import"./escape-html-3c2115ff.js";import"./normalize-wheel-es-3222b0a2.js";import"./vue-router-0700730f.js";import"./axios-fb7d3bb8.js";import"./pinia-a9355e46.js";import"./pinia-plugin-persistedstate-d2bd58cf.js";import"./zipson-d6101bf1.js";import"./mitt-f0e54764.js";const M={class:"dialog-footer"},W=h(k({__name:"ChannelEntryDialog",props:["channelData"],setup(_,{expose:c}){const m=_,h=J("emitter"),y=g(),V=["通道基本信息","支付产品信息","通道资金信息"],w=q(0),k=q(!1),O=q([]),P=q(),S=(e,a,l)=>{a?/^[0-9]+(\.[0-9]{1,2})?$/.test(a)?l():l(new Error("请输入数字，最多两位小数")):l(new Error("请输入保证金"))},B=z({channel_name:[{required:!0,message:"请输入通道名称",trigger:"blur"}],tc_options:[{required:!0,message:"请输入技术参数",trigger:"blur"}],channel_num:[{required:!0,message:"请输入通道号",trigger:"blur"}],country_ids:[{required:!0,message:"请选择国家",trigger:"change"}],margin_balance:[{required:!0,message:"请输入保证金",trigger:"blur"},{validator:S,trigger:"blur"}],balance:[{required:!0,message:"请输入余额",trigger:"blur"},{validator:S,trigger:"blur"}],pay_way_id:[{required:!0,message:"请选择代收支付方式",trigger:"change"}],coin_ids:[{required:!0,trigger:"change",message:"请选择代收货币"}],billing_id:[{required:!0,trigger:"change",message:"请选择结算周期"}],pay_rate:[{required:!0,message:"请输入通道费率：",trigger:"blur"},{validator:S,trigger:"blur"}],product_type_id:[{required:!0,trigger:"change",message:"请选择支持产品类型"}]}),H=q();U(k,((e,a)=>{e&&(P.value={tc_options:"",is_pay_product:0,channel_name:"",channel_num:"",country_ids:"",product_type_id:"",coin_ids:"",pay_way_id:"",billing_id:"",is_u:1,margin_balance:null,balance:null,pay_rate:"",status:0},m.channelData&&(""!==m.channelData.data.country_ids&&L(m.channelData.data.country_ids),P.value={...m.channelData.data})),w.value=0}));const L=e=>{b(e).then((e=>{O.value=e.data||[]}))},W=async e=>{e&&await e.validate(((e,a)=>{if(e){if(w.value!==V.length-1)return void w.value++;m.channelData?f(P.value).then((e=>{1===e.code&&X("修改")})):v(P.value).then((e=>{1===e.code&&X("新增")}))}}))},X=a=>{e({title:"通知",message:`${a}成功`,type:"success",showClose:!1,duration:3e3}),k.value=!1,h.emit("refreshTable")};return c({dialogFormVisible:k}),(e,_)=>{const c=j,g=a,b=l,f=t,v=u,h=r,q=d,z=o,U=i,J=s,S=n,X=p;return x(),C("div",null,[D(X,{modelValue:k.value,"onUpdate:modelValue":_[16]||(_[16]=e=>k.value=e),title:""+(m.channelData?"通道信息修改":"通道录入"),class:"sub-dialog",closeOnClickModal:!1,"destroy-on-close":!0,width:"756px"},{footer:F((()=>[E("span",M,[w.value!==V.length-1?(x(),I(S,{key:0,type:"primary",onClick:_[14]||(_[14]=e=>W(H.value))},{default:F((()=>[R("下一页")])),_:1})):(x(),I(S,{key:1,type:"primary",onClick:_[15]||(_[15]=e=>W(H.value))},{default:F((()=>[R("保存")])),_:1}))])])),default:F((()=>[D(c,{class:"steps",steps:V,active:w.value,"onUpdate:active":_[0]||(_[0]=e=>w.value=e)},null,8,["active"]),0===w.value?(x(),I(z,{key:0,model:P.value,ref_key:"ruleFormRef",ref:H,rules:B,"label-position":"top"},{default:F((()=>[D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"通道名称：",prop:"channel_name",required:""},{default:F((()=>[D(g,{modelValue:P.value.channel_name,"onUpdate:modelValue":_[1]||(_[1]=e=>P.value.channel_name=e),size:"large",placeholder:"请输入"},null,8,["modelValue"])])),_:1})])),_:1})])),_:1}),D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"通道编号：",prop:"channel_num",required:""},{default:F((()=>[D(g,{size:"large",modelValue:P.value.channel_num,"onUpdate:modelValue":_[2]||(_[2]=e=>P.value.channel_num=e),placeholder:"请输入"},null,8,["modelValue"])])),_:1})])),_:1})])),_:1}),D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"支持产品类型：",prop:"product_type_id",required:""},{default:F((()=>[D(q,{size:"large",placeholder:"请选择",modelValue:P.value.product_type_id,"onUpdate:modelValue":_[3]||(_[3]=e=>P.value.product_type_id=e)},{default:F((()=>[(x(!0),C(T,null,$(A(y).basicData.options.product_type,((e,a)=>(x(),I(h,{label:e.value,value:e.id,key:a},null,8,["label","value"])))),128))])),_:1},8,["modelValue"])])),_:1})])),_:1})])),_:1})])),_:1},8,["model","rules"])):1===w.value?(x(),I(z,{key:1,model:P.value,ref_key:"ruleFormRef",ref:H,rules:B,"label-position":"top"},{default:F((()=>[D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"国家：",prop:"country_ids",required:""},{default:F((()=>[D(q,{placeholder:"请选择",modelValue:P.value.country_ids,"onUpdate:modelValue":_[4]||(_[4]=e=>P.value.country_ids=e),size:"large",onChange:L},{default:F((()=>[(x(!0),C(T,null,$(A(y).basicData.countryList,((e,a)=>(x(),I(h,{label:e.name,value:e.id,key:a},null,8,["label","value"])))),128))])),_:1},8,["modelValue"])])),_:1})])),_:1}),D(f,{span:12},{default:F((()=>[D(b,{label:"代收货币：",prop:"coin_ids",required:""},{default:F((()=>[D(q,{size:"large",placeholder:"请选择",modelValue:P.value.coin_ids,"onUpdate:modelValue":_[5]||(_[5]=e=>P.value.coin_ids=e)},{default:F((()=>[(x(!0),C(T,null,$(O.value,((e,a)=>(x(),I(h,{label:e.name,value:e.id,key:a},null,8,["label","value"])))),128))])),_:1},8,["modelValue"])])),_:1})])),_:1})])),_:1}),D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"代收支付方式：",prop:"pay_way_id",required:""},{default:F((()=>[D(q,{size:"large",placeholder:"请选择",modelValue:P.value.pay_way_id,"onUpdate:modelValue":_[6]||(_[6]=e=>P.value.pay_way_id=e)},{default:F((()=>[(x(!0),C(T,null,$(A(y).basicData.options.pay_way,((e,a)=>(x(),I(h,{label:e.value,value:e.id,key:a},null,8,["label","value"])))),128))])),_:1},8,["modelValue"])])),_:1})])),_:1}),D(f,{span:12},{default:F((()=>[D(b,{label:"结算周期：",prop:"billing_id",required:""},{default:F((()=>[D(q,{size:"large",placeholder:"请选择",modelValue:P.value.billing_id,"onUpdate:modelValue":_[7]||(_[7]=e=>P.value.billing_id=e)},{default:F((()=>[(x(!0),C(T,null,$(A(y).basicData.options.billing,((e,a)=>(x(),I(h,{label:e.value,value:e.id,key:a},null,8,["label","value"])))),128))])),_:1},8,["modelValue"])])),_:1})])),_:1})])),_:1}),D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"是否支持提U：",prop:"is_u",required:""},{default:F((()=>[D(J,{modelValue:P.value.is_u,"onUpdate:modelValue":_[8]||(_[8]=e=>P.value.is_u=e)},{default:F((()=>[D(U,{label:1,size:"large"},{default:F((()=>[R("是")])),_:1}),D(U,{label:0,size:"large"},{default:F((()=>[R("否")])),_:1})])),_:1},8,["modelValue"])])),_:1})])),_:1}),D(f,{span:12},{default:F((()=>[D(b,{label:"通道费率：",prop:"pay_rate",required:""},{default:F((()=>[D(g,{modelValue:P.value.pay_rate,"onUpdate:modelValue":_[9]||(_[9]=e=>P.value.pay_rate=e),size:"large",placeholder:"请输入"},{append:F((()=>[R("%")])),_:1},8,["modelValue"])])),_:1})])),_:1})])),_:1}),D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"支付产品：",prop:"is_pay_product",required:""},{default:F((()=>[D(J,{modelValue:P.value.is_pay_product,"onUpdate:modelValue":_[10]||(_[10]=e=>P.value.is_pay_product=e)},{default:F((()=>[D(U,{label:0,size:"large"},{default:F((()=>[R("代收")])),_:1}),D(U,{label:1,size:"large"},{default:F((()=>[R("代付")])),_:1})])),_:1},8,["modelValue"])])),_:1})])),_:1}),D(f,{span:12},{default:F((()=>[D(b,{label:"技术参数：",prop:"tc_options",required:""},{default:F((()=>[D(g,{modelValue:P.value.tc_options,"onUpdate:modelValue":_[11]||(_[11]=e=>P.value.tc_options=e),size:"large",placeholder:"请输入"},null,8,["modelValue"])])),_:1})])),_:1})])),_:1})])),_:1},8,["model","rules"])):2===w.value?(x(),I(z,{key:2,model:P.value,ref_key:"ruleFormRef",ref:H,rules:B,"label-position":"top"},{default:F((()=>[D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"保证金：",prop:"margin_balance",required:""},{default:F((()=>[D(g,{size:"large",modelValue:P.value.margin_balance,"onUpdate:modelValue":_[12]||(_[12]=e=>P.value.margin_balance=e),placeholder:"请输入"},null,8,["modelValue"])])),_:1})])),_:1})])),_:1}),D(v,{gutter:18},{default:F((()=>[D(f,{span:12},{default:F((()=>[D(b,{label:"余额：",prop:"balance",required:""},{default:F((()=>[D(g,{size:"large",modelValue:P.value.balance,"onUpdate:modelValue":_[13]||(_[13]=e=>P.value.balance=e),placeholder:"请输入"},null,8,["modelValue"])])),_:1})])),_:1})])),_:1})])),_:1},8,["model","rules"])):G("",!0)])),_:1},8,["modelValue","title"])])}}}),[["__scopeId","data-v-119cb5e6"]]),X={class:"search-data"},K=(e=>(B("data-v-b6c3b92e"),e=e(),H(),e))((()=>E("div",{class:"search-result"},"通道信息",-1))),N=h(k({__name:"SearchTable",setup(a){const l=J("emitter"),t=z({data:{}}),u=q(),r=z({data:{}});O((()=>{d(),l.on("refreshTable",d)})),P((()=>{l.off("refreshTable")}));const d=(e=1)=>{y(e).then((e=>{t.data=e.data}))};return(a,l)=>{const o=_,i=c,s=n,p=w;return x(),C(T,null,[E("div",X,[K,D(p,{table:t.data,onCurrentChange:d},{default:F((()=>[D(o,{prop:"id",label:"序号",width:"80"},{default:F((e=>[R(S(e.$index+1),1)])),_:1}),D(o,{prop:"channel_name",label:"通道名称",width:"200"}),D(o,{prop:"channel_num",label:"通道号",width:"200"}),D(o,{prop:"product_type_id_text",label:"支持产品类型",width:"140"}),D(o,{prop:"coin_ids_text",label:"代收货币",width:"220"}),D(o,{prop:"pay_way_id_text",label:"代收支付方式",width:"200"}),D(o,{prop:"country_ids_text",label:"国家",width:"200"}),D(o,{prop:"is_u",label:"是否支持提U",width:"120"},{default:F((e=>[R(S(e.row.is_u?"是":"否"),1)])),_:1}),D(o,{prop:"pay_rate",label:"通道费率 (%)",width:"140"}),D(o,{prop:"billing_id_text",label:"结算周期",width:"120"}),D(o,{prop:"tc_options",label:"技术参数",width:"160"}),D(o,{prop:"is_pay_product",label:"支付产品",width:"120"},{default:F((e=>[R(S(e.row.is_pay_product?"代付":"代收"),1)])),_:1}),D(o,{prop:"status",label:"通道状态",width:"120"},{default:F((a=>[D(i,{modelValue:a.row.status,"onUpdate:modelValue":e=>a.row.status=e,"active-value":1,"inactive-value":0,onChange:l=>(({id:a,status:l})=>{V({id:a,status:l}).then((a=>{1===a.code&&e({title:"通知",message:"更改状态成功",type:"success",showClose:!1,duration:3e3})}))})(a.row)},null,8,["modelValue","onUpdate:modelValue","onChange"])])),_:1}),D(o,{prop:"margin_balance",label:"保证金金额",width:"120"}),D(o,{prop:"created",label:"创建时间",width:"200"}),D(o,{fixed:"right",label:"操作",width:"120"},{default:F((e=>[D(s,{link:"",type:"primary",size:"small",onClick:a=>{return l=e.row,u.value.dialogFormVisible=!0,void(r.data=l);var l}},{default:F((()=>[R(" 修改 ")])),_:2},1032,["onClick"])])),_:1})])),_:1},8,["table"])]),D(W,{ref_key:"channelEntryDialog",ref:u,"channel-data":r},null,8,["channel-data"])],64)}}}),[["__scopeId","data-v-b6c3b92e"]]),Q={class:"search-container"},Y={class:"header"},Z=h(k({__name:"index",setup(e){const a=q();return(e,l)=>{const t=L("Plus"),u=m,r=n;return x(),C(T,null,[E("div",Q,[E("div",Y,[D(r,{type:"primary",onClick:l[0]||(l[0]=e=>a.value.dialogFormVisible=!0)},{default:F((()=>[D(u,null,{default:F((()=>[D(t)])),_:1}),R(" 通道录入 ")])),_:1})]),D(N)]),D(W,{ref_key:"channelEntryDialog",ref:a},null,512)],64)}}}),[["__scopeId","data-v-d674b30c"]]);export{Z as default};
