let form      = document.querySelector(".form"),
    url       = form.getAttribute("action"),
    submitbtn = document.querySelector(".btn-submit");

    form.onsubmit =(e)=>
    {
        e.preventDefault()
    }


    submitbtn.addEventListener("click",(e)=>
    {
        document.querySelector('.loadinsuccess').classList.add("active")
        document.querySelector('.overlay').classList.add("active") 
        let formdata = new FormData(form);
        fetch(url,
            {
                method: 'POST',
                body  : formdata
            })
        .then(resp=> resp.json())
        .then(data=>
            {
                removeError(document.querySelectorAll(`.result`))
                if(data.error)
                {   
                    let er = data.error;
                    for( el in er)
                    {

                       if(el)
                       {
                        document.querySelector('.loadinsuccess').classList.remove("active")
                        document.querySelector('.overlay').classList.remove("active")
                        showError(document.querySelector(`.${el}`) , er[el])
                       }
                    }

                }
                if(data.suc)
                {
                    document.querySelector('.loadinsuccess').classList.remove("active")
                    document.querySelector('.overlay').classList.remove("active")
                    Swal.fire({
                        title: 'success',
                        text:  data.suc,
                        icon: 'success',
                        showConfirmButton: false,
                      }) 
                    setInterval(() => {
                        window.location.href = data.redirect
                     }, 1000); 
                }
            })    
    })


    function showError(el , msg)
    {
        el.classList.add("invalid-feedback")
        el.innerHTML = msg;

    }
    function removeError(el)
    {
        el.forEach(element => {
            element.classList.remove("invalid-feedback");
            element.innerHTML = "";
        });
    }

 