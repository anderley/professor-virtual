<?php

class Apostila extends Eloquent {
	
	protected $table = 'apostila';

    public $timestamps = false;

	protected $fillable = ['id', 'titulo', 'cargo', 'imagem', 'valor_impresso', 'valor_digital', 'link_parceiro', 'ativo', 'criacao', 'excluido'];
}