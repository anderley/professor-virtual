<?php

class Video extends Eloquent {
	
	protected $table = 'video';

    public $timestamps = false;

    protected $guarded = ['id'];

	protected $fillable = ['titulo', 'embedded', 'ativo', 'criacao', 'excluido'];
}