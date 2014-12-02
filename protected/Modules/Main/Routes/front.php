<?php

sapp()->get('/', function(){
	wrapObj(new \Main\Controller\User)->hello();
})->name('homepage');

sapp()->get('/register', function(){
	echo 'register';
});