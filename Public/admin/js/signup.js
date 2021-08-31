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
                if(data.error)
                {
                    console.log(data.error)
                }
                if(data.suc)
                {
                    console.log(data.suc)
                }
                if(data.db_error)
                {
                    console.log(db_error)
                }
            })    
    })
