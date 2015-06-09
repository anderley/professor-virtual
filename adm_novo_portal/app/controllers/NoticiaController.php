<?php
session_start();

use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;

class NoticiaController extends BaseController {

	protected $layout = 'layout.main';

	private $access_token = null;

	private $mensages = array(
        'required' => 'Este campo é obrigatório.',
        );
	
	public function listar()
	{
		//FacebookSession::setDefaultApplication('1621934994684546', 'bdaa50bb8f8ef18a41444b1998440cac');
		$helper = new FacebookRedirectLoginHelper(url('listar-noticias'));
		try
		{
			$session = $helper->getSessionFromRedirect();
			if($session)
			{
				$_SESSION['access_token'] = $session->getToken();
			}
			else
			{	
				return Redirect::to($helper->getLoginUrl(array('publish_pages', 'email', 'publish_actions')));
			}
		}
		catch(FacebookRequestException $ex)
		{
			Log::error($ex);
		}
		catch(\Exception $ex)
		{
			Log::error($ex);
		}
	}

	public function listarNoticias()
	{
		$noticias = Noticia::whereNull('excluido')->orderBy('data_publicacao', 'desc')->get();
		switch (Input::get('filtro'))
		{
			case 'titulo':
			case 'autor':
				$noticias = Noticia::whereNull('excluido')->where(Input::get('filtro'), 'like', '%'.Input::get('filtro_valor').'%')->orderBy('criacao', 'desc')->get();
				break;
			case 'etiquetas':
				$etiquetas = explode(", ", Input::get('etiquetas'));
				$noticias = Noticia::join('entidade_tag', function($entidade_tag){
					$entidade_tag->on('entidade_tag.entidade_id', '=', 'noticia.id');
				})->join('tag', function($tag){
					$tag->on('tag.id', '=', 'entidade_tag.tag_id');
				})->whereNull('noticia.excluido')
				->where('entidade_tag.entidade', 'noticia')
				->whereIn('tag.tag', $etiquetas)->orderBy('noticia.data_publicacao', 'desc')->get();
				break;
			case 'publicacao':
				$publicacao_inicio = preg_replace('/(\d{2})\/(\d{2})\/(\d{4})/i', '$3-$2-$1', Input::get('publicacao_inicio'));
				$publicacao_fim = preg_replace('/(\d{2})\/(\d{2})\/(\d{4})/i', '$3-$2-$1', Input::get('publicacao_fim'));
				$noticias = Noticia::whereNull('excluido')->whereBetween('data_publicacao', [$publicacao_inicio, $publicacao_fim])->orderBy('criacao', 'desc')->get();
		}
		$data = array('noticias' => $noticias);
		$this->layout->container =  View::make('noticia.listar', $data);
		View::share('noticiaAtiva', 'active');
	}

	public function incluir()
	{
		$this->layout->container = View::make('noticia.formulario');
		View::share('noticiaAtiva', 'active');
	}

