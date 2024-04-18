<?php

function filterequest($request) {

    return htmlspecialchars(strip_tags($_POST[ $request ]));
        
}   