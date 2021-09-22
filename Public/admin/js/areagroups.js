let add_new_btn = document.querySelector(".add-new");
let submit_btn  = document.querySelector(".submit-btn");
// <form class="add-form">  in modal
let form        = document.querySelector(".add-form");
let table       = document.querySelector(".table");

// $data['load_data']  =  toLink("admin/areagroups/realtime");
let load_data   = table.getAttribute("data-load");

let result = document.querySelectorAll(".result");

let table_serach = document.querySelector(".table-serach");

let search_by_item = document.querySelector(".search_item");

let select_no_pages  = document.querySelector(".select-no-pages");

//$data['edit_data']  =  toLink("admin/areagroups/edit/");
let edit_data   = table.getAttribute("data-edit"); 

 //$data['delete_data']  =  toLink("admin/usersgroups/delete/");
let delete_data   = table.getAttribute("data-delete");
add_new_btn.addEventListener("click",()=>
{

    $('#areagroupmodel').modal('toggle');
})

//  on load

// load all data when refresh page
window.addEventListener("load",()=>
{
    
    loadspinner();
    
    // // $data['load_data']  =  toLink("admin/usersgroups/realtime");
 
    fetchdata(load_data);

});
submit_btn.addEventListener("click",(e)=>
{
    loadspinner();
    //$data['action']     =  toLink("admin/usersgroups/submit");
    let url = submit_btn.getAttribute("data-target");
    let sending_data  = new FormData(form);
    clearResultError(result)

    fetch(url,
        {
            method : "POST",
            body   : sending_data
        }).then(resp=>resp.json())
        .then(data=>
            {
                if(data.error)
                {
                    if(data.error.area_id)
                    {
                        document.querySelector(".area-id").classList.add("alert" , "alert-danger");
                        document.querySelector(".area-id").innerHTML = data.error.area_id;
                    }
                    if(data.error.area_name)
                    {
                        document.querySelector(".area-name").classList.add("alert" , "alert-danger");
                        document.querySelector(".area-name").innerHTML = data.error.area_name;
                    }
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
                      $('#areagroupmodel').modal('toggle');  
                }
                if(data.db_error)
                {
                    console.log(data.db_error)
                }
            }) 
})

select_no_pages.addEventListener("change",()=>
{
  
     loadspinner();
    fetchdata(load_data)
})
table_serach.addEventListener("input",()=>
{
   
    fetchdata(load_data)
})
search_by_item.addEventListener("input",()=>
{
   
    fetchdata(load_data)
})
function clearResultError(resultdivs)
{

    resultdivs.forEach(result => {
        result.innerHTML = "";
        result.classList.remove("alert" , "alert-danger")
        result.classList.remove("success" , "error")
    });

}

function fetchdata(loaddata ,currentpage)
{

    currentpage = currentpage == null ? 1 : parseInt(currentpage);
    let pages_info = new FormData();
    pages_info.append("limit" , select_no_pages.value);
    pages_info.append("search_id" , table_serach.value);
    pages_info.append("search_item" , search_by_item.value);
    pages_info.append("currentpage" , currentpage);
    fetch(loaddata,{
        method: 'POST' , 
        body  : pages_info
    }).then(resp=>resp.json())
    .then(data=>
        {  
            
            removespinner()
            let results = data.results.allwithlimit;
            let total = data.total;
            
            makeTable(results);
            makePagination(total , currentpage)   
            let pagination_pages = document.querySelectorAll(".pagination li");
            if(pagination_pages)
            {
               clickedpage(pagination_pages)
                
            }
            
                   
        
        })
}

