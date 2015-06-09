<?php

class ImportarController extends BaseController {

	protected $layout = 'layout.main';


    public function apostilasOpcao() 
    {
        $xml = simplexml_load_file('http://www.apostilasopcao.com.br/xml-afiliados/xml-auto-afi-8961-todas.xml');
        for ($i = 0; $i < count($xml->concurso); $i++) {
            for ($x = 0; $x < count($xml->concurso[$i]->apostilas->apostila); $x++) {
                $apostila_banco = Apostila::find($xml->concurso[$i]->apostilas->apostila[$x]['codigo']);
                if(is_null($apostila_banco))
                {
                    $apostila_banco = new Apostila;
                    $apostila_banco->id = $xml->concurso[$i]->apostilas->apostila[$x]['codigo'];
                    $apostila_banco->criacao = date('Y-m-d H:m:s');    
                }
                $apostila_banco->titulo = $xml->concurso[$i]['nome'];
                $apostila_banco->cargo = $xml->concurso[$i]->apostilas->apostila[$x]['cargo'];
                $apostila_banco->imagem = $xml->concurso[$i]->apostilas->apostila[$x]->imagem_capa;
                if (!empty($xml->concurso[$i]->apostilas->apostila[$x]->impressa_detalhes->valor))
                {
                    $apostila_banco->valor_impresso = str_replace(",", ".", str_replace(".", "", $xml->concurso[$i]->apostilas->apostila[$x]->impressa_detalhes->valor));
                }
                if (!empty($xml->concurso[$i]->apostilas->apostila[$x]->digital_detalhes->valor))
                {
                    $apostila_banco->valor_digital = str_replace(",", ".", str_replace(".", "", $xml->concurso[$i]->apostilas->apostila[$x]->digital_detalhes->valor));
                }
                $apostila_banco->link_parceiro = $xml->concurso[$i]->apostilas->apostila[$x]->url_apostila;
                $apostila_banco->save();
            }
        }
        $data = array(
            'tipo_alerta' => "alert-success",
            'msg_alerta' => "Apostila importadas com sucesso.",
            );
        return Redirect::to('apostilas')->with($data);
    }
}