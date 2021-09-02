 document.querySelector('.loadinsuccess').classList.add("active") 
 let oldurl = document.querySelector('.loadinsuccess').getAttribute("data-action");
console.log(oldurl);

 url = window.location.href;
 url = url.split("?" ,2);
 let args = url[1];
 let newurl = `${oldurl}?${args}`;
 console.log(newurl)
fetch(newurl)
    .then(resp=> resp.json())
    .then(data=>
    {

        if(data.suc)
        {
            document.querySelector('.loadinsuccess').classList.remove("active")
            Swal.fire({
                title: 'success',
                text:  data.suc,
                icon: 'success',
                showConfirmButton: false,
                }) 
            setInterval(() => {
                window.location.href = data.redirect
                }, 1000); 
        }else
        {
            document.querySelector('.loadinsuccess').classList.remove("active")
            Swal.fire({
                title: 'Error',
                text:  data.exp,
                icon: 'error',
                showConfirmButton: false,
                }) 
            setInterval(() => {
                window.location.href = data.redirect
                }, 1000); 
        }
})    