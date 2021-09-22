<?php

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