 function loadspinner()
{
    document.querySelector('.loadinsuccess').classList.add("active")
    document.querySelector('.overlay').classList.add("active")  
}

 function removespinner()
{
    document.querySelector('.loadinsuccess').classList.remove("active")
    document.querySelector('.overlay').classList.remove("active")  
}


export class CustomFetchPagination
{
    constructor(url ,entrydata = null , currentpage = 1)
    {
        this.url = url;
        this.data = entrydata;
        this.currentpage = currentpage;
    }
    fetchtable(){

            fetch(this.url,{
                method: 'POST' , 
                body  :this.entrydata , 
            }).then(resp=>resp.json())
            .then(data=>
                {  
                    removespinner()
                    let results = data.results;
                
                    makeTable(results);
                    
                    makePagination(data['total-pages'] , this.currentpage)
                    let pagination_pages = document.querySelectorAll(".pagination li");
                    if(pagination_pages)
                    {
                     clickedpage(pagination_pages)                        
                    }

                    //   let delete_url       = delete_btn.getAttribute("data-href");    
                    
                })
    }


    makePagination(totalpages , currentpage)
    {

            let pagination = document.querySelector(".pagination");

            let disabled = currentpage == 1 ? 'disabled' : '';
            let lastdisabled = currentpage == totalpages ? 'disabled' : '';
            let li = `<li class="page-link ${disabled}" data-page="${currentpage -1}">Previous</li>`;
            for (let index = 0; index < totalpages ; index++) { 
                let active = currentpage == index+1 ? 'active' : ''
                li += `<li class="page-link ${active}" data-page="${index +1 }">${index +1}</li>`
            }
            li +=  `<li class="page-link ${lastdisabled}" data-page="${1 + parseInt(currentpage)}">Next </li>`;

            return pagination.innerHTML = li; 

        

    }


    makeTable(results , permessiontable = null)
    {
        let edit_btn;
        let delete_btn;
        let tbody = document.querySelector(".tbody");
        let user_type; 
        tbody.innerHTML = "";
        let addedd_column = "";
        for (let index in results) 
        {
        
        if(permessiontable)
        {
          user_type = results[index].group_id == 1 ? 'admin' : 'user';  
         

            addedd_column += `<tr>
                                <td>
                                    ${user_type}
                                </td>
                                <td>
                                    ${results[index].permession_name}
                                </td>
                            <td class='action'>
                                <button data-href="${edit_data}${results[index].group_id}" class="btn btn-primary edit "
                                data-target="#editmodal" data-toggle= "modal"
                                ><i class="fas fa-edit"></i></button>
                                <button data-href="${delete_data}${results[index].group_id}" class="btn btn-danger delete"
                                data-permession="${results[index].permession_id}""><i class="fas fa-times"></i></button>
                            </td>
                        </tr>`;
            }
            tbody.innerHTML = addedd_column ;
            edit_btn       = document.querySelectorAll(".edit");
            delete_btn     = document.querySelectorAll(".delete");
            
            // after oclick on edit btn 
            edit(edit_btn) 

            // after click on delete btn
            delete_by_id(delete_btn) 
        }
    }


    delete_by_id(el)
    {
        el.forEach(element => {
            element.addEventListener("click",()=>
                {  
                    
                    let  delete_url = element.getAttribute("data-href");  
                    let data_permession = element.getAttribute("data-permession"); 
                    let send_data = new FormData();
                    send_data.append("permession_id" , data_permession)
                    
                    Swal.fire({
                        title: 'delte permession',
                        text:  "Are You Sure to delete permssion",
                        icon: 'warning',
                        showConfirmButton: true,
                        showCancelButton : true
                        
                    }).then(SweetAlertResult=>
                        {
                            if(SweetAlertResult.isConfirmed) { 
                                Myassets.loadspinner();
                                fetch(delete_url,{
                                    method: "POST" ,
                                    body  : send_data
                                }).then(resp=>resp.json())
                                .then(data=>{
                                    
                                    if(data.suc)
                                    {
                                        removespinner()
                                        Swal.fire({
                                            title: 'success',
                                            text:  data.suc,
                                            icon: 'success',
                                            showConfirmButton: false,
                                            timer: 1200
                                        })
                                    }
                                    fetchdata(load_data)
                                })
                                .catch(error=>console.log(error))
                            }
                            else
                            {
                                return
                            }
                        })


                })
                
        });
    }

   
    edit(el)
    {
        let edit_url; 
        el.forEach(element => {
            element.addEventListener("click",()=>
                {
                    Myassets.loadspinner()
                    if(document.getElementById("editmodal"))
                    {
                        document.getElementById("editmodal").remove()
                    }
                    edit_url       = element.getAttribute("data-href"); 
                    
                    fetch(edit_url,{
                        method: "POST"
                    }).then(resp=>resp.text())
                    .then(data=>{
                        Myassets.removespinner()
                        let html = new DOMParser();
                        let elm =  html.parseFromString(data, "text/html");
                        let model = elm.getElementById("editmodal");
                        let edit_form   = elm.querySelector(".edit-form");
                        let table_div = document.querySelector(".table-center");
                        table_div.insertAdjacentElement("afterend" , model);
                        $('#editmodal').modal('show');
                        update(model.querySelector(".save_btn") , edit_form)
                        })  
                        
                        

                    .catch(error=>console.log(error))
                })
                
        });
    }
    update(elmenet , edit_form)
    {
        if(elmenet)
        {
            elmenet.addEventListener("click",()=>  
            {
                let save_url = elmenet.getAttribute("data-target");
                let sending_data  = new FormData(edit_form);
                fetch(save_url,
                    {
                        method : "POST",
                        body   : sending_data
                    }).then(resp=>resp.json())
                    .then(data=>
                        {

                            Myassets.loadspinner();
                            if(data.suc)
                            {
                                Myassets.removespinner()
                                Swal.fire({
                                    title: 'success',
                                    text:  data.suc,
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 1200
                                })
                            }
                            fetchdata(load_data)
                            $('#editmodal').modal('toggle');
                        })
                        
                        .catch(error=>console.log(error))
            })
        }
    }



}







// what i need 
// i need limit  and offset and page number
// according to limit  i will get pages number 
// and get offset
// send this data by fetch to method in db 
// return by data make new fetch by this data

