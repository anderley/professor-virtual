<?php

class Usuario extends Eloquent {
	
	protected $table = 'usuario';

    public $timestamps = false;

    protected $guarded = ['id'];

	protected $fillable = ['login', 'email', 'senha', 'ativo', 'criacao', 'excluido'];

	protected $hidden = ['senha'];
}