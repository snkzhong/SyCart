<?php

sapp()->group('/admin', function(){

	sapp()->get('/login', function(){
		wrapObj(new \Main\Controller\Admin\SecuryController)->login();
	})->name('admin_login');


});