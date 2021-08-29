<?php
namespace System;

use PDO;

class DataBase 
{
    private static $connection = null;
    private $app;
    private $table;
    private $data     = [];
    private $bindings = [];
    private $lastid;
    private $wheres   = [];
    private $havings   = [];
    private $rowcount;
    private $select   = [];
    private $join     = [];
    private $limit;
    private $offset;
    private $orderby;
    private $groupby;
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->connect();
    }
    public function connect()
    {
        if(!static::$connection instanceof PDO)
        {

            $data =$this->app->file->require("config");
            extract($data);

        try {
            static::$connection = new PDO("mysql:host=$server;dbname=$dbname",$username,$password);
            static::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE , PDO::FETCH_OBJ);
            static::$connection->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
            static::$connection->exec( "set names utf8");
        } catch (\PDOException $e) {
           echo $e->getMessage();
        }

        }
        return static::$connection;
    }

    public function connection()
    {
        return static::$connection;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;

    }
    public function from($table)
    {
        $this->table = $table;
        return $this;

    }
    public function data($key , $value =null)
    {
        if(is_array($key))
        {

            $this->data = array_merge($this->data , $key);
            $this->addToBindings(array_values($this->data));
        }
        else
        {
         $this->data[$key] = $value;
         $this->addToBindings($value);           
        } 

        return $this; 

    }

    public function where(...$where)
    {
        $sql = array_shift($where);
        $this->wheres [] = $sql;
        if(count($where) == 1 AND is_array($where))
        {
            $bindings = $where[0];
        }
        else
        {
        $bindings = $where;
        }
        $this->addToBindings($bindings);
        return $this;
    }
    public function having(...$havings)
    {
        $sql = array_shift($havings);
        $this->havings[] = $sql;
        if(count($havings) == 1 AND is_array($havings))
        {
            $bindings = $havings[0];
        }
        else
        {
        $bindings = $havings;
        }
        $this->addToBindings($bindings);
        return $this;
    }

    public function addToBindings($value)
    {
        if(is_array($value))
        {

            $this->bindings = array_merge($this->bindings , array_values($value));

        }else
        {
                $this->bindings[] = $value;
        }
        
    }
    
    
    public function lastId()
    {
        return $this->lastid;
    }
    public function rowCount()
    {
        return $this->rowcount;
    }


    public function query(...$query)
    {
        $sql = array_shift($query);
        if(count($query) == 1 AND is_array($query))
        {
           $bindings = $query[0];
        }
       else
       {
        $bindings = $query;
       }
       
       try {
        $stmt = static::$connection->prepare($sql);
        foreach($bindings  as  $key => $value){
            $stmt->bindValue( $key+1 , $value); 
        }
        $stmt->execute();
        $this->reset();

       } catch (\Exception $e) {
           echo $e."<br>";
           echo $sql."<br>";
           pre($bindings);
       }
       return $stmt;
    }
    public function insert($table = null)
    {
        // insert into users
        if($table)
        {
            $this->table($table);
        }
        $sql = " INSERT INTO $this->table SET ";
        foreach(array_keys($this->data) as $key)
        {
            $sql .= " $key = ? , ";
        }
        $sql = rtrim($sql , ", ");
        
        $query = $this->query($sql , $this->bindings);
        $this->lastid  = static::$connection->lastInsertId();
        $this->rowcount  = $query->rowCount();
        return $this;

    }



    public function update($table = null)
    {
        if($table)
        {
            $this->table($table);
        }
        $sql = " UPDATE $this->table SET ";
        foreach(array_keys($this->data) as $key)
        {
            $sql .= " $key = ? , ";
        }
        $sql = rtrim($sql , ", ");
        if($this->wheres)
        {
            $sql .= " WHERE ".implode(" ",$this->wheres);
        }
        $query = $this->query($sql , $this->bindings);
        $this->lastid  = static::$connection->lastInsertId();
        $this->rowcount  = $query->rowCount();
        return $this;

    }


    
    public function delete($table = null)
    {
        if($table)
        {
            $this->table($table);
        }
        $sql = " DELETE FROM  $this->table ";
        if($this->wheres)
        {
            $sql .= " WHERE ".implode(" ",$this->wheres);
        }
        $query = $this->query($sql , $this->bindings);
        $this->lastid  = static::$connection->lastInsertId();
        $this->rowcount  = $query->rowCount();
        return $this;

    }


    
    public function select($select = null)
    {
        if(is_array($select))
        {
            $this->select = array_merge($this->select , $select);
        }
        else
        {
            $this->select[] = $select;
        }
        return $this;
    }
    public function join($join)
    {
        if(is_array($join))
        {
            $this->join = array_merge($this->join , $join);
        }
        else
        {
            $this->join[] = $join;
        }
        return $this;
    }

    public function limit($limit , $offest = 0)
    {
        $this->limit = $limit;
        $this->offset = $offest;
        return $this;
    }
    public function orderBy($column , $orderby=' ASC ')
    {

        $this->orderby = $column.$orderby;
        return $this;
    }

    public function groupBy($groupby)
    {
        $this->groupby = $groupby;
        return $this;
    }
    public function prepareSql()
    {
        $sql = ' SELECT ';

        if($this->select)
        {

            $sql .= implode(" , " , $this->select);
        }else
        {
            $sql .= " * ";
        }

        if($this->table)
        {
            $sql .= " FROM ".$this->table." ";
        }
        if($this->join)
        {
            $sql .=  implode(" " , $this->join);
        }

        if($this->groupby)
        {
            $sql .= " GROUP BY ".$this->groupby;
        }
        if($this->havings)
        {
            $sql .= " HAVING ".implode(" ",$this->havings);
        }
        if($this->wheres)
        {
            $sql .= " WHERE ".implode(" ",$this->wheres);
        }
        if($this->orderby)
        {
            $sql .= " ORDER BY ".$this->orderby;
        }
        if($this->limit)
        {
            $sql .= " LIMIT ".$this->limit;
        }
        if($this->offset)
        {
            $sql .= " OFFSET ".$this->offset;
        }
        return $sql;
    }
    public function fetch($table = null)
    {
        if(! $this->table)
        {
            $this->from($table);
        }
        $sql = $this->prepareSql();
        $query = $this->query($sql , $this->bindings);
        $result =  $query->fetch();
        $this->reset();
        return $result;
    }
    public function fetchAll($table = null)
    {
        if(! $this->table)
        {
            $this->from($table);
        }
        $sql = $this->prepareSql();
        $query = $this->query($sql , $this->bindings);
        $results =  $query->fetchAll();
        $this->reset();
        return $results;
    }

    
    public function reset()
    {
        $this->data = [];
        $this->bindings = [];
        $this->wheres = [];
        $this->lastid = null;
        $this->table = null;
        $this->rowcount = null;
        $this->select = [];
        $this->havings = [];
        $this->orderby = null;
        $this->limit = null;
        $this->offset = null;
        $this->groupby = null;
        
    }






}