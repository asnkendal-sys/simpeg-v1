<?php

namespace App\Http\Controllers;

use View, Validator, Input, Session, Redirect, Auth;

class ApiController extends Controller {

    public function getIndex() {
        echo "Hello World";
    }
}