	public function salvar()
	{
		// $session = new FacebookSession($_SESSION['access_token']);
		// if(!$session)
		// {
		// 	return "não funciona essa porra!";
		// }
		// // post to page
		// $page_post = (new FacebookRequest( $session, 'POST', '/me/feed', array(
		// 	'access_token' => $this->access_token,
		// 	'name' => 'Facebook API: Posting As A Page using Graph API v2.x and PHP SDK 4.0.x',
		// 	'link' => 'https://www.webniraj.com/2014/08/23/facebook-api-posting-as-a-page-using-graph-api-v2-x-and-php-sdk-4-0-x/',
		// 	'caption' => 'The Facebook API lets you post to Pages you administrate via the API. This tutorial shows you how to achieve this using the Facebook PHP SDK v4.0.x and Graph API 2.x.',
		// 	'message' => 'Check out my new blog post!',
		// 	) ))->execute()->getGraphObject()->asArray();
		// // return post_id
		// return "teste: ".print_r( $page_post );
		View::share('noticiaAtiva', 'active');
		$regras = array(
            'titulo' => 'required',
            'autor' => 'required',
            'texto' => 'required',
            );
        $validator = Validator::make(Input::all(), $regras, $this->mensages);
        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator)->withInput(Input::all());
        }
        $upload_success = true;
        $imagem = Input::file('imagem');
        $link_imagem = null;
        if (!empty($imagem))
        {
			$pasta_imagens = '/noticias/imagens';
			$nome_arquivo = preg_replace('/(.+)\..+/i', '$1', $imagem->getClientOriginalName()).'_'.date('d_m_y_H_m_s').'.'.$imagem->getClientOriginalExtension();
			$nome_arquivo = str_replace(' ', '_', $nome_arquivo);
			$upload_success = Input::file('imagem')->move($_SERVER['DOCUMENT_ROOT'].'/novo_portal/public'.$pasta_imagens, $nome_arquivo);
			$link_imagem = $pasta_imagens.'/'.$nome_arquivo;
			$image_file = $_SERVER['DOCUMENT_ROOT'].'/novo_portal/public'.$link_imagem;
			Image::make($image_file)->widen(106)->save($image_file);
		}
        $upload_success = true;
        $edital = Input::file('edital');
        $link_edital = null;
        if (!empty($edital))
        {
			$pasta_editais = '/editais';
			$nome_arquivo = preg_replace('/(.+)\..+/i', '$1', $edital->getClientOriginalName()).'_'.date('d_m_y_H_m_s').'.'.$edital->getClientOriginalExtension();
			$nome_arquivo = str_replace(' ', '_', $nome_arquivo);
			$upload_success = Input::file('edital')->move($_SERVER['DOCUMENT_ROOT'].'/novo_portal/public'.$pasta_editais, $nome_arquivo);
			$link_edital = $pasta_editais.'/'.$nome_arquivo;
		}
		if ($upload_success)
		{
			if (!Input::has('id'))
			{
				$noticia = new Noticia;
        		$noticia->criacao = date('Y-m-d H:m:s');
			}
			else
			{
				$noticia = Noticia::find(Input::get('id'));
				EntidadeTag::where('entidade_id', $noticia->id)->where('entidade', 'noticia')->delete();
			}
			$noticia->titulo = Input::get('titulo');
			$noticia->autor = Input::get('autor');
			$noticia->fonte = Input::get('fonte');
			if (Input::has('data_publicacao'))
			{
				$noticia->data_publicacao = preg_replace('/(\d{2})\/(\d{2})\/(\d{4})/i', '$3-$2-$1', Input::get('data_publicacao'));
			}
			$noticia->link_referencia = Input::get('link_referencia');
			if (!empty($link_imagem))
			{
				if (Input::has('id') && !empty($noticia->imagem))
				{
					try
					{
						unlink($_SERVER['DOCUMENT_ROOT'].'/novo_portal/public'.$noticia->imagem);
					}
					catch(ErrorException $exception)
					{
						Log::error($exception);
					}
				}
				$noticia->imagem = $link_imagem;
			}
			if (!empty($link_edital))
			{
				if (Input::has('id') && !is_null($noticia->link_edital))
				{
					try
					{
						unlink($_SERVER['DOCUMENT_ROOT'].'/novo_portal/public'.$noticia->link_edital);
					}
					catch(ErrorException $exception)
					{
						Log::error($exception);
					}
				}
				$noticia->link_edital = $link_edital;
			}
        	$noticia->texto = Input::get('texto');
        	$noticia->save();
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
        			$entidadeTag->entidade_id = $noticia->id;
        			$entidadeTag->entidade = 'noticia';
        			$entidadeTag->criacao = date('Y-m-d H:m:s');
        			$entidadeTag->save();
        		}
        	}
	        $data = array(
	            'tipo_alerta' => "alert-success",
	            'msg_alerta' => !Input::has('id') ? "Notícia inserida com sucesso." : "Notícia alterada com sucesso.",
	            );
	        return Redirect::to('incluir-noticia')->with($data);
		}
		else
		{
	        $data = array(
	            'tipo_alerta' => "alert-warning",
	            'msg_alerta' => "Erro ao realizar upload do arquivo.",
	            );
	        return Redirect::back()->with($data);
		}
	}

	public function excluir($id)
	{
		$noticia = Noticia::find($id);
		$noticia->excluido = date('Y-m-d H:m:s');
        $noticia->save();
		$data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => "Notícia excluída com sucesso.",
            );
		return Redirect::to('noticias')->with($data);
	}

	public function editar($id)
	{
		$noticia = Noticia::find($id);
		$tags = Tag::select('tag')->join('entidade_tag', function($entidade_tag){
			$entidade_tag->on('entidade_tag.tag_id', '=', 'tag.id');
		})->where('entidade_tag.entidade_id', $noticia->id)
		->where('entidade_tag.entidade', 'noticia')->whereNull('tag.excluido')->get();
		$str_tags = "";
		foreach ($tags as $tag)
		{
			$str_tags .= $tag->tag.", ";
		}
		$data = array(
			'noticia' => $noticia,
			'tags' => $str_tags,
			);
		$this->layout->container = View::make('noticia.formulario', $data);
		View::share('noticiaAtiva', 'active');
	}

	public function excluirEdital($id)
	{
		$noticia = Noticia::find($id);
		try
		{
			unlink($_SERVER['DOCUMENT_ROOT'].'/novo_portal/public'.$noticia->link_edital);
		}
		catch(ErrorException $exception)
		{
			Log::error($exception);
		}
		$noticia->link_edital = null;
		$noticia->save();
	}

	public function excluirImagem($id)
	{
		$noticia = Noticia::find($id);
		try
		{
			unlink($_SERVER['DOCUMENT_ROOT'].'/novo_portal/public'.$noticia->imagem);
		}
		catch(ErrorException $exception)
		{
			Log::error($exception);
		}
		$noticia->imagem = null;
		$noticia->save();
	}

}