function makePagination(total , currentpage)
{
    let pagination = document.querySelector(".pagination");
  
    let beforepage =  parseInt(currentpage) - 1; // example if  cueenr  = 1 so before will 0 // so i will make it add to 0 + 1 so before will be always 1
    let afterpage =  parseInt(currentpage) + 1;
    let active;
    let tag = "";

    total = parseInt(total);


    
    if(total == 0) { pagination.innerHTML = ""; return ; };

    if(total  > 5)
    {
            if(currentpage > 1)  // ok  make prev icon 
            {
                tag += `<li class="page-link" onclick="makePagination(${total} , ${beforepage })" data-page="${beforepage}">Previous</li>`;
            }else
            {
                tag += `<li class="page-link disabled">Previous</li>`;
            }


            if(currentpage > 2) // 3 if equal only 3 make this 1 before 2
            {
                tag += `<li class="page-link" onclick="makePagination(${total} , 1)" data-page="1">1</li>`; 
                if(currentpage > 3)  // if more than 3 eqal to 4 make  ... after one
                {
                    tag += `<li class="page-link dot">....</li>`; 
                }
            } 

            

            if(currentpage == 1)
            {
                beforepage = beforepage + 1 // 0 so start from 1
                afterpage = afterpage + 2;
            }

            if( currentpage ==  total)
            {
                afterpage = parseInt(afterpage) - 1;
                beforepage = parseInt(beforepage - 2);
            }

            for (let index = beforepage ;  index <= afterpage;  index++) {

                active  = index == currentpage ? 'active' : '';   

                tag += `<li class="page-link ${active}" onclick="makePagination(${total} , ${index})" data-page="${index}"> ${index} </li>`

            }

            if(currentpage < total - 2)
            {
                tag += `<li class="page-link dot">....</li>`; 
            }
            if( currentpage < total-1) // less than 18
            {
                tag += `<li class="page-link" onclick="makePagination(${total} , ${total})" data-page="${total}">${total}</li>`;
            }

            if(currentpage < total) // 11
            {
                tag += `<li class="page-link"  onclick="makePagination(${total} , ${afterpage })" data-page="${afterpage}">Next </li>`
            }
            else
            {
                tag += `<li class="page-link disabled">Next </li>`
            }
    }

    else 
    {
        if(currentpage > 1)
        {
            tag += `<li class="page-link" onclick="makePagination(${total} , ${beforepage })" data-page="${beforepage}">Previous</li>`;
        }else 
        {
            tag += `<li class="page-link disabled">Previous</li>`;
        }
        for ( index = 1 ;  index <= total;  index++) {


            active  = index == currentpage ? 'active' : '';   

            tag += `<li class="page-link ${active}" onclick="makePagination(${total} , ${index})" data-page="${index}">${index}</li>`;

        }

        if(currentpage < total)  // ok 
        {
            tag += `<li class="page-link"  onclick="makePagination(${total} , ${afterpage })" data-page="${afterpage}">Next </li>`
        }else if(currentpage == total) 
        {
            tag += `<li class="page-link disabled">Next </li>`
        }
    }

    pagination.innerHTML  = tag;
    

}


function clickedpage(elment)
{
   
  
    window.addEventListener("click",(e)=>
    {
        elment.forEach(el => {
            if(el == e.target)
            {  
                loadspinner();
                let  currentpage = parseInt(el.getAttribute("data-page"));
                fetchdata( load_data, currentpage)
    
            }
        });
    })
}

function makeTable(results)
{
   
    let edit_btn;
    let delete_btn;
    let tbody = document.querySelector(".tbody");
    tbody.innerHTML = "";
    let addedd_column = "";
    if( Array.isArray(results) )
    {
        for (let index in  results) 
        {
           addedd_column += `<tr>
                            <td>
                            ${results[index].area_id}
                            </td>
                            <td>
                                ${results[index].area_name}
                            </td>
                        <td class='action'>
                            <button data-href="${edit_data}${results[index].area_id}" class="btn btn-primary edit "
                            data-target="#editmodal" data-toggle= "modal"
                            ><i class="fas fa-edit"></i></button>
                            <button data-href="${delete_data}${results[index].area_id}" class="btn btn-danger delete"
                            data-permession="${results[index].area_name}""><i class="fas fa-times"></i></button>
                        </td>
                    </tr>`;
        }
    }

    tbody.innerHTML = addedd_column ;
     edit_btn       = document.querySelectorAll(".edit");
     delete_btn     = document.querySelectorAll(".delete");
     
  //  after oclick on edit btn 
    edit(edit_btn) 

  //  after click on delete btn
    delete_by_id(delete_btn) 
}

//

// click on edit on button on table to edit data 

// edit_url       = element.getAttribute("data-href"); == ${edit_data}${results[index].group_id};
//     == http://www.attendance.com/admin/areagroups/edit/1
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
                  edit_url  = element.getAttribute("data-href"); 
                  
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
            let result = document.querySelectorAll(".result")
            clearResultError(result)
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
                        if(data.error)
                         {   removespinner();
                             if(data.error.area_id)
                             {
                                 document.querySelector(".area-id").classList.add("alert" , "alert-danger");
                                 document.querySelector(".area-id").innerHTML = data.error.area_id;
                             }
                             if(data.error.area_name)
                             {
                                 document.querySelector(".area-name").classList.add("alert" , "alert-danger");
                                 document.querySelector(".area-name").innerHTML = data.error.area_name;
                             }
                         } 
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
                              fetchdata(load_data)
                              $('#editmodal').modal('toggle');
                        }

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
// 
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



