<?php

class Tag extends Eloquent {
	
	protected $table = 'tag';

    public $timestamps = false;

    protected $guarded = ['id'];

	protected $fillable = ['tag', 'ativo', 'criacao', 'excluido'];
}