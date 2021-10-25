let imageinput = document.querySelector(".image-input");
let image = document.querySelector(".img-profile img");
let uploadbtn = document.querySelector(".upload");
let result = document.querySelectorAll(".result");
let imageinnav = document.querySelector(".image-nav")

image.addEventListener("click",()=>
{
    imageinput.click();
    
})

imageinput.addEventListener("input",(e)=>
{
   let file = e.target.files[0];
   let type = file.type.split("/")[1];
   clearResultError(result)
   if(type == "jpeg" || type == "png")
   {
       let reader = new FileReader();
       reader.addEventListener("load",(e)=>
       {
           image.src= e.target.result;
       })
       reader.readAsDataURL(file);
       uploadbtn.style.opacity = "1";
       uploadbtn.style.pointerEvents = "auto"
   }else
   {
    image.src = "";
    document.querySelector(".image").classList.add("alert" , "alert-danger");
    document.querySelector(".image").innerHTML = "sorry this type is not valid";
    uploadbtn.style.opacity = "0.5";
    uploadbtn.style.pointerEvents = "none"
   }
   
})

function clearResultError(resultdivs)
{

    resultdivs.forEach(result => {
        result.innerHTML = "";
        result.classList.remove("alert" , "alert-danger")
        result.classList.remove("success" , "error")
    });

}
uploadbtn.addEventListener("click",()=>
{
    clearResultError(result)
    let url  = uploadbtn.getAttribute("data-upload");
    let imagesrc = imageinput.files[0];
    let data = new FormData();
    data.append("image" , imagesrc);
    fetch(url , {
        method: "POST" , 
        body: data
    }).then(resp=>resp.json())
    .then(data=>{
        document.querySelector(".image").classList.add("alert" , "alert-success");
        document.querySelector(".image").innerHTML = "image updated succfully";
        uploadbtn.style.pointerEvents = "none";
        uploadbtn.style.opacity = "0.5";
        imageinnav.src= `http://www.attendance.com/Public//uploades/images/${data.image}`
    })
})


//  update profile

let save = document.querySelector(".save");
let upated_url = save.getAttribute("data-update");
let form = document.querySelector(".update-form");

save.addEventListener("click",()=>
{
    clearResultError(result)
    let data = new FormData(form);
    fetch(upated_url , {
        method: "POST" , 
        body: data
    }).then(resp=>resp.json())
    .then(data=>{
                if(data.error)
                {
                    if(data.error.firstname)
                    {
                        document.querySelector(".firstname").classList.add("alert" , "alert-danger");
                        document.querySelector(".firstname").innerHTML = data.error.firstname;
                    }
                    if(data.error.lastname)
                    {
                        document.querySelector(".lastname").classList.add("alert" , "alert-danger");
                        document.querySelector(".lastname").innerHTML = data.error.lastname;
                    }
                    if(data.error.email)
                    {
                        document.querySelector(".email").classList.add("alert" , "alert-danger");
                        document.querySelector(".email").innerHTML = data.error.email;
                    }
                    if(data.error.password)
                    {
                        document.querySelector(".password").classList.add("alert" , "alert-danger");
                        document.querySelector(".password").innerHTML = data.error.password;
                    }
                    if(data.error.confirmpassword)
                    {
                        document.querySelector(".confirmpassword").classList.add("alert" , "alert-danger");
                        document.querySelector(".confirmpassword").innerHTML = data.error.confirmpassword;
                    }
                }else if(data.suc)
                {
                    document.querySelector(".updated").classList.add("alert" , "alert-success");
                    document.querySelector(".updated").innerHTML = "updated succsuffly";
                    document.querySelector(".profile-name").innerHTML = `${data.firstname} ${data.lastname}`
                }else if (data.nochange)
                {
                    document.querySelector(".updated").classList.add("alert" , "alert-success");
                    document.querySelector(".updated").innerHTML = data.nochange;
                }
    })
})

function showchangepassword(elm)
{
    elm.classList.add("hide")
    document.querySelector(".password-box").classList.add("show")
   
}
