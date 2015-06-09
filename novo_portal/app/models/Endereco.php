<?php

class Endereco extends Eloquent {
	
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'endereco';

	protected $fillable = array('logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'uf', 'cep', 'codigo_ibge', 'principal', 'excluido', 'usuario_id');

	public $timestamps = false;


	public function usuario()
	{
		return $this->belongsTo('Usuario', 'usuario_id', 'id');
	}
}