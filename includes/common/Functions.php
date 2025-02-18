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
    function setToastMessage($type, $message) {
        $_SESSION['toast_message'] = ["type" => $type, "text" => $message];
    }
    
    function showToast() {
        if (!isset($_SESSION['toast_message'])) return;
    
        $type = $_SESSION['toast_message']['type'];
        $message = $_SESSION['toast_message']['text'];
    
        $toastClass = ($type === "success") ? "bg-success text-white" :
                     (($type === "danger") ? "bg-danger text-white" :
                     (($type === "warning") ? "bg-warning text-dark" : "bg-info text-white"));
    
        $icon = ($type === "success") ? "✔️" : (($type === "danger") ? "❌" : (($type === "warning") ? "⚠️" : "ℹ️"));
        $title = ucfirst($type); 
    
        echo <<<HTML
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1050;">
            <div id="toastContainer"></div>
        </div>
    
        <div class="toast show $toastClass" role="alert" aria-live="assertive" aria-atomic="true" id="toastNotification">
            <div class="toast-header">
                <strong class="me-auto">$icon $title</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                <p class="mb-0">$message</p>
            </div>
        </div>
    
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.getElementById('toastNotification');
                var toastContainer = document.getElementById('toastContainer');
                toastContainer.appendChild(toastEl); 
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
        HTML;
    
        unset($_SESSION['toast_message']);
    }