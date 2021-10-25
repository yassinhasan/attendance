let img = document.querySelector(".profile .img");
let profile = document.querySelector(".profile");
let btn_info = document.querySelector(".info__profile");
let info__logout = document.querySelector(".info__logout");
let info = document.querySelector(".info");
img.addEventListener("click",()=>
{

    profile.classList.toggle("active");
})
info.addEventListener("click",(e)=>
{

    profile.classList.toggle("active");
} )
btn_info.addEventListener("click",(e)=>
{

    e.stopPropagation();
} )
info__logout.addEventListener("click",(e)=>
{

    e.stopPropagation();
} )
