import{m as a,p as t,q as s,S as n,C as e,s as i,t as r,v as o,w as u,x as c,y as d,z as $,B as p,D as w}from"./index-a68c738b.js";async function y(t){return(await a.post(`${e}`,t)).data}async function f({page:t,rows:n}){return(await a.get(`${s}?page=${t}&rows=${n}`)).data}async function _({user_id:t,password:s}){return(await a.post(`${i}`,{user_id:t,password:s})).data}async function g({user_id:t,mch_status:s}){return(await a.post(`${r}`,{user_id:t,mch_status:s})).data}async function h(t){return(await a.post(`${o}`,t)).data}async function k({text:t,role:s}){return(await a.get(`${n}?text=${t}&role=${s}`)).data}async function m({page:t,user_id:s,check_state:n}){return(await a.get(`${u}?rows=10&page=${t}&user_id=${s}&check_state=${n}`)).data}async function x({id:t,key:s,value:n}){return(await a.post(`${p}`,{id:t,key:s,value:n})).data}async function l({ids:t,state:s,reason:n}){return(await a.post(`${w}`,{ids:t,state:s,reason:n})).data}async function v({page:s}){return(await a.get(`${t}?rows=10&page=${s}`)).data}async function j({coin_id:t,rate:s}){return(await a.post(`${c}`,{coin_id:t,rate:s})).data}async function b({id:t,coin_id:s,rate:n}){return(await a.post(`${d}`,{id:t,coin_id:s,rate:n})).data}async function q({id:t,status:s}){return(await a.post(`${$}`,{id:t,status:s})).data}export{l as a,y as b,h as c,f as d,g as e,_ as f,m as g,v as h,b as i,j,q as k,k as s,x as u};