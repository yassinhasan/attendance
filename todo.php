<?php
// THIS WEEK


// TODO: PREPARE AREASUPERVISORS by add supervisor name in select drop and it's value is 
        // id after fenish of it
        // prepare supervisors by join it's table by areasupervisors to get area name
        // also connect area groups to supervisors name 
        // when update supervisor we must change it first in areasupervisor 
        // automaticaly will change in both area and supervisors
        

//TODO: //  MAKE DOWNLOAD XLMS NOT XLS 
//TODO: // MAKT TABLE FOR SUPERVISOR AND THEIR DATA ALL DATA AND TABLE CONTAIN 
//TODO: // when add area show who is exists area id or supservisor id in erro message



// TODO: foregt password
/* FIXME: not found controller  */
// HACK(john): This is a workaround
// TODO(john): A comment in HTML file 

/*
    group 1 permesion  == supervisor 
                       access to all admin page and other oages

          2 permesion == epmolyees 
                       not have any acces to admin oages or sign up or login pages 
                       only pages start with users or "/"
          
    data base 
                   group id
                   group name
                   
                   group_user_id

                   group id id of any permestion

                   g name name of permession
                   group_user_id  == groupid of user

                   like
                   all admin will be groupid =1  == equal to usergroupid 1 

   // i will make permession controller and model
      groupcontroller will open page of table of all permession
                      and have edit or delete or add popup model
                      
                      only user with group 1 have access on it
                      
*/