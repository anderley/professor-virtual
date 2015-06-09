<?php

class HomeController extends BaseController {

	protected $layout = 'layout.main';


	public function show()
	{
		$this->layout->container = View::make('hello')->with('var','Teste');
	}
}
