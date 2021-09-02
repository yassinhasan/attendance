let form      = document.querySelector(".form"),
    url       = form.getAttribute("action"),
    submitbtn = document.querySelector(".btn-submit")

    form.onsubmit =(e)=>
    {
        e.preventDefault()
    }


    submitbtn.addEventListener("click",(e)=>
    {
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
                        showError(document.querySelector(`.${el}`) , er[el])
                       }
                    }

                }
                if(data.invalid)
                {
                    showError(document.querySelector(`.invalid`) , 'soory email or password is not coorect')
                }
                if(data.suc)
                {
                    success(data.redirect)
                }
                if(data.db_error)
                {
                    console.log(db_error)
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

    function success(data)
    {
        document.querySelector('.loadinsuccess').classList.add("active")
        document.querySelector('.overlay').classList.add("active")  
        window.location.href = data;
    }
