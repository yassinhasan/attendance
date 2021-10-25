let add_new_btn = document.querySelector(".add-new");
let submit_btn  = document.querySelector(".submit-btn");
// <form class="add-form">  in modal
let form        = document.querySelector(".add-form");
let table       = document.querySelector(".table");

// $data['load_data']  =  toLink("admin/insurancegroups/realtime");
let load_data   = table.getAttribute("data-load");

let result = document.querySelectorAll(".result");

let table_serach = document.querySelector(".table-serach");

let search_by_item = document.querySelector(".search_item");

let select_no_pages  = document.querySelector(".select-no-pages");

//$data['edit_data']  =  toLink("admin/insurancegroups/edit/");
let edit_data   = table.getAttribute("data-edit"); 
let show_data   = table.getAttribute("data-show"); 

 //$data['delete_data']  =  toLink("admin/usersgroups/delete/");
let delete_data   = table.getAttribute("data-delete");
add_new_btn.addEventListener("click",()=>
{
    let addform = document.querySelector(".add-form")
    nameinput = addform.querySelector("#name");
    mobileinput = addform.querySelector("#mobile");
    notesinput = addform.querySelector(".notes2");
    companyinput = addform.querySelector("#company");
    filesinput = addform.querySelector("#files");
    nameinput.value =""
    mobileinput.value =""
    notesinput.value =""
    companyinput.value =""
    filesinput.value =""
    clearResultError(result)

    $('#insurancemodel').modal('toggle');
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
                
         //         // id	name	mobile	company	dispensed_time	//next_dispensed_time	user_id	drugs	notes	files
                if(data.error)
                {
                    if(data.error.name)
                    {
                       
                        document.querySelector(".name2").classList.add("alert" , "alert-danger");
                        document.querySelector(".name2").innerHTML = data.error.name;
                    }
                    if(data.error.mobile)
                    {
                        document.querySelector(".mobile2").classList.add("alert" , "alert-danger");
                        document.querySelector(".mobile2").innerHTML = data.error.mobile;
                    }
                    if(data.error.company)
                    {
                        document.querySelector(".company2").classList.add("alert" , "alert-danger");
                        document.querySelector(".company2").innerHTML = data.error.company;
                    }
                    if(data.error.dispensed_time)
                    {
                        document.querySelector(".dispensed_time2").classList.add("alert" , "alert-danger");
                        document.querySelector(".dispensed_time2").innerHTML = data.error.dispensed_time;
                    }
                    if(data.error.period)
                    {
                        document.querySelector(".period2").classList.add("alert" , "alert-danger");
                        document.querySelector(".period2").innerHTML = "required";
                    }
                    if(data.error.files)
                    {
                        document.querySelector(".files2").classList.add("alert" , "alert-danger");
                        document.querySelector(".files2").innerHTML = "required";
                    }
                    // if(data.error.drugs)
                    // {
                    //     document.querySelector(".drugs").classList.add("alert" , "alert-danger");
                    //     document.querySelector(".drugs").innerHTML = data.error.drugs;
                    // }
                    if(data.error.next_dispensed_time)
                    {
                        document.querySelector(".next_dispensed_time2").classList.add("alert" , "alert-danger");
                        document.querySelector(".next_dispensed_time2").innerHTML = data.error.next_dispensed_time;
                    }

                    removespinner()
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
                      $('#insurancemodel').modal('toggle');  
                      removespinner()
                }
                if(data.db_error)
                {
                    if(data.db_error)
                    {
                        alert("error")
                    }
                    removespinner()
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
    let preview_btn ;
    let tbody = document.querySelector(".tbody");
    tbody.innerHTML = "";
    let addedd_column = "";
    let is_ready = "";
    if( Array.isArray(results) )
    {
        
        for (let index in  results) 
        {
                 //id	name	mobile	company	dispensed_time	period	next_dispensed_time	user_id	drugs	notes	files	

                 if(results[index].remain < 25)
                 {
                     is_ready = "bg bg-success";  
                 }else
                 {
                    is_ready = ""; 
                 }
           addedd_column += `<tr class="${is_ready}">
                            <td>
                            ${results[index].name}
                            </td>
                            <td>
                            ${results[index].mobile}
                            </td>
                            <td>
                            ${results[index].company}
                            </td>
                            <td>
                                ${results[index].dispensed_time}
                            </td>
                            <td>
                                ${results[index].next_dispensed_time}
                            </td>
                            <td>
                                drugs
                            </td>
                            <td>
                            ${results[index].notes}
                            </td>
                        <td class='action'>
                            <button data-href="${show_data}${results[index].id}" class="btn btn-primary preview "
                            data-target="#previewmodel" data-toggle= "modal"
                            ><i class="fas fa-eye"></i></button>
                            <button data-href="${edit_data}${results[index].id}" class="btn btn-primary edit "
                            data-target="#editmodal" data-toggle= "modal"
                            ><i class="fas fa-edit"></i></button>
                            <button data-href="${delete_data}${results[index].id}" class="btn btn-danger delete"><i class="fas fa-times"></i></button>
                        </td>
                    </tr>`;
        }
    }

    tbody.innerHTML = addedd_column ;
     edit_btn       = document.querySelectorAll(".edit");
     delete_btn     = document.querySelectorAll(".delete");
     preview_btn     = document.querySelectorAll(".preview");
     
  //  after oclick on edit btn 
    edit(edit_btn) 

  //  after click on delete btn
    delete_by_id(delete_btn) 

    preview(preview_btn)  
}

//

// click on edit on button on table to edit data 

// edit_url       = element.getAttribute("data-href"); == ${edit_data}${results[index].group_id};
//     == http://www.attendance.com/admin/insurancegroups/edit/1
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
                     // 

                    let monthperiod2 = elm.querySelector(".period2");
                    let distime = elm.querySelector(".dis-time");
                    
                    monthperiod2.addEventListener("change",(e)=>
                    {
                        setNextRefillTime(document)

                    })
                    distime.addEventListener("change",()=>
                    {
                        setNextRefillTime(document)

                    })
                    
                    function setNextRefillTime(elm)
                    {
                            let monthperiod2 = elm.querySelector(".period2");
                            let nextrefill = elm.querySelector(".next-refill");
                            let distime = elm.querySelector(".dis-time")
                            let days = (monthperiod2.value * 30 )- 5 ;
                            let date = new Date(distime.value);
                            t = date.setDate(date.getDate() + days);
                            t = new Date(t);
                            var month = t.getMonth() + 1;
                            month = month < 10 ? "0"+month : month;
                            var year = t.getFullYear();
                            var day = t.getDate();
                            day = day < 10 ? "0"+day : day;
                            
                            nextrefill.value =  `${year}-${month}-${day}`
                        
                    }
                    
                    setNextRefillTime(elm)
                    
                    
                                        //
                    let table_div = document.querySelector(".table-center");
                    table_div.insertAdjacentElement("afterend" , model);
                    $('#editmodal').modal('show');
                     update(model.querySelector(".save_btn") , edit_form)
                    })  
                    
                    

                  .catch(error=>console.log(error))
            })
            
    });
}
let  preview_url;
function preview(el)
{
    el.forEach(element => {
        element.addEventListener("click",()=>
            {
                 
                 loadspinner()
                  if(document.getElementById("previewmodel"))
                  {
                    document.getElementById("previewmodel").remove()
                   
                  }
                  preview_url  = element.getAttribute("data-href"); 
                  
                  fetch(preview_url,{
                      method: "POST"
                  }).then(resp=>resp.text())
                  .then(data=>{
                     removespinner()
                    let html = new DOMParser();
                    let elm =  html.parseFromString(data, "text/html");
                    let model = elm.getElementById("previewmodel");
                    let table_div = document.querySelector(".table-center");
                    table_div.insertAdjacentElement("afterend" , model);
                    $('#previewmodel').modal('show');
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
                         {   
                            if(data.error.name)
                            {
                                document.querySelector(".name").classList.add("alert" , "alert-danger");
                                document.querySelector(".name").innerHTML = data.error.name;
                            }
                            if(data.error.mobile)
                            {
                                document.querySelector(".mobile").classList.add("alert" , "alert-danger");
                                document.querySelector(".mobile").innerHTML = data.error.mobile;
                            }
                            if(data.error.company)
                            {
                                document.querySelector(".company").classList.add("alert" , "alert-danger");
                                document.querySelector(".company").innerHTML = data.error.company;
                            }
                            if(data.error.dispensed_time)
                            {
                                document.querySelector(".dispensed_time").classList.add("alert" , "alert-danger");
                                document.querySelector(".dispensed_time").innerHTML = data.error.dispensed_time;
                            }
                            if(data.error.period)
                            {
                                document.querySelector(".period").classList.add("alert" , "alert-danger");
                                document.querySelector(".period").innerHTML = "required";
                            }
                            if(data.error.files)
                            {
                                document.querySelector(".files").classList.add("alert" , "alert-danger");
                                document.querySelector(".files").innerHTML = "required";
                            }
                            // if(data.error.drugs)
                            // {
                            //     document.querySelector(".drugs").classList.add("alert" , "alert-danger");
                            //     document.querySelector(".drugs").innerHTML = data.error.drugs;
                            // }
                            if(data.error.next_dispensed_time)
                            {
                                document.querySelector(".next_dispensed_time").classList.add("alert" , "alert-danger");
                                document.querySelector(".next_dispensed_time").innerHTML = data.error.next_dispensed_time;
                            }
                         }  removespinner();
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
                        removespinner();

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



function showchangepassword(elm)
{
    elm.classList.add("hide")
    document.querySelector(".password-box").classList.add("show")
   
}

let monthperiod = document.querySelector(".period");
let nextrefill = document.querySelector(".next-refill");
let distime = document.querySelector(".dis-time")

monthperiod.addEventListener("change",(e)=>
{

    setNextRefillTime()
})
distime.addEventListener("change",(e)=>
{

    setNextRefillTime()
})

function setNextRefillTime()
{
        let monthperiod = document.querySelector(".period");
        let nextrefill = document.querySelector(".next-refill");
        let distime = document.querySelector(".dis-time")
        let days = (monthperiod.value * 30 )- 5 ;
        let date = new Date(distime.value);
        t = date.setDate(date.getDate() + days);
        t = new Date(t);
        var month = t.getMonth() + 1;
        month = month < 10 ? "0"+month : month;
        var year = t.getFullYear();
        var day = t.getDate();
        day = day < 10 ? "0"+day : day;
        
        nextrefill.value =  `${year}-${month}-${day}`
        
  
}   

setNextRefillTime()


