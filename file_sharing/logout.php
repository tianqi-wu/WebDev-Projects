<?php
/* Official process for logging out. Might be used in future assignments.
*/
            session_start();
            session_destroy();
            header("Location: sharing_site.html");
?>
