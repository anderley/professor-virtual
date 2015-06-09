<?php

class EntidadeTag extends Eloquent {
	
	protected $table = 'entidade_tag';

    public $timestamps = false;

	protected $fillable = array(
		'tag_id',
		'entidade_id',
		'entidade',
		'criacao',
		'excluido',
		);
	
}