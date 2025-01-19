import{T as b,o as l,c as n,w as i,a,u as t,Z as _,f as y,t as x,g as d,b as o,d as k,i as V,e as u,n as v}from"./app-B_m04P03.js";import{_ as B}from"./Checkbox-BWCwG82z.js";import{_ as P}from"./GuestLayout-CsjVE6jD.js";import{_ as c,a as f,b as p}from"./TextInput-CjvjuyTn.js";import{P as $}from"./PrimaryButton-xu0tzaiW.js";import"./ApplicationLogo-yo8fDB_0.js";import"./_plugin-vue_export-helper-DlAUqK2U.js";const N={key:0,class:"mb-4 text-sm font-medium text-green-600"},h={class:"mt-4"},q={class:"mt-4 block"},C={class:"flex items-center"},L={class:"mt-4 flex items-center justify-end"},z={__name:"Login",props:{canResetPassword:{type:Boolean},status:{type:String}},setup(m){const e=b({email:"",password:"",remember:!1}),g=()=>{e.post(route("admin.login"),{onFinish:()=>e.reset("password")})};return(w,s)=>(l(),n(P,null,{default:i(()=>[a(t(_),{title:"Log in"}),m.status?(l(),y("div",N,x(m.status),1)):d("",!0),o("form",{onSubmit:k(g,["prevent"])},[o("div",null,[a(c,{for:"email",value:"Email"}),a(f,{id:"email",type:"email",class:"mt-1 block w-full",modelValue:t(e).email,"onUpdate:modelValue":s[0]||(s[0]=r=>t(e).email=r),required:"",autofocus:"",autocomplete:"username"},null,8,["modelValue"]),a(p,{class:"mt-2",message:t(e).errors.email},null,8,["message"])]),o("div",h,[a(c,{for:"password",value:"Password"}),a(f,{id:"password",type:"password",class:"mt-1 block w-full",modelValue:t(e).password,"onUpdate:modelValue":s[1]||(s[1]=r=>t(e).password=r),required:"",autocomplete:"current-password"},null,8,["modelValue"]),a(p,{class:"mt-2",message:t(e).errors.password},null,8,["message"])]),o("div",q,[o("label",C,[a(B,{name:"remember",checked:t(e).remember,"onUpdate:checked":s[2]||(s[2]=r=>t(e).remember=r)},null,8,["checked"]),s[3]||(s[3]=o("span",{class:"ms-2 text-sm text-gray-600"},"Remember me",-1))])]),o("div",L,[m.canResetPassword?(l(),n(t(V),{key:0,href:w.route("admin.password.request"),class:"rounded-md text-sm text-gray-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"},{default:i(()=>s[4]||(s[4]=[u(" Forgot your password? ")])),_:1},8,["href"])):d("",!0),a($,{class:v(["ms-4",{"opacity-25":t(e).processing}]),disabled:t(e).processing},{default:i(()=>s[5]||(s[5]=[u(" Admin Log in ")])),_:1},8,["class","disabled"])])],32)]),_:1}))}};export{z as default};
