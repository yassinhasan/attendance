let active_links = document.querySelectorAll(".nav-item a");

active_links.forEach((e)=>
{        
        e.addEventListener("click",(el)=>
        {
            removeActive(active_links) 
            el.target.classList.add("active")

        })
})

// remove active class from any link 
function removeActive(elment)
{
    elment.forEach((e)=>
    {        
        e.classList.remove("active");
    })
    
}

// set active when refresh
let url = window.location.pathname; // /admin/usersgroups

let target = url.match(/\/(admin)\/?(\w+)?/);


if(target[2] == null && target[1] == 'admin')
{
    document.querySelector(`[data-target='${target[1]}']`).classList.add("active")
}else
{
    let selected_link  = document.querySelector(`[data-target='${target[2]}']`)
    if(selected_link)
    {
        selected_link.classList.add("active")
    }
}

