<?php

class ApostilaController extends BaseController {

	protected $layout = 'layout.main';

	private $mensages = array(
        'required' => 'Este campo é obrigatório.',
        );
	

	public function listar()
	{
        $result = (object) $this->getPaginaApostilas();
		$data = array(
            'apostilas' => $result->apostilas,
            'num_pagina' => $result->num_pagina,
            'total_paginas' => $result->total_paginas,
            'filter' => $result->filter,
            );
		$this->layout->container = View::make('apostila.listar', $data);
		View::share('apostilaAtiva', 'active');
	}

	public function incluir()
	{
		$this->layout->container = View::make('apostila.formulario');
		View::share('apostilaAtiva', 'active');
	}

	public function salvar()
	{
		$regras = array(
            'titulo' => 'required',
            'cargo' => 'required',
            'imagem' => 'required',
            'link_parceiro' => 'required',
            );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput(Input::all());
        }
        if (!Input::has('id'))
        {
        	$apostila = new Apostila;
        	$apostila->criacao = date('Y-m-d H:m:s');
        }
        else
        {
        	$apostila = Apostila::find(Input::get('id'));
        	$apostila->ativo = Input::get('ativo');
        	EntidadeTag::where('entidade_id', $apostila->id)->where('entidade', 'apostila')->delete();
        }
        $apostila->titulo = Input::get('titulo');
        $apostila->cargo = Input::get('cargo');
        $apostila->imagem = Input::get('imagem');
        if (Input::has('valor_impresso'))
        {
        	$apostila->valor_impresso = str_replace(",", ".", str_replace(".", "", Input::get('valor_impresso')));
        }
        if (Input::has('valor_digital'))
        {
        	$apostila->valor_digital = str_replace(",", ".", str_replace(".", "", Input::get('valor_digital')));
        }
        $apostila->link_parceiro = Input::get('link_parceiro');
        $apostila->save();
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
    			$entidadeTag->entidade_id = $apostila->id;
    			$entidadeTag->entidade = 'apostila';
    			$entidadeTag->criacao = date('Y-m-d H:m:s');
    			$entidadeTag->save();
    		}
    	}

        $data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => !Input::has('id') ? "Apostila inserida com sucesso." : "Apostila alterado com sucesso.",
            );
        return Redirect::to('incluir-apostila')->with($data);
	}

	public function excluir($id)
	{
		$apostila = Apostila::find($id);
		$apostila->excluido = date('Y-m-d H:m:s');
        $apostila->save();
		$data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => "Apostila excluída com sucesso.",
            );
		return Redirect::to('apostilas')->with($data);
	}

	public function editar($id)
	{
		$apostila = Apostila::find($id);
		$tags = Tag::select('tag')->join('entidade_tag', function($entidade_tag){
			$entidade_tag->on('entidade_tag.tag_id', '=', 'tag.id');
		})->where('entidade_tag.entidade_id', $apostila->id)
		->where('entidade_tag.entidade', 'apostila')->whereNull('tag.excluido')->get();
		$str_tags = "";
		foreach ($tags as $tag)
		{
			$str_tags .= $tag->tag.", ";
		}
		$data = array(
			'apostila' => $apostila,
			'tags' => $str_tags,
			);
		$this->layout->container = View::make('apostila.formulario', $data);
		View::share('apostilaAtiva', 'active');
	}

    public function getPaginaApostilas($page = 0, $filter = null, $value = null)
    {
        if (Input::has('filtro'))
        {
            $filter = Input::get('filtro');
            $value = Input::has('filtro_valor') ? Input::get('filtro_valor') : Input::get('etiquetas');
        }   
        $query = Apostila::whereNull('excluido')->orderBy('criacao', 'desc');
        switch ($filter)
        {
            case 'titulo':
            case 'cargo':
                $query = Apostila::whereNull('excluido')->where($filter, 'like', '%'.$value.'%')->orderBy('criacao', 'desc');
                break;
            case 'etiquetas':
                $etiquetas = explode(", ", $value);
                $query = Apostila::join('entidade_tag', 'entidade_tag.entidade_id', '=', 'apostila.id')
                ->join('tag', 'tag.id', '=', 'entidade_tag.tag_id')->whereNull('apostila.excluido')
                ->where('entidade_tag.entidade', 'apostila')->whereIn('tag.tag', $etiquetas)
                ->orderBy('apostila.criacao', 'desc');
        } 
        $total_registros = $query->count();
        $total_paginas = 0;
        $max_linhas = 20;
        if (!empty($total_registros))
        {
            $total_paginas = ceil($total_registros / $max_linhas);
        }
        $apostilas = $query->skip($page * $max_linhas)->take($max_linhas)->get();
        $pagina = array(
            'num_pagina' => $page + 1,
            'total_paginas' => $total_paginas,
            'apostilas' => $apostilas,
            'filter' => !is_null($filter) ? $filter.'/'.$value : '',
            );        
        return $pagina;
    }
    
}