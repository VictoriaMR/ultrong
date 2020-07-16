<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use frame\Html;

/**
 * 
 */
class CommonController extends Controller
{
	public function baseHeader()
	{	
		dd(12312);
		Html::addCss('common');

		return view();
	}
}