<?php
session_start();
session_destroy();
session_unset();

echo "<script>
                document.cookie = 'alert = 2;';
                window.location.href='login.php';
                </script>";
