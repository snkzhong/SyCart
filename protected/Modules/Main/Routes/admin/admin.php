<?php

sapp()->group('/admin', function(){

	sapp()->get('/login', function(){
		wrapObj(new Admin_SecuryController)->login();
	})->name('admin_login');


});