<?php

class Noticia extends Eloquent {
	
	protected $table = 'noticia';

    public $timestamps = false;

	protected $fillable = array(
		'titulo',
		'autor',
		'fonte',
		'data_publicacao',
		'link_edital',
		'link_referencia',
		'texto',
		'imagem',
		'criacao',
		'excluido',
		);

}