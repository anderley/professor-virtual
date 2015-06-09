<?php

class TagController extends BaseController {


	protected $layout = 'layout.main';

	private $mensages = array(
        'required' => 'Este campo é obrigatório.',
        'unique' => 'Tag já inserida.',
        );
	

	public function listar()
	{
		$tags = Tag::whereNull('excluido')->orderBy('criacao', 'desc')->get();
		$data = array('tags' => $tags);
		$this->layout->container = View::make('tag.listar', $data);
		View::share('tagAtiva', 'active');
	}

	public function incluir()
	{
		$this->layout->container = View::make('tag.formulario');
		View::share('tagAtiva', 'active');
	}

	public function salvar()
	{
		$regras = (Input::get('id') == "")
			? array(
				'tag' => 'required|unique:tag',
				)
			: array(
				'tag' => 'required',
				);
        $validator = Validator::make(Input::all(), $regras, $this->mensages);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput(Input::all());
        }
        if (Input::get('id') == "")
        {
        	$tag = new Tag;
        	$tag->criacao = date('Y-m-d H:m:s');
        }
        else
        {
        	$tag = Tag::find(Input::get('id'));
        }
        $tag->tag = Input::get('tag');
        $tag->ativo = Input::get('ativo') == 'true';
        $tag->save();

        $data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => (Input::get('id') == "") ? "Tag inserida com sucesso." : "Tag alterada com sucesso.". Input::get('ativo'),
            );
        return Redirect::to('incluir-tag')->with($data);
	}

	public function excluir($id)
	{
		$tag = Tag::find($id);
		$tag->excluido = date('Y-m-d H:m:s');
        $tag->save();
		$data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => "Tag excluída com sucesso.",
            );
		return Redirect::to('tags')->with($data);
	}

	public function editar($id)
	{
		$tag = Tag::find($id);
		$data = array('tag' => $tag);
		$this->layout->container = View::make('tag.formulario', $data);
		View::share('tagAtiva', 'active');
	}
}