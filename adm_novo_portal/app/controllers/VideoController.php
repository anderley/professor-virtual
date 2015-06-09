<?php

class VideoController extends BaseController {


	protected $layout = 'layout.main';

	private $mensages = array(
        'required' => 'Este campo é obrigatório.',
        );

	public function listar()
	{
		$videos = Video::whereNull('excluido')->orderBy('criacao', 'desc')->get();
		switch (Input::get('filtro'))
		{
			case 'titulo':
				$videos = Video::whereNull('excluido')->where(Input::get('filtro'), 'like', '%'.Input::get('filtro_valor').'%')->orderBy('criacao', 'desc')->get();
				break;
			case 'etiquetas':
				$etiquetas = explode(", ", Input::get('etiquetas'));
				$videos = Video::join('entidade_tag', 'entidade_tag.entidade_id', '=', 'video.id')
				->join('tag', 'tag.id', '=', 'entidade_tag.tag_id')->whereNull('video.excluido')
				->where('entidade_tag.entidade', 'video')->whereIn('tag.tag', $etiquetas)
				->orderBy('video.criacao', 'desc')->get();
		}
		$data = array('videos' => $videos);
		$this->layout->container = View::make('video.listar', $data);
		View::share('videoAtiva', 'active');
	}

	public function incluir()
	{
		$this->layout->container = View::make('video.formulario');
		View::share('videoAtiva', 'active');
	}

	public function salvar()
	{
		$regras = array(
            'titulo' => 'required',
            'embedded' => 'required',
            );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput(Input::all());
        }
        if (!Input::has('id'))
        {
        	$video = new Video;
        	$video->criacao = date('Y-m-d H:m:s');
        }
        else
        {
        	$video = Video::find(Input::get('id'));
        	EntidadeTag::where('entidade_id', $video->id)->where('entidade', 'video')->delete();
        }
        $video->titulo = Input::get('titulo');
        $video->embedded = Input::get('embedded');
        $video->save();
        if (Input::has('tags'))
    	{
    		$tags = explode(", ", Input::get('tags'));
    		foreach ($tags as $t)
    		{
    			if (trim($t) == "")
    			{
    				continue ;
    			}
    			$tag = Tag::where('tag', $t)->first();
    			if (is_null($tag))
    			{
    				$tag = new Tag;
    				$tag->tag = $t;
    				$tag->ativo = true;
    				$tag->criacao = date('Y-m-d H:m:s');
    				$tag->save();
    			}
    			$entidadeTag = new EntidadeTag;
    			$entidadeTag->tag_id = $tag->id;
    			$entidadeTag->entidade_id = $video->id;
    			$entidadeTag->entidade = 'video';
    			$entidadeTag->criacao = date('Y-m-d H:m:s');
    			$entidadeTag->save();
    		}
    	}

        $data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => !Input::has('id') ? "Video inserida com sucesso." : "Video alterado com sucesso.",
            );
        return Redirect::to('incluir-video')->with($data);
	}

	public function excluir($id)
	{
		$video = Video::find($id);
		$video->excluido = date('Y-m-d H:m:s');
        $video->save();
		$data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => "Video excluída com sucesso.",
            );
		return Redirect::to('videos')->with($data);
	}

	public function editar($id)
	{
		$video = Video::find($id);
		$tags = Tag::select('tag')->join('entidade_tag', function($entidade_tag){
			$entidade_tag->on('entidade_tag.tag_id', '=', 'tag.id');
		})->where('entidade_tag.entidade_id', $video->id)
		->where('entidade_tag.entidade', 'video')->whereNull('tag.excluido')->get();
		$str_tags = "";
		foreach ($tags as $tag)
		{
			$str_tags .= $tag->tag.", ";
		}
		$data = array(
			'video' => $video,
			'tags' => $str_tags,
			);
		$this->layout->container = View::make('video.formulario', $data);
		View::share('videoAtiva', 'active');
	}

}