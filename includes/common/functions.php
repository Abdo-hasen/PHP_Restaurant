<?php




    function checkRequestMethod($method)
    {
        if($_SERVER["REQUEST_METHOD"] == $method)
        {
            return true;
        }
        
            return false;
        
    }


    function checkInput($method,$input)
    {
        if(isset($method[$input])) // $post["title"]
        {
            return true;
        }

        return false;
    }

   //sanitize input - no check here
    function sanitizeInput($input)
    {
        return htmlspecialchars(htmlentities(trim($input)));
    }

    // redirect
    function redirect($path)
    {
        header("location:$path");
        die;
    }

    // CHECK ERRORS OF VALIDATION
    function checkError($errors)
    {
        if($errors)
        {
            return true;
        }

        return false;
    }


    
    function checkSession($key)
    {
        if(isset($_SESSION[$key]))
        {
            foreach($_SESSION[$key] as $value)
            {
                return true;
            }

            unset($_SESSION[$key]);
        }

        return false;
    }
