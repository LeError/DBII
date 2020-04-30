<?php
    /**
     * view_404.inc.php
     *
     * View that is displayed when a view is not found by the system
     *
     * @author     Robin Herder
     */

    //Prevent user form accessing file directly
    require_once('./logic/security.req.php');
    checkDocument();

?>
<div class="ui container text center aligned">
    <br/>
    <br/>
    <br/>
    <h1 class="ui header">404</h1>
    <p>The page you were looking for could not be found</p>
</div>