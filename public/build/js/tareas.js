!function(){const e=document.location.origin;let t=[],a=[];const n=document.querySelector("#agregar-tarea"),o=document.querySelector("#todas"),r=document.querySelector("#completadas"),c=document.querySelector("#pendientes");function d(){!async function(){try{const a=`${e}/api/tareas?proyecto_url=${u()}`,n=await fetch(a),o=await n.json();t=o,m(t)}catch(e){}}()}function i(a=!1,n){const o=document.createElement("DIV");o.classList.add("modal"),o.innerHTML=`\n            <form class="formulario nueva-tarea">\n                <legend>${a?"Editar tarea":"Nueva tarea"}</legend>\n                <div class="campo">\n                    <label>Tarea</label>\n                    <input \n                        type="text"\n                        name="tarea"\n                        placeholder="Nombre de la tarea"\n                        id="tarea"\n                        value = "${a?""+n.tarea_nombre:""}"\n                    />\n                </div>\n                <div class="opciones">\n                    <input \n                        type="submit" \n                        class="submit-nueva-tarea" \n                        value = "Guardar cambios"\n                    />\n\n                    <button type="button" class="cerrar-modal">Cancelar</button>\n                </div>\n            </form>\n        `,setTimeout(()=>{document.querySelector(".formulario").classList.add("animar")},0),document.querySelector(".dashboard").appendChild(o),o.addEventListener("click",s),o.addEventListener("click",(function(o){if(o.preventDefault(),o.target.classList.contains("submit-nueva-tarea")){const o=document.querySelector("#tarea").value.trim();""===o?l("El nombre de la tarea es oligatorio","error",document.querySelector(".formulario legend")):a?(n.tarea_nombre=o,p(n)):async function(a){const n=new FormData;n.append("tarea_nombre",a),n.append("proyecto_url",u());try{const o=e+"/api/tareas",r=await fetch(o,{method:"POST",body:n}),c=await r.json();if(l(c.alerta,c.tipo,document.querySelector(".formulario legend")),1==c.respuesta){const e=document.querySelector(".modal");setTimeout(()=>{e.remove()},2e3);const n={tarea_id:String(c.tarea_id),tarea_nombre:a,tarea_estado:"0",tarea_proyectoId:String(c.tarea_proyectoId)};t=[...t,n],m(t)}}catch(e){console.log(e,"Error aca")}}(o)}}))}function s(e){if(e.preventDefault(),e.target.classList.contains("cerrar-modal")){return document.querySelector(".formulario").classList.add("cerrar"),void setTimeout(()=>{this.remove()},500)}}function l(e,t,a){const n=document.createElement("div");n.classList.add("alerta",t),n.textContent=e;0===document.querySelectorAll(".error").length&&a.appendChild(n),setTimeout(()=>{n.remove()},3e3)}function u(){const e=new URLSearchParams(window.location.search);return Object.fromEntries(e.entries()).proyecto_url}function m(t){!function(){const e=document.querySelector("#listado-tareas");for(;e.firstChild;)e.removeChild(e.firstChild)}();const a=document.querySelector("#listado-tareas");if(0==t.length){const e=document.createElement("li");e.classList.add("no-tareas"),e.textContent="No hay tareas por realizar",a.appendChild(e)}else{const n={0:"Pendiente",1:"Completado"};t.forEach(o=>{const{tarea_nombre:r,tarea_id:c,tarea_estado:d}=o,s=document.createElement("LI");s.dataset.tareaId=c,s.classList.add("tarea");const l=document.createElement("p");l.textContent=r,l.onclick=()=>{i(!0,{...o})};const f=document.createElement("div");f.classList.add("opciones");const y=document.createElement("button");y.classList.add("estado-tarea",""+n[d].toLowerCase()),y.textContent=n[d],y.dataset.estadoTarea=d,y.onclick=()=>{!function(e){const t="1"===e.tarea_estado?"0":"1";e.tarea_estado=t,p(e)}({...o})};const h=document.createElement("button");h.classList.add("eliminar-tarea"),h.dataset.idTarea=c,h.textContent="Eliminar tarea",h.onclick=function(){!function(a){Swal.fire({title:"Elimiar la tarea?",showCancelButton:!0}).then(n=>{n.isConfirmed&&async function(a){const{tarea_id:n}=a;data=new FormData,data.append("tarea_id",n),data.append("proyecto_url",u());try{const a=e+"/api/tareas/eliminar",o=await fetch(a,{method:"post",body:data});!0===(await o.json()).respuesta&&(t=t.filter(e=>e.tarea_id!==n)),m(t)}catch(e){console.log(e)}}(a)})}({...o})},f.appendChild(y),f.appendChild(h),s.appendChild(l),s.appendChild(f),a.appendChild(s)})}}async function p(n){const{tarea_id:o,tarea_nombre:d,tarea_estado:i,tarea_proyectoId:s}=n;datos=new FormData,datos.append("tarea_id",o),datos.append("tarea_nombre",d),datos.append("tarea_estado",i),datos.append("tarea_proyectoId",s),datos.append("proyecto_url",u());try{const n=e+"/api/tareas/actualizar",s=await fetch(n,{method:"POST",body:datos});if(1==(await s.json()).respuesta){const e=document.querySelector(".modal");e&&(l("Editado correctamente","exito",document.querySelector(".formulario legend")),setTimeout(()=>{e.remove()},2e3)),t=t.map(e=>(e.tarea_id==o&&(e.tarea_estado=i,e.tarea_nombre=d),e)),r.checked||c.checked?m(a):m(t)}}catch(e){console.log(e)}}function f(){a=t.filter(e=>"1"==e.tarea_estado),m(a)}function y(){a=t.filter(e=>"0"==e.tarea_estado),m(a)}function h(){m(t)}n.addEventListener("click",()=>{i(!1,{})}),window.addEventListener("DOMContentLoaded",d),r.addEventListener("click",f),c.addEventListener("click",y),o.addEventListener("click",h)}();