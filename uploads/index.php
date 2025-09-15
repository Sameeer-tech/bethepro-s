<?php
// Prevent direct access to PHP files in uploads directory
http_response_code(403);
exit('Access denied');
?>