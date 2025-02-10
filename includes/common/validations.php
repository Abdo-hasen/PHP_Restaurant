<?php

    // validation by error  :

    function requiredVal($input)
    {
        if(empty($input))
        {
            return true; 
        }

        return false; 
    }



    // minmum length for value
    
    function minVal($input,$length)
    {
        if(strlen($input) < $length)
        {
            return true;
        }

        return false;
    }

  
    // maximum val

    function maxVal($input,$length)
    {
        if(strlen($input)> $length)
        {
            return true;
        }
        return false;
    }
