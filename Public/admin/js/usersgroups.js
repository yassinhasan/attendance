let submit_btn  = document.querySelector(".submit-btn");

// <form class="add-form">  in modal
let form        = document.querySelector(".add-form");
let table       = document.querySelector(".table");

// $data['load_data']  =  toLink("admin/usersgroups/realtime");
 let load_data   = table.getAttribute("data-load");

//$data['edit_data']  =  toLink("admin/usersgroups/edit/");
let edit_data   = table.getAttribute("data-edit"); 

 //$data['delete_data']  =  toLink("admin/usersgroups/delete/");
 let delete_data   = table.getAttribute("data-delete");

let add_new_btn = document.querySelector(".add-new");
let table_serach = document.querySelector(".table-serach");

let search_by_user = document.querySelector(".search_user");

let select_no_pages  = document.querySelector(".select-no-pages");

let btndownlload = document.querySelector(".btn-download");
let loadindata = false;
let alldata = [];

add_new_btn.addEventListener("click",()=>
{
    $('#formModal').modal('toggle');
})


submit_btn.addEventListener("click",(e)=>
{
    //$data['action']     =  toLink("admin/usersgroups/submit");
    let url = submit_btn.getAttribute("data-target");

    let sending_data  = new FormData(form);
    fetch(url,
        {
            method : "POST",
            body   : sending_data
        }).then(resp=>resp.json())
        .then(data=>
            {
                if(data.error)
                {
                    console.log(data.error)
                }
                if(data.suc)
                {
                    
                    fetchdata(load_data)
                    Swal.fire({
                        title: 'success',
                        text:  data.suc,
                        icon: 'success',
                        showConfirmButton: false,
                        timer: 1200
                      })
                      $('#formModal').modal('toggle');

                        
                }
                if(data.db_error)
                {
                    console.log(data.db_error)
                }
            }) 


})



// load all data when refresh page
window.addEventListener("load",()=>
{
    
    loadspinner();
    
    // // $data['load_data']  =  toLink("admin/usersgroups/realtime");
 
    fetchdata(load_data)
});

// here i will send paginaion recodrs 
// i need number of pages from form select
// // according to data come from realtime 
// i will get number of pages so make pagination icons
// then when i add clicked attrubiute on icon to send current page


function fetchdata(loaddata , currentpage = 1)
{
    let pages_info = new FormData();
    pages_info.append("limit" , select_no_pages.value);
    pages_info.append("currentpage" , currentpage);
    pages_info.append("search" , table_serach.value);
   alldata = [];
    fetch(loaddata,{
        method: 'POST' , 
        body  : pages_info
    }).then(resp=>resp.json())
    .then(data=>
        {  
             loadindata = true;
            if(loadindata == true)
            {
                 alldata.push(data); 
            }
          
            
             removespinner()
            let results = data.results;
          
            makeTable(results);
            
            makePagination(data['total-pages'] , currentpage)
             let pagination_pages = document.querySelectorAll(".pagination li");
             clickedpage(pagination_pages)
            //   let delete_url       = delete_btn.getAttribute("data-href");    
             
        })
}

function clickedpage(elment)
{
   
  
    window.addEventListener("click",(e)=>
    {
        elment.forEach(el => {
            if(el == e.target)
            {   
               
                 loadspinner();
                removeactive()
                el.classList.add("active");
                let  currentpage = el.getAttribute("data-page");
                fetch_pagination(currentpage)
    
            }
        });
    })
}


function removeactive()
{
    let pagination_pages = document.querySelectorAll(".pagination li");    
    pagination_pages.forEach(ele => {
        ele.classList.remove("active")
    })
}


function fetch_pagination(currentpage)
{
    
    let pages_info = new FormData();
    pages_info.append("limit" , select_no_pages.value);
    pages_info.append("currentpage" , currentpage);
    fetch(load_data,{
        method: 'POST' , 
        body  : pages_info
    }).then(resp=>resp.json())
    .then(data=>
        { 
            fetchdata(load_data ,currentpage)
         })
}

select_no_pages.addEventListener("change",()=>
{
  
     loadspinner();
    fetchdata(load_data)
})


table_serach.addEventListener("input",()=>
{
   
    fetchdata(load_data)
})




//

function makePagination(totalpages , currentpage)
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

//

// click on edit on button on table to edit data 

// edit_url       = element.getAttribute("data-href"); == ${edit_data}${results[index].group_id};
//     == http://www.attendance.com/admin/usersgroups/edit/1
let edit_url; 
function edit(el)
{
    el.forEach(element => {
        element.addEventListener("click",()=>
            {

                 loadspinner()
                  if(document.getElementById("editmodal"))
                  {
                    document.getElementById("editmodal").remove()
                  }
                  edit_url       = element.getAttribute("data-href"); 
                  
                  fetch(edit_url,{
                      method: "POST"
                  }).then(resp=>resp.text())
                  .then(data=>{
                     removespinner()
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


// update  when edit 

function update(elmenet , edit_form)
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

                         loadspinner();
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
                        $('#editmodal').modal('toggle');
                    })
                    
                    .catch(error=>console.log(error))
        })
    }
}



// delete_url       = element.getAttribute("data-href"); == ${delete_data}${results[index].group_id};
//     == http://www.attendance.com/admin/usersgroups/delete/1
function delete_by_id(el)
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
                             loadspinner();
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


// let pagination = new Pagination(5 , 1);

function makeTable(results)
{
   
    let edit_btn;
    let delete_btn;
    let tbody = document.querySelector(".tbody");
    let user_type; 
    tbody.innerHTML = "";
    let addedd_column = "";
    
    if( Array.isArray(results) )
    {
        for (let index in  results) 
        {
          
         
           
    
           addedd_column += `<tr>
                            <td>
                            ${results[index].group_name}
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
    }

    tbody.innerHTML = addedd_column ;
     edit_btn       = document.querySelectorAll(".edit");
     delete_btn     = document.querySelectorAll(".delete");
     
    // after oclick on edit btn 
    edit(edit_btn) 

    // after click on delete btn
    delete_by_id(delete_btn) 
}

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

let alldataarray;
search_by_user.addEventListener("input",(e)=>
{

    alldataarray = alldata[0]['all-data'] ;

    if(e.target.value != "")
    {
       
        let results = [];
    


        for (let index = 0; index < alldataarray.length; index++) {
    
        
    
                if(alldataarray[index].group_name.indexOf(e.target.value) != -1)
                {
                  
                    results.push(alldataarray[index])
                }
              
        }
        
       if(results.length != 0)
       {
        makeTable(results)
        let pagination_pages = document.querySelector(".pagination");
        pagination_pages.style.display = "none";           
       }

    }else
    {
        
        fetchdata(load_data)
        let pagination_pages = document.querySelector(".pagination")
        pagination_pages.style.display = "flex";
    }


})


// btndownlload.addEventListener("click",()=>
// {

// })