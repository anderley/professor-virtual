<?php

class HomeController extends BaseController {

	/**
     * The layout that should be used for responses.
     */
    protected $layout = 'layouts.main';


	public function show()
	{
		$this->layout = View::make('layouts.main', array('active' => 'home',));
		$noticias = Noticia::whereNull('excluido')->orderBy('data_publicacao', 'desc')->take(10)->get();
        $apostilas = Apostila::whereNull('excluido')->take(10)->get();
		$data = array(
            'active' => 'home',
            'noticias' => $noticias,
            'apostilas' => $apostilas);
		$this->layout->content = View::make('hello', $data);
	}

	public function noticia($titulo, $id)
	{
		$bc = array(
            'breadcrumb' => array(
                array(
                    'nome' => 'Home',
                    'active' => false,
                    'url' => '/',
                ),
                array(
                    'nome' => 'Notícia',
                    'active' => true,
                    'url' => '#',
                ),
            ),
        );
        $this->layout->breadcrumb = View::make('layouts.breadcrumb', $bc);
		$noticia = Noticia::find($id);
        $tags = Tag::select('tag.tag')->join('entidade_tag', function($entidade_tag){
            $entidade_tag->on('entidade_tag.tag_id', '=', 'tag.id');
        })->where('entidade_tag.entidade_id', $noticia->id)
        ->where('entidade_tag.entidade', 'noticia')->whereNull('tag.excluido')->get()->lists('tag');

        $videos = Video::join('entidade_tag', 'entidade_tag.entidade_id', '=', 'video.id')
        ->join('tag', 'tag.id', '=', 'entidade_tag.tag_id')->where('entidade_tag.entidade', 'video')
        ->whereIn('tag.tag', $tags)->whereNull('video.excluido')->groupBy('video.id')->get();

        $apostilas = Apostila::join('entidade_tag', 'entidade_tag.entidade_id', '=', 'apostila.id')
        ->join('tag', 'tag.id', '=', 'entidade_tag.tag_id')->where('entidade_tag.entidade', 'apostila')
        ->whereIn('tag.tag', $tags)->whereNull('apostila.excluido')->groupBy('apostila.id')->get();

		$data = array(
            'noticia' => $noticia,
            'videos' => $videos,
            'apostilas' => $apostilas);
		$this->layout->content = View::make('noticia', $data);
	}

}
